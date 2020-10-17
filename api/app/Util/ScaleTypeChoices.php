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

        $this->GHQ12 = [
            "option_group_a" => json_encode([
                "label" => "",
                "options" => [
                    [
                        "text" => "Not at all",
                        "value" => 0
                    ],
                    [
                        "text" => "Seldom",
                        "value" => 1
                    ],
                    [
                        "text" => "Usual",
                        "value" => 2
                    ],
                    [
                        "text" => "More than usual",
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
            case ScaleTypes::GHQ12:
                return (object) $this->GHQ12;
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

    /**
     * Get the value from the answer based on scale type.
     *
     * @param string $type scale type
     * @param string $option either `option_group_a` or `option_group_b`
     * @param string $answer
     * @return int
     */
    public function getValueFromType(string $type, string $option, string $answer): ?int
    {
        info('SCALE TYPE CHOICES', [
            'type' => 'TESTESTESTESTES',
        ]);

        function getScaleChoice($choices, string $answer) {
            $scaleChoice = [];

            if ($answer == null) return null;

            foreach ($choices as $key => $choice) {


                if ($choice['text'] == $answer) {
                    array_push($scaleChoice, $choice->value);
                }
            }

            return array_pop($scaleChoice);
        }

        switch ($type) {
            case ScaleTypes::MHP:
                return getScaleChoice(json_decode($this->MHP[$option]), $answer);
            case ScaleTypes::PCL5:
                return getScaleChoice(json_decode($this->PCL5[$option]), $answer);
            case ScaleTypes::WHODAS:
                return getScaleChoice(json_decode($this->WHODAS[$option]), $answer);
            case ScaleTypes::GAD:
                return getScaleChoice(json_decode($this->GAD[$option]), $answer);
            case ScaleTypes::PHQ9:
                return getScaleChoice(json_decode($this->PHQ9[$option]), $answer);
            case ScaleTypes::GHQ12:
                return getScaleChoice(json_decode($this->GHQ12[$option]), $answer);
            default:
                return null;
        }
    }
}
