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
  <button type="submit" class="btn btn-primary">Добавить</button>
</form>
@endsection