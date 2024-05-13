@extends('layouts.admin')

@section('content')
<a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>
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