@extends('layouts.admin')

@section('content')
<style>
    table {
        border-collapse: collapse;
        width: 100%;
    }

    th, td {
        padding: 5px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }
</style>
<div>
    <div>{{ $teacher->email }}</div>
    <div>{{ $teacher->name }}</div>
</div>

<div>
    @if ($trialLessons->count() === 0)
        <p>Нет пробных уроков</p>
    @else
        <table>
            <thead>
                <tr>
                    <th>Дата</th>
                    <th>Студент</th>
                    <th>Курс</th>
                    <th>Формат</th>
                    <th>Время</th>
                    <th>Вид урока</th>
                    <th>Редактировать</th>
                    <th>Удалить</th>
                </tr>
            </thead>
            <tbody>
                @foreach($trialLessons as $trialLesson)
                    <tr>
                        <td>{{ $trialLesson->date }}</td>
                        <td>{{ $trialLesson->student }}</td>
                        <td>{{ $trialLesson->course }}</td>
                        <td>{{ $trialLesson->type }}</td>
                        <td>{{ $trialLesson->time }}</td>
                        <td>{{ $trialLesson->form }}</td>
                        <td><a href="{{ route('trial.edit', ['trialLesson' => $trialLesson->id, 'page' => request()->get('page', 1)]) }}">Редактировать урок</a></td>
                        <td>
                            <form action="{{ route('trial.delete', [$trialLesson->id, 'page' => request()->get('page', 1)]) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <input type="submit" value="Удалить" class="btn btn-danger">
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>

<div>
    {{ $trialLessons->appends(['page' => request()->get('page', 1)])->links('vendor.pagination.bootstrap-4') }}
</div>

<div>
    <a href="{{ route('trial.create', ['page' => request()->get('page', 1)]) }}">Добавить пробный урок</a>
</div>

<div>
    <a href="{{ route('teachers.show', ['teacher' => $teacher->id]) }}">Назад</a>
</div>
@endsection
