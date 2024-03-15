@extends('layouts.admin')

@section('content')
    <div>
        <div>
            <?php foreach ($reports as $report) : ?>
                <div>
                    <div><a href=" {{ route('reports.show', $report->id) }} ">{{ ($report->student) }}</a></div>
                    <div>{{ $report->teachers_id }}. {{ $report->course }}. {{ $report->topic }}. {{ $report->date }}. {{ $report->lesson_description }}. {{ $report->comments }}</div>
                </div>
            <?php endforeach ; ?>
        </div>
    </div>

@endsection