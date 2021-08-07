<?php

use App\Http\Controllers\CaisseController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\MaterielController;
use App\Http\Controllers\FormuleController;
use App\Http\Controllers\PDFController;
use Illuminate\Http\Request;
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
Route::get('compte/blocke', function () {
    return view('layouts.compte-block');
})->name('compte/blocke');

Route::middleware(['auth:sanctum', 'verified'])->get('/', function () {
    return view('dashboard');
})->name('dashboard');

Route::prefix('dashboard')->group(function()
{
    //PDF
//    Route::view('/', 'dashboard');
    Route::group(['middleware' => 'auth'], function () {
        Route::get('pdf', [PDFController::class, 'createPDF']);
//        Route::get('/', function () {
//            return view('dashboard');
//        });
        //Abonnement
        Route::get('abonner_add', [ClientController::class, 'add'])->name('add.client');
        Route::post('store', [ClientController::class, 'store'])->name('store.client');
        Route::get('abonner', [ClientController::class, 'view'])->name('view.abonner');
        Route::get('show', [ClientController::class, 'show'])->name('clients.show');

    //Reabonnement
    Route::get('reabonner',[ClientController::class,'review'])->name('review.reabonner');
    Route::get('new_reabonner/{id_client}',[ClientController::class,'reabonne'])->name('reabonne.client');
    Route::post('updateR/{id_client}',[ClientController::class,'updateR'])->name('updateR.client');

    //Modifier
    Route::get('upgrader',[ClientController::class,'viewModif'])->name('upgrader');
    Route::get('upgrade_client/{id_client}',[ClientController::class,'up_client'])->name('up.client');
    Route::post('upgradeClient/{id_client}',[ClientController::class,'upgradeClient'])->name('upgrade.client');

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

            Route::get('compte', [UserController::class, 'index'])->name('compte');
            Route::post('compte/activate', [UserController::class, 'activate'])->name('activate_compte');
            Route::post('compte/block', [UserController::class, 'block'])->name('block_compte');
            Route::post('compte/store', [UserController::class, 'store'])->name('user.add');
            Route::get('compte/add', function () {
                return view('users.add');
            })->name('compte.add');
            Route::get('compte/getUser/{id}', [UserController::class, 'edit_users'])->name('user.editForm');
            Route::post('compte/update', [UserController::class, 'update'])->name('user.update');
            Route::post('compte/delete', [UserController::class, 'delete'])->name('user.delete');

            Route::get('caisse', [CaisseController::class, 'index'])->name('caisse');
            Route::post('caisse/ajouter', [CaisseController::class, 'store'])->name('caisse.ajouter');
            Route::get('caisse/get/{id}', [CaisseController::class, 'get'])->name('caisse.get');
            Route::post('caisse/update', [CaisseController::class, 'update'])->name('caisse.update');
            Route::get('caisse/delete/{id}', [CaisseController::class, 'delete'])->name('caisse.delete');


            Route::get('user/abonnement', [ClientController::class, 'mesAbonnements'])->name('user.abonnement');
            Route::get('user/abonnement/jour', [ClientController::class, 'mesAbonnementsjour'])->name('user.abonnement.jour');
            Route::get('user/reabonnement', [ClientController::class, 'mesReabonnements'])->name('user.reabonnement');
            Route::get('user/reabonnement/jour', [ClientController::class, 'mesReabonnementsAjour'])->name('user.reabonnement.jour');

    });

});
