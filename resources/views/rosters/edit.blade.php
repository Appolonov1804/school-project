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
<form action="{{ route('rosters.update', $roster->id) }}" method="post">
<input type="hidden" name="_token" value="{{ csrf_token() }}">
@method('patch')
<input type="hidden" name="page" value="{{ $currentPage }}">

  <div class="form-group">
    <label for="inputName">Студент</label>
    <input type="text" class="form-control" id="inputName" placeholder="Введите имя студента" name="student" value="{{ $roster->student }}">
  </div>

  <div class="form-group">
    <label for="inputCourse">Курс</label>
    <input type="text" class="form-control" id="inputCourse" placeholder="Введите курс студента" name="course" value="{{ $roster->course }}">
  </div>
  <div class="form-group">
    <label for="inputSchedule">Расписание</label>
    <input type="text" class="form-control" id="inputSchedule" name="schedule" placeholder="Введите расписание студента" value="{{ $roster->schedule ?? '' }}">
</div>
  <div class="form-group">
        <label for="inputType">Вид курса</label>
        <select class="form-control" id="inputType" name="type_id" required>
            <option value="">Выберите вид курса</option>
            @foreach($courseTypes as $courseType)
                <option value="{{ $courseType->id }}" {{ $roster->type_id == $courseType->id ? 'selected' : '' }}>
                    {{ $courseType->name }}
                </option>
            @endforeach
        </select>
    </div>
  <div class="form-group">
    <label for="inputTime">Длительность урока</label>
    <select class="form-control" id="inputTime" name="time">
        <option value="30"  {{ $roster->time == '30' ? 'selected' : '' }}>30 минут</option>
        <option value="40"  {{ $roster->time == '40' ? 'selected' : '' }}>40 минут</option>
        <option value="60"  {{ $roster->time == '60' ? 'selected' : '' }}>60 минут</option>
        <option value="90"  {{ $roster->time == '90' ? 'selected' : '' }}>90 минут</option>
    </select>
  </div>

  <input type="hidden" name="teachers_id" value="{{ $roster->teachers_id }}">
  <button type="submit" class="btn btn-primary">Обновить</button>
</form>
@endsection
