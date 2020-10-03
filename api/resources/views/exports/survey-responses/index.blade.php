@php
use App\Util\ScaleTypeChoices;

$scaleTypeChoice = new ScaleTypeChoices();
@endphp

<h1>SURVEY FORM DETAILS</h1>
<table>
    <tr>
        <th>SURVEY ID:</th>
        <td>{{ $survey->id }}</td>
    </tr>
    <tr>
        <th>SURVEY TITLE:</th>
        <td>{{ $survey->title }}</td>
    </tr>
    <tr>
        <th>DESCRIPTION:</th>
        <td>{{ $survey->description }}</td>
    </tr>
    <tr>
        <th>CREATED_AT:</th>
        <td>{{ $survey->created_at }}</td>
    </tr>
</table>

<h1>RESPONSES</h1>
<br>
@foreach($data as $item)
    <h3>STUDENT NAME: {{ $item->student->full_name }}</h3>

    @foreach($item->response_groups as $responseGroup)
    <h3>SCALE: {{ $responseGroup->label }}</h3>

    <table>
        <thead>
            <tr>
                <th></th>
                <th>Question</th>
                <th>{{ json_decode($scaleTypeChoice->getType($responseGroup->type)->option_group_a)->label }}</th>
                <th>{{ json_decode($scaleTypeChoice->getType($responseGroup->type)->option_group_b)->label }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach($responseGroup->answers as $answer)
            <tr>
                <td></td>
                <td>{{ $answer->question }}</td>
                <td>{{ $answer->answer_a }}</td>
                <td>{{ $answer->answer_b }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endforeach
@endforeach
