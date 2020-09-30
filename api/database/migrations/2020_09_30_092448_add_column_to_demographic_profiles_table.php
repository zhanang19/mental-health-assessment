<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnToDemographicProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('demographic_profiles', function (Blueprint $table) {
            $table->string('parents_ofw')->nullable();
            $table->string('parents_work_location')->nullable();
            $table->string('living_with')->nullable();
            $table->string('parents_away')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('demographic_profiles', function (Blueprint $table) {
            $table->dropColumn([
                'parents_ofw',
                'parents_work_location',
                'living_with',
                'parents_away',
            ]);
        });
    }
}
