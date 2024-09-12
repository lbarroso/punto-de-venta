<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Venta;
use App\Models\Docdeta;
use App\Models\Invoice;
use Carbon\Carbon;

// SW services
require_once app_path('Sw/SWSDK.php');
// use App\Sw\SWSDK;
use SWServices\JSonIssuer\JsonEmisionTimbrado as jsonEmisionTimbrado;

class JsonbuildController extends Controller
{
    
	// atributos
    protected $_numberid;
    protected $_store;
	protected $_rfc;
	protected $_nombre;
    protected $_cp;
    protected $_regimen;
	protected $_descripcion;
	protected $_usocdfi;
    protected $_tipofactor; // 002 IVA
	protected $_impuesto; // 002 IVA
	protected $_tasaocuota; // execento
	protected $_valortasa; // 0.16
	protected $_base; // valor unitario
	protected $_subtotal; // iva
	protected $_importe; // importe impuesto
	protected $_total; // total  
    protected $_formapago; // 03 transferencia default
    protected $_email;

    /*****************************
     * timbrar factura CDFI 4.0 
     ****************************/
    public function timbrar(Request $request)
    {
        // Validar los datos del formulario
        $validatedData = $request->validate([
			'store' => 'required',
            'rfc' => 'required|string|max:13|min:12',
            'nombre' => 'required|string|max:255',
            'DomicilioFiscalReceptor' => 'required|string|max:5',
            'UsoCFDI' => 'required|string|max:3',
            'RegimenFiscalReceptor' => 'required|string|max:4',
            'email' => 'required|email|max:255',
            // Nuevas reglas de validación
            'base' => 'required|numeric|min:0.01', // Numérico, con al menos 2 decimales, no nulo, mayor que cero
            'numberid' => 'required|integer|min:1', // Entero, no nulo, mayor que cero
            'FormaPago' => 'required|string|max:255', // String no nulo            
        ]);

       // request post Receptor
       $this->_store = $validatedData['store'];
       $this->_rfc = $validatedData['rfc'];
       $this->_nombre = $validatedData['nombre'];
       $this->_cp = $validatedData['DomicilioFiscalReceptor'];
       $this->_usocfdi = $validatedData['UsoCFDI'];
       $this->_regimen = $validatedData['RegimenFiscalReceptor'];
       $this->_email = $validatedData['email'];
       $this->_numberid = $validatedData['numberid'];
       $this->_descripcion = "VENTA";    
       
       // Comprobante
       $this->_formapago = !empty($request->input('FormaPago')) ? trim($request->input('FormaPago')) : '01'; // efectivo
       $this->_metodopago = !empty($request->input('MetodoPago')) ? $request->input('MetodoPago') : 'PUE'; // una sola exhibicion

       // Impuestos
       //$this->_base = !empty($request->input('base')) ? number_format($request->input('base'),2,'.','') : 0;
       $this->_impuesto = !empty($request->input('impuesto')) ? $request->input('impuesto') : '002';
       $this->_tipofactor = !empty($request->input('impuesto')) ? $request->input('impuesto') : 'Tasa';
       $this->_tasaocuota = !empty($request->input('impuesto')) ? $request->input('impuesto') : '0.160000';

        // iva desglosado base/1.16
        // $this->_base = number_format($validatedData['base'] / 1.16, 2,'.','');
        // $this->_importe = number_format($validatedData['base'] - $this->_base, 2,'.',''); // diferencia
        
        $this->_base = $request->input('base');

        $this->jsonBuildIngreso();
        
  
        
		
    } // timbrar

	/**
	* timbra factura con IVA desglosado
	* TasaOCuota = 0.160000
	**/
	public function jsonBuildIngreso()
	{
		// encabezado
		header('Content-Type: text/plain');
		date_default_timezone_set('America/Mexico_City');

		// web server produccion
		$params = array(
			"url"=>"http://services.test.sw.com.mx",
			"user"=>"luis.rey.cien@gmail.com",
			"password"=> "SWpruebas"
		);
		// total ticket 
    	$base = (float)$this->_base;

// Calcular la base (sin IVA)
$baseSinIVA = round($base / 1.16, 2);  // Se calcula la base dividiendo por 1.16 (porque 16% de IVA)

// Calcular el IVA desglosado
$impuestoImporte = round($base - $baseSinIVA, 2);  // El IVA es la diferencia entre el total y la base sin IVA

// Formatear los valores a 2 decimales
$baseSinIVA = number_format($baseSinIVA, 2, '.', '');
$importe = number_format($impuestoImporte, 2, '.', '');		

    	// total factura
    	$total = $baseSinIVA + $importe; // 1800 + 288 = 2088

    	// datos EMISOR
    	$emisor["Rfc"]="CUCA871215IK8"; // RUAC780330QR2
    	$emisor["Nombre"]="ANDREA ITZEL CRUZ CHAVEZ"; // CLAUDIA CONCEPCION RUIZ AMAYA
    	$emisor["RegimenFiscal"]="612"; // 612 - Personas Físicas con Actividades Empresariales y Profesionales		

    	// datos receptor
    	$receptor["Rfc"] = $this->_rfc;
    	$receptor["Nombre"] = $this->_nombre;
    	$receptor["DomicilioFiscalReceptor"] = $this->_cp;
    	$receptor["RegimenFiscalReceptor"] = $this->_regimen;
    	$receptor["UsoCFDI"] = $this->_usocfdi;
	
    	// comprobante Exentos 
    	$comprobante["Version"] = "4.0"; 
    	$comprobante["Serie"] = $this->_store;
    	$comprobante["Folio"] = $this->_numberid;
    	$comprobante["Fecha"] = date('Y-m-d\TH:i:s');
    	$comprobante["Sello"] = "";  
    	$comprobante["FormaPago"] = $this->_formapago; // 03 transferencia default
    	$comprobante["NoCertificado"] = "";
    	$comprobante["Certificado"] = "";
    	$comprobante["CondicionesDePago"] = $this->_store;
    	$comprobante["SubTotal"] = "$baseSinIVA";
        $comprobante["Descuento"]= "0.00";
    	$comprobante["Total"]= "$total";
    	$comprobante["Moneda"] = "MXN";
    	$comprobante["TipoDeComprobante"] = "I"; // Ingreso        
    	$comprobante["TipoCambio"] = "1";
    	$comprobante["Exportacion"] = "01";
    	$comprobante["MetodoPago"] = $this->_metodopago;
    	$comprobante["LugarExpedicion"] = "68036"; // Oax
    	$comprobante["Emisor"] = $emisor;
    	$comprobante["Receptor"] = $receptor;

        // Obtener los conceptos
        $concepts = Docdeta::select('docdetas.codbarras', 'docdetas.artdesc', 'docdetas.artprventa', 'docdetas.docimporte', 'docdetas.doccant', 'docdetas.artdescto', 'products.category_id')
            ->leftJoin('products', 'docdetas.product_id', '=', 'products.id')
            ->where('docdetas.movcve', 51)
            ->where('docdetas.docord', $this->_numberid)
            ->get();
            
        $i=0;
    	foreach ($concepts as $concept) {

			// Total del concepto que incluye IVA
			$_base = (float)$concept->docimporte;

			// Calcular la base sin IVA
			$_baseSinIVA = round($_base / 1.16, 2);  // Dividir por 1.16 para obtener la base sin IVA

			// Calcular el IVA desglosado
			$_impuestoImporte = round($_base - $_baseSinIVA, 2);  // El IVA es la diferencia entre el total y la base sin IVA

			// Formatear los valores a 2 decimales
			$_baseSinIVA = number_format($_baseSinIVA, 2, '.', '');
			$_importe = number_format($_impuestoImporte, 2, '.', '');	
            
    		$traslado[0]["Base"] = $_baseSinIVA;        
    		$traslado[0]["Impuesto"] = "002";
    		$traslado[0]["TipoFactor"] = "Tasa";
    		$traslado[0]["TasaOCuota"] = "0.160000";
    		$traslado[0]["Importe"] = $_importe;
    		$impuesto["Traslados"] = $traslado;

            switch($concept->category_id){
                case 2:
                    $ClaveProdServ = "53102700";
                    $ClaveUnidad = "H87";
                    $Unidad = "Pieza";
                break;
                case 3:
                    $ClaveProdServ = "53131600";
                    $ClaveUnidad = "H87";
                    $Unidad = "Pieza";
                break;           
                default: 
                    $ClaveProdServ = "53111900";
                    $ClaveUnidad = "PR";
                    $Unidad = "Par";                    
                break;
            }

        	
			// Valor unitario con IVA (precio por pieza)
			$artprventa = (float)$concept->artprventa;					
			$artdescto = (int)$concept->artdescto;		
			if($artdescto > 0) $artprventa = ($artprventa * $artdescto) / 100;
			// Calcular la base sin IVA para el valor unitario
			$artprventaSinIVA = round($artprventa / 1.16, 2);  // Dividir por 1.16 para obtener la base sin IVA
			// Formatear los valores a 2 decimales
			$artprventaSinIVA = number_format($artprventaSinIVA, 2, '.', '');
       		
			// Concepto del producto
    		$concepto = [
    			"ClaveProdServ" => $ClaveProdServ,
    			"NoIdentificacion" => $this->_numberid,
    			"Cantidad" => $concept->doccant,
    			"ClaveUnidad" => $ClaveUnidad,
    			"Unidad" => $Unidad,
    			"ObjetoImp" => "02",
    			"Descuento" => "0.00",
    			"Descripcion" => substr($concept->artdesc, 0, 35)." ".$concept->codbarras,
    			"ValorUnitario" => $artprventaSinIVA,
    			"Importe" => $_baseSinIVA,
    			"Impuestos" => $impuesto
    		];
    
    		// Agregar el concepto a la lista de conceptos
    		$conceptos[$i] = $concepto;	
            $i++;
            
    	} // EndForeach
    
    	// Agregar los conceptos al comprobante
    	$comprobante["Conceptos"] = $conceptos;
    	
    	// impuestos translados     
    	$ImpuestosTotales["Retenciones"] = null;
    	$ImpuestosTotales["Traslados"][0]["Base"] = $baseSinIVA;
    	$ImpuestosTotales["Traslados"][0]["Impuesto"] = "002";
    	$ImpuestosTotales["Traslados"][0]["TipoFactor"] = "Tasa";
    	$ImpuestosTotales["Traslados"][0]["TasaOCuota"] = "0.160000";	
    	$ImpuestosTotales["Traslados"][0]["Importe"] = $importe;
    	$ImpuestosTotales["TotalImpuestosRetenidosSpecified"] = false;
    	$ImpuestosTotales["TotalImpuestosTrasladados"] = $importe;
    	$ImpuestosTotales["TotalImpuestosTrasladadosSpecified"] = true;	
    	$comprobante["Impuestos"] = $ImpuestosTotales;
    
    	$json = json_encode($comprobante);	
	
        // echo $json;
        
		
        try{

			$basePath = storage_path('facturas/');
			$jsonIssuerStamp = jsonEmisionTimbrado::Set($params);
			$resultadoJson = $jsonIssuerStamp::jsonEmisionTimbradoV4($json);
			
			if($resultadoJson->status=="success"){
				//save CFDI
				$ruta=$basePath.$resultadoJson->data->uuid.".xml";
				file_put_contents($ruta, $resultadoJson->data->cfdi);
				//save QRCode
				$nombreyRuta = $resultadoJson->data->uuid.".png";
				imagepng(imagecreatefromstring(base64_decode($resultadoJson->data->qrCode)), $basePath.$nombreyRuta);
				
				// Asumiendo que ya tienes la instancia de la venta
				$venta = Venta::find($this->_numberid);
				// Asignar el valor del uuid
				$venta->uuid = $resultadoJson->data->uuid;
				// Guardar los cambios en la base de datos
				$venta->save();
				
                // Crear una nueva instancia de Invoice y asignar los valores
                $invoice = new Invoice();
                $invoice->numberid = $this->_numberid;
                $invoice->store = $this->_store;
                $invoice->rfc = $this->_rfc;
                $invoice->nombre = $this->_nombre;
                $invoice->postal_code = $this->_cp;
                $invoice->regimen = $this->_regimen;
                $invoice->uuid = $resultadoJson->data->uuid;
                $invoice->total = $base;
                $invoice->email = $this->_email;            
                $invoice->created_at = Carbon::now('America/Mexico_City');
                $invoice->save();
                
                // timbrado exitoso	
                echo $resultadoJson->status;

			} else {
				// Manejo de errores de timbrado
				$mensaje = $resultadoJson->message . "\n" . $resultadoJson->messageDetail;
				// continuar despues del error
				echo $mensaje;

			}
			//var_dump($resultadoJson);
		}
		catch(Exception $e){
			echo $e->getMessage();
		}         
        
	

    }    


} // class