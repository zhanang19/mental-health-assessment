<?php

namespace App\Http\Controllers\Survey;

use App\Exports\SurveyResponseExport;
use App\Http\Controllers\Controller;
use App\Repository\SurveyResponseRepositoryInterface;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class SurveyResponseExportController extends Controller
{
    private $surveyResponseRepository;

    /**
     * @param \App\Repository\SurveyResponseRepositoryInterface $surveyResponseRepository
     */
    public function __construct(SurveyResponseRepositoryInterface $surveyResponseRepository)
    {
        $this->surveyResponseRepository = $surveyResponseRepository;
    }

    public function export(int $surveyId)
    {
        return Excel::download(new SurveyResponseExport(
            $this->surveyResponseRepository->getSurveyResponsesById($surveyId)
        ), 'students.xlsx');
    }
}
