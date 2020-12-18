<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use XMLWriter;
use Storage;
use ZipArchive;
use Luecano\NumeroALetras\NumeroALetras;
use Greenter\XMLSecLibs\Sunat\SignedXml;
use Greenter\XMLSecLibs\Certificate\X509Certificate;
use Greenter\XMLSecLibs\Certificate\X509ContentType;

use Greenter\Ws\Services\SoapClient;
use Greenter\Ws\Services\BillSender;

//use App\Http\Models\Historia;
use App\Http\Models\Paciente;
//use App\Http\Models\Receta;
use App\Http\Models\Doctor;
use App\Http\Models\Categoria;
use App\Http\Models\Umedida;
use App\Http\Models\Factura;
use App\Http\Models\Detfactura;
use App\Http\Models\NotaAdm;
use App\Http\Models\DetNotaAdm;
use App\Http\Models\NotaFar;
use App\Http\Models\DetNotaFar;

use App\Http\Models\Salida;
use App\Http\Models\Detsalida;
use App\Http\Models\Comprobante;
use App\Http\Models\Afectacion;
use App\Http\Models\Param;

class SunatController extends Controller
{
    public function __construct()
    {
		$this->middleware('auth');		
		$this->middleware('isadmin');
		$this->middleware('permissions');
    }

    public function getSunatCertificado()
    {
        $pfx = file_get_contents('certificado.p12');
        $password = 'RESPIRA2020';

        $certificate = new X509Certificate($pfx, $password);
        $pem = $certificate->export(X509ContentType::PEM);
        file_put_contents('certificate.pem', $pem);

    }

    public function getSunatCertificadoCer()
    {
        $pfx = file_get_contents('certificado.p12');
        $password = 'RESPIRA2020';

        $certificate = new X509Certificate($pfx, $password);
        $cer = $certificate->export(X509ContentType::CER);
        file_put_contents('certificate.cer', $cer);

    }

    public function getSunatAdmision($id)
    {
        //$ruc = file_get_contents('https://api.sunat.cloud/ruc/10804969161');
        
        $factura = Factura::with(['cli'])->findOrFail($id);
        $detfacturas = Detfactura::where('factura_id',$id)->get();
        $moneda = Categoria::where('modulo', 10)->pluck('nombre','codigo');
        $fpago = Categoria::where('modulo', 11)->pluck('nombre','codigo');
        $comprobante = Comprobante::where('activo',1)->pluck('nombre','codigo');
        $clientes = Paciente::orderBy('razsoc','asc')->pluck('razsoc','numdoc');
        $doctor = Doctor::orderBy('nombre','asc')->pluck('nombre','id');
        $afectacion = Afectacion::pluck('nombre','codigo');
        $parametro = Param::findOrFail(1);
        $formatter = new NumeroALetras();
        
        if($factura->moneda=='PEN'){
            $letra = $formatter->toInvoice($factura->total_clinica, 2, 'soles');
        }else{
            $letra = $formatter->toInvoice($factura->total_clinica, 2, 'dólares americanos');
        }

        $archivo = $parametro->ruc.'-'.$factura->comprobante_id.'-'.$factura->serie.'-'.($factura->numero).'.xml';

        $xml = new XMLWriter();        
        //$xml->openURI($archivo);
        $xml->openMemory();
        $xml->setIndent(true);
        //$xml->setIndentString('	'); 
        //$xml->startDocument("1.0", "UTF-8","no");
        $xml->startDocument("1.0", "ISO-8859-1","no");
        $xml->startElement("Invoice");
            $xml->writeAttribute("xmlns", "urn:oasis:names:specification:ubl:schema:xsd:Invoice-2");
            $xml->writeAttribute("xmlns:cac","urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2");
            $xml->writeAttribute("xmlns:cbc","urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2");
            $xml->writeAttribute("xmlns:ccts","urn:un:unece:uncefact:documentation:2");
            $xml->writeAttribute("xmlns:ds","http://www.w3.org/2000/09/xmldsig#");
            $xml->writeAttribute("xmlns:ext","urn:oasis:names:specification:ubl:schema:xsd:CommonExtensionComponents-2");
            $xml->writeAttribute("xmlns:qdt","urn:oasis:names:specification:ubl:schema:xsd:QualifiedDatatypes-2");
            $xml->writeAttribute("xmlns:udt","urn:un:unece:uncefact:data:specification:UnqualifiedDataTypesSchemaModule:2");
            $xml->writeAttribute("xmlns:xsi","http://www.w3.org/2001/XMLSchema-instance");
            //$xml->writeAttribute("","");
            //$xml->writeAttribute("xmlns:sac","urn:sunat:names:specification:ubl:peru:schema:xsd:SunatAggregateComponents-1");
            //$xml->writeAttribute("xmlns:stat","urn:oasis:names:specification:ubl:schema:xsd:DocumentStatusCode-1.0");

            //$xml->writeAttribute("xmlns:xsi","http://www.w3.org/2001/XMLSchema-instance");
            //$xml->writeAttribute("xmlns:xsd","http://www.w3.org/2001/XMLSchema");
            $xml->startElement("ext:UBLExtensions");
                $xml->startElement("ext:UBLExtension");
                    $xml->startElement("ext:ExtensionContent");
                     //$xml->startElement("ds:Signature");
                     //   $xml->writeAttribute('Id', 'Firma');
                     //$xml->endElement();//fin ds:Signature
                    $xml->endElement();//fin ext:ExtensionContent
                $xml->endElement();//fin ext:UBLExtension
            $xml->endElement(); //fin ext:UBLExtensions
            $xml->writeElement("cbc:UBLVersionID", "2.1");
            $xml->writeElement("cbc:CustomizationID", "2.0");
            //$xml->startElement("cbc:ProfileID");
            //    $xml->writeAttribute("schemeName", "SUNAT:Identificador de Tipo de Operacion");
            //    $xml->writeAttribute("schemeAgencyName", "PE:SUNAT");
            //    $xml->writeAttribute("schemeURI", "urn:pe:gob:sunat:cpe:see:gem:catalogos:catalogo17");
            //    $xml->text("0101");
            //$xml->endElement(); //fin cbc:ProfileID
            $xml->startElement("cbc:ID");
                $xml->text($factura->serie."-".($factura->numero));
            $xml->endElement(); //fin cbc:ID
            $xml->startElement("cbc:IssueDate");
                $xml->text($factura->fecha);
            $xml->endElement(); //fin cbc:IssueDate
            //$xml->startElement("cbc:IssueTime");
            //    $xml->text($factura->hora);
            //$xml->endElement(); //fin cbc:IssueTime
            //$xml->startElement("cbc:DueDate");
            //    $xml->text($factura->vencimiento);
            //$xml->endElement(); //fin cbc:DueDate

            $xml->startElement("cbc:InvoiceTypeCode");
                $xml->writeAttribute("listID", "0101");
                $xml->writeAttribute("listAgencyName", "PE:SUNAT");
                $xml->writeAttribute("listURI", "urn:pe:gob:sunat:cpe:see:gem:catalogos:catalogo01");
                $xml->text($factura->comprobante_id);
            $xml->endElement(); //fin cbc:InvoiceTypeCode
            $xml->startElement("cbc:Note");
                $xml->writeAttribute("languageLocaleID", "1000");
                $xml->writeCData("SON: ".$letra);
            $xml->endElement(); //fin cbc:Note
            if($factura->detraccion == 1){
                $xml->startElement("cbc:Note");
                    $xml->writeAttribute("languageLocaleID", "2006");
                    $xml->writeCData("Operación sujeta a detracción");
                $xml->endElement(); //fin cbc:Note
            }
            $xml->startElement("cbc:DocumentCurrencyCode");
                $xml->writeAttribute("listID", "ISO 4217 Alpha");
                $xml->writeAttribute("listName", "Currency");
                //$xml->writeAttribute("listAgencyName", "United Nations Economic Commission for Europe");
                $xml->text($factura->moneda);
            $xml->endElement(); //fin cbc:DocumentCurrencyCode

            $xml->startElement("cbc:LineCountNumeric");
                $xml->text($detfacturas->count());
            $xml->endElement(); //fin cbc:LineCountNumeric
            $xml->startElement("cac:Signature");
                $xml->startElement("cbc:ID");
                    $xml->text('IDSign'.$parametro->ruc);
                $xml->endElement(); //fin cbc:ID
                $xml->startElement("cac:SignatoryParty");
                    $xml->startElement("cac:PartyIdentification");
                        $xml->startElement("cbc:ID");
                            $xml->writeAttribute("schemeID", "6");
                            $xml->writeAttribute("schemeAgencyName", "PE:SUNAT");
                            //$xml->writeAttribute("schemeName", "Documento de Identidad");
                            $xml->writeAttribute("schemeURI", "urn:pe:gob:sunat:cpe:see:gem:catalogos:catalogo06");
                            $xml->text($parametro->ruc);
                        $xml->endElement(); //fin cbc:ID
                    $xml->endElement(); //fin cac:PartyIdentification
                    $xml->startElement("cac:PartyName");
                        $xml->startElement("cbc:Name");
                            $xml->writeCData($parametro->razsoc);
                        $xml->endElement(); //fin cbc:Name
                    $xml->endElement(); //fin cac:PartyName
                $xml->endElement(); //fin cac:SignatoryParty
                $xml->startElement("cac:DigitalSignatureAttachment");
                    $xml->startElement("cac:ExternalReference");
                        $xml->startElement("cbc:URI");
                            $xml->text("#signature".$parametro->ruc);
                        $xml->endElement(); //fin cbc:URI
                    $xml->endElement(); //fin cac:ExternalReference
                $xml->endElement(); //fin cac:DigitalSignatureAttachment
            $xml->endElement(); //fin cac:Signature
            $xml->startElement("cac:AccountingSupplierParty");
                $xml->startElement("cac:Party");
                    $xml->startElement("cac:PartyIdentification");
                        $xml->startElement("cbc:ID");
                            $xml->writeAttribute("schemeID", "6");
                            $xml->writeAttribute("schemeAgencyName", "PE:SUNAT");
                            $xml->writeAttribute("schemeURI", "urn:pe:gob:sunat:cpe:see:gem:catalogos:catalogo06");
                            $xml->text($parametro->ruc);
                        $xml->endElement(); //fin cbc:ID
                    $xml->endElement(); //fin cac:PartyIdentification
                    //$xml->startElement("cac:PartyName");
                    //    $xml->startElement("cbc:Name");
                    //        $xml->writeCData($parametro->razsoc);
                    //    $xml->endElement(); //fin cbc:Name
                    //$xml->endElement(); //fin cac:PartyName
                    $xml->startElement("cac:PartyLegalEntity");
                        $xml->startElement("cbc:RegistrationName");
                            $xml->writeCData($parametro->razsoc);
                        $xml->endElement(); //fin cbc:RegistrationName
                        //$xml->startElement("CompanyID");
                        $xml->startElement("cac:RegistrationAddress");
                            $xml->startElement("cbc:AddressTypeCode");
                                $xml->text("0000");
                            $xml->endElement(); //fin cbc:AddressTypeCode
                        $xml->endElement(); //fin cac:RegistrationAddress                        
                    $xml->endElement(); //fin cac:PartyLegalEntity
                $xml->endElement(); //fin cac:Party
            $xml->endElement(); //fin cac:AccountingSupplierParty

            $xml->startElement("cac:AccountingCustomerParty");
                $xml->startElement("cac:Party");
                    $xml->startElement("cac:PartyIdentification");
                        $xml->startElement("cbc:ID");
                            $xml->writeAttribute("schemeID", $factura->cli->tipdoc_id);
                            //$xml->writeAttribute("schemeName", "Documento de Identidad");
                            $xml->writeAttribute("schemeAgencyName", "PE:SUNAT");
                            $xml->writeAttribute("schemeURI", "urn:pe:gob:sunat:cpe:see:gem:catalogos:catalogo06");
                            $xml->text($factura->ruc);
                        $xml->endElement(); //fin cbc:ID
                    $xml->endElement(); //fin cac:PartyIdentification
                    $xml->startElement("cac:PartyLegalEntity");
                        $xml->startElement("cbc:RegistrationName");
                            $xml->writeCData($factura->cli->razsoc);
                        $xml->endElement(); //fin cbc:RegistrationName
                        $xml->startElement("cac:RegistrationAddress");
                            $xml->startElement("cac:AddressLine");
                                $xml->startElement("cbc:Line");
                                    $xml->writeCData($factura->direccion);
                                $xml->endElement(); //fin cbc:Line
                            $xml->endElement(); //fin cac:AddressLine

                            $xml->startElement("cac:Country");
                                $xml->startElement("cbc:IdentificationCode");
                                    $xml->writeAttribute("listName", "Country");
                                    $xml->writeAttribute("listAgencyName", "United Nations Economic Commission for Europe");
                                    $xml->writeAttribute("listID", "ISO 3166-1");
                                    $xml->writeCData("PE");
                                $xml->endElement(); //fin cbc:IdentificationCode
                            $xml->endElement(); //fin cac:Country
                        $xml->endElement(); //fin cac:RegistrationAddress
                    $xml->endElement(); //fin cac:PartyLegalEntity
                $xml->endElement(); //fin cac:Party
            $xml->endElement(); //fin cac:AccountingCustomerParty
            if($factura->detraccion == 1){
                $xml->startElement("cac:PaymentMeans");
                    $xml->startElement("cbc:PaymentMeansCode");
                        $xml->text("001");
                    $xml->endElement(); //fin cbc:PaymentMeansCode
                    $xml->startElement("cac:PayeeFinancialAccount");
                        $xml->startElement("cbc:ID");
                            $xml->writeAttribute("schemeName", "SUNAT:Codigo de detraccion");
                            $xml->writeAttribute("schemeAgencyName", "PE:SUNAT");
                            $xml->writeAttribute("schemeURI", "urn:pe:gob:sunat:cpe:see:gem:catalogos:catalogo54");
                            $xml->text($parametro->cuenta);
                        $xml->endElement(); //fin cbc:ID
                    $xml->endElement(); //fin cac:PayeeFinancialAccount
                $xml->endElement(); //fin cac:PaymentMeans

                $xml->startElement("cac:PaymentTerms");
                    $xml->startElement("cbc:PaymentMeansID");
                        $xml->text($factura->detraccion_id);
                    $xml->endElement(); //fin cbc:PaymentMeansID
                    $xml->startElement("cbc:PaymentPercent");
                        $xml->text($factura->detraccion_por);
                    $xml->endElement(); //fin cbc:PaymentPercent
                    $xml->startElement("cbc:Amount");
                        $xml->writeAttribute("currencyID", $factura->moneda);
                        $xml->text($factura->detraccion_monto);
                    $xml->endElement(); //fin cbc:Amount
                $xml->endElement(); //fin cac:PaymentTerms
            }
            //Inicio Total Afecto e IGV
            $xml->startElement("cac:TaxTotal");
                $xml->startElement("cbc:TaxAmount");
                    $xml->writeAttribute("currencyID", $factura->moneda);
                    $xml->text($factura->tot_igv);
                $xml->endElement(); //fin cbc:TaxAmount
                $xml->startElement("cac:TaxSubtotal");
                    $xml->startElement("cbc:TaxableAmount");
                        $xml->writeAttribute("currencyID", $factura->moneda);
                        $xml->text(round($factura->tot_gravadas,2));
                    $xml->endElement(); //fin cbc:TaxableAmount
                    $xml->startElement("cbc:TaxAmount");
                        $xml->writeAttribute("currencyID", $factura->moneda);
                        $xml->text($factura->tot_igv);
                    $xml->endElement(); //fin cbc:TaxAmount
                    $xml->startElement("cac:TaxCategory");
                        $xml->startElement("cbc:ID");
                            $xml->writeAttribute("schemeID", "UN/ECE 5305");
                            $xml->writeAttribute("schemeName", "Tax Category Identifier");
                            //$xml->writeAttribute("schemeAgencyName", "United Nations Economic Commission for Europe");
                            $xml->text("S");
                        $xml->endElement(); //fin cbc:ID
                        $xml->startElement("cac:TaxScheme");
                            $xml->startElement("cbc:ID");
                                $xml->writeAttribute("schemeID", "UN/ECE 5153");
                                $xml->writeAttribute("schemeAgencyID", "6");
                                $xml->text("1000");
                            $xml->endElement(); //fin cbc:ID
                            $xml->startElement("cbc:Name");
                                $xml->text("IGV");
                            $xml->endElement(); //fin cbc:Name
                            $xml->startElement("cbc:TaxTypeCode");
                                $xml->text("VAT");
                            $xml->endElement(); //fin cbc:TaxTypeCode
                        $xml->endElement(); //fin cac:TaxScheme
                    $xml->endElement(); //fin cac:TaxCategory
                $xml->endElement(); //fin cac:TaxSubtotal
                //--------------------------------------------
                $xml->startElement("cac:TaxSubtotal");
                        $xml->startElement("cbc:TaxableAmount");
                            $xml->writeAttribute("currencyID", $factura->moneda);
                            $xml->text(round($factura->tot_inafectas,2));
                        $xml->endElement(); //fin cbc:TaxableAmount
                        $xml->startElement("cbc:TaxAmount");
                            $xml->writeAttribute("currencyID", $factura->moneda);
                            $xml->text("0.00");
                        $xml->endElement(); //fin cbc:TaxAmount
                        $xml->startElement("cac:TaxCategory");
                            $xml->startElement("cbc:ID");
                                $xml->writeAttribute("schemeID", "UN/ECE 5305");
                                $xml->writeAttribute("schemeName", "Tax Category Identifier");
                                //$xml->writeAttribute("schemeAgencyName", "United Nations Economic Commission for Europe");
                                $xml->text("O");
                            $xml->endElement(); //fin cbc:ID
                            $xml->startElement("cac:TaxScheme");
                                $xml->startElement("cbc:ID");
                                    $xml->writeAttribute("schemeID", "UN/ECE 5153");
                                    $xml->writeAttribute("schemeAgencyID", "6");
                                    $xml->text("9998");
                                $xml->endElement(); //fin cbc:ID
                                $xml->startElement("cbc:Name");
                                    $xml->text("INA");
                                $xml->endElement(); //fin cbc:Name
                                $xml->startElement("cbc:TaxTypeCode");
                                    $xml->text("FRE");
                                $xml->endElement(); //fin cbc:TaxTypeCode
                            $xml->endElement(); //fin cac:TaxScheme
                        $xml->endElement(); //fin cac:TaxCategory
                    $xml->endElement(); //fin cac:TaxSubtotal
                //--------------------------------------------
                    $xml->startElement("cac:TaxSubtotal");
                        $xml->startElement("cbc:TaxableAmount");
                            $xml->writeAttribute("currencyID", $factura->moneda);
                            $xml->text(round($factura->tot_exoneradas,2));
                        $xml->endElement(); //fin cbc:TaxableAmount
                        $xml->startElement("cbc:TaxAmount");
                            $xml->writeAttribute("currencyID", $factura->moneda);
                            $xml->text("0.00");
                        $xml->endElement(); //fin cbc:TaxAmount
                        $xml->startElement("cac:TaxCategory");
                            $xml->startElement("cbc:ID");
                                $xml->writeAttribute("schemeID", "UN/ECE 5305");
                                $xml->writeAttribute("schemeName", "Tax Category Identifier");
                                //$xml->writeAttribute("schemeAgencyName", "United Nations Economic Commission for Europe");
                                $xml->text("E");
                            $xml->endElement(); //fin cbc:ID
                            $xml->startElement("cac:TaxScheme");
                                $xml->startElement("cbc:ID");
                                    $xml->writeAttribute("schemeAgencyID", "6");
                                    $xml->writeAttribute("schemeID", "UN/ECE 5153");                                    
                                    $xml->text("9997");
                                $xml->endElement(); //fin cbc:ID
                                $xml->startElement("cbc:Name");
                                    $xml->text("EXO");
                                $xml->endElement(); //fin cbc:Name
                                $xml->startElement("cbc:TaxTypeCode");
                                    $xml->text("VAT");
                                $xml->endElement(); //fin cbc:TaxTypeCode
                            $xml->endElement(); //fin cac:TaxScheme
                        $xml->endElement(); //fin cac:TaxCategory
                    $xml->endElement(); //fin cac:TaxSubtotal
                //--------------------------------------------
            $xml->endElement(); //fin cac:TaxTotal
            $xml->startElement("cac:LegalMonetaryTotal");
                $xml->startElement("cbc:LineExtensionAmount");
                    $xml->writeAttribute("currencyID", $factura->moneda);
                    $xml->text($factura->tot_gravadas + $factura->tot_inafectas + $factura->tot_exoneradas);
                $xml->endElement(); //fin cbc:LineExtensionAmount
                $xml->startElement("cbc:TaxInclusiveAmount");
                    $xml->writeAttribute("currencyID", $factura->moneda);
                    $xml->text($factura->total_clinica);
                $xml->endElement(); //fin cbc:TaxInclusiveAmount
                //$xml->startElement("cbc:AllowanceTotalAmount");
                //    $xml->writeAttribute("currencyID", $factura->moneda);
                //    $xml->text("0.00");
                //$xml->endElement(); //fin cbc:AllowanceTotalAmount
                $xml->startElement("cbc:PayableAmount");
                    $xml->writeAttribute("currencyID", $factura->moneda);
                    $xml->text($factura->total_clinica);
                $xml->endElement(); //fin cbc:PayableAmount
            $xml->endElement(); //fin cac:LegalMonetaryTotal
            //Detalles de comprobante
            $i = 1;
            foreach($detfacturas as $detfactura){
                if($detfactura->afectacion_id >= "10" && $detfactura->afectacion_id < "20"){
                    $valventa = round($detfactura->stcli / (1+($parametro->por_igv/100)),2);
                    $Name = "IGV";
                    $TaxTypeCode = "VAT";
                }elseif($detfactura->afectacion_id >= "20" && $detfactura->afectacion_id < "30"){
                    $valventa = $detfactura->stcli;
                    $Name = "EXONERADO";
                    $TaxTypeCode = "VAT";
                }else{
                    $valventa = $detfactura->stcli;
                    $Name = "INAFECTO";
                    $TaxTypeCode = "FREE";
                }

                $xml->startElement("cac:InvoiceLine");
                    $xml->startElement("cbc:ID");
                        $xml->text($i);
                    $xml->endElement(); //fin cbc:ID
                    $xml->startElement("cbc:InvoicedQuantity");
                        $xml->writeAttribute("unitCode", "ZZ");
                        $xml->writeAttribute("unitCodeListID", "UN/ECE rec 20");
                        //$xml->writeAttribute("unitCodeListAgencyName", "United Nations Economic Commission for Europe");
                        $xml->text(round($detfactura->cantidad,2));
                    $xml->endElement(); //fin cbc:InvoicedQuantity
                    $xml->startElement("cbc:LineExtensionAmount");
                        $xml->writeAttribute("currencyID", $factura->moneda);
                        $xml->text($valventa);
                    $xml->endElement(); //fin cbc:LineExtensionAmount
                    $xml->startElement("cac:PricingReference");
                        $xml->startElement("cac:AlternativeConditionPrice");
                            $xml->startElement("cbc:PriceAmount");
                                $xml->writeAttribute("currencyID", $factura->moneda);
                                $xml->text($detfactura->stcli);
                            $xml->endElement(); //fin cbc:PriceAmount
                            $xml->startElement("cbc:PriceTypeCode");
                                $xml->writeAttribute("listAgencyName", "PE:SUNAT");
                                $xml->writeAttribute("listURI", "urn:pe:gob:sunat:cpe:see:gem:catalogos:catalogo16");
                                //$xml->writeAttribute("listName", "SUNAT:Indicador de Tipo de Precio");
                                $xml->text("01");
                            $xml->endElement(); //fin cbc:PriceTypeCode
                        $xml->endElement(); //fin cac:AlternativeConditionPrice
                    $xml->endElement(); //fin cac:PricingReference
                    $xml->startElement("cac:TaxTotal");
                        $xml->startElement("cbc:TaxAmount");
                            $xml->writeAttribute("currencyID", $factura->moneda);
                            $xml->text($detfactura->stcli - $valventa);
                        $xml->endElement(); //fin cbc:TaxAmount
                        $xml->startElement("cac:TaxSubtotal");
                            $xml->startElement("cbc:TaxableAmount");
                                $xml->writeAttribute("currencyID", $factura->moneda);
                                $xml->text($valventa);
                            $xml->endElement(); //fin cbc:TaxableAmount
                            $xml->startElement("cbc:TaxAmount");
                                $xml->writeAttribute("currencyID", $factura->moneda);
                                $xml->text($detfactura->stcli - $valventa);
                            $xml->endElement(); //fin cbc:TaxAmount
                            $xml->startElement("cac:TaxCategory");
                                $xml->startElement("cbc:ID");
                                    $xml->writeAttribute("schemeID", "UN/ECE 5305");
                                    $xml->writeAttribute("schemeName", "Tax Category Identifier");
                                    //$xml->writeAttribute("schemeAgencyName", "United Nations Economic Commission for Europe");
                                    $xml->text("S");
                                $xml->endElement(); //fin cbc:ID
                                $xml->startElement("cbc:Percent");
                                    $xml->text($parametro->por_igv);
                                $xml->endElement(); //fin cbc:Percent
                                $xml->startElement("cbc:TaxExemptionReasonCode");
                                    $xml->writeAttribute("listAgencyName", "PE:SUNAT");
                                    //$xml->writeAttribute("listName", "SUNAT:Codigo de Tipo de Afectacion del IGV");
                                    $xml->writeAttribute("listURI", "urn:pe:gob:sunat:cpe:see:gem:catalogos:catalogo07");
                                    $xml->text($detfactura->afectacion_id);
                                $xml->endElement(); //fin cbc:TaxExemptionReasonCode
                                $xml->startElement("cac:TaxScheme");
                                    $xml->startElement("cbc:ID");
                                        $xml->writeAttribute("schemeID", "UN/ECE 5153");
                                        //$xml->writeAttribute("schemeName", "Tax Scheme Identifier");
                                        //$xml->writeAttribute("schemeAgencyName", "United Nations Economic Commission for Europe");
                                        $xml->text("1000");
                                    $xml->endElement(); //fin cbc:ID
                                    $xml->startElement("cbc:Name");
                                        $xml->text($Name);
                                    $xml->endElement(); //fin cbc:Name
                                    $xml->startElement("cbc:TaxTypeCode");
                                        $xml->text($TaxTypeCode);
                                    $xml->endElement(); //fin cbc:TaxTypeCode
                                $xml->endElement(); //fin cac:TaxScheme
                            $xml->endElement(); //fin cac:TaxCategory
                        $xml->endElement(); //fin cac:TaxSubtotal
                    $xml->endElement(); //fin cac:TaxTotal
                    $xml->startElement("cac:Item");
                        $xml->startElement("cbc:Description");
                            //$xml->writeCData($detfactura->servicio);                            
                            $Serv = preg_replace("/[\r\n|\n|\r]+/", " ", $detfactura->servicio);
                            $xml->writeCData($Serv);
                        $xml->endElement(); //fin cbc:Description
                    $xml->endElement(); //fin cac:Item
                    $xml->startElement("cac:Price");
                        $xml->startElement("cbc:PriceAmount");
                            $xml->writeAttribute("currencyID", $factura->moneda);
                            $xml->text(round($valventa/$detfactura->cantidad,2));
                        $xml->endElement(); //fin cbc:PriceAmount
                    $xml->endElement(); //fin cac:Price

                $xml->endElement(); //fin cac:InvoiceLine
                
                $i++;
            }

        
        $xml->endElement(); //Fin Invoice
        $xml->endDocument();

        $content = $xml->outputMemory();
        $archivo = $factura->ruc.'/'.$archivo;
        Storage::disk('invoice')->makeDirectory($factura->ruc);
        //file_put_contents($archivo, $content);
        Storage::disk('invoice')->put($archivo, $content);
        
        $certPath = 'certificate.pem';
        
        $signer = new SignedXml();
        $signer->setCertificateFromFile($certPath);
        //$xmlSigned = $signer->signFromFile(url('/').'/invoice/'.$archivo);
        $xmlSigned = $signer->signXml($content);
        //file_put_contents($archivo, $xmlSigned);
        Storage::disk('invoice')->put($archivo, $xmlSigned);        

        /*

        $zip = new ZipArchive();
        $filename = $parametro->ruc.'-'.$factura->comprobante_id.'-'.$factura->serie.'-'.intval($factura->numero).".zip";
        $zip->open('invoice/'.$factura->ruc.'/'.$filename, ZipArchive::CREATE);
        $nombrerelativo = basename($archivo);
        $zip->addFile($archivo,$nombrerelativo);
        $zip->close();

        //$url = 'https://www.sunat.gob.pe:443/ol-ti-itcpgem-beta/billService?wsdl';
        $url = 'https://e-beta.sunat.gob.pe/ol-ti-itcpfegem-beta/billService?wsdl';
        
        $client = new SoapClient($url);

        $base = base64_encode(file_get_contents(url('invoice/'.$factura->ruc.'/'.$filename)));
        */

        // URL del servicio para Facturas (BETA ó PRODUCCION).
        $user = $parametro->ruc.$parametro->usuario;
        $pass = $parametro->clave;
        //Beta
        // $urlService = 'https://e-beta.sunat.gob.pe/ol-ti-itcpfegem-beta/billService';
        $urlService = $parametro->servidor;
        //Homologación
        //$urlService = 'https://www.sunat.gob.pe/ol-ti-itcpgem-sqa/billService';
        $soap = new SoapClient();
        $soap->setService($urlService);
        $soap->setCredentials($user, $pass);
        $sender = new BillSender();
        $sender->setClient($soap);
        //$xml = file_get_contents($archivo);
        
        $xml = Storage::disk('invoice')->get($archivo);        
        $envio = $parametro->ruc.'-'.$factura->comprobante_id.'-'.$factura->serie.'-'.($factura->numero);
        $result = $sender->send($envio, $xml);

        if (!$result->isSuccess()) {
            // Error en la conexion con el servicio de SUNAT
            //var_dump($result->getError());
            $factura->cdr = var_dump($result->getError());
            // $factura->cdr = $result->getCdrResponse();
            // $fact = $factura->save();
            // return redirect('/admin/factura/'.$factura->id.'/edit')->with('message', 'Problemas de conexión')->with('typealert', 'danger');
            // return 'Error de conexión';
        }
        $factura->status = 4;
        $cdr = $result->getCdrResponse();
        //file_put_contents('invoice/'.$factura->ruc.'/'.'R-'.$envio.'.zip', $result->getCdrZip());
        $arcresul = $factura->ruc.'/'.'R-'.$envio.'.zip';
        Storage::disk('invoice')->put($arcresul, $result->getCdrZip());

        // Verificar CDR (Factura aceptada o rechazada)
        $code = (int)$cdr->getCode();
        $mensaje = '';

        if ($code === 0) {
            $mensaje = 'ESTADO: ACEPTADA';
            $factura->status = 5;
            if (count($cdr->getNotes()) > 0) {
                $mensaje = ', INCLUYE OBSERVACIONES: ';
                // Mostrar observaciones
                foreach ($cdr->getNotes() as $obs) {
                    $mensaje = 'OBS: '.$obs.', ';
                }
            }
        
        } else if ($code >= 2000 && $code <= 3999) {
            $mensaje = 'ESTADO: RECHAZADA'.', ';
            $factura->status = 6;
        
        } else {
            /* Esto no debería darse, pero si ocurre, es un CDR inválido que debería tratarse como un error-excepción. */
            /*code: 0100 a 1999 */
            $factura->status = 6;
            $mensaje = 'Excepción'.' ';
        }
        
        $mensaje = $cdr->getDescription();

        $factura->cdr = $mensaje;
        
        if($factura->save()){
            return redirect('/admin/factura/'.$factura->id.'/edit')->with('message', 'Documento enviado al servidor de Sunat')->with('typealert', 'success');
        }else{
            return redirect('/admin/factura/'.$factura->id.'/edit')->with('message', 'Problemas de conexión, vuelva a realizar el envío')->with('typealert', 'danger');
        }        
        /* Comprime XML a Zip
        $zip = new ZipArchive();
        $filename = $parametro->ruc.'-'.$factura->comprobante_id.'-'.$factura->serie.'-'.intval($factura->numero).".zip";
        $zip->open('invoice/'.$factura->ruc.'/'.$filename, ZipArchive::CREATE);
        $nombrerelativo = basename($archivo);
        $zip->addFile($archivo,$nombrerelativo);
        $zip->close();
        */

        
       //return  $a;
    }

    public function getSunatNotaAdmision($id)
    {
        $nota = NotaAdm::with(['cli'])->findOrFail($id);
        $detnotas = DetNotaAdm::where('notaadm_id',$id)->get();
        $moneda = Categoria::where('modulo', 10)->pluck('nombre','codigo');
        $fpago = Categoria::where('modulo', 11)->pluck('nombre','codigo');
        $comprobante = Comprobante::where('activo',1)->pluck('nombre','codigo');
        $clientes = Paciente::orderBy('razsoc','asc')->pluck('razsoc','numdoc');
        $doctor = Doctor::orderBy('nombre','asc')->pluck('nombre','id');
        $afectacion = Afectacion::pluck('nombre','codigo');
        $parametro = Param::findOrFail(1);
        $formatter = new NumeroALetras();
        
        if($nota->moneda=='PEN'){
            $letra = $formatter->toInvoice($nota->total, 2, 'soles');
        }else{
            $letra = $formatter->toInvoice($nota->total, 2, 'dólares americanos');
        }

        if($nota->comprobante_id == '07'){
            $inicio = "CreditNote";
            $xmlns = "urn:oasis:names:specification:ubl:schema:xsd:CreditNote-2";
            $listName = "Tipo de nota de credito";
            $NoteLine = "cac:CreditNoteLine";
            $Quantity = "cbc:CreditedQuantity";
        }else{
            $inicio = "DebitNote";
            $xmlns = "urn:oasis:names:specification:ubl:schema:xsd:DebitNote-2";
            $listName = "Tipo de nota de debito";
            $NoteLine = "cac:DebitNoteLine";
            $Quantity = "cbc:DebitedQuantity";
        }

        $archivo = $parametro->ruc.'-'.$nota->comprobante_id.'-'.$nota->serie.'-'.($nota->numero).'.xml';

        $xml = new XMLWriter();    
        //$xml->openURI($archivo);
        $xml->openMemory();
        $xml->setIndent(true);
        //$xml->setIndentString('	'); 
        //$xml->startDocument("1.0", "UTF-8","no");
        $xml->startDocument("1.0", "utf-8","no");
        $xml->startElement($inicio);
        $xml->writeAttribute("xmlns", $xmlns);
        $xml->writeAttribute("xmlns:xsi", "http://www.w3.org/2001/XMLSchema-instance");
        $xml->writeAttribute("xmlns:cac","urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2");
        $xml->writeAttribute("xmlns:cbc","urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2");
        $xml->writeAttribute("xmlns:udt","urn:un:unece:uncefact:data:specification:UnqualifiedDataTypesSchemaModule:2");
        $xml->writeAttribute("xmlns:ccts","urn:un:unece:uncefact:documentation:2");
        $xml->writeAttribute("xmlns:ext","urn:oasis:names:specification:ubl:schema:xsd:CommonExtensionComponents-2");
        $xml->writeAttribute("xmlns:qdt","urn:oasis:names:specification:ubl:schema:xsd:QualifiedDatatypes-2");
        $xml->writeAttribute("xmlns:ds","http://www.w3.org/2000/09/xmldsig#");
        $xml->writeAttribute("xmlns:sac","urn:sunat:names:specification:ubl:peru:schema:xsd:SunatAggregateComponents-1");
       
        $xml->startElement("ext:UBLExtensions");
            $xml->startElement("ext:UBLExtension");
                $xml->startElement("ext:ExtensionContent");
                    //$xml->startElement("ds:Signature");
                    //   $xml->writeAttribute('Id', 'Firma');
                    //$xml->endElement();//fin ds:Signature
                $xml->endElement();//fin ext:ExtensionContent
            $xml->endElement();//fin ext:UBLExtension
        $xml->endElement(); //fin ext:UBLExtensions
        $xml->writeElement("cbc:UBLVersionID", "2.1");
        $xml->writeElement("cbc:CustomizationID", "2.0");
        //$xml->startElement("cbc:ProfileID");
        //    $xml->writeAttribute("schemeName", "SUNAT:Identificador de Tipo de Operacion");
        //    $xml->writeAttribute("schemeAgencyName", "PE:SUNAT");
        //    $xml->writeAttribute("schemeURI", "urn:pe:gob:sunat:cpe:see:gem:catalogos:catalogo17");
        //    $xml->text("0101");
        //$xml->endElement(); //fin cbc:ProfileID
        $xml->startElement("cbc:ID");
            $xml->text($nota->serie."-".($nota->numero));
        $xml->endElement(); //fin cbc:ID
        $xml->startElement("cbc:IssueDate");
            $xml->text($nota->fecha);
        $xml->endElement(); //fin cbc:IssueDate
        $xml->startElement("cbc:IssueTime");
            $xml->text($nota->hora);
        $xml->endElement(); //fin cbc:IssueTime
        $xml->startElement("cbc:Note");
            $xml->writeAttribute("languageLocaleID", "1000");
            $xml->writeCData("SON: ".$letra);
        $xml->endElement(); //fin cbc:Note
        $xml->startElement("cbc:DocumentCurrencyCode");
            $xml->writeAttribute("listID", "ISO 4217 Alpha");
            $xml->writeAttribute("listAgencyName", "United Nations Economic Commission for Europe");
            $xml->writeAttribute("listName", "Currency");
            $xml->text($nota->moneda);
        $xml->endElement(); //fin cbc:DocumentCurrencyCode
        $xml->startElement("cac:DiscrepancyResponse");
            $xml->startElement("cbc:ReferenceID");
                $xml->text($nota->dmserie."-".$nota->dmnumero);
            $xml->endElement(); //fin cbc:ReferenceID
            $xml->startElement("cbc:ResponseCode");
                $xml->writeAttribute("listAgencyName", "PE:SUNAT");
                $xml->writeAttribute("listName", $listName);
                $xml->writeAttribute("listURI", "urn:pe:gob:sunat:cpe:see:gem:catalogos:catalogo09");
                $xml->text($nota->dmtipo_id);
            $xml->endElement(); //fin cbc:ResponseCode
            $xml->startElement("cbc:Description");
                $xml->writeCData($nota->dmdescripcion);
            $xml->endElement(); //fin cbc:Description
        $xml->endElement(); //fin cac:DiscrepancyResponse

        $xml->startElement("cac:BillingReference");
            $xml->startElement("cac:InvoiceDocumentReference");
                $xml->startElement("cbc:ID");
                    $xml->text($nota->dmserie."-".$nota->dmnumero);
                $xml->endElement(); //fin cbc:ID
                // $xml->startElement("cbc:IssueDate");
                //     $xml->text($nota->fecha);
                // $xml->endElement(); //fin cbc:IssueDate
                $xml->startElement("cbc:DocumentTypeCode");
                    $xml->writeAttribute("listAgencyName", "PE:SUNAT");
                    $xml->writeAttribute("listName", "Tipo de Documento");
                    $xml->writeAttribute("listURI", "urn:pe:gob:sunat:cpe:see:gem:catalogos:catalogo01");
                    $xml->text($nota->dmcomprobante_id);
                $xml->endElement(); //fin cbc:DocumentTypeCode
            $xml->endElement(); //fin cac:InvoiceDocumentReference
        $xml->endElement(); //fin cac:BillingReference

            // $xml->startElement("cbc:LineCountNumeric");
            //     $xml->text($detnotas->count());
            // $xml->endElement(); //fin cbc:LineCountNumeric
            
        $xml->startElement("cac:Signature");
            $xml->startElement("cbc:ID");
                $xml->text('IDSignST');
            $xml->endElement(); //fin cbc:ID
            // $xml->startElement("cbc:Note");
            //     $xml->text('GREENTER');
            // $xml->endElement(); //fin cbc:Note
            $xml->startElement("cac:SignatoryParty");
                $xml->startElement("cac:PartyIdentification");
                    $xml->startElement("cbc:ID");
                        // $xml->writeAttribute("schemeID", "6");
                        // $xml->writeAttribute("schemeAgencyName", "PE:SUNAT");
                        // //$xml->writeAttribute("schemeName", "Documento de Identidad");
                        // $xml->writeAttribute("schemeURI", "urn:pe:gob:sunat:cpe:see:gem:catalogos:catalogo06");
                        $xml->text($parametro->ruc);
                    $xml->endElement(); //fin cbc:ID
                $xml->endElement(); //fin cac:PartyIdentification
                $xml->startElement("cac:PartyName");
                    $xml->startElement("cbc:Name");
                        $xml->writeCData($parametro->razsoc);
                    $xml->endElement(); //fin cbc:Name
                $xml->endElement(); //fin cac:PartyName
            $xml->endElement(); //fin cac:SignatoryParty
            $xml->startElement("cac:DigitalSignatureAttachment");
                $xml->startElement("cac:ExternalReference");
                    $xml->startElement("cbc:URI");
                        $xml->text("signature".$parametro->ruc);
                    $xml->endElement(); //fin cbc:URI
                $xml->endElement(); //fin cac:ExternalReference
            $xml->endElement(); //fin cac:DigitalSignatureAttachment
        $xml->endElement(); //fin cac:Signature
        $xml->startElement("cac:AccountingSupplierParty");
            $xml->startElement("cac:Party");
                $xml->startElement("cac:PartyIdentification");
                    $xml->startElement("cbc:ID");
                        $xml->writeAttribute("schemeID", "6");
                        $xml->writeAttribute("schemeName", "Documento de Identidad");
                        $xml->writeAttribute("schemeAgencyName", "PE:SUNAT");
                        $xml->writeAttribute("schemeURI", "urn:pe:gob:sunat:cpe:see:gem:catalogos:catalogo06");
                        $xml->text($parametro->ruc);
                    $xml->endElement(); //fin cbc:ID
                $xml->endElement(); //fin cac:PartyIdentification
                $xml->startElement("cac:PartyName");
                    $xml->startElement("cbc:Name");
                        $xml->writeCData($parametro->razsoc);
                    $xml->endElement(); //fin cbc:Name
                $xml->endElement(); //fin cac:PartyName
                $xml->startElement("cac:PartyLegalEntity");
                    $xml->startElement("cbc:RegistrationName");
                        $xml->writeCData($parametro->razsoc);
                    $xml->endElement(); //fin cbc:RegistrationName
                    //$xml->startElement("CompanyID");
                    $xml->startElement("cac:RegistrationAddress");
                        $xml->startElement("cbc:ID");
                            $xml->writeAttribute("schemeName", "Ubigeos");
                            $xml->writeAttribute("schemeAgencyName", "PE:INEI");
                            $xml->text($parametro->ubigeo);
                        $xml->endElement(); //fin cbc:ID
                        $xml->startElement("cbc:AddressTypeCode");
                            $xml->writeAttribute("listAgencyName", "PE:SUNAT");
                            $xml->writeAttribute("listName", "Establecimientos anexos");
                            $xml->text("0000");
                        $xml->endElement(); //fin cbc:AddressTypeCode
                        $xml->startElement("cbc:CityName");
                            $xml->text($parametro->provincia);
                        $xml->endElement(); //fin cbc:CityName
                        $xml->startElement("cbc:CountrySubentity");
                            $xml->text($parametro->provincia);
                        $xml->endElement(); //fin cbc:CountrySubentity
                        $xml->startElement("cbc:District");
                            $xml->text($parametro->distrito);
                        $xml->endElement(); //fin cbc:District
                        // $xml->startElement("cbc:CitySubdivisionName");
                        //     $xml->text("-");
                        // $xml->endElement(); //fin cbc:CitySubdivisionName
                        $xml->startElement("cac:AddressLine");
                            $xml->startElement("cbc:Line");
                                $xml->text($parametro->direccion);
                            $xml->endElement(); //fin cbc:Line                      
                        $xml->endElement(); //fin cac:AddressLine
                        $xml->startElement("cac:Country");
                            $xml->startElement("cbc:IdentificationCode");
                                $xml->text($parametro->pais);
                            $xml->endElement(); //fin cbc:IdentificationCode
                        $xml->endElement(); //fin cac:Country
                    $xml->endElement(); //fin cac:RegistrationAddress
                $xml->endElement(); //fin cac:PartyLegalEntity
            $xml->endElement(); //fin cac:Party
        $xml->endElement(); //fin cac:AccountingSupplierParty

        $xml->startElement("cac:AccountingCustomerParty");
            $xml->startElement("cac:Party");
                $xml->startElement("cac:PartyIdentification");
                    $xml->startElement("cbc:ID");
                        $xml->writeAttribute("schemeID", $nota->cli->tipdoc_id);
                        $xml->writeAttribute("schemeName", "Documento de Identidad");
                        $xml->writeAttribute("schemeAgencyName", "PE:SUNAT");
                        $xml->writeAttribute("schemeURI", "urn:pe:gob:sunat:cpe:see:gem:catalogos:catalogo06");
                        $xml->text($nota->ruc);
                    $xml->endElement(); //fin cbc:ID
                $xml->endElement(); //fin cac:PartyIdentification
                $xml->startElement("cac:PartyLegalEntity");
                    $xml->startElement("cbc:RegistrationName");
                        $xml->writeCData($nota->cli->razsoc);
                    $xml->endElement(); //fin cbc:RegistrationName
                    $xml->startElement("cac:RegistrationAddress");
                        $xml->startElement("cac:AddressLine");
                            $xml->startElement("cbc:Line");
                                $xml->writeCData($nota->direccion);
                            $xml->endElement(); //fin cbc:Line
                        $xml->endElement(); //fin cac:AddressLine

                        $xml->startElement("cac:Country");
                            $xml->startElement("cbc:IdentificationCode");
                                $xml->writeAttribute("listID", "ISO 3166-1");
                                $xml->writeAttribute("listAgencyName", "United Nations Economic Commission for Europe");
                                $xml->writeAttribute("listName", "Country");
                                $xml->text("PE");
                            $xml->endElement(); //fin cbc:IdentificationCode
                        $xml->endElement(); //fin cac:Country
                    $xml->endElement(); //fin cac:RegistrationAddress
                $xml->endElement(); //fin cac:PartyLegalEntity
            $xml->endElement(); //fin cac:Party
        $xml->endElement(); //fin cac:AccountingCustomerParty
        //Inicio Total Afecto e IGV
        $xml->startElement("cac:TaxTotal");
            $xml->startElement("cbc:TaxAmount");
                $xml->writeAttribute("currencyID", $nota->moneda);
                $xml->text($nota->tot_igv);
            $xml->endElement(); //fin cbc:TaxAmount
            $xml->startElement("cac:TaxSubtotal");
                $xml->startElement("cbc:TaxableAmount");
                    $xml->writeAttribute("currencyID", $nota->moneda);
                    $xml->text(round($nota->tot_gravadas,2));
                $xml->endElement(); //fin cbc:TaxableAmount
                $xml->startElement("cbc:TaxAmount");
                    $xml->writeAttribute("currencyID", $nota->moneda);
                    $xml->text($nota->tot_igv);
                $xml->endElement(); //fin cbc:TaxAmount
                $xml->startElement("cac:TaxCategory");
                    $xml->startElement("cbc:Percent");
                        $xml->text($parametro->por_igv);
                    $xml->endElement(); //fin cbc:Percent
                    // $xml->startElement("cbc:ID");
                    //     // $xml->writeAttribute("schemeID", "UN/ECE 5305");
                    //     // $xml->writeAttribute("schemeName", "Tax Category Identifier");
                    //     //$xml->writeAttribute("schemeAgencyName", "United Nations Economic Commission for Europe");
                    //     $xml->text("S");
                    // $xml->endElement(); //fin cbc:ID
                    $xml->startElement("cac:TaxScheme");
                        $xml->startElement("cbc:ID");
                            $xml->writeAttribute("schemeName", "Codigo de tributos");
                            $xml->writeAttribute("schemeAgencyName", "PE:SUNAT");
                            $xml->writeAttribute("schemeURI", "urn:pe:gob:sunat:cpe:see:gem:catalogos:catalogo05");
                            $xml->text("1000");
                        $xml->endElement(); //fin cbc:ID
                        $xml->startElement("cbc:Name");
                            $xml->text("IGV");
                        $xml->endElement(); //fin cbc:Name
                        $xml->startElement("cbc:TaxTypeCode");
                            $xml->text("VAT");
                        $xml->endElement(); //fin cbc:TaxTypeCode
                    $xml->endElement(); //fin cac:TaxScheme
                $xml->endElement(); //fin cac:TaxCategory
            $xml->endElement(); //fin cac:TaxSubtotal
            //--------------------------------------------
            $xml->startElement("cac:TaxSubtotal");
                    $xml->startElement("cbc:TaxableAmount");
                        $xml->writeAttribute("currencyID", $nota->moneda);
                        $xml->text(round($nota->tot_inafectas,2));
                    $xml->endElement(); //fin cbc:TaxableAmount
                    $xml->startElement("cbc:TaxAmount");
                        $xml->writeAttribute("currencyID", $nota->moneda);
                        $xml->text("0.00");
                    $xml->endElement(); //fin cbc:TaxAmount
                    $xml->startElement("cac:TaxCategory");
                        // $xml->startElement("cbc:ID");
                        //     $xml->writeAttribute("schemeID", "UN/ECE 5305");
                        //     $xml->writeAttribute("schemeName", "Tax Category Identifier");
                        //     //$xml->writeAttribute("schemeAgencyName", "United Nations Economic Commission for Europe");
                        //     $xml->text("O");
                        // $xml->endElement(); //fin cbc:ID
                        $xml->startElement("cac:TaxScheme");
                            $xml->startElement("cbc:ID");
                                $xml->writeAttribute("schemeName", "Codigo de tributos");
                                $xml->writeAttribute("schemeAgencyName", "PE:SUNAT");
                                $xml->writeAttribute("schemeURI", "urn:pe:gob:sunat:cpe:see:gem:catalogos:catalogo05");
                                $xml->text("9998");
                            $xml->endElement(); //fin cbc:ID
                            $xml->startElement("cbc:Name");
                                $xml->text("INA");
                            $xml->endElement(); //fin cbc:Name
                            $xml->startElement("cbc:TaxTypeCode");
                                $xml->text("FRE");
                            $xml->endElement(); //fin cbc:TaxTypeCode
                        $xml->endElement(); //fin cac:TaxScheme
                    $xml->endElement(); //fin cac:TaxCategory
                $xml->endElement(); //fin cac:TaxSubtotal
            //--------------------------------------------
                $xml->startElement("cac:TaxSubtotal");
                    $xml->startElement("cbc:TaxableAmount");
                        $xml->writeAttribute("currencyID", $nota->moneda);
                        $xml->text(round($nota->tot_exoneradas,2));
                    $xml->endElement(); //fin cbc:TaxableAmount
                    $xml->startElement("cbc:TaxAmount");
                        $xml->writeAttribute("currencyID", $nota->moneda);
                        $xml->text("0.00");
                    $xml->endElement(); //fin cbc:TaxAmount
                    $xml->startElement("cac:TaxCategory");
                        // $xml->startElement("cbc:ID");
                        //     $xml->writeAttribute("schemeID", "UN/ECE 5305");
                        //     $xml->writeAttribute("schemeName", "Tax Category Identifier");
                        //     //$xml->writeAttribute("schemeAgencyName", "United Nations Economic Commission for Europe");
                        //     $xml->text("E");
                        // $xml->endElement(); //fin cbc:ID
                        $xml->startElement("cac:TaxScheme");
                            $xml->startElement("cbc:ID");
                                $xml->writeAttribute("schemeName", "Codigo de tributos");
                                $xml->writeAttribute("schemeAgencyName", "PE:SUNAT");                                    
                                $xml->writeAttribute("schemeURI", "urn:pe:gob:sunat:cpe:see:gem:catalogos:catalogo05");                                    
                                $xml->text("9997");
                            $xml->endElement(); //fin cbc:ID
                            $xml->startElement("cbc:Name");
                                $xml->text("EXO");
                            $xml->endElement(); //fin cbc:Name
                            $xml->startElement("cbc:TaxTypeCode");
                                $xml->text("VAT");
                            $xml->endElement(); //fin cbc:TaxTypeCode
                        $xml->endElement(); //fin cac:TaxScheme
                    $xml->endElement(); //fin cac:TaxCategory
                $xml->endElement(); //fin cac:TaxSubtotal
            //--------------------------------------------
        $xml->endElement(); //fin cac:TaxTotal
        if($nota->comprobante_id == '08'){
            $xml->startElement("cac:RequestedMonetaryTotal");
                $xml->startElement("cbc:PayableAmount");
                    $xml->writeAttribute("currencyID", $nota->moneda);
                    $xml->text($nota->total);
                $xml->endElement(); //fin cbc:PayableAmount
            $xml->endElement(); //fin cac:RequestedMonetaryTotal
        }else{
            $xml->startElement("cac:LegalMonetaryTotal");
                $xml->startElement("cbc:PayableAmount");
                    $xml->writeAttribute("currencyID", $nota->moneda);
                    $xml->text($nota->total);
                $xml->endElement(); //fin cbc:PayableAmount
            $xml->endElement(); //fin cac:LegalMonetaryTotal
        }
        
        //Detalles de comprobante
        $i = 1;
        foreach($detnotas as $detnota){
            if($detnota->afectacion_id >= "10" && $detnota->afectacion_id < "20"){
                $valventa = round($detnota->subtotal / (1+($parametro->por_igv/100)),2);
                $Name = "IGV";
                $TaxTypeCode = "VAT";
            }elseif($detnota->afectacion_id >= "20" && $detnota->afectacion_id < "30"){
                $valventa = $detnota->subtotal;
                $Name = "EXONERADO";
                $TaxTypeCode = "VAT";
            }else{
                $valventa = $detnota->subtotal;
                $Name = "INAFECTO";
                $TaxTypeCode = "FREE";
            }

            $xml->startElement($NoteLine);
                $xml->startElement("cbc:ID");
                    $xml->text($i);
                $xml->endElement(); //fin cbc:ID
                $xml->startElement($Quantity);
                    $xml->writeAttribute("unitCode", "ZZ");
                    $xml->writeAttribute("unitCodeListID", "UN/ECE rec 20");
                    $xml->writeAttribute("unitCodeListAgencyName", "United Nations Economic Commission for Europe");
                    $xml->text(round($detnota->cantidad,2));
                $xml->endElement(); //fin cbc:CreditedQuantity
                $xml->startElement("cbc:LineExtensionAmount");
                    $xml->writeAttribute("currencyID", $nota->moneda);
                    $xml->text($valventa);
                $xml->endElement(); //fin cbc:LineExtensionAmount
                $xml->startElement("cac:PricingReference");
                    $xml->startElement("cac:AlternativeConditionPrice");
                        $xml->startElement("cbc:PriceAmount");
                            $xml->writeAttribute("currencyID", $nota->moneda);
                            $xml->text($detnota->subtotal);
                        $xml->endElement(); //fin cbc:PriceAmount
                        $xml->startElement("cbc:PriceTypeCode");
                            $xml->writeAttribute("listAgencyName", "PE:SUNAT");
                            $xml->writeAttribute("listName", "Tipo de Precio");
                            $xml->writeAttribute("listURI", "urn:pe:gob:sunat:cpe:see:gem:catalogos:catalogo16");
                            $xml->text("01");
                        $xml->endElement(); //fin cbc:PriceTypeCode
                    $xml->endElement(); //fin cac:AlternativeConditionPrice
                $xml->endElement(); //fin cac:PricingReference
                $xml->startElement("cac:TaxTotal");
                    $xml->startElement("cbc:TaxAmount");
                        $xml->writeAttribute("currencyID", $nota->moneda);
                        $xml->text($detnota->subtotal - $valventa);
                    $xml->endElement(); //fin cbc:TaxAmount
                    $xml->startElement("cac:TaxSubtotal");
                        $xml->startElement("cbc:TaxableAmount");
                            $xml->writeAttribute("currencyID", $nota->moneda);
                            $xml->text($valventa);
                        $xml->endElement(); //fin cbc:TaxableAmount
                        $xml->startElement("cbc:TaxAmount");
                            $xml->writeAttribute("currencyID", $nota->moneda);
                            $xml->text($detnota->subtotal - $valventa);
                        $xml->endElement(); //fin cbc:TaxAmount
                        $xml->startElement("cac:TaxCategory");
                            $xml->startElement("cbc:Percent");
                                $xml->text($parametro->por_igv);
                            $xml->endElement(); //fin cbc:Percent
                            $xml->startElement("cbc:TaxExemptionReasonCode");
                                $xml->writeAttribute("listAgencyName", "PE:SUNAT");
                                $xml->writeAttribute("listName", "Afectacion del IGV");
                                $xml->writeAttribute("listURI", "urn:pe:gob:sunat:cpe:see:gem:catalogos:catalogo07");
                                $xml->text($detnota->afectacion_id);
                            $xml->endElement(); //fin cbc:TaxExemptionReasonCode
                            $xml->startElement("cac:TaxScheme");
                                $xml->startElement("cbc:ID");
                                    $xml->writeAttribute("schemeName", "Codigo de tributos");
                                    $xml->writeAttribute("schemeAgencyName", "PE:SUNAT");
                                    $xml->writeAttribute("schemeURI", "urn:pe:gob:sunat:cpe:see:gem:catalogos:catalogo05");
                                    $xml->text("1000");
                                $xml->endElement(); //fin cbc:ID
                                $xml->startElement("cbc:Name");
                                    $xml->text($Name);
                                $xml->endElement(); //fin cbc:Name
                                $xml->startElement("cbc:TaxTypeCode");
                                    $xml->text($TaxTypeCode);
                                $xml->endElement(); //fin cbc:TaxTypeCode
                            $xml->endElement(); //fin cac:TaxScheme
                        $xml->endElement(); //fin cac:TaxCategory
                    $xml->endElement(); //fin cac:TaxSubtotal
                $xml->endElement(); //fin cac:TaxTotal
                $xml->startElement("cac:Item");
                    $xml->startElement("cbc:Description");                         
                        $Serv = preg_replace("/[\r\n|\n|\r]+/", " ", $detnota->servicio);
                        $xml->writeCData($Serv);
                    $xml->endElement(); //fin cbc:Description
                $xml->endElement(); //fin cac:Item
                $xml->startElement("cac:Price");
                    $xml->startElement("cbc:PriceAmount");
                        $xml->writeAttribute("currencyID", $nota->moneda);
                        $xml->text(round($valventa/$detnota->cantidad,2));
                    $xml->endElement(); //fin cbc:PriceAmount
                $xml->endElement(); //fin cac:Price

            $xml->endElement(); //fin cac:CreditNoteLine
            
            $i++;
        }

        
        $xml->endElement(); //Fin Invoice
        $xml->endDocument();

        $content = $xml->outputMemory();
        $archivo = $nota->ruc.'/'.$archivo;
        Storage::disk('invoice')->makeDirectory($nota->ruc);
        //file_put_contents($archivo, $content);
        Storage::disk('invoice')->put($archivo, $content);
        
        $certPath = 'certificate.pem';
        
        $signer = new SignedXml();
        $signer->setCertificateFromFile($certPath);
        //$xmlSigned = $signer->signFromFile(url('/').'/invoice/'.$archivo);
        $xmlSigned = $signer->signXml($content);
        //file_put_contents($archivo, $xmlSigned);
        Storage::disk('invoice')->put($archivo, $xmlSigned);        

        /*

        $zip = new ZipArchive();
        $filename = $parametro->ruc.'-'.$factura->comprobante_id.'-'.$factura->serie.'-'.intval($factura->numero).".zip";
        $zip->open('invoice/'.$factura->ruc.'/'.$filename, ZipArchive::CREATE);
        $nombrerelativo = basename($archivo);
        $zip->addFile($archivo,$nombrerelativo);
        $zip->close();

        //$url = 'https://www.sunat.gob.pe:443/ol-ti-itcpgem-beta/billService?wsdl';
        $url = 'https://e-beta.sunat.gob.pe/ol-ti-itcpfegem-beta/billService?wsdl';
        
        $client = new SoapClient($url);

        $base = base64_encode(file_get_contents(url('invoice/'.$factura->ruc.'/'.$filename)));
        */

        // URL del servicio para Facturas (BETA ó PRODUCCION).
        $user = $parametro->ruc.$parametro->usuario;
        $pass = $parametro->clave;
        //Beta
        // $urlService = 'https://e-beta.sunat.gob.pe/ol-ti-itcpfegem-beta/billService';
        $urlService = $parametro->servidor;
        //Homologación
        //$urlService = 'https://www.sunat.gob.pe/ol-ti-itcpgem-sqa/billService';
        $soap = new SoapClient();
        $soap->setService($urlService);
        $soap->setCredentials($user, $pass);
        $sender = new BillSender();
        $sender->setClient($soap);
        //$xml = file_get_contents($archivo);
        
        $xml = Storage::disk('invoice')->get($archivo);        
        $envio = $parametro->ruc.'-'.$nota->comprobante_id.'-'.$nota->serie.'-'.($nota->numero);
        $result = $sender->send($envio, $xml);

        if (!$result->isSuccess()) {
            // Error en la conexion con el servicio de SUNAT
            //var_dump($result->getError());
            return 'Error de conexión';
        }
        $nota->status = 4;
        $cdr = $result->getCdrResponse();
        //file_put_contents('invoice/'.$factura->ruc.'/'.'R-'.$envio.'.zip', $result->getCdrZip());
        $arcresul = $nota->ruc.'/'.'R-'.$envio.'.zip';
        Storage::disk('invoice')->put($arcresul, $result->getCdrZip());

        // Verificar CDR (Factura aceptada o rechazada)
        $code = (int)$cdr->getCode();
        $mensaje = '';

        if ($code === 0) {
            $mensaje = 'ESTADO: ACEPTADA'.PHP_EOL.' ';
            $nota->status = 5;
            if (count($cdr->getNotes()) > 0) {
                $mensaje = 'INCLUYE OBSERVACIONES:'.PHP_EOL.' ';
                // Mostrar observaciones
                foreach ($cdr->getNotes() as $obs) {
                    $mensaje = 'OBS: '.$obs.PHP_EOL.' ';
                }
            }
        
        } else if ($code >= 2000 && $code <= 3999) {
            $mensaje = 'ESTADO: RECHAZADA'.PHP_EOL.' ';
            $nota->status = 6;
        
        } else {
            /* Esto no debería darse, pero si ocurre, es un CDR inválido que debería tratarse como un error-excepción. */
            /*code: 0100 a 1999 */
            $nota->status = 6;
            $mensaje = 'Excepción'.' ';
        }
        
        $mensaje = $cdr->getDescription().PHP_EOL;

        $nota->cdr = $mensaje;
        if($nota->comprobante_id == '07' && $nota->dmtipo_id == '01'){
            $anul = Factura::where('comprobante_id',$nota->dmcomprobante_id)
                ->where('serie',$nota->dmserie)
                ->where('numero',$nota->dmnumero)
                ->update(['anulado'=>1]);
        }
        
        if($nota->save()){
            return redirect('/admin/notadm/'.$nota->id.'/edit')->with('message', 'Documento enviado al servidor de Sunat')->with('typealert', 'success');
        }else{
            return redirect('/admin/notadm/'.$nota->id.'/edit')->with('message', 'Problemas de conexión, vuelva a realizar el envío')->with('typealert', 'danger');
        }        
        /* Comprime XML a Zip
        $zip = new ZipArchive();
        $filename = $parametro->ruc.'-'.$factura->comprobante_id.'-'.$factura->serie.'-'.intval($factura->numero).".zip";
        $zip->open('invoice/'.$factura->ruc.'/'.$filename, ZipArchive::CREATE);
        $nombrerelativo = basename($archivo);
        $zip->addFile($archivo,$nombrerelativo);
        $zip->close();
        */

        
       //return  $a;
    }

    public function getSunatFarmacia($id)
    {
        //$ruc = file_get_contents('https://api.sunat.cloud/ruc/10804969161');
        
        $salida = Salida::with(['cli'])->findOrFail($id);
        $detsalidas = Detsalida::with(['prod'])->where('salida_id',$id)->get();
        $moneda = Categoria::where('modulo', 10)->pluck('nombre','codigo');
        $fpago = Categoria::where('modulo', 11)->pluck('nombre','codigo');
        $comprobante = Comprobante::where('activo',1)->pluck('nombre','codigo');
        $clientes = Paciente::orderBy('razsoc','asc')->pluck('razsoc','numdoc');
        $doctor = Doctor::orderBy('nombre','asc')->pluck('nombre','id');
        $afectacion = Afectacion::pluck('nombre','codigo');
        $parametro = Param::findOrFail(1);
        $formatter = new NumeroALetras();
        
        if($salida->moneda=='PEN'){
            $letra = $formatter->toInvoice($salida->total, 2, 'soles');
        }else{
            $letra = $formatter->toInvoice($salida->total, 2, 'dólares americanos');
        }

        $archivo = $parametro->ruc.'-'.$salida->comprobante_id.'-'.$salida->serie.'-'.($salida->numero).'.xml';

        $xml = new XMLWriter();        
        //$xml->openURI($archivo);
        $xml->openMemory();
        $xml->setIndent(true);
        //$xml->setIndentString('	'); 
        //$xml->startDocument("1.0", "UTF-8","no");
        $xml->startDocument("1.0", "ISO-8859-1","no");
        $xml->startElement("Invoice");
            $xml->writeAttribute("xmlns", "urn:oasis:names:specification:ubl:schema:xsd:Invoice-2");
            $xml->writeAttribute("xmlns:cac","urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2");
            $xml->writeAttribute("xmlns:cbc","urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2");
            $xml->writeAttribute("xmlns:ccts","urn:un:unece:uncefact:documentation:2");
            $xml->writeAttribute("xmlns:ds","http://www.w3.org/2000/09/xmldsig#");
            $xml->writeAttribute("xmlns:ext","urn:oasis:names:specification:ubl:schema:xsd:CommonExtensionComponents-2");
            $xml->writeAttribute("xmlns:qdt","urn:oasis:names:specification:ubl:schema:xsd:QualifiedDatatypes-2");
            $xml->writeAttribute("xmlns:udt","urn:un:unece:uncefact:data:specification:UnqualifiedDataTypesSchemaModule:2");
            $xml->writeAttribute("xmlns:xsi","http://www.w3.org/2001/XMLSchema-instance");
            //$xml->writeAttribute("","");
            //$xml->writeAttribute("xmlns:sac","urn:sunat:names:specification:ubl:peru:schema:xsd:SunatAggregateComponents-1");
            //$xml->writeAttribute("xmlns:stat","urn:oasis:names:specification:ubl:schema:xsd:DocumentStatusCode-1.0");

            //$xml->writeAttribute("xmlns:xsi","http://www.w3.org/2001/XMLSchema-instance");
            //$xml->writeAttribute("xmlns:xsd","http://www.w3.org/2001/XMLSchema");
            $xml->startElement("ext:UBLExtensions");
                $xml->startElement("ext:UBLExtension");
                    $xml->startElement("ext:ExtensionContent");
                     //$xml->startElement("ds:Signature");
                     //   $xml->writeAttribute('Id', 'Firma');
                     //$xml->endElement();//fin ds:Signature
                    $xml->endElement();//fin ext:ExtensionContent
                $xml->endElement();//fin ext:UBLExtension
            $xml->endElement(); //fin ext:UBLExtensions
            $xml->writeElement("cbc:UBLVersionID", "2.1");
            $xml->writeElement("cbc:CustomizationID", "2.0");
            //$xml->startElement("cbc:ProfileID");
            //    $xml->writeAttribute("schemeName", "SUNAT:Identificador de Tipo de Operacion");
            //    $xml->writeAttribute("schemeAgencyName", "PE:SUNAT");
            //    $xml->writeAttribute("schemeURI", "urn:pe:gob:sunat:cpe:see:gem:catalogos:catalogo17");
            //    $xml->text("0101");
            //$xml->endElement(); //fin cbc:ProfileID
            $xml->startElement("cbc:ID");
                $xml->text($salida->serie."-".($salida->numero));
            $xml->endElement(); //fin cbc:ID
            $xml->startElement("cbc:IssueDate");
                $xml->text($salida->fecha);
            $xml->endElement(); //fin cbc:IssueDate
            //$xml->startElement("cbc:IssueTime");
            //    $xml->text($factura->hora);
            //$xml->endElement(); //fin cbc:IssueTime
            //$xml->startElement("cbc:DueDate");
            //    $xml->text($factura->vencimiento);
            //$xml->endElement(); //fin cbc:DueDate

            $xml->startElement("cbc:InvoiceTypeCode");
                $xml->writeAttribute("listID", "0101");
                $xml->writeAttribute("listAgencyName", "PE:SUNAT");
                $xml->writeAttribute("listURI", "urn:pe:gob:sunat:cpe:see:gem:catalogos:catalogo01");
                $xml->text($salida->comprobante_id);
            $xml->endElement(); //fin cbc:InvoiceTypeCode
            $xml->startElement("cbc:Note");
                $xml->writeAttribute("languageLocaleID", "1000");
                $xml->writeCData("SON: ".$letra);
            $xml->endElement(); //fin cbc:Note
            $xml->startElement("cbc:DocumentCurrencyCode");
                $xml->writeAttribute("listID", "ISO 4217 Alpha");
                $xml->writeAttribute("listName", "Currency");
                //$xml->writeAttribute("listAgencyName", "United Nations Economic Commission for Europe");
                $xml->text($salida->moneda);
            $xml->endElement(); //fin cbc:DocumentCurrencyCode

            $xml->startElement("cbc:LineCountNumeric");
                $xml->text($detsalidas->count());
            $xml->endElement(); //fin cbc:LineCountNumeric
            $xml->startElement("cac:Signature");
                $xml->startElement("cbc:ID");
                    $xml->text('IDSign'.$parametro->ruc);
                $xml->endElement(); //fin cbc:ID
                $xml->startElement("cac:SignatoryParty");
                    $xml->startElement("cac:PartyIdentification");
                        $xml->startElement("cbc:ID");
                            $xml->writeAttribute("schemeID", "6");
                            $xml->writeAttribute("schemeAgencyName", "PE:SUNAT");
                            //$xml->writeAttribute("schemeName", "Documento de Identidad");
                            $xml->writeAttribute("schemeURI", "urn:pe:gob:sunat:cpe:see:gem:catalogos:catalogo06");
                            $xml->text($parametro->ruc);
                        $xml->endElement(); //fin cbc:ID
                    $xml->endElement(); //fin cac:PartyIdentification
                    $xml->startElement("cac:PartyName");
                        $xml->startElement("cbc:Name");
                            $xml->writeCData($parametro->razsoc);
                        $xml->endElement(); //fin cbc:Name
                    $xml->endElement(); //fin cac:PartyName
                $xml->endElement(); //fin cac:SignatoryParty
                $xml->startElement("cac:DigitalSignatureAttachment");
                    $xml->startElement("cac:ExternalReference");
                        $xml->startElement("cbc:URI");
                            $xml->text("#signature".$parametro->ruc);
                        $xml->endElement(); //fin cbc:URI
                    $xml->endElement(); //fin cac:ExternalReference
                $xml->endElement(); //fin cac:DigitalSignatureAttachment
            $xml->endElement(); //fin cac:Signature
            $xml->startElement("cac:AccountingSupplierParty");
                $xml->startElement("cac:Party");
                    $xml->startElement("cac:PartyIdentification");
                        $xml->startElement("cbc:ID");
                            $xml->writeAttribute("schemeID", "6");
                            $xml->writeAttribute("schemeAgencyName", "PE:SUNAT");
                            $xml->writeAttribute("schemeURI", "urn:pe:gob:sunat:cpe:see:gem:catalogos:catalogo06");
                            $xml->text($parametro->ruc);
                        $xml->endElement(); //fin cbc:ID
                    $xml->endElement(); //fin cac:PartyIdentification
                    //$xml->startElement("cac:PartyName");
                    //    $xml->startElement("cbc:Name");
                    //        $xml->writeCData($parametro->razsoc);
                    //    $xml->endElement(); //fin cbc:Name
                    //$xml->endElement(); //fin cac:PartyName
                    $xml->startElement("cac:PartyLegalEntity");
                        $xml->startElement("cbc:RegistrationName");
                            $xml->writeCData($parametro->razsoc);
                        $xml->endElement(); //fin cbc:RegistrationName
                        //$xml->startElement("CompanyID");
                        $xml->startElement("cac:RegistrationAddress");
                            $xml->startElement("cbc:AddressTypeCode");
                                $xml->text("0000");
                            $xml->endElement(); //fin cbc:AddressTypeCode
                        $xml->endElement(); //fin cac:RegistrationAddress                        
                    $xml->endElement(); //fin cac:PartyLegalEntity
                $xml->endElement(); //fin cac:Party
            $xml->endElement(); //fin cac:AccountingSupplierParty

            $xml->startElement("cac:AccountingCustomerParty");
                $xml->startElement("cac:Party");
                    $xml->startElement("cac:PartyIdentification");
                        $xml->startElement("cbc:ID");
                            $xml->writeAttribute("schemeID", $salida->cli->tipdoc_id);
                            //$xml->writeAttribute("schemeName", "Documento de Identidad");
                            $xml->writeAttribute("schemeAgencyName", "PE:SUNAT");
                            $xml->writeAttribute("schemeURI", "urn:pe:gob:sunat:cpe:see:gem:catalogos:catalogo06");
                            $xml->text($salida->ruc);
                        $xml->endElement(); //fin cbc:ID
                    $xml->endElement(); //fin cac:PartyIdentification
                    $xml->startElement("cac:PartyLegalEntity");
                        $xml->startElement("cbc:RegistrationName");
                            $xml->writeCData($salida->cli->razsoc);
                        $xml->endElement(); //fin cbc:RegistrationName
                        $xml->startElement("cac:RegistrationAddress");
                            $xml->startElement("cac:AddressLine");
                                $xml->startElement("cbc:Line");
                                    $xml->writeCData($salida->direccion);
                                $xml->endElement(); //fin cbc:Line
                            $xml->endElement(); //fin cac:AddressLine

                            $xml->startElement("cac:Country");
                                $xml->startElement("cbc:IdentificationCode");
                                    $xml->writeAttribute("listName", "Country");
                                    $xml->writeAttribute("listAgencyName", "United Nations Economic Commission for Europe");
                                    $xml->writeAttribute("listID", "ISO 3166-1");
                                    $xml->writeCData("PE");
                                $xml->endElement(); //fin cbc:IdentificationCode
                            $xml->endElement(); //fin cac:Country
                        $xml->endElement(); //fin cac:RegistrationAddress
                    $xml->endElement(); //fin cac:PartyLegalEntity
                $xml->endElement(); //fin cac:Party
            $xml->endElement(); //fin cac:AccountingCustomerParty
            //Inicio Total Afecto e IGV
            $xml->startElement("cac:TaxTotal");
                $xml->startElement("cbc:TaxAmount");
                    $xml->writeAttribute("currencyID", $salida->moneda);
                    $xml->text($salida->tot_igv);
                $xml->endElement(); //fin cbc:TaxAmount
                $xml->startElement("cac:TaxSubtotal");
                    $xml->startElement("cbc:TaxableAmount");
                        $xml->writeAttribute("currencyID", $salida->moneda);
                        $xml->text(round($salida->tot_gravadas,2));
                    $xml->endElement(); //fin cbc:TaxableAmount
                    $xml->startElement("cbc:TaxAmount");
                        $xml->writeAttribute("currencyID", $salida->moneda);
                        $xml->text($salida->tot_igv);
                    $xml->endElement(); //fin cbc:TaxAmount
                    $xml->startElement("cac:TaxCategory");
                        $xml->startElement("cbc:ID");
                            $xml->writeAttribute("schemeID", "UN/ECE 5305");
                            $xml->writeAttribute("schemeName", "Tax Category Identifier");
                            //$xml->writeAttribute("schemeAgencyName", "United Nations Economic Commission for Europe");
                            $xml->text("S");
                        $xml->endElement(); //fin cbc:ID
                        $xml->startElement("cac:TaxScheme");
                            $xml->startElement("cbc:ID");
                                $xml->writeAttribute("schemeID", "UN/ECE 5153");
                                $xml->writeAttribute("schemeAgencyID", "6");
                                $xml->text("1000");
                            $xml->endElement(); //fin cbc:ID
                            $xml->startElement("cbc:Name");
                                $xml->text("IGV");
                            $xml->endElement(); //fin cbc:Name
                            $xml->startElement("cbc:TaxTypeCode");
                                $xml->text("VAT");
                            $xml->endElement(); //fin cbc:TaxTypeCode
                        $xml->endElement(); //fin cac:TaxScheme
                    $xml->endElement(); //fin cac:TaxCategory
                $xml->endElement(); //fin cac:TaxSubtotal
                //--------------------------------------------
                $xml->startElement("cac:TaxSubtotal");
                        $xml->startElement("cbc:TaxableAmount");
                            $xml->writeAttribute("currencyID", $salida->moneda);
                            $xml->text(round($salida->tot_inafectas,2));
                        $xml->endElement(); //fin cbc:TaxableAmount
                        $xml->startElement("cbc:TaxAmount");
                            $xml->writeAttribute("currencyID", $salida->moneda);
                            $xml->text("0.00");
                        $xml->endElement(); //fin cbc:TaxAmount
                        $xml->startElement("cac:TaxCategory");
                            $xml->startElement("cbc:ID");
                                $xml->writeAttribute("schemeID", "UN/ECE 5305");
                                $xml->writeAttribute("schemeName", "Tax Category Identifier");
                                //$xml->writeAttribute("schemeAgencyName", "United Nations Economic Commission for Europe");
                                $xml->text("O");
                            $xml->endElement(); //fin cbc:ID
                            $xml->startElement("cac:TaxScheme");
                                $xml->startElement("cbc:ID");
                                    $xml->writeAttribute("schemeID", "UN/ECE 5153");
                                    $xml->writeAttribute("schemeAgencyID", "6");
                                    $xml->text("9998");
                                $xml->endElement(); //fin cbc:ID
                                $xml->startElement("cbc:Name");
                                    $xml->text("INA");
                                $xml->endElement(); //fin cbc:Name
                                $xml->startElement("cbc:TaxTypeCode");
                                    $xml->text("FRE");
                                $xml->endElement(); //fin cbc:TaxTypeCode
                            $xml->endElement(); //fin cac:TaxScheme
                        $xml->endElement(); //fin cac:TaxCategory
                    $xml->endElement(); //fin cac:TaxSubtotal
                //--------------------------------------------
                    $xml->startElement("cac:TaxSubtotal");
                        $xml->startElement("cbc:TaxableAmount");
                            $xml->writeAttribute("currencyID", $salida->moneda);
                            $xml->text(round($salida->tot_exoneradas,2));
                        $xml->endElement(); //fin cbc:TaxableAmount
                        $xml->startElement("cbc:TaxAmount");
                            $xml->writeAttribute("currencyID", $salida->moneda);
                            $xml->text("0.00");
                        $xml->endElement(); //fin cbc:TaxAmount
                        $xml->startElement("cac:TaxCategory");
                            $xml->startElement("cbc:ID");
                                $xml->writeAttribute("schemeID", "UN/ECE 5305");
                                $xml->writeAttribute("schemeName", "Tax Category Identifier");
                                //$xml->writeAttribute("schemeAgencyName", "United Nations Economic Commission for Europe");
                                $xml->text("E");
                            $xml->endElement(); //fin cbc:ID
                            $xml->startElement("cac:TaxScheme");
                                $xml->startElement("cbc:ID");
                                    $xml->writeAttribute("schemeAgencyID", "6");
                                    $xml->writeAttribute("schemeID", "UN/ECE 5153");                                    
                                    $xml->text("9997");
                                $xml->endElement(); //fin cbc:ID
                                $xml->startElement("cbc:Name");
                                    $xml->text("EXO");
                                $xml->endElement(); //fin cbc:Name
                                $xml->startElement("cbc:TaxTypeCode");
                                    $xml->text("VAT");
                                $xml->endElement(); //fin cbc:TaxTypeCode
                            $xml->endElement(); //fin cac:TaxScheme
                        $xml->endElement(); //fin cac:TaxCategory
                    $xml->endElement(); //fin cac:TaxSubtotal
                //--------------------------------------------
            $xml->endElement(); //fin cac:TaxTotal
            $xml->startElement("cac:LegalMonetaryTotal");
                $xml->startElement("cbc:LineExtensionAmount");
                    $xml->writeAttribute("currencyID", $salida->moneda);
                    $xml->text($salida->tot_gravadas + $salida->tot_inafectas + $salida->tot_exoneradas);
                $xml->endElement(); //fin cbc:LineExtensionAmount
                $xml->startElement("cbc:TaxInclusiveAmount");
                    $xml->writeAttribute("currencyID", $salida->moneda);
                    $xml->text($salida->total);
                $xml->endElement(); //fin cbc:TaxInclusiveAmount
                //$xml->startElement("cbc:AllowanceTotalAmount");
                //    $xml->writeAttribute("currencyID", $factura->moneda);
                //    $xml->text("0.00");
                //$xml->endElement(); //fin cbc:AllowanceTotalAmount
                $xml->startElement("cbc:PayableAmount");
                    $xml->writeAttribute("currencyID", $salida->moneda);
                    $xml->text($salida->total);
                $xml->endElement(); //fin cbc:PayableAmount
            $xml->endElement(); //fin cac:LegalMonetaryTotal
            //Detalles de comprobante
            $i = 1;
            foreach($detsalidas as $detsalida){
                if($detsalida->afectacion_id >= "10" && $detsalida->afectacion_id < "20"){
                    $valventa = round($detsalida->subtotal / (1+($parametro->por_igv/100)),2);
                    $Name = "IGV";
                    $TaxTypeCode = "VAT";
                }elseif($detsalida->afectacion_id >= "20" && $detsalida->afectacion_id < "30"){
                    $valventa = $detsalida->subtotal;
                    $Name = "EXONERADO";
                    $TaxTypeCode = "VAT";
                }else{
                    $valventa = $detsalida->subtotal;
                    $Name = "INAFECTO";
                    $TaxTypeCode = "FREE";
                }

                $xml->startElement("cac:InvoiceLine");
                    $xml->startElement("cbc:ID");
                        $xml->text($i);
                    $xml->endElement(); //fin cbc:ID
                    $xml->startElement("cbc:InvoicedQuantity");
                        $xml->writeAttribute("unitCode", $detsalida->prod->umedida->sunat);
                        $xml->writeAttribute("unitCodeListID", "UN/ECE rec 20");
                        //$xml->writeAttribute("unitCodeListAgencyName", "United Nations Economic Commission for Europe");
                        $xml->text(round($detsalida->cantidad,2));
                    $xml->endElement(); //fin cbc:InvoicedQuantity
                    $xml->startElement("cbc:LineExtensionAmount");
                        $xml->writeAttribute("currencyID", $salida->moneda);
                        $xml->text($valventa);
                    $xml->endElement(); //fin cbc:LineExtensionAmount
                    $xml->startElement("cac:PricingReference");
                        $xml->startElement("cac:AlternativeConditionPrice");
                            $xml->startElement("cbc:PriceAmount");
                                $xml->writeAttribute("currencyID", $salida->moneda);
                                $xml->text($detsalida->subtotal);
                            $xml->endElement(); //fin cbc:PriceAmount
                            $xml->startElement("cbc:PriceTypeCode");
                                $xml->writeAttribute("listAgencyName", "PE:SUNAT");
                                $xml->writeAttribute("listURI", "urn:pe:gob:sunat:cpe:see:gem:catalogos:catalogo16");
                                //$xml->writeAttribute("listName", "SUNAT:Indicador de Tipo de Precio");
                                $xml->text("01");
                            $xml->endElement(); //fin cbc:PriceTypeCode
                        $xml->endElement(); //fin cac:AlternativeConditionPrice
                    $xml->endElement(); //fin cac:PricingReference
                    $xml->startElement("cac:TaxTotal");
                        $xml->startElement("cbc:TaxAmount");
                            $xml->writeAttribute("currencyID", $salida->moneda);
                            $xml->text($detsalida->subtotal - $valventa);
                        $xml->endElement(); //fin cbc:TaxAmount
                        $xml->startElement("cac:TaxSubtotal");
                            $xml->startElement("cbc:TaxableAmount");
                                $xml->writeAttribute("currencyID", $salida->moneda);
                                $xml->text($valventa);
                            $xml->endElement(); //fin cbc:TaxableAmount
                            $xml->startElement("cbc:TaxAmount");
                                $xml->writeAttribute("currencyID", $salida->moneda);
                                $xml->text($detsalida->subtotal - $valventa);
                            $xml->endElement(); //fin cbc:TaxAmount
                            $xml->startElement("cac:TaxCategory");
                                $xml->startElement("cbc:ID");
                                    $xml->writeAttribute("schemeID", "UN/ECE 5305");
                                    $xml->writeAttribute("schemeName", "Tax Category Identifier");
                                    //$xml->writeAttribute("schemeAgencyName", "United Nations Economic Commission for Europe");
                                    $xml->text("S");
                                $xml->endElement(); //fin cbc:ID
                                $xml->startElement("cbc:Percent");
                                    $xml->text($parametro->por_igv);
                                $xml->endElement(); //fin cbc:Percent
                                $xml->startElement("cbc:TaxExemptionReasonCode");
                                    $xml->writeAttribute("listAgencyName", "PE:SUNAT");
                                    //$xml->writeAttribute("listName", "SUNAT:Codigo de Tipo de Afectacion del IGV");
                                    $xml->writeAttribute("listURI", "urn:pe:gob:sunat:cpe:see:gem:catalogos:catalogo07");
                                    $xml->text($detsalida->afectacion_id);
                                $xml->endElement(); //fin cbc:TaxExemptionReasonCode
                                $xml->startElement("cac:TaxScheme");
                                    $xml->startElement("cbc:ID");
                                        $xml->writeAttribute("schemeID", "UN/ECE 5153");
                                        //$xml->writeAttribute("schemeName", "Tax Scheme Identifier");
                                        //$xml->writeAttribute("schemeAgencyName", "United Nations Economic Commission for Europe");
                                        $xml->text("1000");
                                    $xml->endElement(); //fin cbc:ID
                                    $xml->startElement("cbc:Name");
                                        $xml->text($Name);
                                    $xml->endElement(); //fin cbc:Name
                                    $xml->startElement("cbc:TaxTypeCode");
                                        $xml->text($TaxTypeCode);
                                    $xml->endElement(); //fin cbc:TaxTypeCode
                                $xml->endElement(); //fin cac:TaxScheme
                            $xml->endElement(); //fin cac:TaxCategory
                        $xml->endElement(); //fin cac:TaxSubtotal
                    $xml->endElement(); //fin cac:TaxTotal
                    $xml->startElement("cac:Item");
                        $xml->startElement("cbc:Description");
                            //$xml->writeCData($detfactura->servicio);                            
                            $Serv = $detsalida->prod->nombre;
                            $xml->writeCData($Serv);
                        $xml->endElement(); //fin cbc:Description
                    $xml->endElement(); //fin cac:Item
                    $xml->startElement("cac:Price");
                        $xml->startElement("cbc:PriceAmount");
                            $xml->writeAttribute("currencyID", $salida->moneda);
                            $xml->text(round($valventa/$detsalida->cantidad,2));
                        $xml->endElement(); //fin cbc:PriceAmount
                    $xml->endElement(); //fin cac:Price

                $xml->endElement(); //fin cac:InvoiceLine
                
                $i++;
            }

        
        $xml->endElement(); //Fin CreditNote
        $xml->endDocument();

        $content = $xml->outputMemory();
        //$archivo = 'invoice/'.$salida->ruc.'/'.$archivo;
        $archivo = $salida->ruc.'/'.$archivo;
        Storage::disk('invoice')->makeDirectory($salida->ruc);
        //file_put_contents($archivo, $content);
        Storage::disk('invoice')->put($archivo, $content);
        
        $certPath = 'certificate.pem';

        $signer = new SignedXml();
        $signer->setCertificateFromFile($certPath);
        //$xmlSigned = $signer->signFromFile($archivo);
        $xmlSigned = $signer->signXml($content);
        //file_put_contents($archivo, $xmlSigned);
        Storage::disk('invoice')->put($archivo, $xmlSigned); 

        /*

        $zip = new ZipArchive();
        $filename = $parametro->ruc.'-'.$factura->comprobante_id.'-'.$factura->serie.'-'.intval($factura->numero).".zip";
        $zip->open('invoice/'.$factura->ruc.'/'.$filename, ZipArchive::CREATE);
        $nombrerelativo = basename($archivo);
        $zip->addFile($archivo,$nombrerelativo);
        $zip->close();

        //$url = 'https://www.sunat.gob.pe:443/ol-ti-itcpgem-beta/billService?wsdl';
        $url = 'https://e-beta.sunat.gob.pe/ol-ti-itcpfegem-beta/billService?wsdl';
        
        $client = new SoapClient($url);

        $base = base64_encode(file_get_contents(url('invoice/'.$factura->ruc.'/'.$filename)));
        */

        // URL del servicio para Facturas (BETA ó PRODUCCION).
        $user = $parametro->ruc.$parametro->usuario;
        $pass = $parametro->clave;
        //Beta
        // $urlService = 'https://e-beta.sunat.gob.pe/ol-ti-itcpfegem-beta/billService';
        $urlService = $parametro->servidor;
        //Homologación
        //$urlService = 'https://www.sunat.gob.pe/ol-ti-itcpgem-sqa/billService';
        $soap = new SoapClient();
        $soap->setService($urlService);
        $soap->setCredentials($user, $pass);
        $sender = new BillSender();
        $sender->setClient($soap);

        //return $archivo;

        //$xml = file_get_contents($archivo);
        $xml = Storage::disk('invoice')->get($archivo);
        $envio = $parametro->ruc.'-'.$salida->comprobante_id.'-'.$salida->serie.'-'.($salida->numero);
        $result = $sender->send($envio, $xml);

        if (!$result->isSuccess()) {
            return 'Error de conexión';
        }
        $salida->status = 4;
        $cdr = $result->getCdrResponse();
        //file_put_contents('invoice/'.$salida->ruc.'/'.'R-'.$envio.'.zip', $result->getCdrZip());
        $arcresul = $salida->ruc.'/'.'R-'.$envio.'.zip';
        Storage::disk('invoice')->put($arcresul, $result->getCdrZip());

        // Verificar CDR (Factura aceptada o rechazada)
        $code = (int)$cdr->getCode();
        $mensaje = '';

        if ($code === 0) {
            $mensaje = 'ESTADO: ACEPTADA'.PHP_EOL.' ';
            $salida->status = 5;
            if (count($cdr->getNotes()) > 0) {
                $mensaje = 'INCLUYE OBSERVACIONES:'.PHP_EOL.' ';
                // Mostrar observaciones
                foreach ($cdr->getNotes() as $obs) {
                    $mensaje = 'OBS: '.$obs.PHP_EOL.' ';
                }
            }
        
        } else if ($code >= 2000 && $code <= 3999) {
            $mensaje = 'ESTADO: RECHAZADA'.PHP_EOL.' ';
            $salida->status = 6;
        
        } else {
            $salida->status = 6;
            $mensaje = 'Excepción'.' ';
        }
        
        $mensaje = $cdr->getDescription().PHP_EOL;

        $salida->cdr = $mensaje;
        
        if($salida->save()){
            return redirect('/admin/salida/'.$salida->id.'/edit')->with('message', 'Documento enviado al servidor de Sunat')->with('typealert', 'success');
        }else{
            return redirect('/admin/salida/'.$salida->id.'/edit')->with('message', 'Problemas de conexión, vuelva a realizar el envío')->with('typealert', 'danger');
        }
    }

    public function getSunatNotaFarmacia($id)
    {
        $nota = NotaFar::with(['cli','dmcomp','mon'])->findOrFail($id);
        $detnotas = DetNotaFar::with(['prod'])->where('notafar_id',$id)->get();
        $moneda = Categoria::where('modulo', 10)->pluck('nombre','codigo');
        $fpago = Categoria::where('modulo', 11)->pluck('nombre','codigo');
        $comprobante = Comprobante::where('activo',1)->pluck('nombre','codigo');
        $clientes = Paciente::orderBy('razsoc','asc')->pluck('razsoc','numdoc');
        $doctor = Doctor::orderBy('nombre','asc')->pluck('nombre','id');
        $afectacion = Afectacion::pluck('nombre','codigo');
        $parametro = Param::findOrFail(1);
        $formatter = new NumeroALetras();
        
        if($nota->moneda=='PEN'){
            $letra = $formatter->toInvoice($nota->total, 2, 'soles');
        }else{
            $letra = $formatter->toInvoice($nota->total, 2, 'dólares americanos');
        }

        if($nota->comprobante_id == '07'){
            $inicio = "CreditNote";
            $xmlns = "urn:oasis:names:specification:ubl:schema:xsd:CreditNote-2";
            $listName = "Tipo de nota de credito";
            $NoteLine = "cac:CreditNoteLine";
            $Quantity = "cbc:CreditedQuantity";
        }else{
            $inicio = "DebitNote";
            $xmlns = "urn:oasis:names:specification:ubl:schema:xsd:DebitNote-2";
            $listName = "Tipo de nota de debito";
            $NoteLine = "cac:DebitNoteLine";
            $Quantity = "cbc:DebitedQuantity";
        }

        $archivo = $parametro->ruc.'-'.$nota->comprobante_id.'-'.$nota->serie.'-'.($nota->numero).'.xml';

        $xml = new XMLWriter();    
        //$xml->openURI($archivo);
        $xml->openMemory();
        $xml->setIndent(true);
        //$xml->setIndentString('	'); 
        //$xml->startDocument("1.0", "UTF-8","no");
        $xml->startDocument("1.0", "utf-8","no");
        $xml->startElement($inicio);
        $xml->writeAttribute("xmlns", $xmlns);
        $xml->writeAttribute("xmlns:xsi", "http://www.w3.org/2001/XMLSchema-instance");
        $xml->writeAttribute("xmlns:cac","urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2");
        $xml->writeAttribute("xmlns:cbc","urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2");
        $xml->writeAttribute("xmlns:udt","urn:un:unece:uncefact:data:specification:UnqualifiedDataTypesSchemaModule:2");
        $xml->writeAttribute("xmlns:ccts","urn:un:unece:uncefact:documentation:2");
        $xml->writeAttribute("xmlns:ext","urn:oasis:names:specification:ubl:schema:xsd:CommonExtensionComponents-2");
        $xml->writeAttribute("xmlns:qdt","urn:oasis:names:specification:ubl:schema:xsd:QualifiedDatatypes-2");
        $xml->writeAttribute("xmlns:ds","http://www.w3.org/2000/09/xmldsig#");
        $xml->writeAttribute("xmlns:sac","urn:sunat:names:specification:ubl:peru:schema:xsd:SunatAggregateComponents-1");
       
        $xml->startElement("ext:UBLExtensions");
            $xml->startElement("ext:UBLExtension");
                $xml->startElement("ext:ExtensionContent");
                    //$xml->startElement("ds:Signature");
                    //   $xml->writeAttribute('Id', 'Firma');
                    //$xml->endElement();//fin ds:Signature
                $xml->endElement();//fin ext:ExtensionContent
            $xml->endElement();//fin ext:UBLExtension
        $xml->endElement(); //fin ext:UBLExtensions
        $xml->writeElement("cbc:UBLVersionID", "2.1");
        $xml->writeElement("cbc:CustomizationID", "2.0");
        //$xml->startElement("cbc:ProfileID");
        //    $xml->writeAttribute("schemeName", "SUNAT:Identificador de Tipo de Operacion");
        //    $xml->writeAttribute("schemeAgencyName", "PE:SUNAT");
        //    $xml->writeAttribute("schemeURI", "urn:pe:gob:sunat:cpe:see:gem:catalogos:catalogo17");
        //    $xml->text("0101");
        //$xml->endElement(); //fin cbc:ProfileID
        $xml->startElement("cbc:ID");
            $xml->text($nota->serie."-".($nota->numero));
        $xml->endElement(); //fin cbc:ID
        $xml->startElement("cbc:IssueDate");
            $xml->text($nota->fecha);
        $xml->endElement(); //fin cbc:IssueDate
        $xml->startElement("cbc:IssueTime");
            $xml->text($nota->hora);
        $xml->endElement(); //fin cbc:IssueTime
        $xml->startElement("cbc:Note");
            $xml->writeAttribute("languageLocaleID", "1000");
            $xml->writeCData("SON: ".$letra);
        $xml->endElement(); //fin cbc:Note
        $xml->startElement("cbc:DocumentCurrencyCode");
            $xml->writeAttribute("listID", "ISO 4217 Alpha");
            $xml->writeAttribute("listAgencyName", "United Nations Economic Commission for Europe");
            $xml->writeAttribute("listName", "Currency");
            $xml->text($nota->moneda);
        $xml->endElement(); //fin cbc:DocumentCurrencyCode
        $xml->startElement("cac:DiscrepancyResponse");
            $xml->startElement("cbc:ReferenceID");
                $xml->text($nota->dmserie."-".$nota->dmnumero);
            $xml->endElement(); //fin cbc:ReferenceID
            $xml->startElement("cbc:ResponseCode");
                $xml->writeAttribute("listAgencyName", "PE:SUNAT");
                $xml->writeAttribute("listName", $listName);
                $xml->writeAttribute("listURI", "urn:pe:gob:sunat:cpe:see:gem:catalogos:catalogo09");
                $xml->text($nota->dmtipo_id);
            $xml->endElement(); //fin cbc:ResponseCode
            $xml->startElement("cbc:Description");
                $xml->writeCData($nota->dmdescripcion);
            $xml->endElement(); //fin cbc:Description
        $xml->endElement(); //fin cac:DiscrepancyResponse

        $xml->startElement("cac:BillingReference");
            $xml->startElement("cac:InvoiceDocumentReference");
                $xml->startElement("cbc:ID");
                    $xml->text($nota->dmserie."-".$nota->dmnumero);
                $xml->endElement(); //fin cbc:ID
                // $xml->startElement("cbc:IssueDate");
                //     $xml->text($nota->fecha);
                // $xml->endElement(); //fin cbc:IssueDate
                $xml->startElement("cbc:DocumentTypeCode");
                    $xml->writeAttribute("listAgencyName", "PE:SUNAT");
                    $xml->writeAttribute("listName", "Tipo de Documento");
                    $xml->writeAttribute("listURI", "urn:pe:gob:sunat:cpe:see:gem:catalogos:catalogo01");
                    $xml->text($nota->dmcomprobante_id);
                $xml->endElement(); //fin cbc:DocumentTypeCode
            $xml->endElement(); //fin cac:InvoiceDocumentReference
        $xml->endElement(); //fin cac:BillingReference

            // $xml->startElement("cbc:LineCountNumeric");
            //     $xml->text($detnotas->count());
            // $xml->endElement(); //fin cbc:LineCountNumeric
            
        $xml->startElement("cac:Signature");
            $xml->startElement("cbc:ID");
                $xml->text('IDSignST');
            $xml->endElement(); //fin cbc:ID
            // $xml->startElement("cbc:Note");
            //     $xml->text('GREENTER');
            // $xml->endElement(); //fin cbc:Note
            $xml->startElement("cac:SignatoryParty");
                $xml->startElement("cac:PartyIdentification");
                    $xml->startElement("cbc:ID");
                        // $xml->writeAttribute("schemeID", "6");
                        // $xml->writeAttribute("schemeAgencyName", "PE:SUNAT");
                        // //$xml->writeAttribute("schemeName", "Documento de Identidad");
                        // $xml->writeAttribute("schemeURI", "urn:pe:gob:sunat:cpe:see:gem:catalogos:catalogo06");
                        $xml->text($parametro->ruc);
                    $xml->endElement(); //fin cbc:ID
                $xml->endElement(); //fin cac:PartyIdentification
                $xml->startElement("cac:PartyName");
                    $xml->startElement("cbc:Name");
                        $xml->writeCData($parametro->razsoc);
                    $xml->endElement(); //fin cbc:Name
                $xml->endElement(); //fin cac:PartyName
            $xml->endElement(); //fin cac:SignatoryParty
            $xml->startElement("cac:DigitalSignatureAttachment");
                $xml->startElement("cac:ExternalReference");
                    $xml->startElement("cbc:URI");
                        $xml->text("signature".$parametro->ruc);
                    $xml->endElement(); //fin cbc:URI
                $xml->endElement(); //fin cac:ExternalReference
            $xml->endElement(); //fin cac:DigitalSignatureAttachment
        $xml->endElement(); //fin cac:Signature
        $xml->startElement("cac:AccountingSupplierParty");
            $xml->startElement("cac:Party");
                $xml->startElement("cac:PartyIdentification");
                    $xml->startElement("cbc:ID");
                        $xml->writeAttribute("schemeID", "6");
                        $xml->writeAttribute("schemeName", "Documento de Identidad");
                        $xml->writeAttribute("schemeAgencyName", "PE:SUNAT");
                        $xml->writeAttribute("schemeURI", "urn:pe:gob:sunat:cpe:see:gem:catalogos:catalogo06");
                        $xml->text($parametro->ruc);
                    $xml->endElement(); //fin cbc:ID
                $xml->endElement(); //fin cac:PartyIdentification
                $xml->startElement("cac:PartyName");
                    $xml->startElement("cbc:Name");
                        $xml->writeCData($parametro->razsoc);
                    $xml->endElement(); //fin cbc:Name
                $xml->endElement(); //fin cac:PartyName
                $xml->startElement("cac:PartyLegalEntity");
                    $xml->startElement("cbc:RegistrationName");
                        $xml->writeCData($parametro->razsoc);
                    $xml->endElement(); //fin cbc:RegistrationName
                    //$xml->startElement("CompanyID");
                    $xml->startElement("cac:RegistrationAddress");
                        $xml->startElement("cbc:ID");
                            $xml->writeAttribute("schemeName", "Ubigeos");
                            $xml->writeAttribute("schemeAgencyName", "PE:INEI");
                            $xml->text($parametro->ubigeo);
                        $xml->endElement(); //fin cbc:ID
                        $xml->startElement("cbc:AddressTypeCode");
                            $xml->writeAttribute("listAgencyName", "PE:SUNAT");
                            $xml->writeAttribute("listName", "Establecimientos anexos");
                            $xml->text("0000");
                        $xml->endElement(); //fin cbc:AddressTypeCode
                        $xml->startElement("cbc:CityName");
                            $xml->text($parametro->provincia);
                        $xml->endElement(); //fin cbc:CityName
                        $xml->startElement("cbc:CountrySubentity");
                            $xml->text($parametro->provincia);
                        $xml->endElement(); //fin cbc:CountrySubentity
                        $xml->startElement("cbc:District");
                            $xml->text($parametro->distrito);
                        $xml->endElement(); //fin cbc:District
                        // $xml->startElement("cbc:CitySubdivisionName");
                        //     $xml->text("-");
                        // $xml->endElement(); //fin cbc:CitySubdivisionName
                        $xml->startElement("cac:AddressLine");
                            $xml->startElement("cbc:Line");
                                $xml->text($parametro->direccion);
                            $xml->endElement(); //fin cbc:Line                      
                        $xml->endElement(); //fin cac:AddressLine
                        $xml->startElement("cac:Country");
                            $xml->startElement("cbc:IdentificationCode");
                                $xml->text($parametro->pais);
                            $xml->endElement(); //fin cbc:IdentificationCode
                        $xml->endElement(); //fin cac:Country
                    $xml->endElement(); //fin cac:RegistrationAddress
                $xml->endElement(); //fin cac:PartyLegalEntity
            $xml->endElement(); //fin cac:Party
        $xml->endElement(); //fin cac:AccountingSupplierParty

        $xml->startElement("cac:AccountingCustomerParty");
            $xml->startElement("cac:Party");
                $xml->startElement("cac:PartyIdentification");
                    $xml->startElement("cbc:ID");
                        $xml->writeAttribute("schemeID", $nota->cli->tipdoc_id);
                        $xml->writeAttribute("schemeName", "Documento de Identidad");
                        $xml->writeAttribute("schemeAgencyName", "PE:SUNAT");
                        $xml->writeAttribute("schemeURI", "urn:pe:gob:sunat:cpe:see:gem:catalogos:catalogo06");
                        $xml->text($nota->ruc);
                    $xml->endElement(); //fin cbc:ID
                $xml->endElement(); //fin cac:PartyIdentification
                $xml->startElement("cac:PartyLegalEntity");
                    $xml->startElement("cbc:RegistrationName");
                        $xml->writeCData($nota->cli->razsoc);
                    $xml->endElement(); //fin cbc:RegistrationName
                    $xml->startElement("cac:RegistrationAddress");
                        $xml->startElement("cac:AddressLine");
                            $xml->startElement("cbc:Line");
                                $xml->writeCData($nota->direccion);
                            $xml->endElement(); //fin cbc:Line
                        $xml->endElement(); //fin cac:AddressLine

                        $xml->startElement("cac:Country");
                            $xml->startElement("cbc:IdentificationCode");
                                $xml->writeAttribute("listID", "ISO 3166-1");
                                $xml->writeAttribute("listAgencyName", "United Nations Economic Commission for Europe");
                                $xml->writeAttribute("listName", "Country");
                                $xml->text("PE");
                            $xml->endElement(); //fin cbc:IdentificationCode
                        $xml->endElement(); //fin cac:Country
                    $xml->endElement(); //fin cac:RegistrationAddress
                $xml->endElement(); //fin cac:PartyLegalEntity
            $xml->endElement(); //fin cac:Party
        $xml->endElement(); //fin cac:AccountingCustomerParty
        //Inicio Total Afecto e IGV
        $xml->startElement("cac:TaxTotal");
            $xml->startElement("cbc:TaxAmount");
                $xml->writeAttribute("currencyID", $nota->moneda);
                $xml->text($nota->tot_igv);
            $xml->endElement(); //fin cbc:TaxAmount
            $xml->startElement("cac:TaxSubtotal");
                $xml->startElement("cbc:TaxableAmount");
                    $xml->writeAttribute("currencyID", $nota->moneda);
                    $xml->text(round($nota->tot_gravadas,2));
                $xml->endElement(); //fin cbc:TaxableAmount
                $xml->startElement("cbc:TaxAmount");
                    $xml->writeAttribute("currencyID", $nota->moneda);
                    $xml->text($nota->tot_igv);
                $xml->endElement(); //fin cbc:TaxAmount
                $xml->startElement("cac:TaxCategory");
                    $xml->startElement("cbc:Percent");
                        $xml->text($parametro->por_igv);
                    $xml->endElement(); //fin cbc:Percent
                    // $xml->startElement("cbc:ID");
                    //     // $xml->writeAttribute("schemeID", "UN/ECE 5305");
                    //     // $xml->writeAttribute("schemeName", "Tax Category Identifier");
                    //     //$xml->writeAttribute("schemeAgencyName", "United Nations Economic Commission for Europe");
                    //     $xml->text("S");
                    // $xml->endElement(); //fin cbc:ID
                    $xml->startElement("cac:TaxScheme");
                        $xml->startElement("cbc:ID");
                            $xml->writeAttribute("schemeName", "Codigo de tributos");
                            $xml->writeAttribute("schemeAgencyName", "PE:SUNAT");
                            $xml->writeAttribute("schemeURI", "urn:pe:gob:sunat:cpe:see:gem:catalogos:catalogo05");
                            $xml->text("1000");
                        $xml->endElement(); //fin cbc:ID
                        $xml->startElement("cbc:Name");
                            $xml->text("IGV");
                        $xml->endElement(); //fin cbc:Name
                        $xml->startElement("cbc:TaxTypeCode");
                            $xml->text("VAT");
                        $xml->endElement(); //fin cbc:TaxTypeCode
                    $xml->endElement(); //fin cac:TaxScheme
                $xml->endElement(); //fin cac:TaxCategory
            $xml->endElement(); //fin cac:TaxSubtotal
            //--------------------------------------------
            $xml->startElement("cac:TaxSubtotal");
                    $xml->startElement("cbc:TaxableAmount");
                        $xml->writeAttribute("currencyID", $nota->moneda);
                        $xml->text(round($nota->tot_inafectas,2));
                    $xml->endElement(); //fin cbc:TaxableAmount
                    $xml->startElement("cbc:TaxAmount");
                        $xml->writeAttribute("currencyID", $nota->moneda);
                        $xml->text("0.00");
                    $xml->endElement(); //fin cbc:TaxAmount
                    $xml->startElement("cac:TaxCategory");
                        // $xml->startElement("cbc:ID");
                        //     $xml->writeAttribute("schemeID", "UN/ECE 5305");
                        //     $xml->writeAttribute("schemeName", "Tax Category Identifier");
                        //     //$xml->writeAttribute("schemeAgencyName", "United Nations Economic Commission for Europe");
                        //     $xml->text("O");
                        // $xml->endElement(); //fin cbc:ID
                        $xml->startElement("cac:TaxScheme");
                            $xml->startElement("cbc:ID");
                                $xml->writeAttribute("schemeName", "Codigo de tributos");
                                $xml->writeAttribute("schemeAgencyName", "PE:SUNAT");
                                $xml->writeAttribute("schemeURI", "urn:pe:gob:sunat:cpe:see:gem:catalogos:catalogo05");
                                $xml->text("9998");
                            $xml->endElement(); //fin cbc:ID
                            $xml->startElement("cbc:Name");
                                $xml->text("INA");
                            $xml->endElement(); //fin cbc:Name
                            $xml->startElement("cbc:TaxTypeCode");
                                $xml->text("FRE");
                            $xml->endElement(); //fin cbc:TaxTypeCode
                        $xml->endElement(); //fin cac:TaxScheme
                    $xml->endElement(); //fin cac:TaxCategory
                $xml->endElement(); //fin cac:TaxSubtotal
            //--------------------------------------------
                $xml->startElement("cac:TaxSubtotal");
                    $xml->startElement("cbc:TaxableAmount");
                        $xml->writeAttribute("currencyID", $nota->moneda);
                        $xml->text(round($nota->tot_exoneradas,2));
                    $xml->endElement(); //fin cbc:TaxableAmount
                    $xml->startElement("cbc:TaxAmount");
                        $xml->writeAttribute("currencyID", $nota->moneda);
                        $xml->text("0.00");
                    $xml->endElement(); //fin cbc:TaxAmount
                    $xml->startElement("cac:TaxCategory");
                        // $xml->startElement("cbc:ID");
                        //     $xml->writeAttribute("schemeID", "UN/ECE 5305");
                        //     $xml->writeAttribute("schemeName", "Tax Category Identifier");
                        //     //$xml->writeAttribute("schemeAgencyName", "United Nations Economic Commission for Europe");
                        //     $xml->text("E");
                        // $xml->endElement(); //fin cbc:ID
                        $xml->startElement("cac:TaxScheme");
                            $xml->startElement("cbc:ID");
                                $xml->writeAttribute("schemeName", "Codigo de tributos");
                                $xml->writeAttribute("schemeAgencyName", "PE:SUNAT");                                    
                                $xml->writeAttribute("schemeURI", "urn:pe:gob:sunat:cpe:see:gem:catalogos:catalogo05");                                    
                                $xml->text("9997");
                            $xml->endElement(); //fin cbc:ID
                            $xml->startElement("cbc:Name");
                                $xml->text("EXO");
                            $xml->endElement(); //fin cbc:Name
                            $xml->startElement("cbc:TaxTypeCode");
                                $xml->text("VAT");
                            $xml->endElement(); //fin cbc:TaxTypeCode
                        $xml->endElement(); //fin cac:TaxScheme
                    $xml->endElement(); //fin cac:TaxCategory
                $xml->endElement(); //fin cac:TaxSubtotal
            //--------------------------------------------
        $xml->endElement(); //fin cac:TaxTotal
        if($nota->comprobante_id == '08'){
            $xml->startElement("cac:RequestedMonetaryTotal");
                $xml->startElement("cbc:PayableAmount");
                    $xml->writeAttribute("currencyID", $nota->moneda);
                    $xml->text($nota->total);
                $xml->endElement(); //fin cbc:PayableAmount
            $xml->endElement(); //fin cac:RequestedMonetaryTotal
        }else{
            $xml->startElement("cac:LegalMonetaryTotal");
                $xml->startElement("cbc:PayableAmount");
                    $xml->writeAttribute("currencyID", $nota->moneda);
                    $xml->text($nota->total);
                $xml->endElement(); //fin cbc:PayableAmount
            $xml->endElement(); //fin cac:LegalMonetaryTotal
        }
        
        //Detalles de comprobante
        $i = 1;
        foreach($detnotas as $detnota){
            if($detnota->afectacion_id >= "10" && $detnota->afectacion_id < "20"){
                $valventa = round($detnota->subtotal / (1+($parametro->por_igv/100)),2);
                $Name = "IGV";
                $TaxTypeCode = "VAT";
            }elseif($detnota->afectacion_id >= "20" && $detnota->afectacion_id < "30"){
                $valventa = $detnota->subtotal;
                $Name = "EXONERADO";
                $TaxTypeCode = "VAT";
            }else{
                $valventa = $detnota->subtotal;
                $Name = "INAFECTO";
                $TaxTypeCode = "FREE";
            }

            $xml->startElement($NoteLine);
                $xml->startElement("cbc:ID");
                    $xml->text($i);
                $xml->endElement(); //fin cbc:ID
                $xml->startElement($Quantity);
                    $xml->writeAttribute("unitCode", $detnota->prod->umedida->sunat);
                    $xml->writeAttribute("unitCodeListID", "UN/ECE rec 20");
                    $xml->writeAttribute("unitCodeListAgencyName", "United Nations Economic Commission for Europe");
                    $xml->text(round($detnota->cantidad,2));
                $xml->endElement(); //fin cbc:CreditedQuantity
                $xml->startElement("cbc:LineExtensionAmount");
                    $xml->writeAttribute("currencyID", $nota->moneda);
                    $xml->text($valventa);
                $xml->endElement(); //fin cbc:LineExtensionAmount
                $xml->startElement("cac:PricingReference");
                    $xml->startElement("cac:AlternativeConditionPrice");
                        $xml->startElement("cbc:PriceAmount");
                            $xml->writeAttribute("currencyID", $nota->moneda);
                            $xml->text($detnota->subtotal);
                        $xml->endElement(); //fin cbc:PriceAmount
                        $xml->startElement("cbc:PriceTypeCode");
                            $xml->writeAttribute("listAgencyName", "PE:SUNAT");
                            $xml->writeAttribute("listName", "Tipo de Precio");
                            $xml->writeAttribute("listURI", "urn:pe:gob:sunat:cpe:see:gem:catalogos:catalogo16");
                            $xml->text("01");
                        $xml->endElement(); //fin cbc:PriceTypeCode
                    $xml->endElement(); //fin cac:AlternativeConditionPrice
                $xml->endElement(); //fin cac:PricingReference
                $xml->startElement("cac:TaxTotal");
                    $xml->startElement("cbc:TaxAmount");
                        $xml->writeAttribute("currencyID", $nota->moneda);
                        $xml->text($detnota->subtotal - $valventa);
                    $xml->endElement(); //fin cbc:TaxAmount
                    $xml->startElement("cac:TaxSubtotal");
                        $xml->startElement("cbc:TaxableAmount");
                            $xml->writeAttribute("currencyID", $nota->moneda);
                            $xml->text($valventa);
                        $xml->endElement(); //fin cbc:TaxableAmount
                        $xml->startElement("cbc:TaxAmount");
                            $xml->writeAttribute("currencyID", $nota->moneda);
                            $xml->text($detnota->subtotal - $valventa);
                        $xml->endElement(); //fin cbc:TaxAmount
                        $xml->startElement("cac:TaxCategory");
                            $xml->startElement("cbc:Percent");
                                $xml->text($parametro->por_igv);
                            $xml->endElement(); //fin cbc:Percent
                            $xml->startElement("cbc:TaxExemptionReasonCode");
                                $xml->writeAttribute("listAgencyName", "PE:SUNAT");
                                $xml->writeAttribute("listName", "Afectacion del IGV");
                                $xml->writeAttribute("listURI", "urn:pe:gob:sunat:cpe:see:gem:catalogos:catalogo07");
                                $xml->text($detnota->afectacion_id);
                            $xml->endElement(); //fin cbc:TaxExemptionReasonCode
                            $xml->startElement("cac:TaxScheme");
                                $xml->startElement("cbc:ID");
                                    $xml->writeAttribute("schemeName", "Codigo de tributos");
                                    $xml->writeAttribute("schemeAgencyName", "PE:SUNAT");
                                    $xml->writeAttribute("schemeURI", "urn:pe:gob:sunat:cpe:see:gem:catalogos:catalogo05");
                                    $xml->text("1000");
                                $xml->endElement(); //fin cbc:ID
                                $xml->startElement("cbc:Name");
                                    $xml->text($Name);
                                $xml->endElement(); //fin cbc:Name
                                $xml->startElement("cbc:TaxTypeCode");
                                    $xml->text($TaxTypeCode);
                                $xml->endElement(); //fin cbc:TaxTypeCode
                            $xml->endElement(); //fin cac:TaxScheme
                        $xml->endElement(); //fin cac:TaxCategory
                    $xml->endElement(); //fin cac:TaxSubtotal
                $xml->endElement(); //fin cac:TaxTotal
                $xml->startElement("cac:Item");
                    $xml->startElement("cbc:Description");                         
                        $Serv = $detnota->prod->nombre;
                        $xml->writeCData($Serv);
                    $xml->endElement(); //fin cbc:Description
                $xml->endElement(); //fin cac:Item
                $xml->startElement("cac:Price");
                    $xml->startElement("cbc:PriceAmount");
                        $xml->writeAttribute("currencyID", $nota->moneda);
                        $xml->text(round($valventa/$detnota->cantidad,2));
                    $xml->endElement(); //fin cbc:PriceAmount
                $xml->endElement(); //fin cac:Price

            $xml->endElement(); //fin cac:CreditNoteLine
            
            $i++;
        }

        
        $xml->endElement(); //Fin Invoice
        $xml->endDocument();

        $content = $xml->outputMemory();
        $archivo = $nota->ruc.'/'.$archivo;
        Storage::disk('invoice')->makeDirectory($nota->ruc);
        //file_put_contents($archivo, $content);
        Storage::disk('invoice')->put($archivo, $content);
        
        $certPath = 'certificate.pem';
        
        $signer = new SignedXml();
        $signer->setCertificateFromFile($certPath);
        //$xmlSigned = $signer->signFromFile(url('/').'/invoice/'.$archivo);
        $xmlSigned = $signer->signXml($content);
        //file_put_contents($archivo, $xmlSigned);
        Storage::disk('invoice')->put($archivo, $xmlSigned);        

        /*

        $zip = new ZipArchive();
        $filename = $parametro->ruc.'-'.$factura->comprobante_id.'-'.$factura->serie.'-'.intval($factura->numero).".zip";
        $zip->open('invoice/'.$factura->ruc.'/'.$filename, ZipArchive::CREATE);
        $nombrerelativo = basename($archivo);
        $zip->addFile($archivo,$nombrerelativo);
        $zip->close();

        //$url = 'https://www.sunat.gob.pe:443/ol-ti-itcpgem-beta/billService?wsdl';
        $url = 'https://e-beta.sunat.gob.pe/ol-ti-itcpfegem-beta/billService?wsdl';
        
        $client = new SoapClient($url);

        $base = base64_encode(file_get_contents(url('invoice/'.$factura->ruc.'/'.$filename)));
        */

        // URL del servicio para Facturas (BETA ó PRODUCCION).
        $user = $parametro->ruc.$parametro->usuario;
        $pass = $parametro->clave;
        //Beta
        // $urlService = 'https://e-beta.sunat.gob.pe/ol-ti-itcpfegem-beta/billService';
        $urlService = $parametro->servidor;
        //Homologación
        //$urlService = 'https://www.sunat.gob.pe/ol-ti-itcpgem-sqa/billService';
        $soap = new SoapClient();
        $soap->setService($urlService);
        $soap->setCredentials($user, $pass);
        $sender = new BillSender();
        $sender->setClient($soap);
        //$xml = file_get_contents($archivo);
        
        $xml = Storage::disk('invoice')->get($archivo);        
        $envio = $parametro->ruc.'-'.$nota->comprobante_id.'-'.$nota->serie.'-'.($nota->numero);
        $result = $sender->send($envio, $xml);

        if (!$result->isSuccess()) {
            // Error en la conexion con el servicio de SUNAT
            //var_dump($result->getError());
            return 'Error de conexión';
        }
        $nota->status = 4;
        $cdr = $result->getCdrResponse();
        //file_put_contents('invoice/'.$factura->ruc.'/'.'R-'.$envio.'.zip', $result->getCdrZip());
        $arcresul = $nota->ruc.'/'.'R-'.$envio.'.zip';
        Storage::disk('invoice')->put($arcresul, $result->getCdrZip());

        // Verificar CDR (Factura aceptada o rechazada)
        $code = (int)$cdr->getCode();
        $mensaje = '';

        if ($code === 0) {
            $mensaje = 'ESTADO: ACEPTADA'.PHP_EOL.' ';
            $nota->status = 5;
            if (count($cdr->getNotes()) > 0) {
                $mensaje = 'INCLUYE OBSERVACIONES:'.PHP_EOL.' ';
                // Mostrar observaciones
                foreach ($cdr->getNotes() as $obs) {
                    $mensaje = 'OBS: '.$obs.PHP_EOL.' ';
                }
            }
        
        } else if ($code >= 2000 && $code <= 3999) {
            $mensaje = 'ESTADO: RECHAZADA'.PHP_EOL.' ';
            $nota->status = 6;
        
        } else {
            /* Esto no debería darse, pero si ocurre, es un CDR inválido que debería tratarse como un error-excepción. */
            /*code: 0100 a 1999 */
            $nota->status = 6;
            $mensaje = 'Excepción'.' ';
        }
        
        $mensaje = $cdr->getDescription().PHP_EOL;

        $nota->cdr = $mensaje;
        if($nota->comprobante_id == '07' && $nota->dmtipo_id == '01'){
            $anul = Salida::where('comprobante_id',$nota->dmcomprobante_id)
                ->where('serie',$nota->dmserie)
                ->where('numero',$nota->dmnumero)
                ->update(['anulado'=>1]);
        }
        
        if($nota->save()){
            return redirect('/admin/notfar/'.$nota->id.'/edit')->with('message', 'Documento enviado al servidor de Sunat')->with('typealert', 'success');
        }else{
            return redirect('/admin/notfar/'.$nota->id.'/edit')->with('message', 'Problemas de conexión, vuelva a realizar el envío')->with('typealert', 'danger');
        }        
        /* Comprime XML a Zip
        $zip = new ZipArchive();
        $filename = $parametro->ruc.'-'.$factura->comprobante_id.'-'.$factura->serie.'-'.intval($factura->numero).".zip";
        $zip->open('invoice/'.$factura->ruc.'/'.$filename, ZipArchive::CREATE);
        $nombrerelativo = basename($archivo);
        $zip->addFile($archivo,$nombrerelativo);
        $zip->close();
        */

        
       //return  $a;
    }

}
