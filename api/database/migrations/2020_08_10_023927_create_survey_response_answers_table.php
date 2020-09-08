<?php

use App\Enums\SurveyQuestionInputTypes;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSurveyResponseAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('survey_response_answers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('survey_response_group_id');
            $table->unsignedBigInteger('survey_question_id');
            $table->string('answer_a')->nullable();
            $table->string('answer_b')->nullable();

            $table->string('identifier')->comment('can be 1. or 1A, or anything');
            $table->enum('input_type', [
                SurveyQuestionInputTypes::ShortAnswer,
                SurveyQuestionInputTypes::Paragraph,
                SurveyQuestionInputTypes::MultipleChoice,
                SurveyQuestionInputTypes::Checkboxes,
                SurveyQuestionInputTypes::Dropdown,
            ]);
            $table->string('question');
            $table->string('hint')->nullable();
            $table->boolean('required')->default(false);
            $table->json('option_group_a')->nullable();
            $table->json('option_group_b')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });

        Schema::table('survey_response_answers', function (Blueprint $table) {
            $table->foreign('survey_response_group_id')->references('id')->on('survey_response_groups');
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
        Schema::dropIfExists('survey_response_answers');
    }
}
