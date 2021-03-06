<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSurveyResponsesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('survey_responses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student_id');
            $table->unsignedBigInteger('survey_id');
            $table->string('title');
            $table->string('slug')->nullable();
            $table->string('subtitle')->nullable();
            $table->longText('description')->nullable();
            $table->string('color_theme')->default('indigo')->nullable();
            $table->string('status');
            $table->boolean('is_completed')->default(false);
            $table->timestamps();
            $table->softDeletes();
            // $table->unique([
            //     'student_id',
            //     'survey_id'
            // ]);
        });

        Schema::table('survey_responses', function (Blueprint $table) {
            $table->foreign('student_id')->references('id')->on('users');
            $table->foreign('survey_id')->references('id')->on('surveys');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('survey_responses');
    }
}
