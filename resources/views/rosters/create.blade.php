
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="/styles.css">
</head>
<body>
<form action="{{ route('rosters.store') }}" method="post">
<input type="hidden" name="_token" value="{{ csrf_token() }}">
    <div class="form-group">
    <label for="InputStudent">Студент</label>
    <input type="text" class="form-control" id="inputStudent" name="student" placeholder="Введите имя студента">
  </div>
  <br>
  <div class="form-group">
    <label for="inputCourse">Курс</label>
    <input type="text" class="form-control" id="inputCourse" name="course" placeholder="Введите курс студента">
  </div>
  <br>
  <div class="form-group">
    <label for="inputTopic">Тема</label>
    <input type="text" class="form-control" id="inputTopic" name="topic" placeholder="Введите тему урока">
  </div>
  <br>
  <div class="form-group">
    <label for="inputDate">Дата</label>
    <input type="date" class="form-control" id="inputDate" name="date" placeholder="Введите дату">
  </div>
  <br>
  <div class="form-group">
    <label for="inputAttendance">Посещаемость</label>
    <input type="text" class="form-control" id="inputAttendance" name="attendance" placeholder="был, была, не было">
  </div>
  <br>
  <button type="submit" class="btn btn-primary">Добавить</button>
</form>
        
</body>
</html>
</body>
</html>