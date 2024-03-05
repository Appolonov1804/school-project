<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="/resources/css/app.css">
</head>
<body>
<form action="{{ route('rosters.update', $roster->id) }}" method="post"> 
<input type="hidden" name="_token" value="{{ csrf_token() }}">
@method('patch')

  <div class="form-group">
    <label for="inputName">Студент</label>
    <input type="text" class="form-control" id="inputName" placeholder="Введите имя студента" name="student" value=" {{ $roster->student }}">
  </div>
  <br>
  <div class="form-group">
    <label for="inputCourse">Курс</label>
    <input type="text" class="form-control" id="inputCourse" placeholder="Введите курс студента" name="course" value=" {{ $roster->course }}">
  </div>
  <br>
  <div class="form-group">
    <label for="inputTopic">Тема</label>
    <input type="text" class="form-control" id="inputTopic" placeholder="Введите тему урока" name="topic" value=" {{ $roster->topic }}">
  </div>
  <br>
  <div class="form-group">
    <label for="inputDate">Дата</label>
    <input type="date" class="form-control" id="inputDate" placeholder="Введите дату" name="date" value=" {{ $roster->date }}">
  </div>
  <br>
  <div class="form-group">
    <label for="inputAttendance">Посещаемость</label>
    <input type="text" class="form-control" id="inputAttendance" placeholder="был, была, не было" name="attendance" value=" {{ $roster->attendance }}">
  </div>
  <button type="submit" class="btn btn-primary">Обновить</button>
</form>
</body>
</html>