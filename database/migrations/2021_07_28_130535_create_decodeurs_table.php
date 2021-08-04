<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDecodeursTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('decodeurs', function (Blueprint $table) {
            $table->id('id_decodeur');
            $table->bigInteger('num_decodeur');
            $table->integer('quantite');
            $table->integer('prix_decodeur');
            $table->date('date_livaison');
            $table->integer("id_user");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('decodeurs');
    }
}
