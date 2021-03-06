<?php

namespace App\Http\Controllers;

use App\Models\Caisse;
use App\Models\Decodeur;
use App\Models\Formule;
use App\Models\Message;
use App\Models\Message_Envoye;
use App\Models\Reabonnement;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use phpDocumentor\Reflection\Types\Array_;
use Vonage\Client\Exception\Exception;

class MessageController extends Controller
{
    public function sendMessage($message, $numero)
    {
        $sendurl = 'https://smsvas.com/bulk/public/index.php/api/v1/sendsms';
        $response = Http::post($sendurl, [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            "user" => "teneyemdesto@gmail.com",
            "password" => "getel2021",  //getel2021
            "senderid" => "Getel",
            "sms" => $message,
            "mobiles" => $numero
        ]);

        $status = json_decode($response);
//        dd($status);
        $errorcode = $status->sms[0]->errorcode;
        $confirm = 0;
        if ($status->responsecode != 1) {
            $confirm = 0;
        }
        if ($errorcode != "" && $errorcode == -10008) {
            $confirm = $errorcode;
        }
        if ($status->responsemessage == 'success' && $errorcode == "") {
            $confirm = $status->responsemessage;
        }

        return $confirm;
    }

    public function getSMSBalance()
    {
        $balanceurl = 'https://smsvas.com/bulk/public/index.php/api/v1/smscredit?user=teneyemdesto@gmail.com&password=getel2021';

        $response = Http::post($balanceurl, [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            "user" => "teneyemdesto@gmail.com",
            "password" => "getel2021"
        ]);

        $balance = json_decode($response);
        $responsecode = $balance->responsecode;
        return $balance->credit;
    }

    public function store(Request $request)
    {
        $request->validate([
            'message' => 'required',
            'type_sms' => 'required',
            'titre_sms' => 'required',
        ]);
        $delete = Message::where('type_sms', '!=', 'STANDART')->delete();
//        dd($request);
//        if (count($request->titre_sms) === count($request->type_sms ) && count($request->type_sms ) === count( $request->message))
//        {
        $message = array();
        for ($i = 0; $i < count($request->message); $i++) {
            $message[$i] = Message::create([
                'titre_sms' => $request->titre_sms[$i],
                'type_sms' => $request->type_sms[$i],
                'message' => $request->message[$i],
                'description_sms' => ""
            ]);
        }

        if (count($message) === count($request->message)) {
            return redirect()->back()->with('success', 'Enregistr?? avec succ??s!');
        } else {
            return redirect()->back()->with('danger', 'Echec d\'enregistrement. Une erreur est survenue veillez reessayer.');
        }
//        }else{
//            return redirect()->back()->with('danger','Echec d\'enregistrement. Rassurez vous de remplir tous les champs du formulair.');
//
//        }


    }

    public function storestandart(Request $request)
    {
        $request->validate([
            'message' => 'required',
            'titre_sms' => 'required',
        ]);
        $message = Message::create([
            'titre_sms' => strtoupper($request->titre_sms),
            'type_sms' => "STANDART",
            'message' => $request->message,
            'description_sms' => ""
        ]);
        if ($message) {
            return redirect()->back()->with('success', 'Enregistr?? avec succ??s!');
        } else {
            return redirect()->back()->with('danger', 'Echec d\'enregistrement. Une erreur est survenue veillez reessayer.');
        }
    }

    public function update(Request $request)
    {
        $request->validate([
            'message' => 'required',
            'titre_sms' => 'required',
            'id_message' => 'required',
        ]);

        $message = Message::where('id_message', $request->id_message)
            ->update([
                'titre_sms' => strtoupper($request->titre_sms),
                'type_sms' => "STANDART",
                'message' => $request->message,
            ]);
        if ($message) {
            return redirect()->back()->with('success', 'Enregistr?? avec succ??s!');
        } else {
            return redirect()->back()->with('danger', 'Echec d\'enregistrement. Une erreur est survenue veillez reessayer.');
        }
    }

    public function delete($id)
    {
        $message = Message::where('id_message', $id)->delete();
        if ($message) {
            return redirect()->back()->with('success', 'Supprim?? avec succ??s!');
        } else {
            return redirect()->back()->with('danger', 'Echec de suppression. Une erreur est survenue veillez reessayer.');
        }
    }

    public function prepareMessage($data, $type)
    {
//        $id_client
//        <NOM><PRENOM><MONTANT><DATEECHEANCE><DATEREABO>
        $message = Message::where('type_sms', $type)->get();
        $messagecontent = $message[0]->message;
        if (strpos($message[0]->message, "<NOM>") !== false) {
            $messagecontent = str_replace("<NOM>", $data->nom, $messagecontent);
        }
        if (strpos($message[0]->message, "<PRENOM>") !== false) {
            $messagecontent = str_replace("<PRENOM>", $data->prenom, $messagecontent);
        }
        if (strpos($message[0]->message, "<MONTANT>") !== false) {
            $messagecontent = str_replace("<MONTANT>", $data->montant, $messagecontent);
        }
        if (strpos($message[0]->message, "<DATEECHEANCE>") !== false) {
            $messagecontent = str_replace("<DATEECHEANCE>", $data->dateecheance, $messagecontent);
        }
        if (strpos($message[0]->message, "<DATEREABO>") !== false) {
            $messagecontent = str_replace("<DATEREABO>", $data->datereabo, $messagecontent);
        }

//        dd($messagecontent);
        $send = $this->sendMessage($messagecontent, $data->phone);
        $data->message = $messagecontent;
//        if ($send == 0) {
//            $statut = 0;
//        } else {
//            $statut = 1;
//        }
        $confirm = 0;
        if ($send=='success'){
            $send = 1;
        }
        $data->statut = $send;
        $data->id_message = $message[0]->id_message;
//        dd($data);
        $saveSend = $this->storeSened($data);
        if ($saveSend) {
            return $messagecontent;
        } else {
            return 'Error!';
        }

    }

    public function PrepareStandartMessage(Request $request)
    {
        $request->validate([
            'id_message' => 'required',
            'phone' => 'required',
            'id_client' => 'required',
            'nom_client' => 'required',
            'message' => 'required',
        ]);
        $data = new Array_();
        $data->nom = $request->nom;
        $data->prenom = "";
        $data->phone = $request->telephone_client;
        $data->id_client = $request->id_client;
        $data->id_message = $request->id_message;

//        $message = Message::where('id_message', $request->id_message)->get();
        $messagecontent = $request->message;
        $send = $this->sendMessage($messagecontent, $request->phone);
//        if ($send == 0) {
//            $statut = 0;
//        } else {
//            $statut = 1;
//        }
        $data->message = $messagecontent;
        if ($send=='success'){
            $send = 1;
        }
        $data->statut = $send;
        $saveSend = $this->storeSened($data);
        $balance = $this->getSMSBalance();
        if ($send === 1) {
            return redirect()->back()->with('info', 'Message envoy?? avec succ??s. Solde SMS: ' . $balance);
        } else {
            return redirect()->back()->with('danger', 'Echec de l\'envoi du message! Solde SMS: ' . $balance);

        }

    }

    public function PrepareGroupMessage(Request $request)
    {
        $request->validate([
            'id_message' => 'required',
            'phone' => 'required',
            'id_client' => 'required',
            'nom_client' => 'required',
            'message' => 'required',
        ]);
        $data = new Array_();
        $data->nom = $request->nom;
        $data->prenom = "";
        $data->phone = $request->telephone_client;
        $data->id_client = $request->id_client;
        $data->id_message = $request->id_message;

//        $message = Message::where('id_message', $request->id_message)->get();
        $messagecontent = $request->message;
        $send = $this->sendMessage($messagecontent, $request->phone);
//        if ($send == 0) {
//            $statut = 0;
//        } else {
//            $statut = 1;
//        }
        $data->message = $messagecontent;
        $data->statut = $send;
        $saveSend = $this->storeSened($data);
        $balance = $this->getSMSBalance();
        if ($send === 1) {
            return redirect()->back()->with('info', 'Message envoy?? avec succ??s. Solde SMS: ' . $balance);
        } else {
            return redirect()->back()->with('danger', 'Eche de l\'envoi du message! Solde SMS: ' . $balance);

        }

    }

    public function messageData()
    {
        $data = Reabonnement::join('clients', 'reabonnements.id_client', 'clients.id_client')
            ->join('formules', 'reabonnements.id_formule', 'formules.id_formule')
            ->join('decodeurs', 'decodeurs.id_decodeur', 'reabonnements.id_decodeur')
            ->join('client_decodeurs', 'decodeurs.id_decodeur', 'client_decodeurs.id_decodeur')
            ->where('id_reabonnement', 29)
            ->get();
        //REABONNEMENT
        //ABONNEMENT
        //VERSEMENT
        $data_message = new Array_();
        $data_message->nom = $data[0]->nom_client;
        $data_message->prenom = $data[0]->prenom_client;
        $data_message->datereabo = $data[0]->date_reabonnement;
        $data_message->dateecheance = $data[0]->date_reabonnement;
        $data_message->montant = $data[0]->prix_formule * $data[0]->duree;
        $data_message->phone = "679353205";
        $data_message->id_client = 29;

        $message = $this->prepareMessage($data_message, 'VERSEMENT');
        return $message;
    }

    public function storeSened($data)
    {
        $userId = Auth::user()->id;
        $envoi = Message_Envoye::create([
            'id_message' => $data->id_message,
            'id_client' => $data->id_client,
            'nom_client' => $data->nom . $data->prenom,
            'telephone_client' => $data->phone,
            'message' => $data->message,
            'statut' => $data->statut,
            'id_user' => $userId
        ]);

        return $envoi;
    }

    public  function listSend()
    {
        $messages = Message_Envoye::OrderBy('id_message_envoye','DESC')->get();
        $users = User::all();
        return view('message.historiques',compact('messages','users'));
    }


    public function getStandart()
    {
        $messages = Message::where('type_sms', 'STANDART')->get();
        return $messages;
    }

    public function sendManual(Request $request)
    {
        $request->validate([
            'sender' => 'required',
            'phone' => 'required',
            'message' => 'required',
        ]);

        $sendurl = 'https://smsvas.com/bulk/public/index.php/api/v1/sendsms';
        $response = Http::post($sendurl, [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            "user" => "teneyemdesto@gmail.com",
            "password" => "getel2021",
            "senderid" => "$request->sender",
            "sms" => $request->message,
            "mobiles" => $request->phone
        ]);

        $status = json_decode($response);
//        dd($status);
        $errorcode = $status->sms[0]->errorcode;
        $confirm = 0;
        if ($status->responsecode != 1) {
            $confirm = 0;
        }
        if ($errorcode != "" && $errorcode == -10008) {
            $confirm = $errorcode;
        }
        if ($status->responsemessage == 'success' && $errorcode == "") {
            $confirm = 1;
        }
        $datastore = new Array_();
        $datastore->id_message = 0;
        $datastore->id_client = 0;
        $datastore->nom = 'Non d??fini';
        $datastore->prenom = '';
        $datastore->phone = $request->phone;
        $datastore->message = $request->message;
        $datastore->statut = $confirm;
        $this->storeSened($datastore);
        $balance = $this->getSMSBalance();
        if ($confirm === 1) {
            return redirect()->back()->with('info', 'Message envoy?? avec succ??s. Solde SMS: ' . $balance);
        } else {
            return redirect()->back()->with('danger', 'Eche de l\'envoi du message! Solde SMS: ' . $balance);

        }
    }

 public function sendSMSToSelected(Request $request)
    {
        $request->validate([
            'phone' => 'required',
            'message' => 'required',
        ]);
//        $monmessage = "Salut maman ch??rie. c'est a parti de l'application que je
//         developpe que je t'envoi ce message. Tu vas bien j'esp??re: Bonne soir??e a toi maman.";
//        $phone = '665326159';
        $sendurl = 'https://smsvas.com/bulk/public/index.php/api/v1/sendsms';
        $response = Http::post($sendurl, [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            "user" => "teneyemdesto@gmail.com",
            "password" => "getel2021",
            "senderid" => "IngDesto",
            "sms" => $request->message,
            "mobiles" => $request->phone
        ]);

        $status = json_decode($response);
//        dd($status);
        $errorcode = $status->sms[0]->errorcode;
        $confirm = 0;
        if ($status->responsecode != 1) {
            $confirm = 0;
        }
        if ($errorcode != "" && $errorcode == -10008) {
            $confirm = $errorcode;
        }
        if ($status->responsemessage == 'success' && $errorcode == "") {
            $confirm = 1;
        }
        $datastore = new Array_();
        $datastore->id_message = 0;
        $datastore->id_client = 0;
        $datastore->nom = 'Non d??fini';
        $datastore->prenom = '';
        $datastore->phone = $request->phone;
        $datastore->message = $request->message;
        $datastore->statut = $confirm;
        $this->storeSened($datastore);
        $balance = $this->getSMSBalance();
        if ($confirm === 1) {
            return redirect()->back()->with('info', 'Message envoy?? avec succ??s. Solde SMS: ' . $balance);
        } else {
            return redirect()->back()->with('danger', 'Eche de l\'envoi du message! Solde SMS: ' . $balance);

        }
    }


    public function totalCaisse()
    {
        $totat = Caisse::sum("montant");
        return $totat;
    }

    public function dejaConsomme()
    {
        $reste = Formule::join('reabonnements', 'formules.id_formule', 'reabonnements.id_formule')
            ->sum(\DB::raw('formules.prix_formule * reabonnements.duree'));
        return $reste;

    }

    public function resteCaisse()
    {
        $diference = $this->totalCaisse() - $this->dejaConsomme();
        return $diference;

    }

}
