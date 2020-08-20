<?php

namespace App\Http\Controllers\Survey;

use App\Http\Controllers\Controller;
use App\Http\Resources\Survey\SurveyResource;
use App\Repository\SurveyRepositoryInterface;
use Illuminate\Http\Request;

class SurveyController extends Controller
{
    protected $surveyRepository;

    /**
     * @param SurveyRepositoryInterface $surveyRepository
     */
    public function __construct(SurveyRepositoryInterface $surveyRepository)
    {
        $this->surveyRepository = $surveyRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return SurveyResource::collection($this->surveyRepository->all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return new SurveyResource([
            'data' => $this->surveyRepository->createSurvey(),
            'message' => 'A new survey has been created.'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function show(string $slug)
    {
        return new SurveyResource($this->surveyRepository->findBySlug($slug));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        return new SurveyResource([
            'data' => $this->surveyRepository->updateSurvey($id, $request),
            'message' => 'A survey has been updated.'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return new SurveyResource([
            'data' => $this->surveyRepository->deleteById($id),
            'message' => 'A survey has been trashed.'
        ]);
    }
}
