@extends('layouts.admin')

@section('content')
<form action="{{ route('rosters.updateLesson', $roster->id) }}" method="post">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    @method('patch')
    <div class="form-group">
        <label for="inputDate">Дата</label>
        <input type="date" class="form-control" id="inputDate" placeholder="Введите дату" name="date" value="{{ $lessonDetail->date }}">
    </div>
    <br>
    <div class="form-group">
        <label for="inputTopic">Тема</label>
        <input type="text" class="form-control" id="inputTopic" placeholder="Введите тему урока" name="topic" value="{{ $lessonDetail->topic }}">
    </div>
    <div class="form-group">
        <label for="inputAttendance">Посещаемость</label>
        <input type="text" class="form-control" id="inputAttendance" placeholder="был, была, не было" name="attendance" value="{{ $lessonDetail->attendance }}">
    </div>
    <button type="submit" class="btn btn-primary">Сохранить</button>
</form>
@endsection