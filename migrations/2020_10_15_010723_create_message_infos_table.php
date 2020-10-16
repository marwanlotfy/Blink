<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMessageInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chat_message_info', function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('delivered')->default(0);
            $table->boolean('seen')->default(0);
            $table->unsignedInteger('message_id');
            $table->foreign('message_id')
            ->references('id')->on('chat_messages')
            ->onDelete('cascade')
            ->onUpdate('cascade');
            $table->unsignedBigInteger('reciever_id');
            $table->foreign('reciever_id')
            ->references('id')->on(config('blink.defaults.user.table','users'))
            ->onDelete('cascade')
            ->onUpdate('cascade');
            $table->softDeletes();
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
        Schema::dropIfExists('chat_message_info');
    }
}
