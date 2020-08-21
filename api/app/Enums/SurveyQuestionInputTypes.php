<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class SurveyQuestionInputTypes extends Enum
{
    const ShortAnswer = "short answer";
    const Paragraph = "paragraph";
    const MultipleChoice = "multiple choice";
    const Checkboxes = "checkboxes";
    const Dropdown = "dropdown";
}
