<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\User;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::get('get-etiqueta/{barcode}','GLSController@GetEtiqueta');
Route::get('save-etiqueta/{id}','GLSController@SaveEtiqueta');

Route::post('/register', function (Request $request) {
 
    $user = User::create([
        "name"=>'admin',
        "email"=>'admin@admin.com',
        "password"=>Hash::make('admin'),
        "id_role"=>1
    ]);
    
    return response($user, 201);

});

Route::post('/login','AuthenticationController@LogIn')->name('LogIn');
Route::post('/forgot-password','AuthenticationController@recoverPassword');
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('/clientes-prestashop','PrestaShopController@getClientes');
Route::get('/articulos-prestashop','PrestaShopController@getArticulos');
Route::get('/paises-prestashop','PrestaShopController@getCountries');

Route::get('/ordenes-prestashop','PrestaShopController@getOrders');
Route::get('/orden-prestashop/{id}','PrestaShopController@getOrder');

Route::get('/direcciones-prestashop','PrestaShopController@getAddresses');
//produccion
Route::post('/generate-produccion','ProduccionController@GenerateProduccion');
Route::post('/generate-produccion/{fecha}','ProduccionController@GenerateProduccionbyDate');
Route::get('/fix-articulos','ArticuloController@fix');

Route::get('/get-produccion/{fecha}','ProduccionController@getProduccion');
Route::post('/save-produccion','ProduccionController@saveProduccion');

Route::get('/get-headers-produccion','ProduccionController@getHeaders');
Route::get('/get-etiquetas/{fecha}','ProduccionController@testEtiquetas');
Route::get('/orden-fabricacion/{fecha}/export','FabricacionController@ExportOrdenes');
Route::get('/empaquetado/{fecha}/export','ProduccionController@ExportProduccion');

///funciones de cliente
Route::group(['middleware' => ['auth:sanctum']],function(){
    //produccion controller
    Route::post('/empaquetado/pedido/{id}','ProduccionController@AddProductoEmpaquetado');
    Route::delete('/empaquetado/pedido/{id}','ProduccionController@deletePedido');

    //aux
    Route::get('/get-paises','AuxController@getPaises');
    Route::post('/save-constantes','AuxController@saveConstantes');
    Route::get('/get-constantes','AuxController@getConstantes');
    Route::get('/get-log','AuthenticationController@getLog');

    //CRUD Usuario
    Route::get('/get-usuarios','UserController@getUsers')->name('get-usuarios');
    Route::get('/getroles','UserController@getRoles')->name('get-roles');

    Route::post('/delete-usuario','UserController@delete')->name('delete-usuario');
    Route::post('/save-usuario','UserController@create')->name('save-usuario');
    Route::get('/getusuario/{user_id}','UserController@getUsuario')->name('get-usuario');
    Route::post('/update-usuario','UserController@updateUsuario')->name('update-usuario');
    //CRUD Fabricacion
    Route::post('/orden-fabricacion','FabricacionController@generarOrden');
    Route::get('/delete-orden-fabricacion/{id}','FabricacionController@deleteOrden');
    Route::post('/save-orden-fabricacion','FabricacionController@saveOrden');
    Route::post('/finalizar-orden-fabricacion','FabricacionController@finalizarOrden');

    Route::get('/get-orden-fabricacion/{fecha}','FabricacionController@getOrden');
    Route::get('/get-orden-fabricacion-amasado/{fecha}','FabricacionController@getOrdenAmasado');
    Route::get('/consultar-orden-fabricacion/{fecha}','FabricacionController@getOrdenSinGenerar');

    Route::get('/generar-orden-fabricacion-urgencia/{fecha}','FabricacionController@generarOrdenUrgencia');

    Route::get('/get-ordenes-fabricacion','FabricacionController@getOrdenes');
    //CRUD Cliente
    Route::get('/delete-cliente/{id}','ClienteController@deleteCliente');
    Route::post('/save-cliente','ClienteController@saveCliente');
    Route::get('/get-cliente/{id}','ClienteController@getCliente');
    Route::get('/get-clientes','ClienteController@getClientes');
    Route::get('/get-tipo-cliente','ClienteController@getTipoCliente');
    //CRUD Pedido
    Route::get('/delete-pedido/{id}','PedidoController@deletePedido');
    Route::post('/save-pedido','PedidoController@savePedido');
    Route::get('/get-pedido/{id}','PedidoController@getPedido');
    Route::get('/get-pedidos','PedidoController@getPedidos');
    Route::post('/set-pedido-state','PedidoController@setPedidoState');
    Route::get('/get-estados-pedido','PedidoController@getEstadosPedido');
    Route::post('update-pedido-item', 'PedidoController@updatePedidoItem');
    Route::post('save-pedido-item', 'PedidoController@savePedidoItem');
    Route::get('exist-pedido-item', 'PedidoController@exitPedidoItem');

    // control de pedidos
    Route::get('/get-control-pedidos', 'ControlPedidosController@index');
    Route::get('/get-headers-control-pedidos','ControlPedidosController@getHeaders');
    Route::post('/change-inventarios','ControlPedidosController@changeInventarios');

    //Aux Cliente
    Route::get('/get-grupos-cliente','ClienteController@getGrupos');
    //CRUD Articulo
    Route::get('/delete-articulo/{id}','ArticuloController@deleteArticulo');
    Route::post('/save-articulo','ArticuloController@saveArticulo');
    Route::get('/get-articulo/{id}','ArticuloController@getArticulo');
    Route::get('/filter-articulos', 'ArticuloController@filterArticulos');
    Route::get('/get-articulos','ArticuloController@getArticulos');
    Route::get('/get-articulos-produccion','ArticuloController@getArticuloProduccion');

    //CRUD Articulo Familia
    Route::get('/delete-articulo-familia/{id}','ArticuloController@deleteFamilia');
    Route::post('/save-articulo-familia','ArticuloController@saveFamilia');
    Route::get('/get-articulo-familia/{id}','ArticuloController@getFamilia');
    Route::get('/get-articulo-familias','ArticuloController@getFamilias');
    //CRUD Articulo Fabricante
    Route::get('/delete-articulo-fabricante/{id}','ArticuloController@deleteFabricante');
    Route::post('/save-articulo-fabricante','ArticuloController@saveFabricante');
    Route::get('/get-articulo-fabricante/{id}','ArticuloController@getFabricante');
    Route::get('/get-articulo-fabricantes','ArticuloController@getFabricantes');
    //Aux Tipo Etiqueta
    Route::get('/get-tipos-etiqueta','ArticuloController@getTiposEtiqueta');

});
Route::post('/import-test','importController@import');

Route::get('/get-pedidos','PedidoController@GetPedidos');
// Route::get('/get-control-pedidos', 'ControlPedidosController@index');
