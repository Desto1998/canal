<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

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
        DB::table('users')->insert([
            'name' => 'admin',
            'is_active' => 1,
            'is_admin' => 1,
            'email' => 'admin@gmail.com',
            'role' => 'admin',
            'password' => Hash::make('123456'),
        ]);
        DB::table('users')->insert([
            'name' => 'user1',
            'is_active' => 1,
            'is_admin' => 0,
            'role' => 'user',
            'email' => 'user1@gmail.com',
            'password' => Hash::make('123456'),
        ]);
        DB::table('users')->insert([
            'name' => 'user2',
            'is_active' => 0,
            'is_admin' => 0,
            'role' => 'user',
            'email' => 'user2@gmaiil.com',
            'password' => Hash::make('123456'),
        ]);

        DB::table('materiels')->insert([
            'nom_materiel' => 'Télécommande',
            'quantite' => 10,
            'prix_materiel' => 2000,
            'date_livaison' => now(),
            'id_user'=> 1,
        ]);
        DB::table('formules')->insert([
            [
            'nom_formule' => 'EVASION',
            'prix_formule' => '10000',
                'id_user'=> 1,
            ],
            [
            'nom_formule' => 'ACCESS',
            'prix_formule' => '5000',
                'id_user'=> 1,
            ],
            [
            'nom_formule' => 'EVASION +',
            'prix_formule' => '22500',
                'id_user'=> 1,
            ],
            [
            'nom_formule' => 'ACCESS +',
            'prix_formule' => '17000',
                'id_user'=> 1,
            ],
            [
            'nom_formule' => 'PRESTIGE',
            'prix_formule' => '34000',
                'id_user'=> 1,
            ],
            [
            'nom_formule' => 'ESSENTIEL +',
            'prix_formule' => '34000',
                'id_user'=> 1,
            ],
            [
            'nom_formule' => 'TOUT CANAL',
            'prix_formule' => '45000',
                'id_user'=> 1,
            ],
            ]);
            $nbrFormule = 7;


    }
}
