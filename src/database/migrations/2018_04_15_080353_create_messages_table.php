<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(config('chatter.models.message.table'), function (Blueprint $table) {
            $table->increments('id');
            $table->integer('sender_user_id')->unsigned();
            $table->integer('recipient_user_id')->unsigned();
            $table->integer('conversation_id')->unsigned()->comment('id беседы');
            $table->string('conversation_type');
            $table->boolean('status')->unsigned();
            $table->text('message');
            $table->timestamps();

            $table->index('sender_user_id');
            $table->index('recipient_user_id');

            $table->foreign('sender_user_id')->references('id')->on(config('chatter.models.user.table'))->onDelete('cascade');
            $table->foreign('recipient_user_id')->references('id')->on(config('chatter.models.user.table'))->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(config('chatter.models.message.table'));
    }
}
