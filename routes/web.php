<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\InvoiceController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CryptocurrencyController;
use App\Http\Controllers\GiftCardController;
use App\Http\Controllers\ReferralController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\SupportController;
use App\Http\Controllers\VerificationController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Auth;



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

// Route::get('/', function () {
//     return view('welcome');
// });

//Auth routes
Auth::routes(['verify' => true]);

Route::middleware(['auth', 'verified', 'admin'])->group(function(){
    //Admin Routes
Route::prefix('admin')->group(function(){
    Route::get('/admin', [AdminController::class, 'adminDashboard'])->name('admin.dashboard');
    Route::get('/users', [AdminController::class, 'users'])->name('admin.users');
    Route::delete('/users/{id}/delete', [AdminController::class, 'deleteUser'])->name('admin.users.delete');
    Route::get('/users/{id}/details', [AdminController::class, 'getUserDetails'])->name('admin.users.details');
    Route::post('/users/{id}/update', [AdminController::class, 'updateUser'])->name('admin.users.update');
    Route::get('/transactions', [AdminController::class, 'transactions'])->name('admin.transaction');
    Route::get('/active/crypto', [AdminController::class, 'activeCrypto'])->name('active.crypto');
    Route::get('/crypto/exchange', [AdminController::class, 'cryptoExchange'])->name('crypto.exchange');
    Route::post('/crypto/set', [AdminController::class, 'cryptoSet'])->name('crypto.set');
    Route::post('/crypto/add', [AdminController::class, 'addCrypto'])->name('crypto.add');
    Route::get('/crypto/{id}/edit', [AdminController::class, 'editCrypto'])->name('crypto.edit');
    Route::get('/admin-sell', [AdminController::class, 'AdminSellForm'])->name('admin.sell');
    Route::post('/crypto-store', [AdminController::class, 'storecrypto'])->name('admin-crypto.store');
    Route::post('/crypto/{id}/update', [AdminController::class, 'updateCrypto'])->name('crypto.update');
    Route::delete('/crypto/{id}/delete', [AdminController::class, 'deleteCrypto'])->name('delete.crypto');
    Route::get('/currency/exchange', [AdminController::class, 'exchangeRate'])->name('exchange.rate');
    Route::post('/currency/set', [AdminController::class, 'currencySet'])->name('currency.set');
    Route::get('/active/giftcard', [AdminController::class, 'activeGiftcard'])->name('active.giftcard');
    Route::post('/giftcard/add', [AdminController::class, 'addGiftcard'])->name('giftcard.add');
    Route::get('/giftcard/{id}/edit', [AdminController::class, 'editGiftCard'])->name('admin.giftcard.edit');
    Route::put('/giftcard/{id}/update', [AdminController::class, 'updateGiftCard'])->name('admin.giftcard.update');
    Route::delete('giftcard/{id}/delete', [AdminController::class, 'deleteGiftcard'])->name('admin.giftcard.delete');
    Route::get('/setting', [AdminController::class, 'setting'])->name('setting');
    Route::post('/setting/save', [AdminController::class, 'saveSetting'])->name('setting.save');
    Route::get('/admin/buy', [AdminController::class, 'adminBuyForm'])->name('admin.buyform');
    Route::get('/admin/invoice/{order}', [AdminController::class, 'adminInvoice'])->name('admin.invoice');
    Route::post('/order', [AdminController::class, 'adminOrder'])->name('admin.order');
    Route::get('/categories', [DashboardController::class, 'catShow'])->name('category.show');
    Route::post('/save/categories', [DashboardController::class, 'catStore'])->name('category.store');
    Route::get('/categories/{id}/edit', [DashboardController::class, 'catEdit'])->name('category.edit');
    Route::post('/categories/{id}/update', [DashboardController::class, 'catUpdate'])->name('category.update');
    Route::delete('/categories/{id}/delete', [DashboardController::class, 'catDel'])->name('category.delete');
});

});

Route::middleware(['auth', 'verified', 'user'])->group(function(){
    //Dashboard Route
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
    Route::get('/dashboard/transactions', [DashboardController::class, 'transactions'])->name('transactions');
});

Route::middleware(['auth', 'verified'])->group(function(){
    //Crypto Routes
    Route::prefix('crypto')->group(function(){
        Route::get('/', [CryptocurrencyController::class, 'index'])->name('crypto.index');
        Route::get('/crypto/{id}/show', [CryptocurrencyController::class, 'showCoin'])->name('show.coin');
        Route::put('/crypto/{id}/update', [CryptocurrencyController::class, 'updateCoin'])->name('update.coin');
        Route::delete('/crypto/{id}/delete', [CryptocurrencyController::class, 'deleteCoin'])->name('delete.coin');
        Route::get('/buy', [CryptocurrencyController::class, 'buyForm'])->name('crypto.buy');
        Route::post('buy', [CryptocurrencyController::class, 'buy'])->name('buy.order');
        Route::get('/sell', [CryptocurrencyController::class, 'sellForm'])->name('crypto.sell');
        Route::post('/store', [CryptocurrencyController::class, 'store'])->name('crypto.store');
        // Route::get('transactions', [CryptocurrencyController::class, 'cryptoTransactions'])->name('cryptocurrency.transactions');
        Route::get('/{id}/edit', [CryptocurrencyController::class, 'edit'])->name('cryptocurrency.edit');
        Route::get('/{id}/update', [CryptocurrencyController::class, 'update'])->name('cryptocurrency.update');
        // Support Routes
       
    });

    //Giftcard Routes
    Route::prefix('giftcard')->group(function(){
        Route::get('/giftcard', [GiftCardController::class, 'giftIndex'])->name('giftcards');
        Route::get('/giftcard/{id}/show', [GiftCardController::class, 'showGiftcard'])->name('show.giftcard');
        Route::put('/giftcard/{id}/update', [GiftCardController::class, 'updateCard'])->name('update.giftcard');
        Route::delete('/giftcard/{id}/delete', [GiftCardController::class, 'deleteCard'])->name('delete.giftcard');
        // Route::get('/buy-gift', [GiftCardController::class, 'buyForm'])->name('giftcard.buy');
        Route::post('/buy', [GiftCardController::class, 'buy'])->name('gift.buy');
        Route::get('/sell', [GiftCardController::class, 'sellForm'])->name('giftcard.sell');
        Route::post('/store', [GiftCardController::class, 'store'])->name('card.store');
        Route::get('transactions', [GiftCardController::class, 'Transactions'])->name('transactions');
        Route::get('/{id}/edit', [GiftCardController::class, 'edit'])->name('giftcard.edit');
        Route::get('/{id}/update', [GiftCardController::class, 'update'])->name('giftcard.update');
        
    });
    Route::prefix('support')->group(function(){
        Route::get('/', [SupportController::class, 'supportIndex'])->name('support.tickets');
        Route::post('/tickets/open', [DashboardController::class, 'openTicket'])->name('ticket.open');
        Route::get('/ticket/{id}/read', [SupportController::class, 'readTicket'])->name('ticket.read');
        Route::post('/ticket/{id}/update', [SupportController::class, 'updateTicket'])->name('ticket.update');
        Route::delete('/ticket/{id}/delete', [SupportController::class, 'ticketDelete'])->name('ticket.delete');
    });
});

    Route::get('/verification', [VerificationController::class, 'emailVerify'])->name('verify');
    Route::post('/verify', [VerificationController::class, 'verifyMail'])->name('verification.verify');
    Route::post('/resend', [VerificationController::class, 'resend'])->name('verification.resend');

Route::middleware(['web'])->group(function() {
    Route::post('/get-currency-rate/{cryptoId}', [CryptocurrencyController::class, 'getCurrencyRate'])->name('get-currency-rate');
    Route::post('/get-crypto-rate', [GiftcardController::class, 'getCryptoRate'])->name('get-crypto-rate');
    Route::get('/get-account-number/{cryptoId}', [CryptocurrencyController::class, 'getBankAccountNumber'])->name('get-account-number');
    Route::get('/get-wallet-address/{cryptoId}', [CryptocurrencyController::class, 'showWallet'])->name('get-wallet-address');
    Route::get('/get-seller-bank-details', [GiftCardController::class, 'getSellerBankDetails'])->name('get-seller-bank');
    Route::get('/giftcard/{id}/invoice', [InvoiceController::class, 'showInvoice'])->name('invoice.show');
    Route::post('/giftcard/{id}/order', [GiftCardController::class, 'makeOrder'])->name('make.order');
    Route::get('/crypto/invoice{order}', [InvoiceController::class, 'cryptoInvoice'])->name('invoice.crypto');
    Route::get('/orders', [InvoiceController::class, 'orderTable'])->name('order.view');
    Route::get('/orders/{id}/details', [InvoiceController::class, 'getOrderDetails'])->name('order.details');
    Route::post('/orders/{id}/update', [InvoiceController::class, 'updateOrder'])->name('order.update');
    Route::delete('/orders/{id}/delete', [InvoiceController::class, 'deleteOrder'])->name('order.delete');
});
    


Route::get('/', function () {
    return view('user.login');
})->name('login.form');
Route::post('/login', [UserController::class, 'login'])->name('login.store');
Route::get('/signup', [UserController::class, 'signup'])->name('signup');
Route::post('/register', [UserController::class, 'register'])->name('register');
Route::post('/logout', [UserController::class, 'logout'])->name('logout');
Route::post('/users/add', [AdminController::class, 'addUser'])->name('users.add');
Route::get('/reset-password', [UserController::class, 'passwordReset'])->name('reset.password');
Route::get('reset', [UserController::class, 'reset'])->name('reset');

// User profile routes
Route::middleware('auth')->group(function() {
    Route::get('/profile', [UserController::class, 'showProfile'])->name('profile.show');
    Route::get('/profile/{id}/edit', [UserController::class, 'editProfile'])->name('profile.edit');
    Route::post('/2fa-status', [UserController::class, 'faStatus'])->name('fa.status');
    Route::post('/change-password', [UserController::class, 'passChange'])->name('pass.change');
    Route::get('sellgift', [UserController::class, 'giftForm'])->name('gift.form');
    Route::post('/profile/update', [UserController::class, 'updateProfile'])->name('profile.update');
});




  // Referrals Routes
  Route::prefix('referrals')->group(function(){
    Route::get('/', [ReferralController::class, 'index'])->name('referrals');
    Route::get('/history', [ReferralController::class, 'history'])->name('referrals.history');
    Route::get('/earnings', [ReferralController::class, 'earnings'])->name('referrals.earnings');
});

 // Settings Routes
 Route::prefix('settings')->group(function(){
    Route::get('/payment-methods', [SettingsController::class, 'paymentMethod'])->name('settings.payment-method');
    Route::post('/store', [SettingsController::class, 'paymentStore'])->name('store.pay');
    Route::get('/payment-methods/{id}/edit', [SettingsController::class, 'paymentEdit'])->name('payment.edit');
    Route::post('/payment-methods/{id}/update', [SettingsController::class,'paymentUpdate'])->name('payment.update');
    Route::delete('/payment-methods/{id}/delete', [SettingsController::class,'paymentDelete'])->name('payment.delete');
    Route::post('/wallet', [SettingsController::class, 'walletStore'])->name('wallet.pay');
    Route::get('/wallet/{id}/edit', [SettingsController::class, 'walletEdit'])->name('wallet.edit');
    Route::put('/wallet/{id}/update', [SettingsController::class,'walletUpdate'])->name('wallet.update');
    Route::delete('/wallet/{id}/delete', [SettingsController::class,'walletDelete'])->name('wallet.delete');
    Route::get('/sell', [SettingsController::class, 'sellin'])->name('sort');
});
Route::get('giftcard/by-category/{categoryId}', [SettingsController::class, 'getByCategory'])->name('giftcard.by-category');
Route::get('get-exchange-rate/{giftCardId}', [SettingsController::class, 'getExchangeRate'])->name('giftcard.exchange-rate');



