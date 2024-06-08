@extends('layouts.admin')

@section('content')
    <div>
        <a href="{{ route('reports.edit', $report->id) }}">Редактировать</a>
    </div>
    <div>
        <form action="{{ route('reports.delete', $report->id) }}" method="post">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        @method('delete')
        <input type="submit" value="Удалить" class="btn btn-danger">
        </form>
        <div>
            <div>{{ $report->teachers_id }}. {{ $report->student }}. {{ $report->course }}. {{ $report->topic }}. {{ $report->date }}. {{ $report->lesson_description }}. {{ $report->comments }}</div>
        </div>
    </div>
    <div>
        <a href="{{ route('admin.report.report') }}">Назад</a>
    </div>
@endsection