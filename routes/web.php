<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Auth::routes(['register' => false]);
Route::get('language-change', [App\Http\Controllers\LanguageController::class, 'changeLanguage'])->name('changeLanguage');

Route::get('refreshcaptcha', [App\Http\Controllers\Auth\LoginController::class, 'refreshcaptcha'])->name('refreshcaptcha');
Route::get('qr', [App\Http\Controllers\IndexController::class, 'menu'])->name('qr');
Route::get('/', [App\Http\Controllers\IndexController::class, 'index'])->name('/');

Route::get('policies', [App\Http\Controllers\IndexController::class, 'policies'])->name('policies');


Route::get('about', [App\Http\Controllers\IndexController::class, 'about'])->name('about');
Route::get('contacts', [App\Http\Controllers\IndexController::class, 'contacts'])->name('contacts');
Route::post('send', [App\Http\Controllers\IndexController::class, 'send'])->name('send');
Route::get('category', [App\Http\Controllers\IndexController::class, 'categories'])->name('category');
Route::get('menu/info/{id}', [App\Http\Controllers\IndexController::class, 'menuinfo'])->name('menu/info');
Route::get('product/info/{id}', [App\Http\Controllers\IndexController::class, 'proudactinfo'])->name('product/info');
Route::get('all_products', [App\Http\Controllers\IndexController::class, 'products'])->name('all_products');
Route::get('products/discount', [App\Http\Controllers\IndexController::class, 'discountprod'])->name('products/discount');
Route::get('product/category/{id}', [App\Http\Controllers\IndexController::class, 'productcategory'])->name('product/category');

Route::post('cart/store', [App\Http\Controllers\CartController::class, 'store'])->name('cart.store');
Route::get('/cart', [App\Http\Controllers\CartController::class, 'index'])->name('cart.index');
Route::delete('/cart/remove/{product_id}', [App\Http\Controllers\CartController::class, 'remove'])->name('cart.remove');
Route::get('/cart/items/count', [App\Http\Controllers\CartController::class, 'getCartItemCount'])->name('cart.items.count');
Route::post('/cart/update/{product_id}', [App\Http\Controllers\CartController::class, 'updateQuantity'])->name('cart.updateQuantity');

Route::get('home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('report/all', [App\Http\Controllers\HomeController::class, 're'])->name('report/all');

Route::post('order/store', [App\Http\Controllers\OrderController::class, 'store'])->name('order.store');
Route::get('order/success', [App\Http\Controllers\OrderController::class, 'success'])->name('order/success');

Route::get('/search', [App\Http\Controllers\SearchController::class, 'index'])->name('search');


Route::namespace('Dashbord')->group(function ()
 {
  Route::get('sitesetting', [App\Http\Controllers\HomeController::class, 'sitesetting'])->name('sitesetting');
  Route::get('ordersindex', [App\Http\Controllers\HomeController::class, 'ordersindex'])->name('ordersindex');

  Route::get('users', [App\Http\Controllers\Dashbord\UserController::class, 'index'])->name('users');

    Route::get('users/create', [App\Http\Controllers\Dashbord\UserController::class, 'create'])->name('users/create');
    Route::post('users/create', [App\Http\Controllers\Dashbord\UserController::class, 'store'])->name('users/store');;
    Route::get('users/users', [App\Http\Controllers\Dashbord\UserController::class, 'users'])->name('users/users');
    Route::get('users/changeStatus/{id}', [App\Http\Controllers\Dashbord\UserController::class, 'changeStatus'])->name('users/changeStatus');
    Route::get('users/edit/{id}', [App\Http\Controllers\Dashbord\UserController::class, 'edit'])->name('users/edit');
    Route::post('users/edit/{id}', [App\Http\Controllers\Dashbord\UserController::class, 'update'])->name('users/update');
    Route::get('users/profile/{id}', [App\Http\Controllers\Dashbord\UserController::class, 'show'])->name('users/profile');
    Route::get('users/changepassword/{id}', [App\Http\Controllers\Dashbord\UserController::class, 'showChangePasswordForm'])->name('users/ChangePasswordForm');
    Route::POST('users/changepassword/{id}', [App\Http\Controllers\Dashbord\UserController::class, 'changePassword'])->name('users/changepassword');
    Route::get('users/myactivity', [App\Http\Controllers\Dashbord\UserController::class, 'myactivity'])->name('users/myactivity');

    //----------------------------city-----------------------------------------------------------------       
    Route::get('cities', [App\Http\Controllers\Dashbord\CityController::class, 'index'])->name('cities');
    Route::get('cities/create', [App\Http\Controllers\Dashbord\CityController::class, 'create'])->name('cities/create');
    Route::post('cities/create', [App\Http\Controllers\Dashbord\CityController::class, 'store'])->name('cities/store');;
    Route::get('cities/cities', [App\Http\Controllers\Dashbord\CityController::class, 'cities'])->name('cities/cities');;
    Route::get('cities/edit/{id}', [App\Http\Controllers\Dashbord\CityController::class, 'edit'])->name('cities/edit');
    Route::post('cities/edit/{id}', [App\Http\Controllers\Dashbord\CityController::class, 'update'])->name('cities/update');
    Route::delete('cities/delete/{id}', [App\Http\Controllers\Dashbord\CityController::class, 'delete'])->name('cities/delete');

    Route::get('aboutus', [App\Http\Controllers\Dashbord\AboutusController::class, 'index'])->name('aboutus');
    Route::get('aboutus/create', [App\Http\Controllers\Dashbord\AboutusController::class, 'create'])->name('aboutus/create');
    Route::get('aboutus/aboutus', [App\Http\Controllers\Dashbord\AboutusController::class, 'aboutus'])->name('aboutus/aboutus');;
    Route::post('aboutus/create', [App\Http\Controllers\Dashbord\AboutusController::class, 'store'])->name('aboutus/store');;
    Route::get('aboutus/edit', [App\Http\Controllers\Dashbord\AboutusController::class, 'edit'])->name('aboutus/edit');
    Route::post('aboutus/edit', [App\Http\Controllers\Dashbord\AboutusController::class, 'update'])->name('aboutus/update');

    Route::get('slider', [App\Http\Controllers\Dashbord\SliderController::class, 'index'])->name('slider');
    Route::get('slider/create', [App\Http\Controllers\Dashbord\SliderController::class, 'create'])->name('slider/create');
    Route::post('slider/create', [App\Http\Controllers\Dashbord\SliderController::class, 'store'])->name('slider/store');;

    Route::get('slider/slider', [App\Http\Controllers\Dashbord\SliderController::class, 'sliders'])->name('slider/slider');
    Route::get('slider/delete/{id}', [App\Http\Controllers\Dashbord\SliderController::class, 'destroy'])->name('slider/delete');
    Route::get('salesbanners', [App\Http\Controllers\Dashbord\SalesbannerController::class, 'index'])->name('salesbanners');
    Route::get('salesbanners/create', [App\Http\Controllers\Dashbord\SalesbannerController::class, 'create'])->name('salesbanners/create');

    Route::post('salesbanners/create', [App\Http\Controllers\Dashbord\SalesbannerController::class, 'store'])->name('salesbanners/store');
    Route::get('salesbanners/salesbanners', [App\Http\Controllers\Dashbord\SalesbannerController::class, 'salesbanners'])->name('salesbanners/salesbanners');
    Route::delete('salesbanners/delete/{id}', [App\Http\Controllers\Dashbord\SalesbannerController::class, 'destroy'])->name('salesbanners/delete');

    

    Route::get('contactus', [App\Http\Controllers\Dashbord\ContactusController::class, 'index'])->name('contactus');
    Route::get('contactus/edit', [App\Http\Controllers\Dashbord\ContactusController::class, 'edit'])->name('contactus/edit');
    Route::post('contactus/edit', [App\Http\Controllers\Dashbord\ContactusController::class, 'update'])->name('contactus/update');


    Route::get('inbox', [App\Http\Controllers\Dashbord\InboxController::class, 'index'])->name('inbox');
    Route::get('inbox/inbox', [App\Http\Controllers\Dashbord\InboxController::class, 'inbox'])->name('inbox/inbox');
  

    Route::get('categories',  [App\Http\Controllers\Dashbord\CategoriesController::class, 'index'])->name('categories.index');
    Route::get('categories/create',  [App\Http\Controllers\Dashbord\CategoriesController::class, 'create'])->name('categories.create');
    Route::post('categories',  [App\Http\Controllers\Dashbord\CategoriesController::class, 'store'])->name('categories.store');
    Route::get('categories/{id}/edit',  [App\Http\Controllers\Dashbord\CategoriesController::class, 'edit'])->name('categories.edit');
    Route::put('categories/{id}',  [App\Http\Controllers\Dashbord\CategoriesController::class, 'update'])->name('categories.update');
    Route::delete('categories/{id}',  [App\Http\Controllers\Dashbord\CategoriesController::class, 'destroy'])->name('categories.destroy');
    Route::post('categories/change-status/{id}', [App\Http\Controllers\Dashbord\CategoriesController::class, 'changeCategoryStatus'])->name('categories.changeStatus');


    Route::get('products', [App\Http\Controllers\Dashbord\ProductsController::class, 'index'])->name('products');
    Route::get('products/create', [App\Http\Controllers\Dashbord\ProductsController::class, 'create'])->name('products/create');
    Route::post('products/create', [App\Http\Controllers\Dashbord\ProductsController::class, 'store'])->name('products/store');;
    Route::get('products/products', [App\Http\Controllers\Dashbord\ProductsController::class, 'products'])->name('products/products');
    Route::get('products/changeStatus/{id}', [App\Http\Controllers\Dashbord\ProductsController::class, 'changeStatus'])->name('products/changeStatus');
    Route::get('products/edit/{id}', [App\Http\Controllers\Dashbord\ProductsController::class, 'edit'])->name('products/edit');
    Route::get('products/delete/{id}', [App\Http\Controllers\Dashbord\ProductsController::class, 'destroy'])->name('products/delete');
    Route::post('products/edit/{id}', [App\Http\Controllers\Dashbord\ProductsController::class, 'update'])->name('products/update');
    Route::get('products/gellary/{id}', [App\Http\Controllers\Dashbord\ProductsController::class, 'gellary'])->name('products/gellary');
    Route::get('products/deleteImage/{id}', [App\Http\Controllers\Dashbord\ProductsController::class, 'deleteImage'])->name('products/deleteImage');


    Route::get('discounts', [App\Http\Controllers\Dashbord\DiscountController::class, 'index'])->name('discounts');
    Route::get('discounts/create', [App\Http\Controllers\Dashbord\DiscountController::class, 'create'])->name('discounts/create');

    Route::get('discounts/getproudact', [App\Http\Controllers\Dashbord\DiscountController::class, 'getproudact'])->name('discounts/getproudact');
    Route::post('discounts/create', [App\Http\Controllers\Dashbord\DiscountController::class, 'store'])->name('discounts/store');
    Route::get('discounts/discounts', [App\Http\Controllers\Dashbord\DiscountController::class, 'discount'])->name('discounts/discounts');
    Route::get('discounts/delete/{id}', [App\Http\Controllers\Dashbord\DiscountController::class, 'destroy'])->name('discounts/delete');

    
    
    Route::get('pending/oreder', [App\Http\Controllers\Dashbord\OrderController::class, 'pedningindex'])->name('pending/oreder');
    Route::get('pending/oreders', [App\Http\Controllers\Dashbord\OrderController::class, 'orderspenidng'])->name('pending/oreders');
   
   Route::get('all/oreder', [App\Http\Controllers\Dashbord\OrderController::class, 'allindex'])->name('all/oreder');
    Route::get('all/oreders', [App\Http\Controllers\Dashbord\OrderController::class, 'ordersall'])->name('all/oreders');
   
   
   
   
    Route::post('pending/preparationfuction/{id}', [App\Http\Controllers\Dashbord\OrderController::class, 'preparationfuction'])->name('pending/preparationfuction');
    Route::post('pending/cancelfunction/{id}', [App\Http\Controllers\Dashbord\OrderController::class, 'cacnelfuction'])->name('pending/cancelfunction');
    Route::get('complete/oreder', [App\Http\Controllers\Dashbord\OrderController::class, 'completelindex'])->name('complete/oreder');
    Route::get('complete/oreders', [App\Http\Controllers\Dashbord\OrderController::class, 'orderscompletel'])->name('complete/oreders');
 
    
    
    Route::get('cancel/oreder', [App\Http\Controllers\Dashbord\OrderController::class, 'cancelindex'])->name('cancel/oreder');
    Route::get('cancel/oreders', [App\Http\Controllers\Dashbord\OrderController::class, 'orderscancel'])->name('cancel/oreders');

    Route::get('underprocess/oreder', [App\Http\Controllers\Dashbord\OrderController::class, 'underptocessindex'])->name('underprocess/oreder');
    Route::get('underprocess/oreders', [App\Http\Controllers\Dashbord\OrderController::class, 'underptocessindexs'])->name('underprocess/oreders');
    Route::get('orderitem/{id}', [App\Http\Controllers\Dashbord\OrderController::class, 'orderitem'])->name('orderitem');
    Route::put('order/update/{id}', [App\Http\Controllers\Dashbord\OrderController::class, 'update'])->name('order.update');
    Route::delete('/order/item/remove/{id}', [App\Http\Controllers\Dashbord\OrderController::class, 'removeItemFromOrder'])->name('order.item.remove');
    Route::post('order/complete/{id}', [App\Http\Controllers\Dashbord\OrderController::class, 'markAsComplete'])->name('order.complete');


    Route::get('notifications', [App\Http\Controllers\Dashbord\NotificationController::class, 'index'])->name('notifications.index');
    Route::get('notifications/read/{id}', [App\Http\Controllers\Dashbord\NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::get('/notifications/fetch', [App\Http\Controllers\Dashbord\NotificationController::class, 'fetch'])->name('notifications.fetch');

    
    
    
    


    Route::get('stock', [App\Http\Controllers\Dashbord\StockController::class, 'all'])->name('stock');
    Route::get('stock/stock', [App\Http\Controllers\Dashbord\StockController::class, 'stock'])->name('stock/stock');
  
    Route::get('stockall/{id}', [App\Http\Controllers\Dashbord\StockController::class, 'indexall'])->name('stockall');
    Route::get('stock/stockall/{id}', [App\Http\Controllers\Dashbord\StockController::class, 'stockall'])->name('stock/stockall');
  

    Route::get('receipts', [App\Http\Controllers\Dashbord\ReceiptController::class, 'index'])->name('receipts');
  Route::get('receipts/create', [App\Http\Controllers\Dashbord\ReceiptController::class, 'create'])->name('receipts/create');
  Route::post('receipts/create', [App\Http\Controllers\Dashbord\ReceiptController::class, 'store'])->name('receipts/store');;
  Route::get('receipts/receipts', [App\Http\Controllers\Dashbord\ReceiptController::class, 'receipts'])->name('receipts/receipts');
  Route::get('receipts/show/{id}', [App\Http\Controllers\Dashbord\ReceiptController::class, 'show'])->name('receipts/show');
  Route::get('et-grades-sizes', [App\Http\Controllers\Dashbord\ReceiptController::class, 'getGradesAndSizes'])->name('get/grades/sizes');
  Route::get('receipts/search', [App\Http\Controllers\Dashbord\ReceiptController::class, 'search'])->name('receipts/search');

    
  

  Route::get('returns', [App\Http\Controllers\Dashbord\ReturnsController::class, 'index'])->name('returns');
  Route::get('returns/create', [App\Http\Controllers\Dashbord\ReturnsController::class, 'create'])->name('returns/create');
  Route::get('returns/fetch/invoice', [App\Http\Controllers\Dashbord\ReturnsController::class, 'fetchInvoice'])->name('returns/fetch/invoice');
  Route::post('returns/process', [App\Http\Controllers\Dashbord\ReturnsController::class, 'processReturn'])->name('returns/process');
  Route::get('returns/returns', [App\Http\Controllers\Dashbord\ReturnsController::class, 'returns'])->name('returns/returns');

  

  Route::get('exchange', [App\Http\Controllers\Dashbord\ExchangeController::class, 'index'])->name('exchange');
  Route::get('exchange/create', [App\Http\Controllers\Dashbord\ExchangeController::class, 'create'])->name('exchange/create');
  Route::post('exchange/create', [App\Http\Controllers\Dashbord\ExchangeController::class, 'store'])->name('exchange/store');;
  Route::get('exchange/exchange', [App\Http\Controllers\Dashbord\ExchangeController::class, 'exchange'])->name('exchange/exchange');
  Route::get('exchange/show/{id}', [App\Http\Controllers\Dashbord\ExchangeController::class, 'show'])->name('exchange/show');
  Route::get('exchange/stockall', [App\Http\Controllers\Dashbord\ExchangeController::class, 'stockall'])->name('exchange/stockall');
  Route::get('exchange/invoice/{id}', [App\Http\Controllers\Dashbord\ExchangeController::class, 'invoice'])->name('exchange/invoice');

  
  Route::get('report/sales', [App\Http\Controllers\Dashbord\ReportController::class, 'sales'])->name('report/sales');
  Route::get('/dashbord/report/search-sales', [App\Http\Controllers\Dashbord\ReportController::class, 'searchSales'])->name('report.searchSales');


  Route::get('report/return', [App\Http\Controllers\Dashbord\ReportController::class, 'return'])->name('report/return');
  Route::get('/dashbord/report/search-return', [App\Http\Controllers\Dashbord\ReportController::class, 'searchreturn'])->name('report.searchreturn');

  
  
});

Route::prefix('policy')->name('policy.')->group(function () {
    Route::get('/', [App\Http\Controllers\Dashbord\PolicyController::class, 'index'])->name('index');
    Route::get('/create', [App\Http\Controllers\Dashbord\PolicyController::class, 'create'])->name('create');
    Route::post('/store', [App\Http\Controllers\Dashbord\PolicyController::class, 'store'])->name('store');
    Route::get('/edit/{id}', [App\Http\Controllers\Dashbord\PolicyController::class, 'edit'])->name('edit');
    Route::put('/update/{id}', [App\Http\Controllers\Dashbord\PolicyController::class, 'update'])->name('update');
    Route::delete('/destroy/{id}', [App\Http\Controllers\Dashbord\PolicyController::class, 'destroy'])->name('destroy');
});
