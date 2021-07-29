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
            $table->integer('num_decodeur');
            $table->integer('quantite');
            $table->integer('prix_decodeur');
            $table->integer('quantite_stock');
            $table->date('date_livaison');

            $table->unsignedBigInteger('id_materiel');
            $table->foreign('id_materiel')->references('id_materiel')->on('materiels')->onDelete('restrict')->onUpdate('restrict');
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
