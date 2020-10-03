<?php

use App\Enums\ScaleTypes;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnTypeToSurveyResponsGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('survey_response_groups', function (Blueprint $table) {
            $table->string('type')->nullable()->default(ScaleTypes::NONE);
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
            $table->dropColumn('type');
        });
    }
}
