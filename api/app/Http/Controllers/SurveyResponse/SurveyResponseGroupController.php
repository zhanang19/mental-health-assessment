<?php

namespace App\Http\Controllers\SurveyResponse;

use App\Http\Controllers\Controller;
use App\Repository\SurveyResponseRepositoryInterface;
use Illuminate\Http\Request;

class SurveyResponseGroupController extends Controller
{
    /**
     * @var SurveyResponseRepositoryInterface
     */
    protected $surveyResponseRepository;

    /**
     * @param SurveyResponseRepositoryInterface $surveyResponseRepository
     */
    public function __construct(
        SurveyResponseRepositoryInterface $surveyResponseRepository
    ) {
        $this->surveyResponseRepository = $surveyResponseRepository;
    }

    /**
     * Display the specified resource.
     *
     * @param int $responseId
     * @param int $responseGroupId
     * @return \Illuminate\Http\Response
     */
    public function show(int $responseId, int $responseGroupId)
    {
        return response()->json([
            "data" => $this->surveyResponseRepository->findResponseGroupById(
                $responseId, $responseGroupId
            )
        ]);
    }
}
