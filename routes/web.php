<?php

use App\Http\Controllers\CaisseController;
use App\Http\Controllers\FactureController;
use App\Http\Controllers\GeneralController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\SortController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VersementController;
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
Route::get('logout', [UserController::class, 'doLogout']);
Route::get('compte/blocke', function () {
    return view('layouts.compte-block');
})->name('compte/blocke');



Route::prefix('dashboard')->group(function () {
    //PDF
//    Route::view('/', 'dashboard');
    Route::middleware(['auth:sanctum', 'verified'])->get('/', function () {
        return redirect()->route('home');
    })->name('dashboard');
    Route::group(['middleware' => 'auth'], function () {
        Route::get('pdf', [PDFController::class, 'createPDF']);
//        Route::get('/', function () {
//            return view('dashboard');
//        }
        Route::get('dashboard', [GeneralController::class, 'dashboard'])->name('home');
        Route::post('app/recherche', [GeneralController::class, 'rechercherGlobal'])->name('app.rechercher');
        //Abonnement
        Route::get('abonner_add', [ClientController::class, 'add'])->name('add.client');
        Route::get('abonner_add', [ClientController::class, 'add'])->name('add.client');
        Route::post('store', [ClientController::class, 'store'])->name('store.client');
        Route::get('abonner', [ClientController::class, 'view'])->name('view.abonner');
        Route::get('show/{id_client}', [ClientController::class, 'show'])->name('clients.show');
        Route::post('abonner/delete', [ClientController::class, 'deleteAbonne'])->name('abonnement.delete');


        //Reabonnement
        Route::get('reabonner', [ClientController::class, 'review'])->name('review.reabonner');
        Route::post('reabonner/add', [ClientController::class, 'reabonneAdd'])->name('store.client.reabonnement');
        Route::get('new_reabonner/{id_client}', [ClientController::class, 'reabonne'])->name('reabonne.client');
        Route::post('reabonner/delete', [ClientController::class, 'deleteReabonne'])->name('reabonnement.delete');
        Route::post('reabonner/recover', [ClientController::class, 'recoverReabonne'])->name('reabonnement.recover');
        Route::post('updateR/{id_client}', [ClientController::class, 'updateR'])->name('updateR.client');
        Route::get('reabonnement/all', [ClientController::class, 'allReabonnement'])->name('user.reabonnement.all');
        Route::post('reabonnement/sortby', [SortController::class, 'sortReabonnement'])->name('reabonnement.sort');


        //Modifier
        Route::get('upgrader', [ClientController::class, 'viewModif'])->name('upgrader');
        Route::get('upgrade_client/{id_client}/{id_reabonnement?}', [ClientController::class, 'up_client'])->name('up.client');
        Route::post('upgradeClient/{id_client}', [ClientController::class, 'upgradeReabonnement'])->name('upgrade.client');
        Route::get('abonner/upgrade/{id_client}/{id_abonnement}', [ClientController::class, 'upAbonnement'])->name('abonnement.upgrade');
        Route::post('abonner/upgrade/save', [ClientController::class, 'upgradeAbonnement'])->name('abonnement.upgrade.save');

        Route::get('modif_client/{id_client}', [ClientController::class, 'edit_client'])->name('edit.client');
        Route::post('updateM', [ClientController::class, 'updateM'])->name('updateM.client');

        Route::get('modif_formule/{id_formule}', [FormuleController::class, 'edit_formule'])->name('edit.formule');
        Route::post('update/{id_formule}', [FormuleController::class, 'update'])->name('update.formule');

        Route::get('modif_materiel/{type_id}', [MaterielController::class, 'edit'])->name('edit.materiel');
        Route::post('update/{id_type}', [MaterielController::class, 'update'])->name('update.materiel');



        //Liste des clients
        Route::get('clients', [ClientController::class, 'allview'])->name('clients');
        Route::post('clients/new_decodeur', [ClientController::class, 'newDecodeur'])->name('clients.new_decodeur');
        Route::post('clients/delete', [ClientController::class, 'deleteClient'])->name('client.delete');

        //Stock
        Route::get('stock', [MaterielController::class, 'index'])->name('stock');
        Route::post('storeMat', [MaterielController::class, 'storeMat'])->name('store.materiel');
        Route::post('storeDec', [MaterielController::class, 'storeDec'])->name('store.decodeur');

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
        Route::post('caisse/store/achat', [CaisseController::class, 'addVersementAchat'])->name('caisse.store.achat');
        Route::post('caisse/update/achat', [CaisseController::class, 'EditVersementAchat'])->name('achat.update');
        Route::get('caisse/delete/achat/{id_achat}', [CaisseController::class, 'deleteVersementAchat'])->name('achat.delete');
        Route::post('caisse/sort', [CaisseController::class, 'sortBy'])->name('caisse.sort');


        Route::get('user/abonnement', [ClientController::class, 'mesAbonnements'])->name('user.abonnement');
        Route::get('user/abonnement/jour', [ClientController::class, 'mesAbonnementsjour'])->name('user.abonnement.jour');
        Route::get('user/reabonnement', [ClientController::class, 'mesReabonnements'])->name('user.reabonnement');
        Route::get('user/reabonnement/jour', [ClientController::class, 'mesReabonnementsAjour'])->name('user.reabonnement.jour');
        Route::get('user/reabonnement/credit', [ClientController::class, 'creditReabonnement'])->name('user.reabonnement.credit');


        Route::get('users/lient/perdu', [ClientController::class, 'clientPerdu'])->name('user.client.perdu');
        Route::get('user/client/nouveau', [ClientController::class, 'nouveauClient'])->name('user.client.nouveau');
        Route::get('user/client/relancer/{numero}', [ClientController::class, 'relancerClient'])->name('user.client.relancer');
        Route::get('user/client/terme', [ClientController::class, 'bientotATerme'])->name('user.client.terme');

        Route::get('settings', [SettingController::class, 'index'])->name('settings');

        Route::post('settings/store/sms/standard', [MessageController::class, 'storestandart'])->name('settings.store.sms.standart');
        Route::post('settings/store/sms', [MessageController::class, 'store'])->name('settings.store.sms');
        Route::get('message/delete/{id}', [MessageController::class, 'delete'])->name('message.delete');
        Route::post('message/update', [MessageController::class, 'update'])->name('message.update');

        Route::post('settings/store/versement', [VersementController::class, 'store'])->name('settings.store.versement');
        Route::get('versement/delete/{id}', [VersementController::class, 'delete'])->name('versement.delete');
        Route::post('versement/update', [VersementController::class, 'update'])->name('versement.update');
        Route::get('printFacture/{id_reabonnement}', [FactureController::class, 'printFactureReabo'])->name('printpdf');

        Route::get('test/message', [MessageController::class, 'messageData'])->name('test.message');
        Route::post('send/message', [MessageController::class, 'PrepareStandartMessage'])->name('send.message');
        Route::post('send/message/group', [MessageController::class, 'PrepareGroupMessage'])->name('send.message.group');
        Route::post('send/message/manual', [MessageController::class, 'sendManual'])->name('send.message.manual');
        Route::post('send/message/toselected', [MessageController::class, 'sendSMSToSelected'])->name('send.message.to.selected');

        //Historiques des messages
        Route::get('messages/historiques', [MessageController::class, 'listSend'])->name('historiques');
    });
    Route::get('canal/doc', function () {
        return view('layouts.doc');
    })->name('canal.doc');
});
