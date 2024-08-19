@extends('layouts.admin')

@section('content')


<style>
    table {
        border-collapse: collapse;
        width: 100%;
    }

    th,
    td {
        padding: 5px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }
</style>
<a class="dropdown-item" href="{{ route('logout') }}"
    onclick="event.preventDefault();
    document.getElementById('logout-form').submit();">
    {{ __('Logout') }}
</a>
<div>
    <a href="{{ route('teachers.edit', $teacher->id) }}">Изменить имя преподавателя</a>
</div>
<div>
    <form action="{{ route('teachers.delete', $teacher->id) }}" method="post">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        @method('delete')
        <input type="submit" value="Удалить преподавателя" class="btn btn-danger">
    </form>
</div>
<div>
    <div> {{ $teacher->email }}</div>
    <div>{{ $teacher->name }}</div>
    <div>Позиция: {{ $teacher->position }} teacher</div>
</div>
<div>
    <h2>Журналы учителя {{ $teacher->name }}</h2>
    @if ($rosters->isNotEmpty())
        @foreach($rosters as $roster)
            <h3>{{ $roster->student }}</h3>
            <table>
                <thead>
                    <tr>
                        <th>Курс</th>
                        <th>Время</th>
                        <th>Дата</th>
                        <th>Тема</th>
                        <th>Посещение</th>
                        
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{ $roster->course }}</td>
                        <td>{{ $roster->time }} минут</td>
                    </tr>
                    @foreach($roster->lessonDetails as $lessonDetail)
                        <tr>
                            <td></td>
                            <td></td> 
                            <td>{{ $lessonDetail->date }}</td>
                            <td>{{ $lessonDetail->topic }}</td>
                            <td>{{ $lessonDetail->attendance }}</td>
                            <td><a href="{{ route('lessons.edit', ['roster' => $roster->id, 'lesson_id' => $lessonDetail->id]) }}">Редактировать урок</a></td>
                            <td>
                            <form action="{{ route('lessons.delete', ['roster' => $roster->id, 'lesson_id' => $lessonDetail->id]) }}" method="post">
                                @csrf
                                @method('delete')
                                <input type="submit" value="Удалить урок" class="btn btn-danger">
                            </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div>
                <a href="{{ route('lessons.create', ['roster' => $roster->id]) }}">Отметить урок {{ $roster->student }}</a>
            </div>
            <div>
                <a href="{{ route('rosters.edit', $roster->id) }}">Редактировать журналы {{ $roster->student }}</a>
            </div>
            <div>
                <form action="{{ route('rosters.delete', $roster->id) }}" method="post">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    @method('delete')
                    <input type="submit" value="Удалить журнал" class="btn btn-danger">
                </form>
            </div>
        @endforeach
    @else
        <p>У этого преподавателя пока нет журналов.</p>
    @endif
</div>
<div>
    {{ $rosters->links() }}
</div>
<div>
    <a href="{{ route('rosters.create') }}">Добавить индивидуальный журнал</a>
</div>
<div>
    <a href="{{ route('groups.show', $teacher) }}">Группы</a>
</div>
<div>
    <a href="{{ route('teachers.reportShow', $teacher) }}">Отчёты учителя</a>
</div>
<div>
    <a href="{{ route('teachers.show', ['teacher' => $teacher->id]) }}">Назад</a>
</div>
<div>
    <h4>Заработано: {{ $totalSalary }}</h4>
</div>
<form method="POST" action="{{ route('teachers.resetSalary', ['teacher' => $teacher->id]) }}">
    @csrf
    <button type="submit">Обнулить зарплату</button>
</form>
@endsection
