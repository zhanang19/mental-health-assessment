<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class ScaleInterpretationTypes extends Enum
{
    const Mild = "Mild";
    const Moderate = "Moderate";
    const NeedsCloseMonitoring = "Serious/Needs Close Monitoring";
    const NeedsClinicalAttention = "Crtical/Needs Clinical Attention";
    const Severe = "Severe";
    const RequiresMedicalAssitance = "Requires Medical Assitance";
}
