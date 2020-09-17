<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithProperties;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class StudentExport implements FromCollection, WithHeadings, WithProperties, WithMapping
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
    public function collection()
    {
        return $this->collection;
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
            $data->full_name,
            $data->email,
            $data->date_created,
            $data->demographicProfile->identification_number,
            $data->demographicProfile->age,
            $data->demographicProfile->gender,
            $data->demographicProfile->date_of_birth,
            $data->demographicProfile->place_of_birth,
            $data->demographicProfile->religious_affiliation,
            $data->demographicProfile->gpa,
            $data->demographicProfile->citizenship,
            $data->demographicProfile->ordinal_position,
            $data->demographicProfile->currently_living_with,
            $data->demographicProfile->city_address,
            $data->demographicProfile->home_address,
            $data->demographicProfile->is_scholar,
            $data->demographicProfile->is_affected_marawi_siege,
            $data->demographicProfile->scholarship_grant,
            $data->demographicProfile->parents_marital_status,
            $data->demographicProfile->family_monthly_income,
            $data->demographicProfile->school_last_attended,
            $data->demographicProfile->school_address,
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
                "Full Name",
                "Email",
                "Date Created",
                "Identification Number",
                "Age",
                "Gender",
                "Date of Birth",
                "Place of Birth",
                "Religious Affiliation",
                "GPA",
                "citizenship",
                "ordinal position",
                "currently living with",
                "city address",
                "home address",
                "is scholar",
                "is affected marawi siege",
                "scholarship grant",
                "parents marital status",
                "family monthly income",
                "school last attended",
                "school address",
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
