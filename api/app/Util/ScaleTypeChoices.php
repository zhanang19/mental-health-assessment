<?php

namespace App\Util;

use App\Enums\ScaleTypes;

class ScaleTypeChoices
{
    private $MHP;
    private $PCL5;
    private $WHODAS;
    private $GAD;
    private $PHQ9;

    public function __construct()
    {
        $this->MHP = [
            "option_group_a" => json_encode([
                "label" => "Frequency",
                "options" => [
                    [
                        "text" => "None",
                        "value" => 0
                    ],
                    [
                        "text" => "Once or twice a month",
                        "value" => 1
                    ],
                    [
                        "text" => "Once a week",
                        "value" => 2
                    ],
                    [
                        "text" => "Twice a week",
                        "value" => 3
                    ],
                    [
                        "text" => "Almost everyday",
                        "value" => 4
                    ],
                ]
            ]),
            "option_group_b" => json_encode([
                "label" => "Degree of being bothered by these experiences",
                "options" => [
                    [
                        "text" => "Not at all bothered",
                        "value" => 0
                    ],
                    [
                        "text" => "A little bit bothered",
                        "value" => 1
                    ],
                    [
                        "text" => "Moderately bothered",
                        "value" => 2
                    ],
                    [
                        "text" => "Quite a bit bothered",
                        "value" => 3
                    ],
                    [
                        "text" => "Extremely bothered",
                        "value" => 4
                    ],
                ]
            ]),
        ];

        $this->PCL5 = [
            "option_group_a" => json_encode([
                "label" => "",
                "options" => [
                    [
                        "text" => "Not at all",
                        "value" => 0
                    ],
                    [
                        "text" => "A little bit",
                        "value" => 1
                    ],
                    [
                        "text" => "Moderately",
                        "value" => 2
                    ],
                    [
                        "text" => "Quite a bit",
                        "value" => 3
                    ],
                    [
                        "text" => "Extremely",
                        "value" => 4
                    ],
                ]
            ]),
            "option_group_b" => json_encode(null),
        ];

        $this->WHODAS = [
            "option_group_a" => json_encode([
                "label" => "",
                "options" => [
                    [
                        "text" => "None",
                        "value" => 0
                    ],
                    [
                        "text" => "Mild",
                        "value" => 1
                    ],
                    [
                        "text" => "Moderate",
                        "value" => 2
                    ],
                    [
                        "text" => "Severe",
                        "value" => 3
                    ],
                    [
                        "text" => "Extreme or cannot do",
                        "value" => 4
                    ],
                ]
            ]),
            "option_group_b" => json_encode(null),
        ];

        $this->GAD = [
            "option_group_a" => json_encode([
                "label" => "",
                "options" => [
                    [
                        "text" => "Not at all",
                        "value" => 0
                    ],
                    [
                        "text" => "Several days",
                        "value" => 1
                    ],
                    [
                        "text" => "More than half the days",
                        "value" => 2
                    ],
                    [
                        "text" => "Nearly every day",
                        "value" => 3
                    ],
                ]
            ]),
            "option_group_b" => json_encode(null),
        ];

        $this->PHQ9 = [
            "option_group_a" => json_encode([
                "label" => "",
                "options" => [
                    [
                        "text" => "Not at all",
                        "value" => 0
                    ],
                    [
                        "text" => "Several days",
                        "value" => 1
                    ],
                    [
                        "text" => "More than half the days",
                        "value" => 2
                    ],
                    [
                        "text" => "Nearly every day",
                        "value" => 3
                    ],
                ]
            ]),
            "option_group_b" => json_encode(null),
        ];
    }

    /**
     * Get scale type choices based on type.
     *
     * @param string $type
     * @return object
     */
    public function getType(string $type): object
    {
        switch ($type) {
            case ScaleTypes::MHP:
                return (object) $this->MHP;
            case ScaleTypes::PCL5:
                return (object) $this->PCL5;
            case ScaleTypes::WHODAS:
                return (object) $this->WHODAS;
            case ScaleTypes::GAD:
                return (object) $this->GAD;
            case ScaleTypes::PHQ9:
                return (object) $this->PHQ9;
            default:
                return (object) [
                    "option_group_a" => json_encode([
                        "label" => "Choices A",
                        "options" => [
                            ["text" => "Undefined Option", "value" => null],
                        ]
                    ]),
                    "option_group_b" => json_encode([
                        "label" => "Choices B",
                        "options" => [
                            ["text" => "Undefined Option", "value" => null],
                        ]
                    ]),
                ];
        }
    }
}
