@extends('layouts.admin')

@section('content')
<style>
    input:-webkit-autofill,
input:-webkit-autofill:hover,
input:-webkit-autofill:focus,
textarea:-webkit-autofill,
textarea:-webkit-autofill:hover,
textarea:-webkit-autofill:focus,
select:-webkit-autofill,
select:-webkit-autofill:hover,
select:-webkit-autofill:focus {
  border: 1px solid green;
  -webkit-text-fill-color: green;
  -webkit-box-shadow: 0 0 0px 1000px #000 inset;
  transition: background-color 5000s ease-in-out 0s;
}
</style>
<form action="{{ route('teachers.update', $teacher->id) }}" method="post">
<input type="hidden" name="_token" value="{{ csrf_token() }}">
@method('patch')
  <div class="form-group">
    <label for="name">Имя</label>
    <input type="text" class="form-control" id="inputName" name="name" placeholder="Введите имя" value="{{ $teacher->name }}">
    <br><br>
    <label for="exampleInputEmail1">Email</label>
    <input type="email" class="form-control" id="exampleInputEmail1" name="email" placeholder="Введите email" value="{{ $teacher->email }}">
  </div>
  <div class="form-group">
    <label for="position">Выберите позицию</label>
    <select id="position" name="position">
        <option value="junior">Младший преподаватель</option>
        <option value="senior">Старший преподаватель</option>
    </select>
  </div>
  <button type="submit" class="btn btn-primary">Обновить</button>
</form>

@endsection
