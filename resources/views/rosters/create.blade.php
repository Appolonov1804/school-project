@extends('layouts.admin')

@section('content')
<form action="{{ route('rosters.store') }}" method="post">
<input type="hidden" name="_token" value="{{ csrf_token() }}">
    <div class="form-group">
    <label for="InputStudent">Студент</label>
    <input type="text" class="form-control" id="inputStudent" name="student" placeholder="Введите имя студента">
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
    <label for="inputAttendance">Посещаемость</label>
    <input type="text" class="form-control" id="inputAttendance" name="attendance" placeholder="был, была, не было">
  </div>
  <div class="form-group">
    <label for="teachers">Выбрать преподавателя</label>
      <select class="form-control" id="teachers" name="teachers_id">
    <?php foreach ($teachers as $teacher) : ?>
      <option value="{{ $teacher->id }}">{{ $teacher->name }}</option>
    <?php endforeach ; ?>
      </select>
  </div>
  <button type="submit" class="btn btn-primary">Добавить</button>
</form>
@endsection