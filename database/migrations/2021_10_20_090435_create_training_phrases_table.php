<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrainingPhrasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('training_phrases', function (Blueprint $table) {
            $table->id();

            $table->string('text');
            $table->foreignId('intent_id')->constrained();

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
        Schema::table('training_phrases', function (Blueprint $table) {
            $table->dropForeign(['intent_id']);
        });

        Schema::dropIfExists('training_phrases');
    }
}
