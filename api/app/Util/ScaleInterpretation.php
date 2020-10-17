<?php

namespace App\Util;

use App\Enums\ScaleInterpretationTypes;

class ScaleInterpretation
{
    /**
     * @var object
     */
    private object $mild;

    /**
     * @var object
     */
    private object $moderate;

    /**
     * @var object
     */
    private object $needsCloseMonitoring;

    /**
     * @var object
     */
    private object $needsClinicalAttention;

    /**
     * @var object
     */
    private object $severe;

    /**
     * @var object
     */
    private object $requiresMedicalAssitance;

    /**
     * Instantiate values for all the properties.
     */
    public function __construct()
    {
        $this->mild = (object) [
            'min' => 30,
            'max' => 39,
        ];

        $this->moderate = (object) [
            'min' => 40,
            'max' => 49,
        ];

        $this->needsCloseMonitoring = (object) [
            'min' => 50,
            'max' => 59,
        ];

        $this->needsClinicalAttention = (object) [
            'min' => 60,
            'max' => 69,
        ];

        $this->severe = (object) [
            'min' => 70,
            'max' => 79,
        ];

        // greater than or equal to 80
        $this->requiresMedicalAssitance = (object) [
            'min' => 80,
            'max' => null,
        ];
    }

    /**
     * Get the interpretation result based on `t-score`.
     *
     * @param int|double $tScore
     * @return string
     */
    public function getInterpretation($tScore): string
    {
        // mild
        if ($tScore >= $this->mild->min && $tScore <= $this->mild->max) return ScaleInterpretationTypes::Mild;

        // moderate
        if ($tScore >= $this->moderate->min && $tScore <= $this->moderate->max) return ScaleInterpretationTypes::Moderate;

        // serious / needs close monitoring
        if ($tScore >= $this->needsCloseMonitoring->min && $tScore <= $this->needsCloseMonitoring->max) return ScaleInterpretationTypes::NeedsCloseMonitoring;

        // crtical / needs clinical attention
        if ($tScore >= $this->needsClinicalAttention->min && $tScore <= $this->needsClinicalAttention->max) return ScaleInterpretationTypes::NeedsClinicalAttention;

        // severe
        if ($tScore >= $this->severe->min && $tScore <= $this->severe->max) return ScaleInterpretationTypes::Severe;

        // requires medical assistance
        if ($tScore >= $this->requiresMedicalAssitance->min) return ScaleInterpretationTypes::RequiresMedicalAssitance;
    }
}
