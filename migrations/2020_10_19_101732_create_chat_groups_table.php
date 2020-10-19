<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChatGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chat_groups', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('chat_id');
            $table->foreign('chat_id')
            ->references('id')->on('chats')
            ->onDelete('cascade')
            ->onUpdate('cascade');
            $table->string('icon');
            $table->string('name');
            $table->unsignedBigInteger('created_by');
            $table->foreign('created_by')
            ->references('id')->on(config('blink.defaults.user.table','users'))
            ->onDelete('cascade')
            ->onUpdate('cascade');
            $table->string('description');
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
        Schema::dropIfExists('chat_groups');
    }
}
