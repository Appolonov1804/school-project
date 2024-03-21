@extends('layouts.admin')

@section('content')
<form action="{{ route('reports.store') }}" method="post">
<input type="hidden" name="_token" value="{{ csrf_token() }}">
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
  <div class="form-group">
    <select class="form-control" id="teachers" name="teachers_id"> 
      <label for="teachers">Выбрать преподавателя</label>
  <?php foreach ($teachers as $teacher) : ?>
      <option value="{{ $teacher->id }}">{{ $teacher->name }}</option>
  <?php endforeach ; ?>
    </select>
  </div>
  <button type="submit" class="btn btn-primary">Добавить</button>
</form>
@endsection