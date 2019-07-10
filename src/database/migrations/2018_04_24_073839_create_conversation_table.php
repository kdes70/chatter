<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConversationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(config('chatter.models.conversation.table'), function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->bigInteger('user_one')->unsigned()->index();
            $table->bigInteger('user_two')->unsigned()->index();

            $table->unique(array('user_one', 'user_two'));

            $table->foreign('user_one')->references('id')->on(config('chatter.models.user.table'))->onDelete('cascade');
            $table->foreign('user_two')->references('id')->on(config('chatter.models.user.table'))->onDelete('cascade');

        });

        Schema::table(config('chatter.models.message.table'), function (Blueprint $table) {
            $table->foreign('conversation_id')->references('id')->on(config('chatter.models.conversation.table'))->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table(config('chatter.models.message.table'), function (Blueprint $table) {
            $table->dropForeign('messages_conversation_id_foreign');
        });

        Schema::dropIfExists(config('chatter.models.conversation.table'));
    }
}
