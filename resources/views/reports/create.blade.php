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
<form action="{{ route('reports.store') }}" method="post">
<input type="hidden" name="_token" value="{{ csrf_token() }}">
<input type="hidden" name="page" value="{{ $page }}">
  <div>
    <label for="name">Студент</label>
    <input type="text" class="form-control" id="inputName" name="student" placeholder="Введите имя студента">
  </div>
  <div class="form-group">
    <label for="inputCourse">Курс</label>
    <input type="text" class="form-control" id="inputCourse" name="course" placeholder="Введите курс студента">
  </div>
  <div class="form-group">
    <label for="inputTopic">Тема</label>
    <input type="text" class="form-control" id="inputTopic" name="topic" placeholder="Введите тему урока">
  </div>
  <div class="form-group">
    <label for="inputDate">Дата</label>
    <input type="date" class="form-control" id="inputDate" name="date" placeholder="Введите дату">
  </div>
  <div class="form-group">
    <label for="inputDescription">Описание урока</label>
    <input type="text" class="form-control" id="inputDescription" name="lesson_description" placeholder="Введите описание урока">
  </div>
  <div class="form-group">
    <label for="inputComments">Комментарии</label>
    <input type="text" class="form-control" id="inputComments" name="comments" placeholder="Введите замечания">
  </div>
  @if(auth()->user()->teacher)
  <input type="hidden" name="teachers_id" value="{{ auth()->user()->teacher->id }}">
  @endif
  <button type="submit" class="btn btn-primary">Добавить</button>
</form>
@endsection
