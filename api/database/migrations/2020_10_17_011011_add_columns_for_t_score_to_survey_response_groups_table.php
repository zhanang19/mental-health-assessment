<?php

use App\Enums\ScaleInterpretationTypes;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsForTScoreToSurveyResponseGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('survey_response_groups', function (Blueprint $table) {
            // frequency
            $table->enum('interpretation_x', [
                ScaleInterpretationTypes::Mild,
                ScaleInterpretationTypes::Moderate,
                ScaleInterpretationTypes::NeedsCloseMonitoring,
                ScaleInterpretationTypes::NeedsClinicalAttention,
                ScaleInterpretationTypes::Severe,
                ScaleInterpretationTypes::RequiresMedicalAssitance,
            ]);
            $table->double('t_score_x')->default(0)->nullable();
            $table->double('raw_score_x')->default(0)->nullable();
            $table->double('mean_x')->default(0)->nullable();
            $table->double('standard_deviation_x')->default(0)->nullable();

            // degree of being bothered
            $table->enum('interpretation_x', [
                ScaleInterpretationTypes::Mild,
                ScaleInterpretationTypes::Moderate,
                ScaleInterpretationTypes::NeedsCloseMonitoring,
                ScaleInterpretationTypes::NeedsClinicalAttention,
                ScaleInterpretationTypes::Severe,
                ScaleInterpretationTypes::RequiresMedicalAssitance,
            ]);
            $table->double('t_score_y')->default(0)->nullable();
            $table->double('raw_score_y')->default(0)->nullable();
            $table->double('mean_y')->default(0)->nullable();
            $table->double('standard_deviation_y')->default(0)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('survey_response_groups', function (Blueprint $table) {
            $table->dropColumn([
                't_score_x',
                'raw_score_x',
                'mean_x',
                'standard_deviation_x',

                't_score_y',
                'raw_score_y',
                'mean_y',
                'standard_deviation_y',
            ]);
        });
    }
}
