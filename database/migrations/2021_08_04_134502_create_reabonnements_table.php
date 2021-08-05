<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReabonnementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reabonnements', function (Blueprint $table) {
            $table->id('id_reabonnement');
            $table->integer('id_client');
            $table->integer('id_decodeur');
            $table->integer('id_formule');
            $table->integer('type_reabonement');
            $table->date('date_reabonnement');
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
        Schema::dropIfExists('reabonnements');
    }
}
