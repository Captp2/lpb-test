<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnswersIntentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('answers_intents', function (Blueprint $table) {
            $table->id();

            $table->foreignId('intent_id')->constrained();
            $table->foreignId('answer_id')->constrained();
            $table->string('position');

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
        Schema::table('answers_intents', function (Blueprint $table) {
            $table->dropForeign(['intent_id']);
            $table->dropForeign(['answer_id']);
        });
        Schema::dropIfExists('answers_intents');
    }
}
