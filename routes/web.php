<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\MaterielController;
use App\Http\Controllers\FormuleController;
use App\Http\Controllers\PDFController;

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
    return view('auth.login');
});
Route::get('logout', [UserController::class,'doLogout']);

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::prefix('dashboard')->group(function()
{
    //PDF
    Route::get('pdf',[PDFController::class,'createPDF']);

    //Abonnement
    Route::get('abonner_add',[ClientController::class,'add'])->name('add.client');
    Route::post('store',[ClientController::class,'store'])->name('store.client');
    Route::get('abonner',[ClientController::class,'view'])->name('view.abonner');
    Route::get('show',[ClientController::class,'show'])->name('clients.show');

    //Reabonnement
    Route::get('reabonner',[ClientController::class,'review'])->name('review.reabonner');
    Route::get('new_reabonner/{id_client}',[ClientController::class,'reabonne'])->name('reabonne.client');
    Route::post('updateR/{id_client}',[ClientController::class,'updateR'])->name('updateR.client');

    //Modifier
    Route::get('modifier',[ClientController::class,'viewModif'])->name('modifier');
    Route::get('modif_client/{id_client}',[ClientController::class,'edit_client'])->name('edit.client');
    Route::post('updateM/{id_client}',[ClientController::class,'updateM'])->name('updateM.client');

    Route::get('modif_formule/{id_formule}',[FormuleController::class,'edit_formule'])->name('edit.formule');
    Route::post('update/{id_formule}',[FormuleController::class,'update'])->name('update.formule');

    Route::get('modif_materiel/{type_id}',[MaterielController::class,'edit'])->name('edit.materiel');
    Route::post('update/{id_type}',[MaterielController::class,'update'])->name('update.materiel');

    //Historiques
    Route::get('/historiques', function () {
        return view('historiques');
    })->name('historiques');

    //Liste des clients
    Route::get('clients',[ClientController::class,'allview'])->name('clients');

    //Stock
    Route::get('stock',[MaterielController::class,'index'])->name('stock');
    Route::post('storeMat',[MaterielController::class,'storeMat'])->name('store.materiel');
    Route::post('storeDec',[MaterielController::class,'storeDec'])->name('store.decodeur');

    Route::get('/messagerie', function () {
        return view('messagerie');
    })->name('messagerie');

    Route::get('send-sms-notification', [MessageController::class, 'sendSmsNotificaition']);

});
