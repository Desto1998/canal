<?php

namespace App\Console\Commands;
use App\Http\Controllers\MessageController;
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
        $data = DB::table('clients')->get();
//        DD($data);

        if (!empty($data)){
            foreach ($data as $key => $value){
                $now = time(); // or your date as well
                $now = strtotime(date('Y-m-d'));
                $your_date = strtotime($value->date_reabonnement);
//                $your_date = strtotime("2021-08-07");
                $datediff =   $your_date-$now;

                $maxjour = round($datediff / (60 * 60 * 24));
                if ($maxjour==3){
                    $envoi = (new MessageController)->sendMessage('Venez vous reabonner maintenant',$value->telephone_client );
                }
            }
            if ($envoi==0){
                $this->info( "Message envoyé");
            }else{
                $this->error( "Message Pas envoyé");
            }
        }

    }
}
