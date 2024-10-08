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
<form action="{{ route('membership.store') }}" method="post">
    @csrf
    <input type="hidden" name="roster_id" value="{{ $roster->id }}">
    <div class="form-group">
        <label for="inputMembership">Оплачено уроков</label>
        <input type="text" class="form-control" id="inputMembership" name="membership">
    </div>
    <button type="submit" class="btn btn-primary">Сохранить</button>
</form>
@endsection
