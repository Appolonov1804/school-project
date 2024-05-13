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
<form action="{{ route('groupLessons.updateLesson', ['group' => $group->id, 'lesson' => $lesson->id]) }}" method="post">
    @csrf
    @method('PATCH')  <!-- Используем метод PUT для отправки запроса обновления -->

    <!-- Поля для редактирования данных урока -->
    <div class="form-group">
        <label for="inputDate">Дата</label>
        <input type="date" class="form-control" id="inputDate" name="date" value="{{ $lesson->date }}">
    </div>
    <div class="form-group">
        <label for="inputTopic">Тема</label>
        <input type="text" class="form-control" id="inputTopic" name="topic" value="{{ $lesson->topic }}">
    </div>
    <div class="form-group">
        <label for="inputTime">Длительность урока</label>
        <select class="form-control" id="inputTime" name="time">
            <option value="40" {{ $lesson->time == 40 ? 'selected' : '' }}>40 минут</option>
            <option value="60" {{ $lesson->time == 60 ? 'selected' : '' }}>60 минут</option>
            <option value="90" {{ $lesson->time == 90 ? 'selected' : '' }}>90 минут</option>
        </select>
    </div>

    <!-- Поля для редактирования посещаемости студентов -->
    @foreach ($lesson->students as $student)
    <div class="form-group">
        <label for="inputAttendance_{{ $student->id }}">Посещаемость для {{ $student->student }}</label><br>
        <input type="text" class="form-control" id="inputAttendance_{{ $student->id }}" name="attendance[{{ $student->id }}][attendance]" value="{{ $student->pivot->attendance }}">
        <!-- Добавляем скрытое поле для отправки идентификатора студента -->
        <input type="hidden" name="attendance[{{ $student->id }}][student_id]" value="{{ $student->id }}">
    </div>
    @endforeach

    <button type="submit" class="btn btn-primary">Сохранить</button>
</form>
@endsection