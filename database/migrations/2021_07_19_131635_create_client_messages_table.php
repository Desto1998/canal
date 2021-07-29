<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('client__messages', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->unsignedBigInteger('message_id');
            $table->foreign('message_id')
                ->references('id_message')
                ->on('messages')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('client_id');
            $table->foreign('client_id')
                ->references('id_client')
                ->on('clients')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('client__messages');
    }
}
