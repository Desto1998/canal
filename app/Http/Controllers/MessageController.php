<?php

namespace App\Http\Controllers;

use App\Models\Caisse;
use App\Models\Formule;
use App\Models\Message;
use Illuminate\Http\Request;
use Vonage\Client\Exception\Exception;
class MessageController extends Controller
{
    public function sendMessage($message, $numero){
//        try {
//            $basic  = new \Vonage\Client\Credentials\Basic("955fc9c6", "mAWAdKoZ6Emoe6QU");
//            $client = new \Vonage\Client($basic);
//            $response = $client->sms()->send(
//                new \Vonage\SMS\Message\SMS(
//                    $numero,
//                    'GETEL',
//                    $message,
//                )
//            );
//            $message1 = $response->current();

//            if ($message1->getStatus() == 0) {
//                $message_con = $message1->getStatus();
//            }
//        } catch (Exception $e) {
//            $message_con = "Error: ". $e->getMessage();
//        }
//        return $message_con;
    }

    public function store( Request $request )
    {
        $request->validate([
            'message'=>'required',
            'type_sms'=>'required',
            'titre_sms'=>'required',
        ]);
        $delete = Message::where('type_sms','!=','STANDART')->delete();
//        dd($request);
//        if (count($request->titre_sms) === count($request->type_sms ) && count($request->type_sms ) === count( $request->message))
//        {
        $message = array();
            for ($i = 0; $i < count($request->message) ; $i++)
            {
                $message[$i] = Message::create([
                    'titre_sms' => $request->titre_sms[$i],
                    'type_sms' => $request->type_sms[$i],
                    'message' => $request->message[$i],
                    'description_sms' => ""
                ]);
            }

            if (  count($message) === count($request->message) ){
                return redirect()->back()->with('success','Enregistré avec succés!');
            }else{
                return redirect()->back()->with('danger','Echec d\'enregistrement. Une erreur est survenue veillez reessayer.');
            }
//        }else{
//            return redirect()->back()->with('danger','Echec d\'enregistrement. Rassurez vous de remplir tous les champs du formulair.');
//
//        }


    }
    public function storestandart( Request $request )
    {
        $request->validate([
            'message'=>'required',
            'titre_sms'=>'required',
        ]);
        $message = Message::create([
            'titre_sms' => strtoupper($request->titre_sms),
            'type_sms' => "STANDART",
            'message' => $request->message,
            'description_sms' => ""
        ]);
        if ( $message ){
            return redirect()->back()->with('success','Enregistré avec succés!');
        }else{
            return redirect()->back()->with('danger','Echec d\'enregistrement. Une erreur est survenue veillez reessayer.');
        }
    }
    public function update( Request $request )
    {
        $request->validate([
            'message'=>'required',
            'titre_sms'=>'required',
            'id_message'=>'required',
        ]);

        $message = Message::where('id_message',$request->id_message)
            ->update([
            'titre_sms' => strtoupper($request->titre_sms) ,
            'type_sms' => "STANDART",
            'message' => $request->message,
        ]);
        if ( $message ){
            return redirect()->back()->with('success','Enregistré avec succés!');
        }else{
            return redirect()->back()->with('danger','Echec d\'enregistrement. Une erreur est survenue veillez reessayer.');
        }
    }

    public function delete( $id )
    {
        $message = Message::where('id_message',$id)->delete();
        if ( $message ){
            return redirect()->back()->with('success','Supprimé avec succés!');
        }else{
            return redirect()->back()->with('danger','Echec de suppression. Une erreur est survenue veillez reessayer.');
        }
    }

    public function totalCaisse(){
        $totat = Caisse::sum("montant");
        return $totat;
    }
    public function dejaConsomme(){
        $reste= Formule::join('reabonnements','formules.id_formule','reabonnements.id_formule')
            ->sum(\DB::raw('formules.prix_formule * reabonnements.duree'));
        return $reste;

    }
    public function resteCaisse(){
        $diference = $this->totalCaisse() - $this->dejaConsomme();
        return $diference;

    }

}
