@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Speak'n go</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('Вы вошли в профиль!') }}
                    <a class="dropdown-item" href="{{ route('logout') }}"
                        onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();">
                        {{ __('Выйти') }}
                    </a>
                </div>
                <div>
                    @if ($user && $user->teacher)
                        <a href="{{ route('teachers.show', ['teacher' => $user->teacher->id]) }}">Моя страница</a>
                    @else
                        <span>У вас нет страницы</span>
                    @endif
                </div>
                    <a href="{{ route('teachers.create') }}">Добавить страницу учителя</a>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection
