<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();
        Schema::create('clients', function (Blueprint $table) {
            $table->id('id_client');
            $table->string("nom_client");
            $table->string("prenom_client");
            $table->integer("num_abonne");
            $table->string("adresse_client");
            $table->integer("telephone_client");
            $table->date("date_abonnement");
            $table->date("date_reabonnement");

            $table->unsignedBigInteger('id_formule');
            $table->foreign('id_formule')->references('id_formule')->on('formules')->onDelete('restrict')->onUpdate('restrict');

            $table->unsignedBigInteger('id_materiel');
            $table->foreign('id_materiel')->references('id_materiel')->on('materiels')->onDelete('restrict')->onUpdate('restrict');

            $table->unsignedBigInteger('id_decodeur');
            $table->foreign('id_decodeur')->references('id_decodeur')->on('decodeurs')->onDelete('restrict')->onUpdate('restrict');

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
        Schema::dropIfExists('clients');
    }
}
