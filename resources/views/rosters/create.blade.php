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
<form action="{{ route('rosters.store') }}" method="post">
    @csrf
    <div class="form-group">
        <label for="inputStudent">Студент</label>
        <input type="text" class="form-control" id="inputStudent" name="student" placeholder="Введите имя студента">
    </div>
    <div class="form-group">
        <label for="inputCourse">Курс</label>
        <input type="text" class="form-control" id="inputCourse" name="course" placeholder="Введите курс студента">
    </div>
    <div class="form-group">
        <label for="inputSchedule">Расписание</label>
        <input type="text" class="form-control" id="inputSchedule" name="schedule" placeholder="Введите расписание студента">
    </div>
    <div class="form-group">
        <label for="inputType">Вид курса</label>
        <select class="form-control" id="inputType" name="type_id" required>
            <option value="">Выберите вид курса</option>
            @foreach($courseTypes as $courseType)
                <option value="{{ $courseType->id }}">{{ $courseType->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group">
    <label for="inputTime">Длительность урока</label>
    <select class="form-control" id="inputTime" name="time">
        <option value="30">30 минут</option>
        <option value="40">40 минут</option>
        <option value="60">60 минут</option>
        <option value="90">90 минут</option>
    </div>
    @if(auth()->user()->teacher)
        <input type="hidden" name="teachers_id" value="{{ auth()->user()->teacher->id }}">
    @endif
    <button type="submit" class="btn btn-primary">Добавить</button>
</form>
@endsection
