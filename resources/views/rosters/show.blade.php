@extends('layouts.admin')
    <style>
        .salary-container {
            justify-content: flex-end;
        }
    </style>
@section('content')
<div>
    <a href="{{ route('groups.show', $teacher) }}">Группы</a>
</div>
<div>
    <a href="{{ route('trial.show', $teacher) }}">Пробные уроки</a>
</div>
<div>
    <a href="{{ route('teachers.edit', $teacher->id) }}">Изменить имя преподавателя</a>
</div>
    <h1>Список журналов учителя {{ $teacher->name }}</h1>

    @if ($rosters->isNotEmpty())
        <ul>
            @foreach($rosters as $roster)
                <li>
                    <a href="{{ route('teachers.showRosters', ['teacher' => $teacher->id, 'roster' => $roster->id]) }}">{{ $roster->student }} - {{ $roster->course }}</a>
                </li>
            @endforeach
        </ul>
        {{ $rosters->links() }}
    @else
        <p>У этого преподавателя пока нет журналов.</p>
    @endif

    <a href="{{ route('teachers.show', $teacher) }}">Главная страница</a>

<div>
    <h4>Заработано: {{ $totalSalary }}</h4>
</div>
<div class="salary-container">
    <form method="POST" action="{{ route('teachers.resetSalary', ['teacher' => $teacher->id]) }}" onsubmit="return resetSalary()">
        @csrf
        <button type="submit">Обнулить зарплату</button>
    </form>
</div>
<script>
    function resetSalary() {
        return confirm('Обнулить зарплату?');
    }
</script>
@endsection

