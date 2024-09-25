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
<form action="{{ route('lessons.store', $roster->id) }}" method="post">
    @csrf
    <input type="hidden" name="roster_id" value="{{ $roster->id }}">
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
        <label for="inputAttendance">Посещаемость</label>
        <select type="text" class="form-control" id="inputAttendance" name="attendance">
            <option>был/была</option>
            <option>не было</option>
        </select>
    </div>
    <div class="form-group">
        <label for="inputTime">Длительность урока</label>
        <select class="form-control" id="inputTime" name="time">
            <option value="30">30 минут</option>
            <option value="40">40 минут</option>
            <option value="60">60 минут</option>
            <option value="90">90 минут</option>
        </select>
    </div>
    <div class="form-group">
        <label for="inputScore">Баллы</label>
        <input type="text" class="form-control" id="inputScore" name="score">
    </div>
    <button type="submit" class="btn btn-primary">Отметить</button>
</form>
@endsection
