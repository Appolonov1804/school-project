@extends('layouts.admin')
@section('content')

<h1>Расписание студентов</h1>
    <div>
        <table>
            <tr>
                <th>Индивидуальные</th>
            </tr>
            @foreach ($rosters as $roster)
            <tr>
                <td>{{ $roster->student }}:
                    @if (!empty($roster->schedule))
                    {{ $roster->schedule }}
                    @else Расписание не указано
                @endif
                </td>
            </tr>
            @endforeach
                <tr>
                    <th>Группы</th>
                </tr>
            @foreach ($groups as $group)
                <tr>
                    <td>{{ $group->course }} {{ $group->schedule }}</td>
                </tr>
            @endforeach
        </table>
    </div>
    <div>
        <a href="{{ route('teachers.show', ['teacher' => $teacher->id]) }}">Назад</a>
    </div>
@endsection
