<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientDecodeursTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('client_decodeurs',function (Blueprint $table) {
            $table->id();
            $table->date("date_abonnement");
            $table->date("date_reabonnement");
            $table->timestamps();
            $table->unsignedBigInteger('id_client');
            $table->foreign('id_client')
                ->references('id_client')
                ->on('clients')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('id_decodeur');
            $table->foreign('id_decodeur')
                ->references('id_decodeur')
                ->on('decodeurs')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->integer("id_user");
            $table->integer("id_formule");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('client_decodeurs');
    }
}
