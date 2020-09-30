<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterColumnQuestionInSurveyResponseAnswersTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('survey_response_answers', function (Blueprint $table) {
            $table->mediumText('question')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('survey_response_answers', function (Blueprint $table) {
            $table->string('question')->change();
        });
    }
}
