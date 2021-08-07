<?php

namespace App\Console\Commands;
use App\Http\Controllers\MessageController;
use App\Models\Decodeur;
use App\Models\ClientDecodeur;
use App\Models\Client;
use Illuminate\Console\Command;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Models\User;

class DailyMessage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'daily:message';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send best wishes daily.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     *///        ->dailyAt('13:00′);
    //            DB::table('recent_users')->delete();
    public function handle()
    {
        $envoi = -1;
//        $envoi = (new MessageController)->sendMessage('DESTO TEST','237679353205' );
//        $data = DB::table('clients')->get();
        $date_reabonnement = date_format(date_add(date_create(date("Y-m-d")),date_interval_create_from_date_string("3 days")),'Y-m-d');

        $data = ClientDecodeur::join('clients','clients.id_client','client_decodeurs.id_client')
//            ->join('clients','clients.id_client','client_decodeurs.id_client')
            ->where('client_decodeurs.date_reabonnement','<=',$date_reabonnement)
            ->get();
//        DD($data);

        if (!empty($data)){
            foreach ($data as $key => $value){
//                $now = time(); // or your date as well
//                $now = strtotime(date('Y-m-d'));
//                $your_date = strtotime($value->date_reabonnement);
////                $your_date = strtotime("2021-08-07");
//                $datediff =   $your_date-$now;
//
//                $maxjour = round($datediff / (60 * 60 * 24));

                    $envoi = (new MessageController)->sendMessage('Votre abonnemet CANAL+ expire dans 3 jours. Nous prions de vous reabonner avant son expiration. Merci!',$value->telephone_client );
            }
//            if ($envoi==0){
//                $this->info( "Message envoyé");
//            }else{
//                $this->error( "Message Pas envoyé");
//            }
        }

    }
}
