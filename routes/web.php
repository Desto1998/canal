<?php

use App\Http\Controllers\AbonnementController;
use App\Http\Controllers\CaisseController;
use App\Http\Controllers\FactureController;
use App\Http\Controllers\GeneralController;
use App\Http\Controllers\ReabonnementController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\SortController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\UpgradeController;
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
        Route::post('abonner/delete', [AbonnementController::class, 'deleteAbonne'])->name('abonnement.delete');
        Route::get('abonner/sortBy', [SortController::class, 'sortAbonnement'])->name('abonnement.sort');
        Route::post('abonner/recover', [AbonnementController::class, 'recoverReabonne'])->name('abonnement.recover');


        //Reabonnement
        Route::get('reabonner', [ReabonnementController::class, 'review'])->name('review.reabonner');
        Route::post('reabonner/add', [ReabonnementController::class, 'reabonneAdd'])->name('store.client.reabonnement');
        Route::get('new_reabonner/{id_client}', [ReabonnementController::class, 'reabonne'])->name('reabonne.client');
        Route::post('reabonner/delete', [ReabonnementController::class, 'deleteReabonne'])->name('reabonnement.delete');
        Route::post('reabonner/recover', [ReabonnementController::class, 'recoverReabonne'])->name('reabonnement.recover');
        Route::post('updateR/{id_client}', [ReabonnementController::class, 'updateR'])->name('updateR.client');
        Route::get('reabonnement/all', [ReabonnementController::class, 'allReabonnement'])->name('user.reabonnement.all');
        Route::post('reabonnement/sortby', [SortController::class, 'sortReabonnement'])->name('reabonnement.sort');


        //Modifier
        Route::get('upgrader', [UpgradeController::class, 'viewModif'])->name('upgrader');
        Route::post('upgrader/add', [UpgradeController::class, 'addNew'])->name('upgrader.add');
        Route::get('upgrader/all', [UpgradeController::class, 'allUpgrades'])->name('upgrader.all');
        Route::get('upgrade_client/{id_client}/{id_reabonnement?}', [ReabonnementController::class, 'up_client'])->name('up.client');
        Route::post('upgradeClient/{id_client}', [ReabonnementController::class, 'upgradeReabonnement'])->name('upgrade.client');
        Route::post('recover_upgrade', [UpgradeController::class, 'recoverUpgrade'])->name('upgrade.recover');
        Route::get('upgrades/sortBy', [SortController::class, 'sortUpgrades'])->name('upgrade.sort');
        Route::get('abonner/upgrade/{id_client}/{id_abonnement}', [AbonnementController::class, 'upAbonnement'])->name('abonnement.upgrade');
        Route::post('upgrade/delete', [UpgradeController::class, 'deleteUpgrade'])->name('upgrade.delete');
        Route::post('abonner/upgrade/save', [AbonnementController::class, 'upgradeAbonnement'])->name('abonnement.upgrade.save');
        Route::post('abonner/delete', [AbonnementController::class, 'deleteAbonne'])->name('abonnement.delete');

        Route::get('modif_client/{id_client}', [ClientController::class, 'edit_client'])->name('edit.client');
        Route::post('updateM', [ClientController::class, 'updateM'])->name('updateM.client');

        Route::get('modif_formule/{id_formule}', [FormuleController::class, 'edit_formule'])->name('edit.formule');
        Route::post('update/{id_formule}', [FormuleController::class, 'update'])->name('update.formule');

        Route::get('modif_materiel/{type_id}', [MaterielController::class, 'edit'])->name('edit.materiel');
        Route::post('update/{id_type}', [MaterielController::class, 'update'])->name('update.materiel');



        //Liste des clients
        Route::get('clients', [ClientController::class, 'allview'])->name('clients');
        Route::post('client/add', [ClientController::class, 'addNewClient'])->name('client.add');
        Route::get('client/add/form', function () {
                return view('client.add');
            })->name('client.add.form');
        Route::post('clients/new_decodeur', [ClientController::class, 'newDecodeur'])->name('clients.new_decodeur');
        Route::post('clients/delete', [ClientController::class, 'deleteClient'])->name('client.delete');

        //Stock
        Route::get('stock', [MaterielController::class, 'index'])->name('stock');
        Route::post('storeMat', [MaterielController::class, 'storeMat'])->name('store.materiel');
        Route::post('storeDec', [MaterielController::class, 'storeDec'])->name('store.decodeur');
        Route::get('stock/makefield', [StockController::class, 'makeForm'])->name('stock.makefield');
        Route::get('stock/storedecodeur', [StockController::class, 'storeDecodeur'])->name('stock.store.decodeur');
        Route::post('stock/delete', [StockController::class, 'deleteDecodeur'])->name('stock.delete.decodeur');
        Route::post('stock/addsale', [StockController::class, 'addVente'])->name('stock.sale.add');
        Route::post('stock/sale/delete', [StockController::class, 'deleteVente'])->name('stock.sale.delete');
//        Route::post('stock/sale/delete', [StockController::class, 'deleteVente'])->name('stock.sale.delete');

        Route::get('/messagerie', function () {
            return view('message.messagerie');
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
        Route::post('caisse/recouvrement/store', [CaisseController::class, 'storeRecouvrement'])->name('caisse.store.recouvrement');
        Route::get('caisse/delete/achat/{id_achat}', [CaisseController::class, 'deleteVersementAchat'])->name('achat.delete');
        Route::post('caisse/sort', [SortController::class, 'sortByCaisse'])->name('caisse.sort');


        Route::get('user/abonnement', [AbonnementController::class, 'mesAbonnements'])->name('user.abonnement');
        Route::get('user/abonnement/jour', [AbonnementController::class, 'mesAbonnementsjour'])->name('user.abonnement.jour');
        Route::get('user/reabonnement', [ReabonnementController::class, 'mesReabonnements'])->name('user.reabonnement');
        Route::get('user/reabonnement/jour', [ReabonnementController::class, 'mesReabonnementsAjour'])->name('user.reabonnement.jour');
        Route::get('user/reabonnement/credit', [ReabonnementController::class, 'creditReabonnement'])->name('user.reabonnement.credit');


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
        Route::get('printFacture/abo/{id_abonnement}', [FactureController::class, 'printFactureAbo'])->name('abo.printpdf');

        Route::get('test/message', [MessageController::class, 'messageData'])->name('test.message');
        Route::post('send/message', [MessageController::class, 'PrepareStandartMessage'])->name('send.message');
        Route::post('send/message/group', [MessageController::class, 'PrepareGroupMessage'])->name('send.message.group');
        Route::post('send/message/manual', [MessageController::class, 'sendManual'])->name('send.message.manual');
        Route::post('send/message/toselected', [MessageController::class, 'sendSMSToSelected'])->name('send.message.to.selected');


        //Historiques des messages
        Route::get('messages/historiques', [MessageController::class, 'listSend'])->name('historiques');

        //Route generer les raports
        Route::get('messages/historiques', [MessageController::class, 'listSend'])->name('historiques');
        Route::get('messages/historiques', [MessageController::class, 'listSend'])->name('historiques');

//        Route::get('rapport/form', function () {
//            return view('raport.form');
//        })->name('rapport.form');

        Route::get('rapport/form', [GeneralController::class, 'getUsers'])->name('rapport.form');
        Route::get('rapport/generate', [GeneralController::class, 'makeReport'])->name('report.make');
        Route::get('rapport/print', [GeneralController::class, 'print'])->name('report.print');

        // all today operations
        Route::get('todays/all', [GeneralController::class, 'TodayOperations'])->name('today.all');
        Route::get('credit/all', [GeneralController::class, 'OperationsCredit'])->name('credit.all');


    });
    Route::get('canal/doc', function () {
        return view('layouts.doc');
    })->name('canal.doc');
});
