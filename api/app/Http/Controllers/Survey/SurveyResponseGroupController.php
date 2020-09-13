<?php

namespace App\Http\Controllers\Survey;

use App\Http\Controllers\Controller;
use App\Http\Requests\Survey\SurveyResponseGroupRequest;
use App\Repository\SurveyResponseRepositoryInterface;
use Illuminate\Http\JsonResponse;
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
            ),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\Survey\SurveyResponseGroupRequest $request
     * @param int $responseId
     * @param int $responseGroupId
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(
        SurveyResponseGroupRequest $request,
        int $responseId,
        int $responseGroupId
    ): JsonResponse {
        return response()->json([
            'data' => $request->persist($responseId, $responseGroupId),
            'message' => 'Hooray! You have completed this sub-scale.'
        ], 200);
    }
}
