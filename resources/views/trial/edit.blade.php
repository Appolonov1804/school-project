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
<form action="{{ route('trial.update', ['trialLesson' => $trialLesson->id]) }}" method="post">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    @method('patch')
    <input type="hidden" name="page" value="{{ $page }}">

    <div class="form-group">
        <label for="inputDate">Дата</label>
        <input type="date" class="form-control" id="inputDate" name="date" placeholder="Введите дату" value="{{ $trialLesson->date }}">
    </div>

    <div class="form-group">
        <label for="inputStudent">Студент</label>
        <input type="text" class="form-control" id="inputStudent" name="student" placeholder="Введите имя студента" value="{{ $trialLesson->student }}">
    </div>

    <div class="form-group">
        <label for="inputCourse">Курс</label>
        <input type="text" class="form-control" id="inputCourse" name="course" placeholder="Введите курс студента" value="{{ $trialLesson->course }}">
    </div>

    <div class="form-group">
        <label for="inputType">Формат</label>
        <select class="form-control" id="inputType" name="type">
            <option value="Индивидуальный" {{ old('type', $trialLesson->type ?? '') == 'Индивидуальный' ? 'selected' : '' }}>Индивидуальный</option>
            <option value="Группа" {{ old('type', $trialLesson->type ?? '') == 'Группа' ? 'selected' : '' }}>Группа</option>
            <option value="Мини-группа" {{ old('type', $trialLesson->type ?? '') == 'Мини-группа' ? 'selected' : '' }}>Мини-группа</option>
        </select>
    </div>

    <div class="form-group">
        <label for="inputTime">Длительность урока</label>
        <select class="form-control" id="inputTime" name="time">
            <option value="30" {{ old('time', $trialLesson->time ?? '') == '30' ? 'selected' : '' }}>30 минут</option>
            <option value="40" {{ old('time', $trialLesson->time ?? '') == '40' ? 'selected' : '' }}>40 минут</option>
            <option value="60" {{ old('time', $trialLesson->time ?? '') == '60' ? 'selected' : '' }}>60 минут</option>
            <option value="90" {{ old('time', $trialLesson->time ?? '') == '90' ? 'selected' : '' }}>90 минут</option>
        </select>
    </div>

    <div class="form-group">
        <label for="inputForm">Вид урока</label>
        <select class="form-control" id="inputForm" name="form">
            <option value="Пробный" {{ old('form', $trialLesson->form ?? '') == 'Пробный' ? 'selected' : '' }}>Пробный</option>
            <option value="Студент записался" {{ old('form', $trialLesson->form ?? '') == 'Студент записался' ? 'selected' : '' }}>Студент записался</option>
            <option value="Замена" {{ old('form', $trialLesson->form ?? '') == 'Замена' ? 'selected' : '' }}>Замена</option>
            <option value="Отработка" {{ old('form', $trialLesson->form ?? '') == 'Отработка' ? 'selected' : '' }}>Отработка</option>
        </select>
    </div>

    @if(auth()->user()->teacher)
        <input type="hidden" name="teachers_id" value="{{ auth()->user()->teacher->id }}">
    @endif
    <button type="submit" class="btn btn-primary">Добавить</button>
</form>
@endsection
