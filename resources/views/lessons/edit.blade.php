@extends('layouts.admin')

@section('content')
<style>
    input:-webkit-autofill,
input:-webkit-autofill:hover, 
input:-webkit-autofill:focus,
textarea:-webkit-autofill,
textarea:-webkit-autofill:hover,
textarea:-webkit-autofill:focus,
select:-webkit-autofill,
select:-webkit-autofill:hover,
select:-webkit-autofill:focus { 
  border: 1px solid green;
  -webkit-text-fill-color: green;
  -webkit-box-shadow: 0 0 0px 1000px #000 inset;
  transition: background-color 5000s ease-in-out 0s;
}
</style>
<form action="{{ route('lessons.updateLesson', ['roster' => $roster->id, 'lesson_id' => $lessonDetail->id]) }}" method="post">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <input type="hidden" name="_method" value="PATCH">
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