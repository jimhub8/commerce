<?php

use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\File;

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
// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('vendors', function () {
    return view('auth.vendor');
});
Route::get('thankyou', function () {
    return view('include.thankyou');
});
Route::post('/vendor_user', 'VendorController@vendor_user')->name('vendor_user');
Route::post('/vendor_company', 'VendorController@vendor_company')->name('vendor_company');
Route::post('vendor_logo/{id}', 'VendorController@vendor_logo')->name('vendor_logo');
// Mpesa
// Route::any('/register_url', 'SafmpesaController@register_url')->name('register_url');
// Route::any('/validate', 'SafmpesaController@validate')->name('validate');
// Route::any('/confirmation', 'SafmpesaController@confirmation')->name('confirmation');
Route::any('/mpesapay', 'SafmpesaController@mpesapay')->name('mpesapay');
Route::post('couponApply', 'CouponController@couponApply')->name('couponApply');

Route::get('couponSes', 'CartController@couponSes')->name('couponSes');

Route::get('/', 'HomeController@ecommerce')->name('ecommerce');
Route::resource('products', 'ProductController1');
Route::resource('wish', 'WishController');
Route::resource('subcategories', 'SupCategoryController');
Route::resource('prescriptions', 'PrescriptionController');
Route::resource('reviews', 'ReviewController');

Route::get('/ecommerce', 'HomeController@ecommerce')->name('ecommerce')->middleware('verified');
Route::get('/getReviews/{id}', 'ReviewController@getReviews')->name('getReviews');

Route::get('/getsP', 'SliderController@getsP')->name('getsP');
Route::get('/getTP', 'SliderController@getTP')->name('getTP');
Route::get('/getTPN', 'SliderController@getTPN')->name('getTPN');
Route::get('/headerPro', 'SliderController@headerPro')->name('headerPro');

Route::get('/bestSellF', 'SliderController@bestSellF')->name('bestSellF');
Route::get('/bestSellA', 'SliderController@bestSellA')->name('bestSellA');
Route::get('/featuredF', 'SliderController@featuredF')->name('featuredF');
Route::get('/featuredA', 'SliderController@featuredA')->name('featuredA');
Route::get('/newProF', 'SliderController@newProF')->name('newProF');
Route::get('/newProA', 'SliderController@newProA')->name('newProA');

Route::post('/cart/{id}', 'CartController@addToCart')->name('addToCart');
Route::get('/getCart', 'CartController@getCart')->name('getCart');
Route::post('/subToCart/{id}', 'CartController@subToCart')->name('subToCart');
Route::post('/cartAdd/{id}', 'CartController@cartAdd')->name('cartAdd');
Route::post('/flashCart/{id}', 'CartController@flashCart')->name('flashCart');
Route::get('/getCartProduct', 'CartController@getCartProduct')->name('getCartProduct');

Route::get('/getProducts', 'ProductController1@getProducts')->name('getProducts');
Route::post('/product_image/{id}', 'ProductController1@product_image')->name('product_image');
Route::post('/proImg/{id}', 'ProductController1@proImg')->name('proImg');
Route::get('/featured', 'ProductController1@featured')->name('featured');
Route::get('/bestSell', 'ProductController1@bestSell')->name('bestSell');
Route::get('/newProduct', 'ProductController1@newProduct')->name('newProduct');
Route::get('/related/{id}', 'ProductController1@related')->name('related');
Route::post('/search', 'ProductController1@search')->name('search');
Route::post('/searchProduct', 'ProductController1@searchProduct')->name('searchProduct');

Route::post('/searchItems/{search}', 'ProductController1@searchItems')->name('searchItems');

Route::post('/filterProduct/{id}', 'FilterController@filterProduct')->name('filterProduct');
Route::post('/FilterShop', 'FilterController@FilterShop')->name('FilterShop');
Route::post('/filterItem', 'FilterController@filterItem')->name('filterItem');

Route::post('/preImg/{id}', 'PrescriptionController@preImg')->name('preImg');

Route::post('/NotyOrder/{id}', 'NotificationController@NotyOrder')->name('NotyOrder');
Route::post('/read', 'NotificationController@read')->name('read');
Route::get('/Chattynoty', 'NotificationController@Chattynoty')->name('Chattynoty');
Route::get('/notifications', 'NotificationController@notifications')->name('notifications');

Route::resource('brands', 'BrandController');
Route::resource('categories', 'CategoryController');
Route::resource('menus', 'MenuController');
Auth::routes(['verify' => true]);

Route::get('ratings/{id}', 'ReviewController@ratings')->name('ratings');
Route::post('rate/{id}', 'ReviewController@rate')->name('rate');
Route::get('bestRated', 'ReviewController@bestRated')->name('bestRated');

Route::get('category/{id}', 'CategoryController@category')->name('category');
Route::get('catLimit', 'CategoryController@catLimit')->name('catLimit');

Route::get('subcategory/{id}', 'SupCategoryController@subcategory')->name('subcategory');

// Auth::routes();
// Route::group(['middleware' => ['verified']], function () {
Route::group(['middleware' => ['auth']], function () {
    Route::get('/paypal', function () {
        return view('paypal.createPay');
    });
    Route::resource('roles', 'RoleController');
    Route::resource('users', 'UserController');
    Route::resource('companies', 'CompanyController');
    Route::resource('coupons', 'CouponController');
    Route::resource('sizes', 'SizeController');
    Route::resource('images', 'ProductimgController');
    Route::resource('sales', 'SaleController');

    Route::get('/logoutOther', 'UserController@logoutOther')->name('logoutOther');
    Route::post('/logOtherDevices', 'UserController@logOtherDevices')->name('logOtherDevices');
    Route::get('/clientOrders', 'SaleController@clientOrders')->name('clientOrders');

    Route::get('/getUsersCount', 'UserController@getUsersCount')->name('getUsersCount');

    Route::post('permisions/{id}', 'UserController@permisions')->name('permisions');
    Route::get('getUsers', 'UserController@getUsers')->name('getUsers');
    Route::get('getDrivers', 'UserController@getDrivers')->name('getDrivers');
    Route::get('getCustomer', 'UserController@getCustomer')->name('getCustomer');
    Route::get('getLogedinUsers', 'UserController@getLogedinUsers')->name('getLogedinUsers');
    Route::post('profile/{id}', 'UserController@profile')->name('profile');
    Route::post('getSorted', 'UserController@getSorted')->name('getSorted');
    Route::post('getUserPro/{id}', 'UserController@getUserPro')->name('getUserPro');
    Route::post('getUserPerm/{id}', 'UserController@getUserPerm')->name('getUserPerm');
    Route::post('password', 'UserController@password')->name('password');
    Route::patch('AuthUserUp/{id}', 'UserController@AuthUserUp')->name('AuthUserUp');

    Route::get('execute-payment', 'PaymentController@execute')->name('execute');
    Route::post('createpayment', 'PaymentController@create')->name('create');
    Route::resource('orders', 'OrderController');
    Route::resource('aboutus', 'AboutController');

    Route::post('/StatusItem/{id}', 'ProductController1@StatusItem')->name('StatusItem');

    Route::get('/admin', 'HomeController@admin')->name('admin');

    Route::get('/home', 'HomeController@index')->name('home');
    Route::post('/filterItems', 'FilterController@filterItems')->name('filterItems');

    Route::get('/pay', 'OrderController@pay')->name('pay');

    Route::get('getChartOrders', 'DashboardController@getChartOrders')->name('getChartOrders');
    Route::get('getBrands', 'DashboardController@getBrands')->name('getBrands');
    Route::get('getChartData', 'DashboardController@getChartData')->name('getChartData');
    Route::get('getCategories', 'DashboardController@getCategories')->name('getCategories');
    Route::get('getOrders', 'DashboardController@getOrders')->name('getOrders');
    Route::get('getCountCount', 'DashboardController@getCountCount')->name('getCountCount');
    Route::get('countDelivered', 'DashboardController@countDelivered')->name('countDelivered');
    Route::get('countPending', 'DashboardController@countPending')->name('countPending');
    Route::get('countOrders', 'DashboardController@countOrders')->name('countOrders');


    Route::post('cash_delivery', 'PaymentController@cash_delivery')->name('cash_delivery');

    // About us

    Route::get('getUsersRole', 'RoleController@getUsersRole')->name('getUsersRole');
    Route::get('getRoles', 'RoleController@getRoles')->name('getRoles');
    Route::get('getPermissions', 'RoleController@getPermissions')->name('getPermissions');
    Route::post('getRolesPerm/{id}', 'RoleController@getRolesPerm')->name('getRolesPerm');
    Route::get('getRoles', 'RoleController@getRoles')->name('getRoles');

    Route::post('assignR', 'RoleController@assignR')->name('assignR');

    Route::any('invoiceOrder', 'InvoiceController@invoiceOrder')->name('invoiceOrder');
    Route::any('invoice/{id}', 'InvoiceController@invoice')->name('invoice');

    Route::post('logo/{id}', 'CompanyController@logo')->name('logo');
    Route::post('company_activate/{id}', 'CompanyController@company_activate')->name('company_activate');

    Route::any('apiGet', 'CarouselController@apiGet')->name('apiGet');


    // Reports
    Route::post('vendorProduct', 'ReportController@vendorProduct')->name('vendorProduct');
    // Route::get('sales', 'PaymentController@sales')->name('sales');


    Route::post('userExpo', 'ReportController@userExpo')->name('userExpo');
    Route::post('deriverdExpo', 'ReportController@deriverdExpo')->name('deriverdExpo');
    Route::post('customersExpo', 'ReportController@customersExpo')->name('customersExpo');
    Route::post('branchesExpo', 'ReportController@branchesExpo')->name('branchesExpo');
    Route::post('agentsExpo', 'ReportController@agentsExpo')->name('agentsExpo');
    Route::post('cancledExpo', 'ReportController@cancledExpo')->name('cancledExpo');
    Route::post('pendingExpo', 'ReportController@pendingExpo')->name('pendingExpo');
    Route::post('bookingExpo', 'ReportController@bookingExpo')->name('bookingExpo');
    Route::post('approvedExpo', 'ReportController@approvedExpo')->name('approvedExpo');
    Route::post('dispatchedExpo', 'ReportController@dispatchedExpo')->name('dispatchedExpo');
    Route::post('DriverReport', 'ReportController@DriverReport')->name('DriverReport');

    Route::post('generate_pdf', 'ReportController@generate_pdf')->name('generate_pdf');
    Route::post('DelivReport', 'ReportController@DelivReport')->name('DelivReport');

    Route::post('pod/{id}', 'ReportController@pod')->name('pod');

    Route::post('ProdReport', 'ReportController@ProdReport')->name('ProdReport');
});
// });
