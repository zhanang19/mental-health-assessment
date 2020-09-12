<?php

namespace App\Service\Interpretation;

interface BaseInterpretationInterface
{
    /**
     * Get the score from a student.
     *
     * @param int $studentId
     * @param int $responseId
     * @return any
     */
    public function interpret($studentId, $responseId);
}
