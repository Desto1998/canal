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
        $envoi = (new MessageController)->sendMessage('DESTO TEST','237679353205' );
        $data = DB::table('clients')->get();

        if (!empty($data)){
            foreach ($data as $key => $value){

                $envoi = (new MessageController)->sendMessage('Venez vous reabonner1',$value->telephone_client );
                DD($value->telephone_client);
            }
            if ($envoi==0){
                DD("DESTO evoyé");
            }else{
                DD("Pas envoyé");
            }
        }
        DD("DESTO");
        $this->info('Message sent.');
    }
}
