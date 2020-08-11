<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSurveyQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('survey_questions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('survey_id');
            $table->unsignedBigInteger('survey_question_group_id');
            $table->string('identifier')->comment('can be 1. or 1A, or anything');
            $table->string('input_type');
            $table->string('question');
            $table->string('hint')->nullable();
            $table->json('validations')->nullable();
            $table->json('option_group_a')->nullable();
            $table->json('option_group_b')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::table('survey_questions', function (Blueprint $table) {
            $table->foreign('survey_id')->references('id')->on('surveys');
            $table->foreign('survey_question_group_id')->references('id')->on('survey_question_groups');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('survey_questions');
    }
}
