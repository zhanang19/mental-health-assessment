<?php

namespace App\Service\Interpretation;

class BaseInterpretation implements BaseInterpretationInterface
{
    /**
     * Get the score from a student.
     *
     * @param int $studentId
     * @param int $responseId
     * @return any
     */
    public function interpret($studentId, $responseId)
    {
        return $studentId;
    }
}
