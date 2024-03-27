@extends('layouts.admin')

@section('content')
<form action="{{ route('rosters.saveDetails', $roster->id) }}" method="post">
    @csrf
    @method('PATCH')
    <input type="hidden" name="roster_id" value="{{ $roster->id }}">
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
        <input type="text" class="form-control" id="inputAttendance" name="attendance" placeholder="был, была, не было">
    </div>
    <button type="submit" class="btn btn-primary">Отметить</button>
</form>
@endsection