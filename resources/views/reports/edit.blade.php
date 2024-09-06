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
<form action="{{ route('reports.update', $report->id) }}" method="post">
<input type="hidden" name="_token" value="{{ csrf_token() }}">
@method('patch')
<input type="hidden" name="page" value="{{ $page }}">
  <div class="form-group">
    <label for="inputName">Студент</label>
    <input type="text" class="form-control" id="inputName" placeholder="Введите имя студента" name="student" value=" {{ $report->student }}">
  </div>
  <br>
  <div class="form-group">
    <label for="inputCourse">Курс</label>
    <input type="text" class="form-control" id="inputCourse" placeholder="Введите курс студента" name="course" value="{{ $report->course }}">
  </div>
  <br>
  <div class="form-group">
    <label for="inputTopic">Тема</label>
    <input type="text" class="form-control" id="inputTopic" placeholder="Введите тему урока" name="topic" value="{{ $report->topic }}">
  </div>
  <br>
  <div class="form-group">
    <label for="inputDate">Дата</label>
    <input type="date" class="form-control" id="inputDate" placeholder="Введите дату" name="date" value="{{ $report->date }}">
  </div>
  <br>
  <div class="form-group">
    <label for="inputDescription">Описание урока</label>
    <input type="text" class="form-control" id="inputDescription" placeholder="Введите описание урока" name="lesson_description" value=" {{ $report->lesson_description }}">
  </div>
  <div class="form-group">
    <label for="inputComments">Замечания</label>
    <input type="text" class="form-control" id="inputComments" placeholder="Введите замечания" name="comments" value="{{ $report->comments }}">
  </div>
  <input type="hidden" name="teachers_id" value="{{ $report->teaachers_id }}">
  <button type="submit" class="btn btn-primary">Обновить</button>
</form>

@endsection
