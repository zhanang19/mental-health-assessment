<?php

namespace App\Http\Requests\Survey;

use App\Repository\SurveyResponseRepositoryInterface;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Arr;

class SurveyResponseGroupRequest extends FormRequest
{
    /**
     * @var SurveyResponseRepositoryInterface
     */
    protected $surveyResponseRepository;

    /**
     * @param SurveyResponseRepositoryInterface $surveyResponseRepository
     */
    public function __construct(SurveyResponseRepositoryInterface $surveyResponseRepository)
    {
        $this->surveyResponseRepository = $surveyResponseRepository;
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check();
    }

    /**
     * @param int $userId
     * @return User
     */
    public function persist(
        int $responseId = null,
        int $responseGroupId = null
    ) {
        $responseGroup = null;

        if ($this->method() == "POST") {
            /** @todo will move takeSurvey() method in here */
            // $responseGroup = $this->surveyResponseRepository->create($this->all());
        } else if ($this->method() == "PUT") {
            $responseGroup = $this->surveyResponseRepository->updateResponseGroupById(
                $responseId, $responseGroupId, $this->all()
            );
        }

        return $responseGroup;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [];
    }
}
