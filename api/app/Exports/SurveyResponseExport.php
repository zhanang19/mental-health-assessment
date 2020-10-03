<?php

namespace App\Exports;

use App\SurveyResponse;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;

class SurveyResponseExport implements FromView
{
    /**
     * @var Collection
     */
    private $collection;

    /**
     * @param Collection $collection
     */
    public function __construct(Collection $collection)
    {
        $this->collection = $collection;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function view(): View
    {
        return view('exports.survey-responses.index', [
            'survey' => $this->collection->first()->survey,
            'data' => $this->collection
        ]);
    }

    /**
     * Customizing the columns that gets exported.
     *
     * @return array
     */
    public function map($data): array
    {
        return [
            $data->id,
        ];
    }

    /**
     * The heading attributes of the spreadsheet.
     *
     * @return array
     */
    public function headings(): array
    {
        return [
            [
                "ID",
            ]
        ];
    }

    /**
     * Custom properties for the spreadsheet file.
     *
     * @return array
     */
    public function properties(): array
    {
        return [
            'title'          => 'List of Students',
            'description'    => 'List of all students registered in the application',
            'subject'        => 'Students',
            'keywords'       => 'students,export,spreadsheet',
            'category'       => env('Students'),
            'company'        => env('APP_COMPANY', 'MSU-IIT'),
        ];
    }
}
