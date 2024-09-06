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
<form action="{{ route('trial.store') }}" method="post">
    @csrf
    <input type="hidden" name="page" value="{{ $page }}">
    <div class="form-group">
        <label for="inputDate">Дата</label>
        <input type="date" class="form-control" id="inputDate" name="date" placeholder="Введите дату">
    </div>
    <div class="form-group">
        <label for="inputStudent">Студент</label>
        <input type="text" class="form-control" id="inputStudent" name="student" placeholder="Введите имя студента">
    </div>
    <div class="form-group">
        <label for="inputCourse">Курс</label>
        <input type="text" class="form-control" id="inputCourse" name="course" placeholder="Введите курс студента">
    </div>
    <div class="form-group">
        <label for="inputType">Формат</label>
        <select class="form-control" id="inputType" name="type">
            <option value="Индивидуальный">Индивидуальный</option>
            <option value="Группа">Группа</option>
            <option value="Мини-группа">Мини-группа</option>
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
        <label for="inputForm">Вид урока</label>
        <select class="form-control" id="inputForm" name="form">
            <option value="Пробный">Пробный</option>
            <option value="Замена">Замена</option>
            <option value="Отработка">Отработка</option>

    </div>
    @if(auth()->user()->teacher)
        <input type="hidden" name="teachers_id" value="{{ auth()->user()->teacher->id }}">
    @endif
    <button type="submit" class="btn btn-primary">Добавить</button>
</form>
@endsection
