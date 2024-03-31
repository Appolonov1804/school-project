@extends('layouts.admin')

@section('content')
<a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>
<div>
    <div>
        <?php foreach ($teachers as $teacher) : ?>
        <div>
        <div>{{ $teacher->id }}. {{ $teacher->email }}</div>
        <div><a href="{{ route('teachers.show', $teacher->id) }}">{{ $teacher->name }}</a></div>
        </div>
        <?php endforeach ; ?>
    </div>
    <div>
        <a href="{{ route('teachers.create') }}">Добавить учителя</a>
    </div>
   
</div>

@endsection