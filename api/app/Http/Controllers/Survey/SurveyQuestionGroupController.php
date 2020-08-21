<?php

namespace App\Http\Controllers\Survey;

use App\Http\Controllers\Controller;
use App\Repository\SurveyRepositoryInterface;
use Illuminate\Http\Request;

class SurveyQuestionGroupController extends Controller
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
    public function duplicate(int $surveyId, int $questionGroupId)
    {
        return response()->json([
            "data" => $this->surveyRepository->duplicateQuestionGroup(
                $surveyId, $questionGroupId
            ),
            "message" => "A survey question group has been duplicated."
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(int $surveyId)
    {
        return response()->json([
            "data" => $this->surveyRepository->createQuestionGroup($surveyId),
            "message" => "A survey question group was added."
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $surveyId
     * @param int $questionGroupId
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $surveyId, int $questionGroupId)
    {
        return response()->json([
            "data" => $this->surveyRepository->deleteQuestionGroupById(
                $surveyId, $questionGroupId
            ),
            "message" => "A survey question group has been deleted."
        ]);
    }
}
