<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin;
use App\Http\Controllers\Customer;
use App\Http\Controllers\Manager;
use App\Http\Controllers\Owner;
use App\Http\Controllers\Public;
use App\Http\Controllers\Seller;
use App\Http\Controllers\OtpVerificationController;
use App\Http\Controllers\GoogleController;
use Illuminate\Support\Facades\Auth;

Route::domain(env('APP_DOMAIN'))->group(function () {
    // Redirect all routes to the www subdomain
    Route::get('/{any}', function () {
        return redirect()->to(env('APP_URL') . '/' . request()->path());
    })->where('any', '.*');
});

//Authentication
Auth::routes();

Route::post('/otp/mobile', [OtpVerificationController::class, 'sendOtp'])->name('mobile-sendOtp');
Route::post('/otp/mobile/verify', [OtpVerificationController::class, 'verifyOtp'])->name('mobile-verifyOtp');
Route::post('/mobile/check', [OtpVerificationController::class, 'checkUniqueNumber'])->name('mobile.unique.check');

// Routes for luckystargroceries.com
Route::domain(env('APP_URL'))->group(function () {

    // Google Login
    Route::group(['prefix' => 'google'], function () {
        Route::get('login', [GoogleController::class, 'loginWithGoogle'])->name('google.login');
        Route::get('callback', [GoogleController::class, 'callbackFromGoogle'])->name('google.callback');
    });

    // Public Routes (Guest and Customer)
    Route::middleware([])->group(function () {
        Route::get('/', [Public\PageController::class, 'index']);
        Route::get('/home', [Public\PageController::class, 'index'])->name('home');
        Route::get('/products', [Public\PageController::class, 'products'])->name('products');
        Route::get('/contact', [Public\PageController::class, 'contact'])->name('contact');
        Route::get('/product/{id}', [Public\PageController::class, 'product'])->name('product');
    });

    // Customer Private Routes
    Route::middleware(['role:customer', 'auth'])->group(function () {

        Route::prefix('orders')->name('orders.')->group(function () {
            Route::get('/clear', [Customer\OrderController::class, 'clear'])->name('clear');
            Route::get('/checkout', [Customer\OrderController::class, 'checkout'])->name('checkout');
            Route::get('/tracking', [Customer\OrderController::class, 'order_tracking'])->name('track');
            Route::post('/tracking/success', [Customer\OrderController::class, 'orderReceived'])->name('received.success');
            Route::post('/tracking/failed', [Customer\OrderController::class, 'orderFailedReceived'])->name('received.failed');
            Route::post('/checkout/confirm', [Customer\OrderController::class, 'checkout_confirm'])->name('confirm');
            Route::get('/success', [Customer\OrderController::class, 'gcashPaymentSuccess'])->name('payment.gcash.success');
            Route::get('/failed', [Customer\OrderController::class, 'gcashPaymentFailed'])->name('payment.gcash.failed');
        });
        Route::resource('/orders', Customer\OrderController::class);
        Route::get('/account', [Customer\AccountController::class, 'index'])->name('account.index');
        Route::get('/address', [Customer\AccountController::class, 'address'])->name('address');
        Route::get('/address/add', [Customer\AccountController::class, 'createAddress'])->name('address.create');
        Route::get('/address/{id}', [Customer\AccountController::class, 'editAddress'])->name('address.edit');
        Route::post('/address/{id}', [Customer\AccountController::class, 'updateAddress'])->name('address.update');
        Route::post('/address', [Customer\AccountController::class, 'storeAddress'])->name('address.store');
        Route::delete('/address/{id}', [Customer\AccountController::class, 'deleteAddress'])->name('address.delete');
        Route::post('/account', [Customer\AccountController::class, 'update'])->name('account.update');
    });
});

// Routes for seller.luckystargroceries.com
Route::domain(env('SELLER_APP_URL'))->group(function () {

    // Google Login for Seller
    Route::group(['prefix' => 'google'], function () {
        Route::get('login', [Seller\GoogleController::class, 'loginWithGoogle'])->name('google.login.seller');
        Route::get('callback', [Seller\GoogleController::class, 'callbackFromGoogle'])->name('google.callback.seller');
    });

    Route::middleware('auth')->group(function () {
        Route::get('/', [Seller\PageController::class, 'index'])->name('index');
    });

    Route::middleware('guest')->group(function () {
        Route::get('/login', [Seller\PageController::class, 'login'])->name('seller.auth.login');
    });

    Route::middleware(['auth', 'role:owner|manager|cashier|courier|promodiser'])->group(function () {

        Route::middleware(['auth', 'can:manage_products'])->group(function () {
            Route::resource('/products', Seller\ProductController::class);
            Route::delete('/products/{product}/delete', [Seller\ProductController::class, 'delete'])->name('products.delete');
            Route::get('/product/suggestion', [Seller\ProductController::class, 'suggestion'])->name('product.suggestion');
            Route::post('/product/restock', [Seller\ProductController::class, 'restock'])->name('product.restock');
            Route::get('/product/export', [Seller\ProductController::class, 'exportProducts'])->name('product.export');
        });

        Route::middleware(['auth', 'can:process_orders'])->group(function () {
            Route::get('/orders', [Seller\OrderController::class, 'index'])->name('orders');
            Route::get('/orders/{order_number}', [Seller\OrderController::class, 'show'])->name('orders.show');
            Route::get('/orders/{order_number}/print', [Seller\OrderController::class, 'toPrint'])->name('order.print');
            Route::post('/orders/{order_number}', [Seller\OrderController::class, 'updateOrderStatus'])->name('order.update.status');
            Route::get('/scan', [Seller\OrderController::class, 'scan_order'])->name('order.scan');
            Route::post('/scan/proceed', [Seller\OrderController::class, 'updateScannedOrder'])->name('order.scan.proceed');
            Route::get('/check-order-status/{order_number}', [Seller\OrderController::class, 'checkOrderStatus'])->name('order.check.status');
        });

        Route::middleware(['auth', 'can:manage_sales_report'])->group(function () {
            Route::get('/sales', [Seller\SaleController::class, 'sales_report'])->name('sales');
            Route::get('/sales/overview', [Seller\SaleController::class, 'salesOverview'])->name('sales.overview');
            Route::get('/sales/products_and_performance', [Seller\SaleController::class, 'productsAndPerformance'])->name('sales.products_and_performance');
            Route::post('/sales/data', [Seller\SaleController::class, 'getSalesData'])->name('sales.data');
            Route::get('/sales/history', [Seller\SaleController::class, 'salesHistory'])->name('sales.history');
            Route::get('/sales/export', [Seller\SaleController::class, 'exportSales'])->name('sales.export');
        });

        Route::middleware(['auth', 'can:manage_promotions'])->group(function () {
            Route::get('/mail', [Seller\PromotionController::class, 'index'])->name('mail.promotions');
            Route::post('/mail', [Seller\PromotionController::class, 'sendEmail'])->name('mail.promotions.send');
        });

        Route::middleware(['auth', 'can:manage_customer_data'])->group(function () {
        });

        Route::middleware(['auth', 'can:manage_billing'])->group(function () {
            Route::get('/', [Seller\RemittanceController::class, 'index'])->name('remittance');
            Route::get('/remittance', [Seller\RemittanceController::class, 'index'])->name('remittance');
            Route::post('/remittance', [Seller\RemittanceController::class, 'collect'])->name('remittance.collect');
            Route::get('/remittance/report', [Seller\RemittanceController::class, 'report'])->name('remittance.report');
            Route::get('/remittance/export', [Seller\RemittanceController::class, 'exportRemittance'])->name('remittance.export');
            Route::get('/remittance/{order_number}', [Seller\RemittanceController::class, 'show'])->name('remittance.order.show');
        });

        Route::middleware(['auth', 'can:manage_shipping'])->group(function () {
            Route::get('/delivery', [Seller\DeliveryController::class, 'index'])->name('delivery');
            Route::post('/delivery/check', [Seller\DeliveryController::class, 'checkOrderNumber'])->name('delivery.check');
            Route::get('/delivery/{order_number}', [Seller\DeliveryController::class, 'show'])->name('delivery.show');
            Route::post('/delivery/{order_number}/update', [Seller\DeliveryController::class, 'updateStatus'])->name('delivery.status.update');
        });

        Route::middleware(['auth', 'can:manage_wallet'])->group(function () {
            Route::get('/wallet', [Seller\WalletController::class, 'wallet'])->name('wallet');
            Route::get('/history', [Seller\WalletController::class, 'history'])->name('history');
        });

        Route::middleware(['auth'])->group(function () {
            Route::get('/', [Seller\PageController::class, 'index'])->name('index');
            Route::get('/dashboard', [Seller\PageController::class, 'index'])->name('index');
            Route::get('/profile', [Seller\AccountController::class, 'profile'])->name('account.profile');
            Route::post('/profile', [Seller\AccountController::class, 'update'])->name('account.profile.update');
            Route::get('/settings', [Seller\AccountController::class, 'settings'])->name('account.settings');
        });

        Route::middleware(['auth', 'can:manage_staff'])->group(function () {
            Route::resource('staff', Seller\StaffManagementController::class);
            Route::get('/roles-and-permissions', [Seller\StaffManagementController::class, 'rolesAndPermissions'])->name('roles-permissions');
            Route::post('/roles-and-permissions/assign/{role}', [Seller\StaffManagementController::class, 'assignPermissions'])->name('roles-permissions.assign');
            Route::post('/roles-and-permissions/update-user-roles/{userId}', [Seller\StaffManagementController::class, 'updateRoles'])->name('roles-permissions.update.user.roles');
            Route::delete('/roles-and-permissions/remove-staff/{user}', [Seller\StaffManagementController::class, 'removeStaff'])->name('rolesAndPermission.removeStaff');
        });

        Route::middleware(['auth', 'can:manage_content'])->group(function () {
            Route::get('/content-management/carousel', [Seller\ContentManagementController::class, 'viewCarousel'])->name('carousel.view');
            Route::get('/content-management/carousel/add', [Seller\ContentManagementController::class, 'createCarousel'])->name('carousel.create');
            Route::post('/content-management/carousel/add', [Seller\ContentManagementController::class, 'storeCarousel'])->name('carousel.store');
            Route::get('/content-management/carousel/{slide}', [Seller\ContentManagementController::class, 'editCarousel'])->name('carousel.edit');
            Route::put('/content-management/carousel/{slide}', [Seller\ContentManagementController::class, 'updateCarousel'])->name('carousel.update');
            Route::delete('/content-management/carousel/{slide}', [Seller\ContentManagementController::class, 'destroyCarousel'])->name('carousel.destroy');
        });
    });
});
