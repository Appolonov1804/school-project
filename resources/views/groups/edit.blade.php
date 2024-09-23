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
    .student-input {
        justify-content: flex-end;
    }
</style>
<form action="{{ route('groups.update', $group->id) }}" method="post">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    @method('patch')
    <input type="hidden" name="page" value="{{ $groupPage }}">
    <div class="form-group" id="studentsContainer">
        <label for="inputStudents">Студенты</label>
        @foreach ($group->students as $student)
        <div class="student-input">
            <input type="text" class="form-control" name="students[{{ $student->id }}]" value="{{ $student->student }}">
            <button type="button" class="btn btn-danger remove-student">Удалить</button>
        </div>
        @endforeach
    </div>
    <button type="button" id="addStudent" class="btn btn-secondary">Добавить студента</button>
    <div class="form-group">
        <label for="inputCourse">Курс</label>
        <input type="text" class="form-control" id="inputCourse" placeholder="Введите курс студента" name="course" value="{{ $group->course }}">
    </div>
    <div class="form-group">
        <label for="inputSchedule">Расписание</label>
        <input type="text" class="form-control" id="inputSchedule" name="schedule" placeholder="Введите расписание студента" value="{{ $group->schedule }}">
    </div>
    <input type="hidden" name="teachers_id" value="{{ $group->teachers_id }}">

    <button type="submit" class="btn btn-primary">Обновить</button>
</form>
<script>
   document.getElementById('studentsContainer').addEventListener('click', function(e) {
        if (e.target && e.target.classList.contains('remove-student')) {
            if (confirm('Вы уверены, что хотите удалить студента?')) {
                e.target.parentElement.remove();
            }
        }
    });
    document.getElementById('addStudent').addEventListener('click', function() {
        var container = document.getElementById('studentsContainer');
        var newStudentInput = document.createElement('div');
        newStudentInput.classList.add('form-group', 'student-input');
        newStudentInput.innerHTML = `
            <input type="text" class="form-control" name="new_students[]" placeholder="Введите студента">
            <button type="button" class="btn btn-danger remove-student">Удалить</button>
        `;
        container.appendChild(newStudentInput);
    });
</script>
@endsection
