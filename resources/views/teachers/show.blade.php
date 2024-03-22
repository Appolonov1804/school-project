@extends('layouts.admin')

@section('content')
    <div>
        <a href="{{ route('teachers.edit', $teacher->id) }}">Изменить имя преподавателя</a>
    </div>
    <div>
        <form action="{{ route('teachers.delete', $teacher->id) }}" method="post">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        @method('delete')
        <input type="submit" value="Удалить" class="btn btn-danger">
        </form>
    </div>
    <div>
        <div>{{ $teacher->id }}. {{ $teacher->email }}</div>
        <div>{{ $teacher->name }}</div>
    </div>
    <div>
    <h2>Журналы учителя {{ $teacher->name }}</h2>
        @foreach($rosters as $roster)
            <div>{{ $roster->id }}. {{ $roster->student }}. {{ $roster->course }}</div>
            <div>{{ $roster->topic }}. {{ $roster->date }}. {{ $roster->attendance }}</div>
        @endforeach
    </div>
    <div>
        <a href="{{ route('rosters.edit', $roster->id) }}">Редактировать журналы</a>
    </div>
    <div>
        <form action="{{ route('rosters.delete', $roster->id) }}" method="post">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        @method('delete')
        <input type="submit" value="Удалить" class="btn btn-danger">
        </form>
    </div>
    <div>
        <a href="{{ route('teachers.reportShow', $teacher) }}">Отчёты учителя</a>
    </div>
    <div>
        <a href="{{ route('admin.teacher.teacher') }}">Назад</a>
    </div>
@endsection