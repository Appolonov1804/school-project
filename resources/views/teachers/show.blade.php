<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <div>
        <a href="{{ route('teachers.edit', $teacher->id) }}">Редактировать</a>
    </div>
    <div>
        <form action="{{ route('teachers.delete', $teacher->id) }}" method="post">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        @method('delete')
        <input type="submit" value="Удалить" class="btn btn-danger">
        </form>
    </div>
    <div>
        <div>{{ $teacher->id }}. {{ $teacher->email }}</div>
        <div>{{ $teacher->name }}</div>
    </div>
    <div>
        <a href="{{ route('teachers.index') }}">Назад</a>
    </div>
</body>

</html>