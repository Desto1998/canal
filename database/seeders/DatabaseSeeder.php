<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        DB::table('formules')->insert([
            [
            'nom_formule' => 'EVASION',
            'prix_formule' => '13000'
            ],
            [
            'nom_formule' => 'ACCESS',
            'prix_formule' => '5000'
            ],
            [
            'nom_formule' => 'EVASION +',
            'prix_formule' => '25000'
            ],
            [
            'nom_formule' => 'ACCESS +',
            'prix_formule' => '45000'
            ],
            [
            'nom_formule' => 'ESSENTIEL',
            'prix_formule' => '35000'
            ],
            [
            'nom_formule' => 'ESSENTIEL +',
            'prix_formule' => '50000'
            ],
            [
            'nom_formule' => 'TOUT CANAL',
            'prix_formule' => '65000'
            ],
            ]);
            $nbrFormule = 7;
    }
}
