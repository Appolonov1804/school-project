<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="/resources/css/app.css">
</head>
<body>
<form action="{{ route('reports.update', $report->id) }}" method="post">
<input type="hidden" name="_token" value="{{ csrf_token() }}">
@method('patch')
 >
  <div class="form-group">
    <label for="inputName">Студент</label>
    <input type="text" class="form-control" id="inputName" placeholder="Введите имя студента" name="student" value=" {{ $report->student }}">
  </div>
  <br>
  <div class="form-group">
    <label for="inputCourse">Курс</label>
    <input type="text" class="form-control" id="inputCourse" placeholder="Введите курс студента" name="course" value=" {{ $report->course }}">
  </div>
  <br>
  <div class="form-group">
    <label for="inputTopic">Тема</label>
    <input type="text" class="form-control" id="inputTopic" placeholder="Введите тему урока" name="topic" value=" {{ $report->topic }}">
  </div>
  <br>
  <div class="form-group">
    <label for="inputDate">Дата</label>
    <input type="date" class="form-control" id="inputDate" placeholder="Введите дату" name="date" value=" {{ $report->date }}">
  </div>
  <br>
  <div class="form-group">
    <label for="inputDescription">Описание урока</label>
    <input type="text" class="form-control" id="inputDescription" placeholder="Введите описание урока" name="lesson_description" value=" {{ $report->lesson_description }}">
  </div>
  <div class="form-group">
    <label for="inputComments">Замечания</label>
    <input type="text" class="form-control" id="inputComments" placeholder="Введите замечания" name="comments" value=" {{ $report->comments }}">
  </div>
  <div class="form-group">
    <label for="teachers">Выбрать преподавателя</label>
      <select class="form-control" id="teachers" name="teachers_id">
    <?php foreach ($teachers as $teacher) : ?>
      <option 

      {{ $teacher->id === $report->teachers_id ? ' selected' : '' }}

        value="{{ $teacher->id }}">{{ $teacher->name }}</option>
    <?php endforeach ; ?>
      </select>
  </div>
  <button type="submit" class="btn btn-primary">Обновить</button>
</form>
        
</body>
</html>