<?php

namespace App\Http\Controllers;

use App\Models\Caisse;
use App\Models\Formule;
use Illuminate\Http\Request;
use Vonage\Client\Exception\Exception;
class MessageController extends Controller
{
    public function sendMessage($message, $numero){
        try {
            $basic  = new \Vonage\Client\Credentials\Basic("955fc9c6", "mAWAdKoZ6Emoe6QU");
            $client = new \Vonage\Client($basic);
            $response = $client->sms()->send(
                new \Vonage\SMS\Message\SMS(
                    $numero,
                    'GETEL',
                    $message,
                )
            );
            $message1 = $response->current();

            if ($message1->getStatus() == 0) {
                $message_con = $message1->getStatus();
            }
        } catch (Exception $e) {
            $message_con = "Error: ". $e->getMessage();
        }
        return $message_con;
    }
    public function totalCaisse(){
        $totat = Caisse::sum("montant");
        return $totat;
    }
    public function dejaConsomme(){
        $reste= Formule::join('reabonnements','formules.id_formule','reabonnements.id_formule')
//            ->where('formules.id_formule','reabonnements.id_formule')
//            ->sum('formules.prix_formule'* 'formules.duree');
            ->sum(\DB::raw('formules.prix_formule * reabonnements.duree'));
//        \DB::raw('logins_sun + logins_mon')
        return $reste;

    }
    public function resteCaisse(){
        $diference = $this->totalCaisse() - $this->dejaConsomme();
        return $diference;

    }

}
