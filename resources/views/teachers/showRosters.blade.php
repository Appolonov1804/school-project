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
    .lesson-container {
        justify-content: flex-end;
    }
    .lesson-actions {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

</style>

<h1>Журнал: {{ $roster->student }}</h1>

<h2>Курс: {{ $roster->course }}</h2>
<p>Расписание: {{ $roster->schedule }}</p>
<p>Время: {{ $roster->time }} минут</p>

@if ($roster->lessonDetails->isNotEmpty())
    <table>
        <thead>
            <tr>
                <th>Дата</th>
                <th>Тема</th>
                <th>Посещение</th>
                <th></th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach($roster->lessonDetails as $lessonDetail)
                <tr>
                    <td>{{ $lessonDetail->date }}</td>
                    <td>{{ $lessonDetail->topic }}</td>
                    <td>
                        {{ $lessonDetail->attendance }}
                        @if ($lessonDetail->paid === 1)
                                оплачено
                        @endif
                    </td>
                    <td>{{ $lessonDetail->score }}</td>
                    <td>
                        <div class="lesson-actions">
                            <a href="{{ route('lessons.edit', ['roster' => $roster->id, 'lesson_id' => $lessonDetail->id, 'page' => request()->get('page', 1)]) }}">Редактировать урок</a>
                            <a href="{{ route('reports.create', [
                                'report' => $report->id,
                                'lesson_id' => $lessonDetail->id,
                                'roster' => $roster->id,
                                'page' => request()->get('page', 1),
                                'student' => $roster->student,
                                'course' => $roster->course,
                                'date' => $lessonDetail->date,
                                'topic' => $lessonDetail->topic,
                            ]) }}">Отчёт</a>
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
@else
    <p>Нет данных по урокам для этого журнала.</p>
@endif

<div>
    <a href="{{ route('lessons.create', ['roster' => $roster->id, 'page' => request()->get('page', 1)]) }}">Отметить урок {{ $roster->student }}</a>
</div>
<div>
    <a href="{{ route('rosters.edit', ['roster' => $roster->id, 'page' => request()->get('page', 1)]) }}">Редактировать журналы {{ $roster->student }}</a>
</div>
<div>
    <form action="{{ route('rosters.delete', [$roster->id, 'page' => request()->get('page', 1)]) }}" method="post">
        @csrf
        @method('delete')
        <input type="submit" value="Удалить журнал" class="btn btn-danger" onclick="return confirm('Вы уверены, что хотите удалить этот журнал?');">
    </form>
</div>

<div>
    <a href="{{ route('rosters.show', ['teacher' => $teacher->id]) }}">Назад к списку журналов</a>
</div>

<script>
    function lessonDelete() {
        return confirm('Подтвердите удаление');
    }
</script>
@endsection
