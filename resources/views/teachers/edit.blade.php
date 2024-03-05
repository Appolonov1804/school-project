<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="/resources/css/app.css">
</head>
<body>
<form action="{{ route('teachers.update', $teacher->id) }}" method="post">
<input type="hidden" name="_token" value="{{ csrf_token() }}">
@method('patch')
  <div class="form-group">
    <label for="name">Имя</label>
    <input type="text" class="form-control" id="inputName" name="name" placeholder="Введите имя" value="{{ $teacher->name }}">
    <br><br>
    <label for="exampleInputEmail1">Email</label>
    <input type="email" class="form-control" id="exampleInputEmail1" name="email" placeholder="Введите email" value=" {{ $teacher->email }}">
  </div>
  <button type="submit" class="btn btn-primary">Обновить</button>
</form>
        
</body>
</html>