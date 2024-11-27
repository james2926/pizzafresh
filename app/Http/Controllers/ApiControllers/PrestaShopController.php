<?php

namespace App\Http\Controllers\ApiControllers;

use App\Http\Controllers\Controller;
use App\Models\Articulo;
use App\Models\Cliente;
use App\Models\Direccion;
use App\Models\Pais;
use App\Models\Pedido;
use App\Models\PedidoItem;
use App\Models\UltimoClientePresta;

class PrestaShopController extends Controller
{
    public const key = 'VVPZYJR984E5H7AXZMNU751MRXSWFND9';
    public const url = 'http://qualitypizzafresh.com/api/';

    public function getArticulos()
    {
        $client = new \GuzzleHttp\Client();
        $response = $client->request('GET', self::url.'products?ws_key='.self::key);
        $articulos = $this->XMLtoArray($response->getBody())['PRESTASHOP']['PRODUCTS']['PRODUCT'];
        // return $articulos;

        $articulos_array = [];
        foreach ($articulos as $articulo) {
            try {
                $articulos_array[] = $this->getArticulo($articulo['ID']);
            } catch (Exception $ex) {
            }
        }

        return ['data' => $articulos, 'elements' => $articulos_array];
    }

    public function getArticulo($id)
    {
        $client = new \GuzzleHttp\Client();
        $response = $client->request('GET', self::url.'products/'.$id.'?ws_key='.self::key);
        $articulo = $this->XMLtoArray($response->getBody())['PRESTASHOP']['PRODUCT'];

        $arr = [
            'ref' => $articulo['REFERENCE'] ?? '',
            'nombre' => $articulo['NAME']['LANGUAGE']['12']['content'],
            'descripcion' => $articulo['META_DESCRIPTION']['LANGUAGE']['4']['content'],
            'peso' => $articulo['WEIGHT'],
            'id_tipo_etiqueta' => 1,
            'precio' => $articulo['PRICE'],
            'id_prestashop' => $id,
        ];

        $art = Articulo::updateOrCreate(['id_prestashop' => $id], $arr);

        return $art;
    }

    public function getOrders()
    {
        $client = new \GuzzleHttp\Client();
        $lastPedido = Pedido::max('id_prestashop') ?? 12408;
        $response = $client->request('GET', self::url.'orders?ws_key='.self::key.'&limit='.$lastPedido.',100000');
        $body =   $this->XMLtoArray($response->getBody());
        if(!isset ($body['PRESTASHOP']['ORDERS']['ORDER'])){
            return 'Importación realizada con éxito';
        }
        $orders =$body['PRESTASHOP']['ORDERS']['ORDER'];

        $orders_array = [];
        if(isset($orders['ID'])){
            $orders = [ $orders];
        }
        // return $this->getOrder($orders[10]['ID']);
        for ($i = count($orders) - 1; $i >= 0; --$i) {
            $order = $orders[$i];
            try {
                if (intval($order['ID']) > intval($lastPedido)) {
                    $orders_array[] = $this->getOrder($order['ID']);
                }
            } catch (Exception $ex) {
            }
        }

        return ['data' => $orders, 'elements' => $orders_array];
    }

    public function saveDireccion($id, $tipo)
    {
        $add = $this->getAddress($id);

        $cliente = $this->getCliente($add['id_cliente']);

        $dir = null;
        if ($tipo == 1) {
            if ($cliente->DireccionEnvio) {
                $dir = $cliente->DireccionEnvio;
            }
        } else {
            if ($cliente->DireccionFacturacion) {
                $dir = $cliente->DireccionFacturacion;
            }
        }
        if ($dir == null) {
            $dir = Direccion::create([
                'telefono' => $add['telefono'],
                'direccion' => $add['direccion'],
                'ciudad' => $add['ciudad'],
                'id_pais' => $add['id_pais'],
                'codigo_postal' => $add['codigo_postal'],
            ]);
        } else {
            $dir->update([
                'telefono' => $add['telefono'],
                'direccion' => $add['direccion'],
                'ciudad' => $add['ciudad'],
                'id_pais' => $add['id_pais'],
                'codigo_postal' => $add['codigo_postal'],
            ]);
        }
        if ($add['dni']) {
            $cliente->cif = $add['dni'];
        }
        if ($tipo == 1) {
            $cliente->id_direccion_envio = $dir->id;
        } else {
            $cliente->id_direccion_facturacion = $dir->id;
        }
        $cliente->update();

        return $cliente;
    }

    public function getOrder($id)
    {
        $client = new \GuzzleHttp\Client();
        $response = $client->request('GET', self::url.'orders/'.$id.'?ws_key='.self::key);
        $order = $this->XMLtoArray($response->getBody())['PRESTASHOP']['ORDER'];

        $cliente = $this->saveDireccion($order['ID_ADDRESS_DELIVERY']['content'], 1);

        $cliente = $this->saveDireccion($order['ID_ADDRESS_INVOICE']['content'], 2);
        $arr = [
            'nro' => $order['ID'],
            'id_cliente' => $cliente->id,
            'gastos_envio' => $order['TOTAL_SHIPPING'] ?? 0,
            'descuento' => $order['TOTAL_DISCOUNTS'] ?? 0,
            'id_prestashop' => $order['ID'],
            'fecha' => $order['DATE_ADD'] ?? null,
        ];
        $productos_arr = $order['ASSOCIATIONS']['ORDER_ROWS']['ORDER_ROW'];
        $pedido = Pedido::updateOrCreate(['id_prestashop' => $arr['nro']], $arr);
        $items = [];
        if (isset($productos_arr['ID'])) {
            $productos_arr = [$productos_arr];
        }
        foreach ($productos_arr as $producto) {
            $obj = Articulo::where('ref', $producto['PRODUCT_REFERENCE'] ?? '')->first();

            $item = [
                'id_articulo' => $obj ? $obj->id : 0,
                'cantidad' => $producto['PRODUCT_QUANTITY'] ?? '',
                'precio' => $producto['PRODUCT_PRICE'] ?? '',
            ];

            $items[] = PedidoItem::updateOrCreate(['id_pedido' => $pedido->id, 'id_articulo' => $item['id_articulo']], $item);
        }
        $pedido->items = $items;

        return $arr;
    }

    public function getAddresses()
    {
        $client = new \GuzzleHttp\Client();
        $response = $client->request('GET', self::url.'addresses?ws_key='.self::key);
        $addresses = $this->XMLtoArray($response->getBody())['PRESTASHOP']['ADDRESSES']['ADDRESS'];
        $clientes_array = [];
        foreach ($addresses as $client) {
            try {
                $clientes_array[] = $this->getAddress($client['ID']);
            } catch (\Exception $ex) {
            }
        }

        return ['data' => $addresses, 'elements' => $clientes_array];
    }

    public function getAddress($id)
    {
        $client = new \GuzzleHttp\Client();
        $response = $client->request('GET', self::url.'addresses/'.$id.'?ws_key='.self::key);

        $clientes = $this->XMLtoArray($response->getBody())['PRESTASHOP']['ADDRESS'];

        $cliente = [
                'id_cliente' => isset($clientes['ID_CUSTOMER']['content']) ? $clientes['ID_CUSTOMER']['content'] : $clientes['ID_CUSTOMER'],
                'telefono' => $clientes['PHONE'] ?? '',
                'direccion' => $clientes['ADDRESS1'] ?? ' '.$clientes['ADDRESS2'] ?? '',
                'ciudad' => $clientes['CITY'] ?? '',
                'codigo_postal' => $clientes['POSTCODE'] ?? '',
                'id_pais' => $clientes['ID_COUNTRY']['content'],
                'dni' => $clientes['DNI'] ?? null,
        ];

        return $cliente;
    }

    public function getClientes()
    {
        $client = new \GuzzleHttp\Client();
        $response = $client->request('GET', self::url.'customers?ws_key='.self::key);
        $clientes = $this->XMLtoArray($response->getBody())['PRESTASHOP']['CUSTOMERS']['CUSTOMER'];

        $ultimo = UltimoClientePresta::find(1);
        if ($ultimo == null) {
            $ultimo = UltimoClientePresta::create(['id_cliente' => 0]);
        }
        $clientes_array = [];

        foreach ($clientes as $client) {
            if (intval($client['ID']) > $ultimo->id_cliente) {
                try {
                    $clientes_array[] = $this->getCliente($client['ID']);
                } catch (\Exception $ex) {
                }
            }
        }

        return ['data' => $clientes, 'elements' => $clientes_array];
    }

    public function getCliente($id)
    {
        $client = new \GuzzleHttp\Client();
        $response = $client->request('GET', self::url.'customers/'.$id.'?ws_key='.self::key);
        $clientes = $this->XMLtoArray($response->getBody())['PRESTASHOP']['CUSTOMER'];

        $arr = [
            'nombre' => $clientes['FIRSTNAME'],
            'apellidos' => $clientes['LASTNAME'],
            'nombre_fiscal' => $clientes['FIRSTNAME'].' '.$clientes['LASTNAME'],
            'email' => $clientes['EMAIL'],
            'fecha_nacimiento' => $clientes['BIRTHDAY'] == '0000-00-00' ? null : $clientes['BIRTHDAY'],
            'id_grupo' => 1,
        ];
        $cliente = Cliente::updateOrCreate(['email' => $clientes['EMAIL']], $arr);

        return $cliente;
    }

    public function XMLtoArray($XML)
    {
        $xml_parser = xml_parser_create();
        xml_parse_into_struct($xml_parser, $XML, $vals);
        xml_parser_free($xml_parser);
        // wyznaczamy tablice z powtarzajacymi sie tagami na tym samym poziomie
        $_tmp = '';
        foreach ($vals as $xml_elem) {
            $x_tag = $xml_elem['tag'];
            $x_level = $xml_elem['level'];
            $x_type = $xml_elem['type'];
            if ($x_level != 1 && $x_type == 'close') {
                if (isset($multi_key[$x_tag][$x_level])) {
                    $multi_key[$x_tag][$x_level] = 1;
                } else {
                    $multi_key[$x_tag][$x_level] = 0;
                }
            }
            if ($x_level != 1 && $x_type == 'complete') {
                if ($_tmp == $x_tag) {
                    $multi_key[$x_tag][$x_level] = 1;
                }
                $_tmp = $x_tag;
            }
        }
        // jedziemy po tablicy
        foreach ($vals as $xml_elem) {
            $x_tag = $xml_elem['tag'];
            $x_level = $xml_elem['level'];
            $x_type = $xml_elem['type'];
            if ($x_type == 'open') {
                $level[$x_level] = $x_tag;
            }
            $start_level = 1;
            $php_stmt = '$xml_array';
            if ($x_type == 'close' && $x_level != 1) {
                ++$multi_key[$x_tag][$x_level];
            }
            while ($start_level < $x_level) {
                $php_stmt .= '[$level['.$start_level.']]';
                if (isset($multi_key[$level[$start_level]][$start_level]) && $multi_key[$level[$start_level]][$start_level]) {
                    $php_stmt .= '['.($multi_key[$level[$start_level]][$start_level] - 1).']';
                }
                ++$start_level;
            }
            $add = '';
            if (isset($multi_key[$x_tag][$x_level]) && $multi_key[$x_tag][$x_level] && ($x_type == 'open' || $x_type == 'complete')) {
                if (!isset($multi_key2[$x_tag][$x_level])) {
                    $multi_key2[$x_tag][$x_level] = 0;
                } else {
                    ++$multi_key2[$x_tag][$x_level];
                }
                $add = '['.$multi_key2[$x_tag][$x_level].']';
            }
            if (isset($xml_elem['value']) && trim($xml_elem['value']) != '' && !array_key_exists('attributes', $xml_elem)) {
                if ($x_type == 'open') {
                    $php_stmt_main = $php_stmt.'[$x_type]'.$add.'[\'content\'] = $xml_elem[\'value\'];';
                } else {
                    $php_stmt_main = $php_stmt.'[$x_tag]'.$add.' = $xml_elem[\'value\'];';
                }
                eval($php_stmt_main);
            }
            if (array_key_exists('attributes', $xml_elem)) {
                if (isset($xml_elem['value'])) {
                    $php_stmt_main = $php_stmt.'[$x_tag]'.$add.'[\'content\'] = $xml_elem[\'value\'];';
                    eval($php_stmt_main);
                }
                foreach ($xml_elem['attributes'] as $key => $value) {
                    $php_stmt_att = $php_stmt.'[$x_tag]'.$add.'[$key] = $value;';
                    eval($php_stmt_att);
                }
            }
        }

        return $xml_array;
    }

    // paises
    public function getCountries()
    {
        $client = new \GuzzleHttp\Client();
        $response = $client->request('GET', self::url.'countries?ws_key='.self::key);
        $addresses = $this->XMLtoArray($response->getBody())['PRESTASHOP']['COUNTRIES']['COUNTRY'];

        $clientes_array = [];
        foreach ($addresses as $client) {
            try {
                $clientes_array[] = $this->getCountry($client['ID']);
            } catch (\Exception $ex) {
            }
        }

        return ['data' => $addresses, 'elements' => $clientes_array];
    }

    public function getCountry($id)
    {
        $client = new \GuzzleHttp\Client();
        $response = $client->request('GET', self::url.'countries/'.$id.'?ws_key='.self::key);

        $country = $this->XMLtoArray($response->getBody())['PRESTASHOP']['COUNTRY'];

        $arr = [
        'id' => $id,
            'nombre' => $country['NAME']['LANGUAGE'][0]['content'] ?? '',
            'activo' => $country['ACTIVE'] ?? '',
        ];
        $pais = Pais::updateOrCreate(['id' => $id], $arr);

        return $pais;
    }
}
