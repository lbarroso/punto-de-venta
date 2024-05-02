<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ImageController;
use App\Http\Controllers\ProductController;



/*

|--------------------------------------------------------------------------

| Web Routes

|--------------------------------------------------------------------------

|

| Here is where you can register web routes for your application. These

| routes are loaded by the RouteServiceProvider within a group which

| contains the "web" middleware group. Now create something great!

|

*/



Route::get('/', function () {

    return view('welcome');

});



Auth::routes();



Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// view test adminLte

//Route::get('/plantilla', [App\Http\Controllers\HomeController::class, 'adminlte'])->name('adminlte');



// productos

Route::apiResource('products',App\Http\Controllers\ProductController::class)->middleware('auth');

Route::get('products/categories/all',[App\Http\Controllers\ProductController::class,'categories'])->name('products.categories');
Route::get('products/proveedores/all',[App\Http\Controllers\ProductController::class,'proveedores'])->name('products.proveedores');
Route::get('salidas/clientes/all',[App\Http\Controllers\ClienteController::class,'clientes'])->name('salidas.clientes');

Route::get('productcreate',[App\Http\Controllers\ProductController::class,'productcreate'])->name('product.create')->middleware('auth');

Route::post('productstore',[App\Http\Controllers\ProductController::class,'productstore'])->name('product.store')->middleware('auth');

Route::get('productvalidate',[App\Http\Controllers\ProductController::class,'productvalidate'])->name('product.validation');

Route::get('productcodes/{id}',[App\Http\Controllers\ProductController::class,'productcodes'])->name('product.codes');

Route::get('deletecodes/{id}',[App\Http\Controllers\ProductController::class,'deletecodes'])->name('delete.codes');

Route::post('storecodes',[App\Http\Controllers\ProductController::class,'storecodes'])->name('store.codes');


Route::resource('categories',App\Http\Controllers\CategoryController::class)->middleware('auth');

Route::resource('proveedores',App\Http\Controllers\ProveedoreController::class)->middleware('auth');

Route::resource('clientes',App\Http\Controllers\ClienteController::class)->middleware('auth');

Route::resource('empresas',App\Http\Controllers\EmpresaController::class)->middleware('auth');

// imagenes
Route::controller(ImageController::class)->name('images.')->group(function () {

    Route::get('images/product/table/{product}','table');

    Route::post('images/store','store')->name('store');

    Route::delete('images/{image}','destroy');

});


// menu reportes
Route::prefix('reports')->group(function(){
    Route::get('diarios',[App\Http\Controllers\ProductController::class,'reportsdiarios'])->name('daily.days');
    Route::get('descendente',[App\Http\Controllers\VentaController::class,'descendente'])->name('descendente');
    Route::get('ventas',[App\Http\Controllers\VentaController::class,'ventas'])->name('ventas');
});


// punto de venta
Route::apiResource('pvproducts',App\Http\Controllers\PvproductController::class)->middleware('auth');
Route::get('docdetastore',[App\Http\Controllers\PvproductController::class,'docdetaStore'])->name('docdeta.store');
Route::get('venta/total',[App\Http\Controllers\VentaController::class,'ventatotal'])->name('venta.total');
Route::get('venta/totalproducts',[App\Http\Controllers\VentaController::class,'totalproducts'])->name('venta.totalproducts');
Route::get('venta/{cash}',[App\Http\Controllers\VentaController::class,'ventacash'])->name('venta.cash');
Route::post('ventastore',[App\Http\Controllers\VentaController::class,'store'])->name('venta.store');
Route::post('descto/venta',[App\Http\Controllers\VentaController::class,'desctoventa'])->name('descto.venta');
Route::get('venta/ticket/{id}',[App\Http\Controllers\VentaController::class,'ticket'])->name('venta.ticket');
Route::get('salida/ticket/{id}',[App\Http\Controllers\SalidaController::class,'ticket'])->name('salida.ticket');
Route::get('dailysales',[App\Http\Controllers\VentaController::class,'dailysales'])->name('daily.sales');
Route::get('salesreport',[App\Http\Controllers\VentaController::class,'salesreport'])->name('sales.report');
Route::get('pvproducts/find/{texto}',[App\Http\Controllers\VentaController::class,'buscar'])->name('pvproducts.find');

// catalogo con imagenes
Route::get('catalogopdf',[App\Http\Controllers\ProductController::class,'downloadDompdf'])->name('catalogo.pdf');

// reportes Excel
Route::get('/posicionalmacen', [App\Http\Controllers\ProductController::class, 'posicionexport'])->name('posicion.almacen');
Route::get('/descendente/export', [App\Http\Controllers\VentaController::class, 'descendenteexport'])->name('descendente.export');
Route::get('/descendente/print', [App\Http\Controllers\VentaController::class, 'descendenteprint'])->name('descendente.print');

// users
Route::get('/change-password',[App\Http\Controllers\UserController::class,'passwordForm'])->name('password.change');
Route::post('/change-password',[App\Http\Controllers\UserController::class,'changePassword'])->name('password.update');
Route::get('profile/edit', [App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
Route::post('profile/update', [App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');

// cajas
Route::get('cash',[App\Http\Controllers\CashRegisterController::class,'index'])->name('cash.index');
Route::post('/cash/start', [App\Http\Controllers\CashRegisterController::class, 'startcash'])->name('cash.start');
Route::post('/cash/withdraw', [App\Http\Controllers\CashRegisterController::class, 'withdrawCash'])->name('cash.withdraw');
Route::post('/cash/sale', [App\Http\Controllers\CashRegisterController::class, 'recordsale'])->name('cash.sale');

// cierres
Route::get('cierre',[App\Http\Controllers\CierreController::class,'index'])->name('cierre.index');
Route::post('cierre/store',[App\Http\Controllers\CierreController::class,'store'])->name('cierre.store');
Route::get('cierre/ticket',[App\Http\Controllers\CierreController::class,'ticket'])->name('cierre.ticket');

// menu entradas y salidas
Route::prefix('inventario')->group(function(){
    // Route::get('transferencia', [App\Http\Controllers\TransferenciaController::class, 'index'])->name('transferencias.index');
    Route::get('compras', [App\Http\Controllers\CompraController::class, 'index'])->name('compras.index');
    Route::get('salidas',[App\Http\Controllers\SalidaController::class,'index'])->name('salidas.index');
});
// entradas de proveedor
Route::get('entrada/find/{code}',[App\Http\Controllers\DocdetaController::class,'findcode'])->name('entrada.find.code');

Route::get('entrada/modal/find/{texto}',[App\Http\Controllers\DocdetaController::class,'entradafindproduct'])->name('entrada.find.product');
Route::get('entrada/docdeta/store',[App\Http\Controllers\DocdetaController::class,'entradadocdetastore'])->name('entrada.docdeta.store');
Route::get('entrada/index/table',[App\Http\Controllers\DocdetaController::class,'entradaindex'])->name('entrada.index.table');
Route::get('salida/index/table',[App\Http\Controllers\DocdetaController::class,'salidaindex'])->name('salida.index.table');
Route::post('entrada/ajax/product',[App\Http\Controllers\DocdetaController::class,'entradaajaxproduct'])->name('entrada.ajax.product');
Route::post('salida/ajax/product',[App\Http\Controllers\DocdetaController::class,'salidaajaxproduct'])->name('salida.ajax.product');

Route::get('entrada/product/show/{id}',[App\Http\Controllers\DocdetaController::class,'entradaproductshow'])->name('entrada.product.show');
Route::get('entrada/product/delete/{id}',[App\Http\Controllers\DocdetaController::class,'entradaproductdelete'])->name('entrada.product.delete');
Route::get('salida/product/update/{id}',[App\Http\Controllers\DocdetaController::class,'salidaproductupdate'])->name('salida.product.update');
Route::get('entrada/product/update/{id}',[App\Http\Controllers\DocdetaController::class,'entradaproductupdate'])->name('entrada.product.update');

Route::get('entrada/total',[App\Http\Controllers\DocdetaController::class,'entradatotal'])->name('entrada.total');
Route::get('salida/total',[App\Http\Controllers\DocdetaController::class,'salidatotal'])->name('salida.total');
// 
Route::post('compras/store',[App\Http\Controllers\CompraController::class,'store'])->name('compras.store');
Route::get('compras/pdf/{id}',[App\Http\Controllers\CompraController::class,'pdf'])->name('compras.pdf');
Route::get('salidas/pdf/{id}',[App\Http\Controllers\SalidaController::class,'pdf'])->name('salidas.pdf');
Route::post('salidas/store',[App\Http\Controllers\SalidaController::class,'store'])->name('salidas.store');
