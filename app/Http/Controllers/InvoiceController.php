<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Empresa;
use App\Models\Docdeta;
use App\Models\Venta;
use App\Models\Invoice;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
// send email
use Illuminate\Support\Facades\Mail;
use App\Mail\Facturacion;

class InvoiceController extends Controller
{

    /**
     * imprimir ticket con Qr para facturar
     */
    public function ticket(Request $request)
    {
        $id = !empty($request->id) ? $request->id : 0;
       
        // Generación del QR Code
        $url_qr = url('/invoices/ticket/qr/' . $id);
        $qrCode = QrCode::size(200)->generate($url_qr);

        $empresa = Empresa::find(1);

        // Obtener los detalles de la factura
        $docdetas = Docdeta::where('movcve', 51)
            ->where('docord', $id)
            ->get();

        $total = $docdetas->sum('docimporte');
        $articulos = $docdetas->sum('doccant');
        
        $venta = Venta::find($id);                
        
        // view
        return view('invoices.ticket', compact('qrCode','url_qr','id','empresa','total','docdetas','venta','articulos'));
        
    } // ticket

    /**
     * formulario generar factura electrónica, escanea este código QR con tu celular.
     * invoices/ticket/qr/{id}
     */
    public function create(Request $request)
    {
        $id = $request->id;

        $store = !empty($request->store) ? $request->store : config('app.name', 'Laravel');

        if (empty($id)) {
            return response()->json(['error' => 'Datos insuficientes para generar la factura.'], 400);
        }
    
        // Verificar si el documento ya ha sido timbrado
        $invoiceExists = Invoice::where('numberid', $id)->where('store', $store)->exists();

        if ($invoiceExists) {
            return response()->json(['error' => 'Este documento ya fue timbrado y enviado al RFC receptor.'], 400);
        }        

        $venta = Venta::find($id);

        $diferenciaEnHoras = $venta->getHoursDifferenceFromNow();

        if ($diferenciaEnHoras > 124) {
            return response()->json(['error' => 'La factura fiscal no puede generarse despues de 24 horas de la compra.'], 400);
        }

        $FormaPago = $venta->pvtipopago == 'efectivo' ?  "01" : "04"; // 04 tarjeta

        // Obtener los detalles de la factura
        $total = Docdeta::where('movcve', 51)
            ->where('docord', $id)
            ->get()
            ->sum('docimporte');        

        if($total != $venta->pvtotal) {
            return response()->json(['error' => 'El importe total del ticket no coincide con la suma del importe por cada articulo.'], 400);
        }

        return view('invoices.create',compact('id','total','FormaPago','store'));
    }
    
    public function store(Request $request)
    {
       // Definir las reglas de validación
       $rules = [
            'rfc' => 'required|string|max:13|min:12',
            'nombre' => 'required|string|max:255',
            'DomicilioFiscalReceptor' => 'required|string|size:5',
            'UsoCFDI' => 'required|string|size:3',
            'RegimenFiscalReceptor' => 'required|string|size:3',
            'email' => 'required|email|max:255',
            'base' => 'required|numeric|min:0',            
            'store' => 'required|string|max:100',
            'FormaPago' => 'required|string|size:2'
        ];

        // Mensajes personalizados de error
        $messages = [
            'rfc.required' => 'El RFC es obligatorio.',
            'rfc.size' => 'El RFC debe tener exactamente 13 caracteres.',
            'DomicilioFiscalReceptor.size' => 'El Código Postal debe tener exactamente 5 dígitos.',
            'email.email' => 'El correo electrónico debe ser una dirección válida.',
            'numberid.exists' => 'El ID de la venta asociado no existe.',
            'base.numeric' => 'El monto base debe ser un número válido.',
            'FormaPago.size' => 'La Forma de Pago debe contener exactamente 2 caracteres según el catálogo SAT.',
            // Agregar más mensajes personalizados si es necesario
        ];
        
        // Ejecutar la validación
        $validator = Validator::make($request->all(), $rules, $messages);
        
        // Verificar si la validación falla
        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }        

        try {

            // Crear una nueva instancia de Invoice y asignar los valores
            $invoice = new Invoice();
            $invoice->numberid = $request->input('numberid');
            $invoice->store = $request->input('store');
            $invoice->rfc = strtoupper($request->input('rfc'));
            $invoice->nombre = strtoupper($request->input('nombre'));
            $invoice->postal_code = $request->input('DomicilioFiscalReceptor');
            $invoice->regimen = $request->input('RegimenFiscalReceptor');
            $invoice->uuid = $request->input('uuid');
            $invoice->total = $request->input('base');
            $invoice->email = $request->input('email');            
            $invoice->created_at = Carbon::now('America/Mexico_City');
            $invoice->save();


            // Enviar el correo con la factura
            $this->sendInvoiceEmail($invoice);    

            // Redirigir al método success con el número de ID
            return redirect()->route('invoices.success')->with([
                'id' => $invoice->numberid,
                'uuid' => $invoice->uuid
            ]);
                                
        } catch (\Exception $e) {
     
        
            \Log::error('Error al generar una copia de la factura: ' . $e->getMessage());
        
            return redirect()
                ->back()
                ->with('error', 'Ocurrió un error al generar copia de la factura. Por favor, contacte al administrador.')
                ->withInput();
        }
        

    }

    /**
     * timbrado exitoso
     */
    public function success(Request $request)
    {
        $id = $request->session()->get('id', 0);
    
        // Buscar la venta relacionada
        $venta = Venta::find($id);

        if (!$venta) {
            return redirect()->route('invoices.error')->with('error', 'Venta no encontrada');
        }    
    
        // Pasar los datos de la venta a la vista
        return view('invoices.success', compact('venta'));
    }
    
    /**
     * error al descargar factura 
     */
    public function error()
    {
        return view('invoices.error');
    }

    protected function sendInvoiceEmail(Invoice $invoice)
    {
        Mail::send('emails.invoice', ['invoice' => $invoice], function ($message) use ($invoice) {
            $message->to($invoice->email, $invoice->nombre)
                    ->subject('Su factura electrónica')

                    ->attach(storage_path('facturas/' . $invoice->uuid . '.xml'));
        });
    }


    protected function sendInvoiceEmail2(Invoice $invoice)
    {
        $to = $invoice->email;
        $subject = "Su factura electrónica";
        
        // Cuerpo del correo
        $message = "
            <html>
            <head>
            <title>Factura Electrónica</title>
            </head>
            <body>
            <p>Estimado(a) {$invoice->nombre},</p>
            <p>Adjunto encontrará su factura electrónica correspondiente a la compra realizada.</p>
            <p>UUID de la factura: {$invoice->uuid}</p>
            </body>
            </html>
        ";
    
        // Encabezados del correo
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $headers .= 'From: no-reply@tu-sitio.com' . "\r\n";
    
        // Ruta de los archivos adjuntos
        $pdfAttachment = 'http://localhost/puntoventa/public/invoices/pdf/' . $invoice->uuid . '.pdf';
        $xmlAttachment = storage_path('facturas/' . $invoice->uuid . '.xml');
    
        // Adjuntar archivos al correo
        $boundary = md5(time());
        $headers .= "Content-Type: multipart/mixed; boundary=\"{$boundary}\"\r\n";
    
        $body = "--{$boundary}\r\n";
        $body .= "Content-Type: text/html; charset=UTF-8\r\n";
        $body .= "Content-Transfer-Encoding: 7bit\r\n\r\n";
        $body .= $message . "\r\n\r\n";
    
        // Adjuntar PDF
        if (file_exists($pdfAttachment)) {
            $pdfData = file_get_contents($pdfAttachment);
            $pdfEncoded = chunk_split(base64_encode($pdfData));
            $body .= "--{$boundary}\r\n";
            $body .= "Content-Type: application/pdf; name=\"factura.pdf\"\r\n";
            $body .= "Content-Disposition: attachment; filename=\"factura.pdf\"\r\n";
            $body .= "Content-Transfer-Encoding: base64\r\n\r\n";
            $body .= $pdfEncoded . "\r\n\r\n";
        }
    
        // Adjuntar XML
        if (file_exists($xmlAttachment)) {
            $xmlData = file_get_contents($xmlAttachment);
            $xmlEncoded = chunk_split(base64_encode($xmlData));
            $body .= "--{$boundary}\r\n";
            $body .= "Content-Type: text/xml; name=\"factura.xml\"\r\n";
            $body .= "Content-Disposition: attachment; filename=\"factura.xml\"\r\n";
            $body .= "Content-Transfer-Encoding: base64\r\n\r\n";
            $body .= $xmlEncoded . "\r\n\r\n";
        }
    
        $body .= "--{$boundary}--";
    
        // Enviar el correo
        mail($to, $subject, $body, $headers);
    }
    
    
} // class
