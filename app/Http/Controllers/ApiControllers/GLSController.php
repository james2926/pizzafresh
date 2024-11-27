<?php
namespace App\Http\Controllers\ApiControllers;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Pedido;
class GLSController extends Controller
{
    public function SaveEtiqueta($id){
        $pedido = Pedido::find($id);
        if(!$pedido){
            return Response('Pedido No Encontrado',404);
        }
        if($pedido->cod_barras){
            return $this->GetEtiqueta($pedido->cod_barras);
        }
        $uidCliente="6BAB7A53-3B6D-4D5A-9450-702D2FAC0B11";
        $envio = array();
        $envio["fecha"] = date('Y-m-d');
        $envio["servicio"] = "1";
        $envio["horario"] = "3";
        $envio["bultos"] = "1";
        $envio["peso"] = "1";
        $envio["reem"] = "0";
        //preguntar a pizza fresh
        $envio["nombreOrg"] = "Pizza Fresh S.L.";
        $envio["direccionOrg"] = "Carrer Ferrers, 31";
        $envio["poblacionOrg"] = "Guardamar del Segura";
        $envio["codPaisOrg"] = "ES";
        $envio["cpOrg"] = "03140";
        $envio["nombreDst"] = $pedido->Cliente->nombre;//"consignee name";
        $envio["direccionDst"] = $pedido->Cliente->DireccionEnvio->direccion;
        $envio["poblacionDst"] = $pedido->Cliente->DireccionEnvio->ciudad;//"consignee city";
        $envio["codPaisDst"] = $pedido->Cliente->DireccionEnvio->Pais->codigo;
        $envio["cpDst"] = $pedido->Cliente->DireccionEnvio->codigo_postal;
        $envio["tfnoDst"] = $pedido->Cliente->DireccionEnvio->telefono;
        $envio["emailDst"] = $pedido->Cliente->email;
        $envio["observaciones"] =""; //"transport notes";
        $envio["nif"] = $pedido->Cliente->cif;
        $envio["portes"] = "P";
        //$envio["RefC"] = "1234561009";
        $xmlRequest = '<?xml version="1.0" encoding="utf-8"?>
        <soap12:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap12="http://www.w3.org/2003/05/soap-envelope">
        <soap12:Body>
        <GrabaServicios  xmlns="http://www.asmred.com/">
        <docIn>
           <Servicios uidcliente="' . $uidCliente . '" xmlns="http://www.asmred.com/">
           <Envio>
              <Fecha>' . $envio["fecha"] . '</Fecha>
              <Servicio>' . $envio["servicio"] . '</Servicio>
              <Horario>' . $envio["horario"] . '</Horario>
              <Bultos>' . $envio["bultos"] . '</Bultos>
              <Peso>' . $envio["peso"] . '</Peso>
              <Portes>' . $envio["portes"] . '</Portes>
              <Importes>
                 <Reembolso>'. $envio["reem"] .'</Reembolso>
              </Importes>
              <Remite>
                 <Nombre>' . $envio["nombreOrg"] . '</Nombre>
                 <Direccion>' . $envio["direccionOrg"] . '</Direccion>
                 <Poblacion>' . $envio["poblacionOrg"] . '</Poblacion>
                 <Pais>' . $envio["codPaisOrg"] . '</Pais>
                 <CP>' . $envio["cpOrg"] . '</CP>
              </Remite>
              <Destinatario>
                 <Nombre>' . $envio["nombreDst"] . '</Nombre>
                 <Direccion>' . $envio["direccionDst"] . '</Direccion>
                 <Poblacion>' . $envio["poblacionDst"] . '</Poblacion>
                 <Pais>' . $envio["codPaisDst"]. '</Pais>
                 <CP>' . $envio["cpDst"] . '</CP>
                 <Telefono>' . $envio["tfnoDst"] . '</Telefono>
                 <Email>' . $envio["emailDst"] . '</Email>
                 <NIF>' . $envio["nif"] . '</NIF>
                 <Observaciones>' . $envio["observaciones"] . '</Observaciones>
              </Destinatario>
              <DevuelveAdicionales>
    <Etiqueta>1</Etiqueta>
  </DevuelveAdicionales>
           </Envio>
           </Servicios>
           </docIn>
        </GrabaServicios>
        </soap12:Body>
        </soap12:Envelope>';
        
        try{
            $client = new \GuzzleHttp\Client();
            ///https://app.vbservicios.es/api/saveclientes-facebook
            $response = $client->request('POST', 'https://wsclientes.asmred.com/b2b.asmx?op=GrabaServicios', [
                'body'    => $xmlRequest,
                'headers' => [
                    "Content-Type" => "application/soap+xml; charset=utf-8;"]
            ]); 
            $body = $response->getBody()->getContents();

            $cod_barras = explode('"',explode('codbarras="',$body)[1])[0];
            $pedido->cod_barras = $cod_barras;
            $pedido->save();
            $etiqueta_64 = explode('</Etiqueta>',explode('<Etiqueta bulto="1">',$body)[1])[0];
            $file = base64_decode($etiqueta_64);
            return response($file)->withHeaders([
                'Content-Type' => 'application/pdf',
            ]);
        }catch(\Exception $e){
            return response()->json('El código postal es invalido', 400);
        } 
    }
    public function GetEtiqueta($barcode){
        $uid = '6BAB7A53-3B6D-4D5A-9450-702D2FAC0B11';
        $xmlRequest = '<?xml version="1.0" encoding="utf-8"?>
        <soap12:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap12="http://www.w3.org/2003/05/soap-envelope">
        <soap12:Body>
        <EtiquetaEnvioV2 xmlns="http://www.asmred.com/">
            <uidcliente><![CDATA['.$uid.']]></uidcliente>
            <codigo><![CDATA['.$barcode.']]></codigo>
            <tipoEtiqueta><![CDATA[PDF]]></tipoEtiqueta>
        </EtiquetaEnvioV2>
        </soap12:Body>
        </soap12:Envelope>';
        $client = new \GuzzleHttp\Client();
        ///https://app.vbservicios.es/api/saveclientes-facebook
        $response = $client->request('POST', 'https://wsclientes.asmred.com/b2b.asmx?op=EtiquetaEnvioV2', [
            'body'    => $xmlRequest,
            'headers' => [
                "Content-Type" => "application/soap+xml; charset=utf-8;"]
        ]
        ) ; 
        $body = $response->getBody()->getContents();
        $etiqueta_64 = explode('</Etiqueta>',explode('<Etiqueta>',$body)[1])[0];
        $file = base64_decode($etiqueta_64);
        return response($file)->withHeaders([
            'Content-Type' => 'application/pdf',
        ]);


    }
}
