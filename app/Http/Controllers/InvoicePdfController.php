<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Tcpdf;

class InvoicePdfController extends Controller
{
    protected $_Sello;
    protected $_Fecha;	
    protected $_Folio;
	protected $_Serie;
    protected $_UUID;
    protected $_numerocer;
    protected $_NoCertificadoSAT;
    protected $_NoCertificado; 
    protected $_SelloSAT;	
    protected $_SelloCFD;
    protected $_RfcProvCertif;
    protected $_EmisorRFC;
    protected $_EmisorNombre;
    protected $_ReceptorRFC;
    protected $_ReceptorNombre;
    protected $_ReceptorUsoCFDI;
    protected $_ReceptorRegimen;
    protected $_ReceptorDomicilio;
    protected $_RegimenFiscal;
    protected $_LugarExpedicion;
    protected $_FormaPago;
    protected $_MetodoPago;
    protected $_ValorUnitario;
    protected $_Descripcion;
    protected $_Cantidad;
    protected $_Importe;
    protected $_Unidad;
    protected $_SubTotal;
    protected $_Total;
    protected $_ClaveProdServ;
    protected $_ClaveUnidad;
    protected $_Base;
    protected $_NoIdentificacion;
    protected $_ImpuestoImporte;
    protected $_ImpuestoTasaOCuota;
	protected $_ConceptoImporte;
	protected $_ConceptoValorUnitario;
    
    /**
	* generar PDF del XML (CFDI)
	* funcion principal
	**/
    public function index(Request $request)	 
    {

		// request uuid
		$uuid = isset($request->uuid) ? trim($request->uuid): die('ocurrio un error al leer el archivo xml');
		
		// archivo XML 
        $basePath = storage_path('facturas/');
        
		$fichero = $basePath.$uuid.".xml";
        
		// cargar XML
		$xml = simplexml_load_file($fichero);
        
		// configuraciones XML
		$ns = $xml->getNamespaces(true);
		$xml->registerXPathNamespace('cfdi', $ns['cfdi']);
		$xml->registerXPathNamespace('t', $ns['tfd']);		     
        
        // libreria PDF
        require_once app_path('Tcpdf/tcpdf.php');        
        // configuracion PDF
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);  
        $pdf->SetTitle($uuid.'Pdf');           
        $pdf->AddPage();
        $pdf->SetFont('helvetica', '', 9);        
        // set default header data
        $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 001', PDF_HEADER_STRING, array(0,64,255), array(0,64,128));
        $pdf->setFooterData(array(0,64,0), array(0,64,128));
        // set header and footer fonts
        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
        // set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        // set margins
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

        // ruta
        $url = url();
		
		// Guardar informacion CFDI
		foreach ($xml->xpath('//cfdi:Comprobante') as $cfdiComprobante){ 
			$this->_Serie = $cfdiComprobante['Serie'];
			$this->_Sello = $cfdiComprobante['Sello'];
			$this->_Folio = $cfdiComprobante['Folio'];
			$this->_Fecha = $cfdiComprobante['Fecha']; 
			$this->_FormaPago = $cfdiComprobante['FormaPago'];
			$this->_MetodoPago = $cfdiComprobante['MetodoPago'];
			$this->_LugarExpedicion = $cfdiComprobante['LugarExpedicion']; 
			$this->_NoCertificado = $cfdiComprobante['NoCertificado'];	
			$this->_SubTotal = $cfdiComprobante['SubTotal']; 
			$this->_Total = $cfdiComprobante['Total'];			
		}	
		
		// guardar informacion Timbrado
		foreach ($xml->xpath('//t:TimbreFiscalDigital') as $tfd) {
		   $this->_UUID = $tfd['UUID'];
		   $this->_RfcProvCertif = $tfd['RfcProvCertif'];
		}
		// guardar datos timbre
		foreach ($xml->xpath('//t:TimbreFiscalDigital') as $tfd) {
		   $this->_SelloCFD = $tfd['SelloCFD']; 
		   $this->_SelloSAT = $tfd['SelloSAT']; 
		   $this->_NoCertificadoSAT = $tfd['NoCertificadoSAT']; 
		} 			
		// gaurdar datos emisor
		foreach ($xml->xpath('//cfdi:Comprobante//cfdi:Emisor') as $Emisor){ 
		   $this->_EmisorRFC = $Emisor['Rfc']; 
		   $this->_EmisorNombre = $Emisor['Nombre'];
		   $this->_RegimenFiscal = $Emisor['RegimenFiscal'];
		} 	
		// guardar datos recpetor
		foreach ($xml->xpath('//cfdi:Comprobante//cfdi:Receptor') as $Receptor){ 
		   $this->_ReceptorRFC = $Receptor['Rfc'];
		   $this->_ReceptorNombre = $Receptor['Nombre'];	   
		   $this->_ReceptorUsoCFDI = $Receptor['UsoCFDI'];
           $this->_ReceptorRegimen = $Receptor['RegimenFiscalReceptor'];
           $this->_ReceptorDomicilio = $Receptor['DomicilioFiscalReceptor'];
           
		} 


// Inicializar arreglo para guardar los conceptos
$conceptos = [];

// Guardar datos de los conceptos de la factura en un arreglo
foreach ($xml->xpath('//cfdi:Comprobante//cfdi:Conceptos//cfdi:Concepto') as $Concepto) { 	
    $conceptos[] = [
        'ClaveProdServ' => (string) $Concepto['ClaveProdServ'],  // 86101605
        'Cantidad' => (float) $Concepto['Cantidad'],  // 1
        'ClaveUnidad' => (string) $Concepto['ClaveUnidad'],  // ANN
        'NoIdentificacion' => (string) $Concepto['NoIdentificacion'],  // E48
        'Unidad' => (string) $Concepto['Unidad'],  // servicios
        'Descripcion' => (string) $Concepto['Descripcion'], 
        'Importe' => (float) $Concepto['Importe'], 
        'ValorUnitario' => (float) $Concepto['ValorUnitario']
    ];
}		
		// guardar datos factura impuestos
		foreach ($xml->xpath('//cfdi:Comprobante//cfdi:Impuestos//cfdi:Traslados//cfdi:Traslado') as $Traslado){ 
		   $this->_ImpuestoTasaOCuota = $Traslado['TasaOCuota']; // 1200.00
		   $this->_ImpuestoImporte = $Traslado['Importe']; // importe IVA  192.00
		   $this->_TipoFactor = $Traslado['TipoFactor']; 
		} 		
		
		/*************** encabezado PDF *******/
		$head = '<div> </div>';		
		$head .='<table style="width: 100%; font-size:10pt">
			<tr>
				<td rowspan="7" style="width:110px;"> <img src="'.$basePath.'logo-converse.jpg" width="110" height="110" > </td>
				<td style="text-align: justify; width:300px;"><strong>'.$this->_EmisorNombre.'</strong>  </td>
			</tr>
			<tr>
				<td>'.$this->_EmisorRFC.' </td>
			</tr>
			<tr>
				<td><small>'.$this->_RegimenFiscal.'-'.$this->regimen().' </small></td>
			</tr>
			<tr>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td>'.$this->_ReceptorNombre.' </td>
			</tr>
			<tr>
				<td>'.$this->_ReceptorRFC.' </td>
			</tr>			
			<tr>
				<td><small>Regimen Fiscal: '.$this->_ReceptorRegimen.' - '.$this->regimen().' C.P.: '.$this->_ReceptorDomicilio.' </small></td>
			</tr>

		</table>';		
		
		/*************** HTML PDF *************/
		// factura		
		$html ='<div><h2><strong><span style="color:#0f4673">Factura: '.$this->_Serie.'/'.$this->_Folio.' </span></strong></h2></div>';		
		// fecha, metodo
		$html .='<table style="width: 100%">
			<tr>
				<td>Fecha de factura</td>
				<td>Uso CFDI</td>
				<td>Forma de pago</td>
				<td>Metodo de pago</td>
			</tr>
			<tr>
				<td>'.$this->_Fecha.'</td>
				<td>'.$this->usoCfdi().' </td>
				<td>'.$this->formapago().' </td>
				<td>'.$this->metodoPago().' </td>
			</tr>
		</table>';		
		// productos, total, iva
		$html .='<div> &nbsp;</div>';
		$html .='<table style="width: 100%; font-size: 7pt;">
			<tr>
				<td bgcolor="#808080" colspan="6">&nbsp;</td>
			</tr>
			<tr>
				<td>CÓDIGO PRODUCTO</td>
				<td>UNIDAD</td>
				<td>CANT.</td>
				<td>DESCRIPCIÓN</td>			
				<td>PRECIO UNITARIO</td>
				<td>IMPORTE</td>
			</tr>';
			foreach ($conceptos as $concepto) {

				$html .='<tr>
					<td>'.$concepto['ClaveProdServ'].'</td>
					<td>'.$concepto['ClaveUnidad'].' - '.$concepto['Unidad'].'</td>
					<td>'.$concepto['Cantidad'].'</td>
					<td>'.$concepto['Descripcion'].'</td>				
					<td>'.number_format( $concepto['ValorUnitario'], 2).'</td>
					<td>'.number_format( $concepto['Importe'], 2).'</td>
					</tr>';
				}

			$html .='
			<tr>
				<td bgcolor="#808080" colspan="6">&nbsp;</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>Subtotal</td>
				<td style="text-align:right;">$ '.number_format( (float)$this->_SubTotal,2).'</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>			
			<tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td style="text-align:right;"> Tipo Factor: '.$this->_TipoFactor.' '.$this->_ImpuestoTasaOCuota.' % </td>
				<td style="text-align:right;">$ '.number_format( (float)$this->_ImpuestoImporte,2).'</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>					
			<tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td><strong>Total</strong></td>
				<td style="text-align:right;">$ '.number_format((float)$this->_Total,2).'</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td bgcolor="#808080" colspan="2">&nbsp;</td>
			</tr>			
		</table>';
		// salto de linea 
		$html .='<div> &nbsp;</div>';
		$html .='<div> &nbsp;</div>';
		
		// sello digital CFDI
		$html .='<table style="width: 100%; font-size:8pt">
			<tr>
				<td>Sello digital del CFDI:</td>
			</tr>
			<tr>
				<td style="text-align: justify; font-size:7pt">'.$this->_SelloCFD.'</td>
			</tr>
			</table>';	

		// sello digital SAT	
		$html .='<div> &nbsp;</div>';
		
		$html .='<table style="width: 100%; font-size:8pt">
			<tr>
				<td>Sello digital del SAT:</td>
			</tr>
			<tr>
				<td style="text-align: justify; font-size:7pt">'.$this->_SelloSAT.'</td>
			</tr>
			</table>';
		// codigo qr
		$html .='<div> &nbsp;</div>';
		$html .='<table style="width: 100%;">
			<tr>
				<td rowspan="4"> <img src="'.$basePath.'/'.$this->_UUID.'.png" style="height:170px; width:170px;">  </td>
				<td colspan="4" style="font-size:7px">Cadena Original del complementario de certificacion digital del SAT:</td>
			</tr>
			<tr style="text-align: justify; font-size:7x">
				<td colspan="4">'.$this->_Sello.'</td>
			</tr>
			<tr style="font-size:7px">
				<td>RFC del proveedor:</td>
				<td>'.$this->_RfcProvCertif.'</td>
				<td>Fecha y hora de certificacion:</td>
				<td>'.$this->_Fecha.'</td>
			</tr>
			<tr style="font-size:7px">
				<td colspan="4">No. de serie del cerificado SAT: '.$this->_NoCertificadoSAT.'<br>Versi&oacute;n CFDI: 4.0 </td>
			</tr>
			<tr style="font-size:8px">
				<td colspan="4">Folio fiscal: '.$this->_UUID.'</td>
			</tr>			
			</table>';		
		$html .='<div> &nbsp;</div>';
		$html .='<table style="width: 100%; text-align:center; height:150px" ><tr><td> Este documento es una representaci&oacute;n impresa de un CFDI</td></tr></table>';	
			
		// pdf encabezado
        $pdf->writeHTML($head, false, false,false,FALSE,'');
		// pdf HTML
        $pdf->writeHTML($html, true, false, true, FALSE,'');      
        // nombre del PDF
        $name = $this->_UUID;
        // output PDF document    
		$pdf->Output( $name.'.pdf', 'I');        

    } // index

    
	/**
	* Catálogo de uso de comprobantes SAT
	**/
    public function usoCfdi()
    {
    	switch($this->_ReceptorUsoCFDI){
    		case "CP01": $uso ="Pagos"; break;
    		case "G01": $uso ="Adquisicion de mercancias"; break;
    		case "G02": $uso ="Devoluciones, descuentos o bonificaciones"; break;
    		case "G03": $uso ="Gastos en general"; break;
    		case "I01": $uso ="Construcciones"; break;
    		case "I02": $uso ="Mobilario y equipo de oficina por inversiones"; break;
    		case "I03": $uso ="Equipo de transporte"; break;
    		case "I04": $uso ="Equipo de computo y accesorios"; break;
    		case "I05": $uso ="Dados, troqueles, moldes, matrices y herramental"; break;
    		case "I06": $uso ="Comunicaciones telefonicas"; break;
    		case "I07": $uso ="Comunicaciones satelitales"; break;
    		case "I08": $uso ="Otra maquinaria y equipo"; break;
    		case "D01": $uso ="Honorarios medicos, dentales y gastos hospitalarios."; break;
    		case "D02": $uso ="Gastos médicos por incapacidad o discapacidad"; break;
    		case "D03": $uso ="Gastos funerales."; break;
    		case "D04": $uso ="Donativos."; break;
    		case "D05": $uso ="Intereses reales efectivamente pagados por creditos hipotecarios (casa habitacion)."; break;
    		case "D06": $uso ="Aportaciones voluntarias al SAR."; break;
    		case "D07": $uso ="Primas por seguros de gastos medicos."; break;
    		case "D08": $uso ="Gastos de transportacion escolar obligatoria."; break;
    		case "D09": $uso ="Depositos en cuentas para el ahorro, primas que tengan como base planes de pensiones."; break;
    		case "D10": $uso ="Pagos por servicios educativos (colegiaturas)"; break;
    		case "P01": $uso ="Por definir"; break;
    		default: $uso ="Error";
    	} // switch
    	
    	return $uso;
    	
    } // usocfdi
    
	/**
	* Catálogo de Método de Pago SAT
	**/
    public function metodoPago()
    {
    	switch($this->_MetodoPago){
    		case "PUE": $metodo ="Pago en una sola exhibición"; break;
    		case "PPD": $metodo ="Pago en parcialidades o diferido"; break;
    		default: $metodo ="Error";
    	} // switch
    	
    	return $metodo;
    	
    } // metodopago

	/**
	* Catálogo formas de pago SAT
	**/
    public function formaPago()
    {
    	switch($this->_FormaPago){
    		case "01": $forma ="Efectivo"; break;
    		case "02": $forma ="Cheque nominativo"; break;
    		case "03": $forma ="Transferencia electrónica de fondos"; break;
    		case "04": $forma ="Tarjeta de crédito"; break;
    		case "05": $forma ="Monedero electrónico"; break;
    		case "06": $forma ="Dinero electrónico"; break;
    		case "08": $forma ="Vales de despensa"; break;
    		case "12": $forma ="Dación en pago"; break;
    		case "13": $forma ="Pago por subrogación"; break;
    		case "14": $forma ="Pago por consignación"; break;
    		case "15": $forma ="Condonación"; break;
    		case "17": $forma ="Compensación"; break;
    		case "23": $forma ="Novación"; break;
    		case "24": $forma ="Confusión"; break;
    		case "25": $forma ="Remisión de deuda"; break;
    		case "26": $forma ="Prescripción o caducidad"; break;
    		case "27": $forma ="A satisfacción del acreedor"; break;
    		case "28": $forma ="Tarjeta de débito"; break;
    		case "29": $forma ="Tarjeta de servicios"; break;
    		case "30": $forma ="Aplicación de anticipos"; break;
    		case "31": $forma ="Intermediario pagos"; break;
    		case "99": $forma ="Por definir"; break;
    		default: $forma ='Error'; 
    	} // switch
    	
    	return $forma;
    	
    } // formapago    

    /**
     * catalogo regimen fiscal
     */

     public function regimen()
     {
         switch($this->_ReceptorRegimen)
         {             
             case "601": $regimen ="General de Ley Personas Morales"; break;
             case "603": $regimen ="Personas Morales con Fines no Lucrativos"; break;
             case "605": $regimen ="Sueldos y Salarios e Ingresos Asimilados a Salarios"; break;
             case "606": $regimen ="Arrendamiento"; break;
             case "607": $regimen ="Régimen de Enajenación o Adquisición de Bienes"; break;
             case "608": $regimen ="Demás ingresos"; break;
             case "610": $regimen ="Residentes en el Extranjero sin Establecimiento Permanente en México"; break;
             case "611": $regimen ="Ingresos por Dividendos (socios y accionistas)"; break;
             case "612": $regimen ="Personas Físicas con Actividades Empresariales y Profesionales"; break;
             case "614": $regimen ="Ingresos por intereses"; break;
             case "615": $regimen ="Régimen de los ingresos por obtención de premios"; break;
             case "616": $regimen ="Sin obligaciones fiscales"; break;
             case "620": $regimen ="Sociedades Cooperativas de Producción que optan por diferir sus ingresos"; break;
             case "621": $regimen ="Incorporación Fiscal"; break;
             case "622": $regimen ="Actividades Agrícolas, Ganaderas, Silvícolas y Pesqueras"; break;
             case "623": $regimen ="Opcional para Grupos de Sociedades"; break;
             case "624": $regimen ="Coordinados"; break;
             case "625": $regimen ="Régimen de las Actividades Empresariales con ingresos a través de Plataformas Tecnológicas"; break;
             case "626": $regimen ="Régimen Simplificado de Confianza"; break;
             
             default: $regimen ='Error'; 
         } // switch
         
         return $regimen;
         
     } // formapago


	 /**
	  * forzar descarga de archivo XML
	  */	
      public function downloadXml(Request $request) 
      {
          // $url = url();
          $uuid = !empty($request->uuid) ? trim($request->uuid) : false;
  
          $basePath = storage_path('facturas/');

          $headers = array(
              'Content-Type: application/xml',
              'Content-Disposition: attachment; filename="'.$uuid.'"'
          
          );
      
          return response()->download($basePath.$uuid.".xml", $uuid.".xml", $headers);
      }    
                
} // class
