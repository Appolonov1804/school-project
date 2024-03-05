<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="/styles.css">
</head>
<body>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="/styles.css">
</head>
<body>
<form action="{{ route('reports.store') }}" method="post">
<input type="hidden" name="_token" value="{{ csrf_token() }}">
  <div>
    <label for="name">Студент</label>
    <input type="text" class="form-control" id="inputName" name="student" placeholder="Введите имя студента">
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
    <label for="inputDescription">Описание урока</label>
    <input type="text" class="form-control" id="inputDescription" name="lesson_description" placeholder="Введите описание урока">
  </div>
  <br>
  <div class="form-group">
    <label for="inputComments">Комментарии</label>
    <input type="text" class="form-control" id="inputComments" name="comments" placeholder="Введите замечания">
  </div>
  <br>
  <button type="submit" class="btn btn-primary">Добавить</button>
</form>
        
</body>
</html>
</body>
</html>