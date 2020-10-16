<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChatImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chat_images', function (Blueprint $table) {
            $table->id();
            $table->string('path');
            $table->unsignedBigInteger('images_message_id');
            $table->foreign('images_message_id')
            ->references('id')->on('chat_images_messages')
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
        Schema::dropIfExists('chat_images');
    }
}
