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
<form action="{{ route('groups.store') }}" method="post">
    @csrf
    <div id="studentsContainer">
    <div class="form-group">
        <label for="inputStudent">Студент</label>
        <input type="text" class="form-control" id="inputStudent" name="students[]" placeholder="Введите имя студента">
    </div>
    </div>
    <div class="form-group">
        <label for="inputCourse">Курс</label>
        <input type="text" class="form-control" id="inputCourse" name="course" placeholder="Введите курс студента">
    </div>

    @if(auth()->user()->teacher)
        <input type="hidden" name="teachers_id" value="{{ auth()->user()->teacher->id }}">
    @endif
    <button type="button" id="addStudent" class="btn btn-primary">Добавить студента</button>
    <button type="submit" class="btn btn-primary">Добавить группу</button>
</form>

<script>
    document.getElementById('addStudent').addEventListener('click', function() {
        var container = document.getElementById('studentsContainer');
        var newStudentInput = document.createElement('div');
        newStudentInput.classList.add('form-group', 'student-input');
        newStudentInput.innerHTML = '<label for="inputStudents">Студенты</label><input type="text" class="form-control" name="students[]" placeholder="Введите имя студента">';
        container.appendChild(newStudentInput);
    });
</script>
@endsection