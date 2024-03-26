@extends('layouts.admin')

@section('content')
<form action="{{ route('rosters.update', $roster->id) }}" method="post"> 
<input type="hidden" name="_token" value="{{ csrf_token() }}">
@method('patch')

  <div class="form-group">
    <label for="inputName">Студент</label>
    <input type="text" class="form-control" id="inputName" placeholder="Введите имя студента" name="student" value=" {{ $roster->student }}">
  </div>
  <br>
  <div class="form-group">
    <label for="inputCourse">Курс</label>
    <input type="text" class="form-control" id="inputCourse" placeholder="Введите курс студента" name="course" value=" {{ $roster->course }}">
  </div>
  <br>
  <div class="form-group">
    <label for="teachers">Выбрать преподавателя</label>
      <select class="form-control" id="teachers" name="teachers_id">
    <?php foreach ($teachers as $teacher) : ?>
      <option value="{{ $teacher->id }}">{{ $teacher->name }}</option>
    <?php endforeach ; ?>
      </select>
  </div>
  <button type="submit" class="btn btn-primary">Обновить</button>
</form>
@endsection 