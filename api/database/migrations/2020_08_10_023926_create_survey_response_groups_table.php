<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSurveyResponseGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('survey_response_groups', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('survey_response_id');
            // $table->unsignedBigInteger('survey_response_answer_id');
            $table->string('label');
            $table->mediumText('instructions')->nullable();
            $table->string('status');
            $table->integer('questions_answered')->default(0);
            $table->integer('total_questions')->default(0);
            $table->boolean('is_completed')->default(false);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::table('survey_response_groups', function (Blueprint $table) {
            $table->foreign('survey_response_id')->references('id')->on('survey_responses');
            // $table->foreign('survey_response_answer_id')->references('id')->on('survey_response_answers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('survey_response_groups');
    }
}
