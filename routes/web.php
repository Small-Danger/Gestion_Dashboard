<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('landing.index');
});

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\DestinationController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\StockController;

use App\Http\Controllers\Api\DestinatiController;


Route::middleware(['auth'])->group(function () {


Route::get('/destinations/search', [DestinationController::class, 'search']);

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // ... autres routes protégées
    Route::resource('clients', ClientController::class);
    Route::resource('destinations', DestinationController::class);
    Route::resource('companies', CompanyController::class);

    // Route de suppression d’un mouvement (hors destination)
    Route::delete('stock/{stockMovement}', [StockController::class, 'destroy'])->name('stock.destroy');

     // Routes de gestion des stocks par destination
 //      Route::get('{destination}/stock', [StockMovementController::class, 'index'])->name('stock.index');
  //     Route::get('{destination}/stock/create', [StockMovementController::class, 'create'])->name('stock.create');
  //     Route::post('{destination}/stock', [StockMovementController::class, 'store'])->name('stock.store');


     // Routes pour la gestion des stocks
Route::post('companies/{company}/stock', [CompanyController::class, 'storeStock'])->name('companies.stock.store');
Route::put('stock/{stockMovement}', [StockController::class, 'update'])->name('stock.update');

    // Routes pour la gestion des stocks par compagnie
Route::get('companies/stock', [CompanyController::class, 'stockIndex'])->name('companies.stock.index');
Route::get('companies/{company}/stock/destinations', [CompanyController::class, 'stockDestinations'])->name('companies.stock.destinations');

// Affiche toutes les transactions d'un client
Route::get('/clients/{client}/transactions', [TransactionController::class, 'index'])->name('clients.transactions.index');

// Enregistre une transaction pour un client
Route::post('/clients/{client}/transactions', [TransactionController::class, 'store'])->name('clients.transactions.store');

// Affiche le formulaire de modification d'une transaction
Route::get('/clients/{client}/transactions/{transaction}/edit', [TransactionController::class, 'edit'])->name('clients.transactions.edit');

// Met à jour une transaction existante
Route::put('/clients/{client}/transactions/{transaction}', [TransactionController::class, 'update'])->name('clients.transactions.update');

// Supprime une transaction
Route::delete('/clients/{client}/transactions/{transaction}', [TransactionController::class, 'destroy'])->name('clients.transactions.destroy');

});

// Authentification
Route::middleware('guest')->group(function () {

    // Register
    Route::get('register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('register', [AuthController::class, 'register']);

    // Login
    Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('login', [AuthController::class, 'login']);
    
    // Mot de passe oublié
    Route::get('forgot-password', [AuthController::class, 'showForgotPasswordForm'])
        ->name('password.request');
    
    Route::post('forgot-password', [AuthController::class, 'sendResetLinkEmail'])
        ->name('password.email');
    
    // Réinitialisation
    Route::get('reset-password/{token}', [AuthController::class, 'showResetPasswordForm'])
        ->name('password.reset');
    
    Route::post('reset-password', [AuthController::class, 'resetPassword'])
        ->name('password.update');

});

// Déconnexion
Route::post('logout', [AuthController::class, 'logout'])->name('logout');