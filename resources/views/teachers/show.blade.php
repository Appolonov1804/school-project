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
    .link-container {
        display: flex;
        gap: 10px;
        align-items: center;
    }
    .form-container {
        text-align: right;
        justify-content: flex-end;
    }
    .lesson-container {
        justify-content: flex-end;
    }
    .salary-container {
        justify-content: flex-end;
    }
</style>
<a class="dropdown-item" href="{{ route('logout') }}"
    onclick="event.preventDefault();
    document.getElementById('logout-form').submit();">
    {{ __('Logout') }}
</a>
<div>
<a href="{{ route('rosters.show', ['teacher' => $teacher->id]) }}" class="nav-link">
    <i class="fa-solid fa-user"></i>
    <p>Студенты</p>
</a>
</div>
<div class="link-container">
    <a href="{{ route('groups.show', $teacher) }}">Группы</a>
    <a href="{{ route('trial.show', $teacher) }}">Пробные уроки</a>
    <a href="{{ route('rosters.create', ['page' => request()->get('page', 1)]) }}">Добавить индивидуальный журнал</a>
    <a href="{{ route('teachers.reportShow', $teacher) }}">Отчёты учителя</a>
    <a href="{{ route('rosters.showSchedule', [$teacher->id]) }}">Расписание</a>
</div>
<div>
    <a href="{{ route('teachers.edit', $teacher->id) }}">Изменить имя</a>
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
            <h3>{{ $roster->student }}: @if ($roster->courseTypes && $roster->courseTypes->name === 'Персональный') Персональный @endif</h3>
            <h5>{{ $roster->schedule }}</h5>
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
                            <td>
                                {{ $lessonDetail->attendance }}
                            @if ($lessonDetail->paid === 1)
                                оплачено
                            @endif
                            </td>
                            <td>{{ $lessonDetail->score }}</td>

                            <td><a href="{{ route('lessons.edit', ['roster' => $roster->id, 'lesson_id' => $lessonDetail->id, 'page' => request()->get('page', 1)]) }}">Редактировать урок</a></td>
                            <td><a href="{{ route('reports.create', [
                                'report' => $report->id,
                                'lesson_id' => $lessonDetail->id,
                                'roster' => $roster->id,
                                'page' => request()->get('page', 1),
                                'student' => $roster->student,
                                'course' => $roster->course,
                                'date' => $lessonDetail->date,
                                'topic' => $lessonDetail->topic,
                                ]) }}">Отчёт</a></td>
                            <td>
                            <div class="lesson-container">
                                <form action="{{ route('lessons.delete', ['roster' => $roster->id, 'lesson_id' => $lessonDetail->id, 'page' => request()->get('page', 1)]) }}" method="post" onsubmit="return lessonDelete()">
                                    @csrf
                                    @method('delete')
                                    <input type="submit" value="Удалить урок" class="btn btn-danger">
                                </form>
                            </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div>
                <a href="{{ route('lessons.create', ['roster' => $roster->id, 'page' => request()->get('page', 1)]) }}">Отметить урок {{ $roster->student }}</a>
            </div>
            <div>
                <a href="{{ route('rosters.edit', ['roster' => $roster->id, 'page' => request()->get('page', 1)]) }}">Редактировать журналы {{ $roster->student }}</a>
            </div>
            <div class="lesson-container">
                <form action="{{ route('rosters.delete', [$roster->id, 'page' => request()->get('page', 1)]) }}" method="post" onsubmit="return lessonDelete()">
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
    {{ $rosters->appends(['page' => request()->get('page', 1)])->links('vendor.pagination.bootstrap-4') }}
</div>
<div>
    <a href="{{ route('teachers.show', ['teacher' => $teacher->id]) }}">Назад</a>
</div>
<div>
    <h4>Заработано: {{ $totalSalary }}</h4>
</div>
<div class="salary-container">
<form method="POST" action="{{ route('teachers.resetSalary', ['teacher' => $teacher->id]) }}" onsubmit="return resetSalary()">
    @csrf
    <button type="submit">Обнулить зарплату</button>
</form>
</div>
<div class="form-container">
    <form action="{{ route('teachers.delete', $teacher->id) }}" method="post" onsubmit="return confirmDelete()">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        @method('delete')
        <input type="submit" value="Удалить аккаунт" class="btn btn-danger">
    </form>
</div>

<script>
    function confirmDelete() {
        return confirm('Вы уверены, что хотите удалить Ваш аккаунт?');
    }

    function lessonDelete() {
        return confirm('Подтвердите удаление');
    }
    function resetSalary() {
        return confirm('Обнулить зарплату?');
    }
</script>
@endsection
