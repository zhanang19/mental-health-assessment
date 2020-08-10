<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSurveyQuestionGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('survey_question_groups', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('survey_id');
            $table->unsignedBigInteger('survey_question_id');
            $table->string('label');
            $table->mediumText('instructions')->nullable();
            $table->timestamps();
        });

        Schema::table('survey_question_groups', function (Blueprint $table) {
            $table->foreign('survey_id')->references('id')->on('surveys');
            $table->foreign('survey_question_id')->references('id')->on('survey_questions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('survey_question_groups');
    }
}
