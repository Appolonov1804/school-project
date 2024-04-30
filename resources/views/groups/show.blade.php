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
    <h2>Группы учителя {{ $teacher->name }}</h2>
    @if (!empty($groups) && $groups->isNotEmpty())
    @foreach($groups as $group)
    <h3>{{ $group->name }}</h3>
    <table>
    <thead>
        <tr>
            <th>Курс</th>
            <th>Время</th>
            <th>Дата</th>
            <th>Тема</th>
            <th>Студенты</th>
            <th>Посещаемость</th>
            <th>Действия</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($group->groupLessons as $groupLesson)
        <tr>
            <td>{{ $group->course }}</td>
            <td>{{ $groupLesson->time }} минут</td>
            <td>{{ $groupLesson->date }}</td>
            <td>{{ $groupLesson->topic }}</td>
            <td>
                @if ($groupLesson->students->isNotEmpty())
                    @foreach ($groupLesson->students as $student)
                        {{ $student->student }}
                        @if (!$loop->last)
                            <hr style="border-top: 1px solid #ddd; margin: 2px 0;">
                        @endif
                    @endforeach
                @else
                    Нет студентов
                @endif
            </td>
            <td>
                @foreach ($groupLesson->students as $student)
                    {{ $student->pivot->attendance ?? 'N/A' }}
                    @if (!$loop->last)
                        <hr style="border-top: 1px solid #ddd; margin: 2px 0;">
                    @endif
                @endforeach
            </td>
            <td>
                <a href="{{ route('groupsLessons.edit', ['group' => $group->id, 'group_lesson_id' => $groupLesson->id]) }}">Редактировать урок</a>
                <form action="{{ route('groupsLessons.delete', ['group' => $group->id, 'group_lesson_id' => $groupLesson->id]) }}" method="post">
                    @csrf
                    @method('delete')
                    <button type="submit" class="btn btn-danger">Удалить урок</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
    <div>
        <a href="{{ route('groupsLessons.create', ['group' => $group->id]) }}">Отметить урок</a>
    </div>
    <div>
        <a href="{{ route('groups.edit', $group->id) }}">Редактировать журналы</a>
    </div>
    <div>
        <form action="{{ route('groups.delete', $group->id) }}" method="post">
            @csrf
            @method('delete')
            <input type="submit" value="Удалить журнал" class="btn btn-danger">
        </form>
    </div>
@endforeach 
    @else
        <p>У этого преподавателя пока нет групп.</p>
    @endif
</div>

<div>
    <a href="{{ route('groups.create') }}">Добавить групповой журнал</a>
</div>
<div>
    <a href="{{ route('teachers.reportShow', $teacher) }}">Отчёты учителя</a>
</div>
<div>
    <a href="{{ route('teachers.show', ['teacher' => $teacher->id]) }}">Назад</a>
</div>

@endsection