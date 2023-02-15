<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\SellerController;

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

Route::get('/', [HomeController::class, 'index']);
Route::get('/index2', [HomeController::class, 'index2']);
Route::get('/index3', [HomeController::class, 'index3']);
Route::get('/all_customers', [HomeController::class, 'all_customers']);
Route::get('/index2_customer', [HomeController::class, 'index2_customer']);
Route::get('/index_new', [HomeController::class, 'index_new']);

//Api Method
Route::post('/update_invoice_number', [ApiController::class, 'update_invoice_number'])->name('update_invoice_number');
Route::post('/update_supplier_track_number', [ApiController::class, 'update_supplier_track_number'])->name('update_supplier_track_number');
Route::post('/update_parcel_weight', [ApiController::class, 'update_parcel_weight'])->name('update_parcel_weight');
Route::post('/update_shipped_status', [ApiController::class, 'update_shipped_status'])->name('update_shipped_status');
Route::post('/change_parcel_type', [ApiController::class, 'change_parcel_type'])->name('change_parcel_type');
Route::post('/update_parcel_status_backend', [ApiController::class, 'update_parcel_status_backend'])->name('update_parcel_status_backend');
Route::post('/delete_parcel_backend', [ApiController::class, 'delete_parcel_backend'])->name('delete_parcel_backend');
Route::post('/update_invoice_status', [ApiController::class, 'update_invoice_status'])->name('update_invoice_status');
Route::post('/update_wishlist_products_backend', [ApiController::class, 'update_wishlist_products_backend'])->name('update_wishlist_products_backend');
Route::post('/delete_wishlist_products_backend', [ApiController::class, 'delete_wishlist_products_backend'])->name('delete_wishlist_products_backend');
Route::post('/delete_wishlist_customer', [ApiController::class, 'delete_wishlist_customer'])->name('delete_wishlist_customer');
Route::post('/update_customer_product_wishlist', [ApiController::class, 'update_customer_product_wishlist'])->name('update_customer_product_wishlist');
Route::post('/supplier_tracking', [ApiController::class, 'supplier_tracking'])->name('supplier_tracking');
Route::post('/update_hs_code', [ApiController::class, 'update_hs_code'])->name('update_hs_code');
Route::post('/join_parcel', [ApiController::class, 'join_parcel'])->name('join_parcel');
Route::post('/update_wishlist_products', [ApiController::class, 'update_wishlist_products'])->name('update_wishlist_products');
Route::post('/archive_backend', [ApiController::class, 'archive_backend'])->name('archive_backend');
Route::post('/create_parcel_backend', [ApiController::class, 'create_parcel_backend'])->name('create_parcel_backend');
Route::post('/delete_instock_products_backend', [ApiController::class, 'delete_instock_products_backend'])->name('delete_instock_products_backend');
Route::post('/paid_products_backend', [ApiController::class, 'paid_products_backend'])->name('paid_products_backend');
Route::post('/update_track_number', [ApiController::class, 'update_track_number'])->name('update_track_number');
Route::post('/scan_products', [ApiController::class, 'scan_products'])->name('scan_products');


//Test methods
Route::get('/awb_archive', [TestController::class, 'awb_archive']);
Route::get('/awb', [TestController::class, 'awb']);
Route::get('/create', [TestController::class, 'create']);
Route::get('/error', [TestController::class, 'error']);
Route::get('/delete', [TestController::class, 'delete']);
Route::get('/keyword', [TestController::class, 'keyword']);
Route::get('/matching_rajat', [TestController::class, 'matching_rajat']);
Route::match(['get', 'post'], '/matching', [TestController::class, 'matching']);
// matching page apis...
Route::post('/add_matching_cost', [TestController::class, 'add_matching_cost']);
Route::post('/supplier_tracking', [TestController::class, 'supplier_tracking']);
Route::post('/update_hs_code', [TestController::class, 'update_hs_code']);
Route::post('/join_parcel', [TestController::class, 'join_parcel']);
Route::post('/update_wishlist_products', [TestController::class, 'update_wishlist_products']);
Route::post('/archive_backend', [TestController::class, 'archive_backend']);
// Route::post('/create_parcel_backend', [TestController::class, 'create_parcel_backend']);
Route::post('/delete_instock_products_backend', [TestController::class, 'delete_instock_products_backend']);
Route::post('/paid_products_backend', [TestController::class, 'paid_products_backend']);
Route::post('/update_track_number', [TestController::class, 'update_track_number']);
// end matching page api..
Route::get('/read', [TestController::class, 'read']);
Route::get('/shipment_archive', [TestController::class, 'shipment_archive']);
Route::get('/shipment_new_with_user', [TestController::class, 'shipment_new_with_user']);
Route::get('/shipment_new', [TestController::class, 'shipment_new']);
Route::get('/shipment_with_user', [TestController::class, 'shipment_with_user']);
Route::get('/shipment', [TestController::class, 'shipment']);
Route::get('/test1', [TestController::class, 'test1']);
Route::get('/wallet_new', [TestController::class, 'wallet_new']);
Route::get('/wallet_page_backup', [TestController::class, 'wallet_page_backup']);
Route::get('/wallet_page_new', [TestController::class, 'wallet_page_new']);
Route::get('/wallet_page', [TestController::class, 'wallet_page']);
Route::get('/walletpage', [TestController::class, 'walletpage']);
Route::get('/wishlist', [TestController::class, 'wishlist']);
/*
Seller Routes..
*/
Route::get('/seller', [SellerController::class, 'index']);
Route::match(['get', 'post'], '/seller/create', [SellerController::class, 'create']);
Route::get('/seller/read', [SellerController::class, 'read']);
Route::get('/seller/error', [SellerController::class, 'error']);
Route::match(['get', 'post'], '/seller/update', [SellerController::class, 'update']);
Route::get('/seller/delete', [SellerController::class, 'delete']);
