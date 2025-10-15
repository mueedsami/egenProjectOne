<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Mail\OrderPlacedMail;
use App\Models\Order;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\Admin\AdminChatController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PaymentController;



/*
|--------------------------------------------------------------------------
| USER SIDE
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/product/{slug}', [ProductController::class, 'show'])->name('product.show');


Route::middleware('auth')->group(function () {
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');
    Route::get('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout/place', [CheckoutController::class, 'store'])->name('checkout.store');
    Route::get('/dashboard', fn() => view('dashboard'))->name('dashboard');
});

Route::post('/pay', [PaymentController::class, 'pay'])->name('pay');
Route::post('/payment/success', [PaymentController::class, 'success']);
Route::post('/payment/fail', [PaymentController::class, 'fail']);
Route::post('/payment/cancel', [PaymentController::class, 'cancel']);


/*
|--------------------------------------------------------------------------
| USER AUTHENTICATION
|--------------------------------------------------------------------------
*/
Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
Route::post('/login', [AuthenticatedSessionController::class, 'store']);
Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
Route::post('/register', [RegisteredUserController::class, 'store']);
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/chat', [ChatController::class, 'index'])->name('chat.index');
    Route::get('/chat/{id}', [ChatController::class, 'show'])->name('chat.show');
    Route::post('/chat/send', [ChatController::class, 'storeMessage'])->name('chat.send');
});

Route::middleware('auth')->group(function () {
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::get('/orders/{order}/invoice', [OrderController::class, 'invoice'])->name('orders.invoice');
});


/*
|--------------------------------------------------------------------------
| ADMIN AUTHENTICATION
|--------------------------------------------------------------------------
*/
Route::get('/admin/login', [AuthenticatedSessionController::class, 'createAdmin'])->name('admin.login');
Route::post('/admin/login', [AuthenticatedSessionController::class, 'storeAdmin'])->name('admin.login.submit');
Route::get('/admin/register', [RegisteredUserController::class, 'createAdmin'])->name('admin.register');
Route::post('/admin/register', [RegisteredUserController::class, 'storeAdmin'])->name('admin.register.submit');



/*
|--------------------------------------------------------------------------
| ADMIN PANEL (Protected)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
        // ✅ Use custom names to prevent product.show conflict
        Route::resource('products', AdminProductController::class);
    });

/*


|--------------------------------------------------------------------------
| TEST ROUTES
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/chats', [AdminChatController::class, 'index'])->name('chats.index');
    Route::get('/chats/{chat}', [AdminChatController::class, 'show'])->name('chats.show');
    Route::post('/chats/{chat}/send', [AdminChatController::class, 'send'])->name('chats.send');
});


Route::get('/test-mail', function () {
    $order = Order::latest()->first();
    if (!$order) {
        return '⚠️ No orders found to test mail.';
    }
    Mail::to('mueedibnesami.anoy@gmail.com')->send(new OrderPlacedMail($order));
    return '✅ Test mail sent (check Mailtrap inbox)';
});

Route::get('/mail-test', function () {
    try {
        Mail::raw('Hello from Laravel Sandbox!', function ($message) {
            $message->to('customer@example.com')
                ->subject('✅ Test Email from Laravel');
        });
        return '✅ Mail sent successfully to Mailtrap inbox!';
    } catch (\Throwable $e) {
        return '❌ Mail failed: ' . $e->getMessage();
    }
});
