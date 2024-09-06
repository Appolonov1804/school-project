@extends('layouts.admin')

@section('content')

<style>
    table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 20px;
    }

    th, td {
        padding: 8px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }

    .students-list ul {
        list-style-type: none;
        padding: 0;
    }

    .students-list table {
        width: 100%;
        border-collapse: collapse;
    }

    .students-list th, .students-list td {
        padding: 8px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }
</style>

<a class="dropdown-item" href="{{ route('logout') }}"
    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
    {{ __('Logout') }}
</a>

<div>
    <a href="{{ route('teachers.edit', $teacher->id) }}">Изменить имя преподавателя</a>
</div>

<div>
    <form action="{{ route('teachers.delete', $teacher->id) }}" method="post">
        @csrf
        @method('delete')
        <input type="submit" value="Удалить преподавателя" class="btn btn-danger">
    </form>
</div>

<div>
    <div>{{ $teacher->email }}</div>
    <div>{{ $teacher->name }}</div>
    <div>Позиция: {{ $teacher->position }} teacher</div>
</div>

<div>
    <h2>Группы учителя {{ $teacher->name }}</h2>

    @if (!empty($groups) && $groups->isNotEmpty())
        @foreach($groups as $group)
            <div>
                <h3>{{ $group->name }}</h3>
                <p><strong>Курс:</strong> {{ $group->course }}</p>
                <p><strong>{{ $group->schedule }}</strong></p>
                <div class="students-list">
                    <strong>Студенты:</strong>
                    <table>
                        <tbody>
                            @foreach ($group->students as $student)
                                <tr>
                                    <td>{{ $student->student }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <table>
                    <thead>
                        <tr>
                            <th>Дата</th>
                            <th>Время</th>
                            <th>Тема</th>
                            <th>Посещаемость</th>
                            <th>Баллы</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($group->groupLessons as $groupLesson)
                            <tr>
                                <td>{{ $groupLesson->date }}</td>
                                <td>{{ $groupLesson->time }} минут</td>
                                <td>{{ $groupLesson->topic }}</td>
                                <td>
                                    <ul>
                                        @foreach ($groupLesson->students as $student)
                                            <li>{{ $student->student }} - {{ $student->pivot->attendance ?? 'N/A' }}</li>
                                        @endforeach
                                    </ul>
                                </td>
                                <td>
                                    <ul>
                                        @foreach ($groupLesson->students as $student)
                                            @if ($student->pivot->score)
                                            <li>{{ $student->pivot->score }}</li>
                                            @endif
                                        @endforeach
                                    </ul>
                                </td>
                                <td>
                                    <a href="{{ route('groupsLessons.edit', ['group' => $group->id, 'group_lesson_id' => $groupLesson->id, 'page' => request()->get('page', 1)]) }}">Редактировать урок</a>
                                    <form action="{{ route('groupsLessons.delete', ['group' => $group->id, 'group_lesson_id' => $groupLesson->id, 'page' => request()->get('page', 1)]) }}" method="post">
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
                    <a href="{{ route('groupsLessons.create', ['group' => $group->id, 'page' => request()->get('page', 1)]) }}">Отметить урок</a>
                    <br>
                    <a href="{{ route('groups.edit', ['group' => $group->id, 'page' => request()->get('page', 1)]) }}">Редактировать журналы</a>
                    <form action="{{ route('groups.delete', ['group' => $group->id, 'page' => request()->get('page', 1)]) }}" method="post">
                        @csrf
                        @method('delete')
                        <input type="submit" value="Удалить журнал" class="btn btn-danger">
                    </form>
                </div>
            </div>
        @endforeach
    @else
        <p>У этого преподавателя пока нет групп.</p>
    @endif  
</div>
<div>
    {{ $groups->appends(['page' => request()->get('page', 1)])->links('vendor.pagination.bootstrap-4') }}
</div>
<div>
    <a href="{{ route('groups.create', ['page' => request()->get('page', 1)]) }}">Добавить групповой журнал</a>
</div>

<div>
    <a href="{{ route('teachers.reportShow', $teacher) }}">Отчёты учителя</a>
</div>

<div>
    <a href="{{ route('teachers.show', ['teacher' => $teacher->id]) }}">Назад</a>
</div>

@endsection
