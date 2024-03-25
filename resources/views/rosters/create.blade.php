@extends('layouts.admin')

@section('content')
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
        <label for="teachers">Выбрать преподавателя</label>
        <select class="form-control" id="teachers" name="teachers_id">
            @foreach($teachers as $teacher)
                <option value="{{ $teacher->id }}">{{ $teacher->name }}</option>
            @endforeach
        </select>
    </div>
    <button type="submit" class="btn btn-primary">Добавить</button>
</form>
@endsection