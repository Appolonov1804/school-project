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
<form action="{{ route('groupsLessons.store', $group->id) }}" method="post">
    @csrf
    <input type="hidden" name="group_id" value="{{ $group->id }}">
    <input type="hidden" name="page" value="{{ $page }}">
    <div class="form-group">
        <label for="inputDate">Дата</label>
        <input type="date" class="form-control" id="inputDate" name="date" placeholder="Введите дату">
    </div>
    <div class="form-group">
        <label for="inputTopic">Тема</label>
        <input type="text" class="form-control" id="inputTopic" name="topic" placeholder="Введите тему урока">
    </div>
    <div class="form-group">
        <label for="inputTime">Длительность урока</label>
        <select class="form-control" id="inputTime" name="time">
            <option value="40">40 минут</option>
            <option value="60">60 минут</option>
            <option value="90">90 минут</option>
        </select>
    </div>
    @foreach ($group->students as $student)
    <div class="form-group">
        <label for="inputAttendance_{{ $student->id }}">Посещаемость для {{ $student->student }}</label><br>
        <select class="form-control" id="inputAttendance_{{ $student->id }}" name="attendance[{{ $student->id }}][attendance]">
            <option>был/была</option>
            <option>не было</option>
        </select>
        <input type="hidden" name="attendance[{{ $student->id }}][student_id]" value="{{ $student->id }}">
    </div>
    @endforeach

    @foreach ($group->students as $student)
    <div class="form-group">
        <label for="inputScore_{{ $student->id }}">Баллы для {{ $student->student }}</label><br>
        <input type="text" class="form-control" id="inputScore_{{ $student->id }}" name="score[{{ $student->id }}][score]">
    </div>
    @endforeach

    <button type="submit" class="btn btn-primary">Отметить</button>
</form>
@endsection
