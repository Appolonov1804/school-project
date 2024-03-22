@extends('layouts.admin')

@section('content')
    
    <div>
        <div>{{ $teacher->id }}. {{ $teacher->email }}</div>
        <div>{{ $teacher->name }}</div>
    </div>
    <div>
    <h2>Отчёты учителя {{ $teacher->name }}</h2>
        @foreach($reports as $report)
            <div>{{ $report->id }}. {{ $report->student }}. {{ $report->course }}</div>
            <div>{{ $report->topic }}. {{ $report->date }}. {{ $report->lesson_description }}. {{ $report->comments }}</div>
            <div>
                <a href="{{ route('reports.edit', ['report' => $report->id]) }}">Редактировать отчёты</a>
            </div>
    </div>
    
    <div>
        <form action="{{ route('reports.delete', $report->id) }}" method="post">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        @method('delete')
        <input type="submit" value="Удалить" class="btn btn-danger">
        </form>
    </div>
    <div>
        <a href="{{ route('teachers.show', $teacher) }}">Назад</a>
    </div>
    @endforeach
@endsection