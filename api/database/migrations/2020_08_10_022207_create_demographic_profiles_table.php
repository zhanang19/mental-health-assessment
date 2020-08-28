<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDemographicProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('demographic_profiles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student_id');
            $table->string('identification_number')->unique();
            $table->integer('age');
            $table->enum('gender', ['Male', 'Female']);
            $table->date('date_of_birth');
            $table->string('place_of_birth');
            $table->string('religious_affiliation');
            $table->decimal('gpa');
            $table->string('citizenship');
            $table->string('ordinal_position');
            $table->string('currently_living_with');
            $table->string('city_address')->nullable();
            $table->string('home_address');
            $table->boolean('is_scholar')->default(false);
            $table->boolean('is_affected_marawi_siege')->default(false);
            $table->string('scholarship_grant')->nullable();
            $table->string('parents_marital_status')->nullable();
            $table->string('family_monthly_income')->nullable();
            $table->string('school_last_attended')->nullable();
            $table->string('school_address')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::table('demographic_profiles', function (Blueprint $table) {
            $table->foreign('student_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('demographic_profiles');
    }
}
