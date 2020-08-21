<?php

namespace App\Http\Controllers\Survey;

use App\Http\Controllers\Controller;
use App\Repository\SurveyRepositoryInterface;
use Illuminate\Http\Request;

class SurveyQuestionController extends Controller
{
    /**
     * @var SurveyRepositoryInterface
     */
    protected $surveyRepository;

    /**
     * @param SurveyRepositoryInterface $surveyRepository
     */
    public function __construct(SurveyRepositoryInterface $surveyRepository)
    {
        $this->surveyRepository = $surveyRepository;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $surveyId
     * @param int $questionGroupId
     * @return \Illuminate\Http\Response
     */
    public function duplicate(int $surveyId, int $questionGroupId, int $questionId)
    {
        return response()->json([
            "data" => $this->surveyRepository->duplicateQuestion(
                $surveyId, $questionGroupId, $questionId
            ),
            "message" => "A survey question has been duplicated."
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(int $surveyId, int $questionGroupId)
    {
        return response()->json([
            "data" => $this->surveyRepository->createQuestion($surveyId, $questionGroupId),
            "message" => "A survey question was added."
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $surveyId
     * @param int $questionGroupId
     * @param int $questionId
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $surveyId, int $questionGroupId, int $questionId)
    {
        return response()->json([
            "data" => $this->surveyRepository->deleteQuestionById(
                $surveyId, $questionGroupId, $questionId
            ),
            "message" => "A survey question has been deleted."
        ]);
    }
}
