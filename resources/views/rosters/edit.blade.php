@extends('layouts.admin')

@section('content')
<form action="{{ route('rosters.update', $roster->id) }}" method="post"> 
<input type="hidden" name="_token" value="{{ csrf_token() }}">
@method('patch')

  <div class="form-group">
    <label for="inputName">Студент</label>
    <input type="text" class="form-control" id="inputName" placeholder="Введите имя студента" name="student" value=" {{ $roster->student }}">
  </div>

  <div class="form-group">
    <label for="inputCourse">Курс</label>
    <input type="text" class="form-control" id="inputCourse" placeholder="Введите курс студента" name="course" value=" {{ $roster->course }}">
  </div>

  <div class="form-group">
    <label for="inputTime">Длительность урока</label>
    <select class="form-control" id="inputTime" name="time">
        <option value="40"  {{ $roster->time == '40' ? 'selected' : '' }}>40 минут</option>
        <option value="60"  {{ $roster->time == '60' ? 'selected' : '' }}>60 минут</option>
        <option value="90"  {{ $roster->time == '90' ? 'selected' : '' }}>90 минут</option>
    </select>
  </div>
  
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