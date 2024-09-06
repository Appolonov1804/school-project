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
<div>
    <div> {{ $teacher->email }}</div>
    <div>{{ $teacher->name }}</div>
</div>

<div>
    @if ($reports->isEmpty())
        <p>Нет доступных отчётов</p>
    @else
        <table>
            <thead>
                <tr>

                    <th>Ученик</th>
                    <th>Курс</th>
                    <th>Тема</th>
                    <th>Дата</th>
                    <th>Описание занятия</th>
                    <th>Комментарии</th>
                </tr>
            </thead>
            <tbody>
                @foreach($reports as $report)
                    <tr>

                        <td>{{ $report->student }}</td>
                        <td>{{ $report->course }}</td>
                        <td>{{ $report->topic }}</td>
                        <td>{{ $report->date }}</td>
                        <td>{{ $report->lesson_description }}</td>
                        <td>{{ $report->comments }}</td>
                        <td><a href="{{ route('reports.edit', ['report' => $report->id, 'page' => request()->get('page', 1)]) }}">Редактировать отчёты</a></td>

                        <td><form action="{{ route('reports.delete', [$report->id, 'page' => request()->get('page', 1)]) }}" method="post">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                @method('delete')
                                <input type="submit" value="Удалить" class="btn btn-danger">
                        </form></td>
                    </tr>
                @endforeach

            </tbody>
        </table>

    @endif

</div>
    <div>
        {{ $reports->appends(['page' => request()->get('page', 1)])->links('vendor.pagination.bootstrap-4') }}
    </div>
<div>
    <a href="{{ route('reports.create', ['page' => request()->get('page', 1)]) }}">Добавить отчёт</a>
</div>

<div>
    <a href="{{ route('teachers.show', ['teacher' => $teacher->id]) }}">Назад</a>
</div>
@endsection
