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
            <label for="inputAttendance">Посещаемость для {{ $student->student }}</label>
            <input type="text" class="form-control" id="inputAttendance" name="attendance[]" placeholder="был, была, не было">
            <input type="hidden" name="student_id[]" value="{{ $student->id }}">
        </div>
    @endforeach
    <button type="submit" class="btn btn-primary">Отметить</button>
</form>
@endsection