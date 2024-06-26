@extends('layouts.admin')

@section('content')
    <a class="dropdown-item" href="{{ route('logout') }}"
        onclick="event.preventDefault();
        document.getElementById('logout-form').submit();">
            {{ __('Logout') }}
    </a>
    <div>
        <div>
            <?php foreach ($rosters as $roster) : ?>
            <div>
                <div><a href="{{ route('rosters.show', $roster->id) }}">{{ $roster->student }}</a></div>
                <div>{{ $roster->teachers_id }}. {{ $roster->course }}. {{ $roster->topic }}. {{ $roster->date }}. {{ $roster->attendance }}</div>
            
            </div>
            <?php endforeach ; ?>
        </div>
        <div>
            <a href="{{ route('rosters.create') }}">Создать журнал</a>
        </div>
    </div>

@endsection