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
    Route::get('descendente',[App\Http\Controllers\ProductController::class,'reportsdescendente'])->name('descendente');
});


// punto de venta
Route::apiResource('pvproducts',App\Http\Controllers\PvproductController::class)->middleware('auth');
Route::get('docdetastore',[App\Http\Controllers\PvproductController::class,'docdetaStore'])->name('docdeta.store');
Route::get('venta/total',[App\Http\Controllers\VentaController::class,'ventatotal'])->name('venta.total');
Route::get('venta/totalproducts',[App\Http\Controllers\VentaController::class,'totalproducts'])->name('venta.totalproducts');
Route::get('venta/{cash}',[App\Http\Controllers\VentaController::class,'ventacash'])->name('venta.cash');
Route::post('ventastore',[App\Http\Controllers\VentaController::class,'store'])->name('venta.store');
Route::get('venta/ticket/{id}',[App\Http\Controllers\VentaController::class,'ticket'])->name('venta.ticket');
Route::get('dailysales',[App\Http\Controllers\VentaController::class,'dailysales'])->name('daily.sales');
Route::get('pvproducts/find/{texto}',[App\Http\Controllers\VentaController::class,'buscar'])->name('pvproducts.find');

// catalogo con imagenes
Route::get('catalogopdf',[App\Http\Controllers\ProductController::class,'downloadDompdf'])->name('catalogo.pdf');

// posicion excel
Route::get('/posicionalmacen', [App\Http\Controllers\ProductController::class, 'posicionexport'])->name('posicion.almacen');

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

// entradas y salidas inventario
Route::prefix('inventario')->group(function(){
    Route::get('entrada/index',[App\Http\Controllers\DocdetaController::class,'entradaindex'])->name('entrada.index');
    Route::get('salida/index',[App\Http\Controllers\DocdetaController::class,'salidaindex'])->name('salida.index');
});

Route::get('entrada/find/{code}',[App\Http\Controllers\DocdetaController::class,'findcode'])->name('entrada.find.code');
Route::get('entrada/index/table',[App\Http\Controllers\DocdetaController::class,'entradaindex'])->name('entrada.index.table');