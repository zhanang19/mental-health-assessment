<?php

use App\Repository\SurveyRepositoryInterface;
use Illuminate\Database\Seeder;

class SurveySeeder extends Seeder
{
    protected $surveyRepository;

    public function __construct(SurveyRepositoryInterface $surveyRepository)
    {
        $this->surveyRepository = $surveyRepository;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->surveyRepository->newSurvey();
    }
}
