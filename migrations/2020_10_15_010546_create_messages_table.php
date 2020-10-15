<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chat_messages', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('messageable_id');
            $table->string('messageable_type');
            $table->unsignedInteger('chat_id');
            $table->foreign('chat_id')
            ->references('id')->on('chats')
            ->onDelete('cascade')
            ->onUpdate('cascade');
            $table->unsignedBigInteger('sender_id');
            $table->foreign('sender_id')
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
        Schema::dropIfExists('chat_messages');
    }
}
