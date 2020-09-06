<?php

namespace App\Http\Controllers\Survey;

use App\Enums\RouteGuards;
use App\Http\Controllers\Controller;
use App\Http\Resources\SurveyResponse\SurveyResponseResource;
use App\Repository\SurveyResponseRepositoryInterface;
use Illuminate\Http\Request;

class SurveyResponseController extends Controller
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

        // $this->middleware([
        //     RouteGuards::SuperAdminOrAdministrator,
        // ])->except(["index", "show", "findBySlug"]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return SurveyResponseResource::collection(
            $this->surveyResponseRepository->all()
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return new SurveyResponseResource([
            "data" => $this->surveyResponseRepository->create(),
            "message" => "You started to take the survey. Good luck!"
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param int $responseId
     * @return \Illuminate\Http\Response
     */
    public function show(int $responseId)
    {
        return new SurveyResponseResource(
            $this->surveyResponseRepository->findById($responseId)
        );
    }

    // /**
    //  * Display the specified resource.
    //  *
    //  * @param  string  $slug
    //  * @return \Illuminate\Http\Response
    //  */
    // public function findBySlug(string $slug)
    // {
    //     return new SurveyResponseResource(
    //         $this->surveyResponseRepository->findBySlug($slug)
    //     );
    // }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $responseId
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, int $responseId)
    {
        return new SurveyResponseResource([
            "data" => $this->surveyResponseRepository->update($responseId, $request),
            "message" => "A survey has been updated."
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $responseId
     * @return \Illuminate\Http\Response
     */
    public function destroy($responseId)
    {
        return new SurveyResponseResource([
            "data" => $this->surveyResponseRepository->deleteById($responseId),
            "message" => "A survey has been trashed."
        ]);
    }
}
