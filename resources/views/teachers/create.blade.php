@extends('layouts.admin')

@section('content')
<form action="{{ route('teachers.store') }}" method="post">
<input type="hidden" name="_token" value="{{ csrf_token() }}">
  <div class="form-group">
    <label for="name">Имя</label>
    <input type="text" class="form-control" id="inputName" name="name" placeholder="Введите имя">
    <br><br>
    <label for="exampleInputEmail1">Email</label>
    <input type="email" class="form-control" id="exampleInputEmail1" name="email" placeholder="Введите email">
  </div>
  <div class="form-group">
    <label for="exampleInputPassword1">Пароль</label>
    <input type="password" class="form-control" id="exampleInputPassword1" name="password" placeholder="Пароль">
  </div>
  <div class="form-group">
    <label for="exampleInputPassword2">Подтверждение пароля</label>
    <input type="password" class="form-control" id="exampleInputPassword2" name="password_confirmation" placeholder="Подтвердите пароль">
  </div>
  <button type="submit" class="btn btn-primary">Добавить</button>
</form>
        
@endsection