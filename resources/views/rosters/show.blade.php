<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <div>
        <a href="{{ route('rosters.edit', $roster->id) }}">Редактировать</a>
    </div>
    <div>
        <form action="{{ route('rosters.delete', $roster->id) }}" method="post">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        @method('delete')
        <input type="submit" value="Удалить" class="btn btn-danger">
        </form>
    </div>
    <div>
        <div>{{ $roster->teachers_id }}. {{ $roster->student }}. {{ $roster->course }}</div>
        <div>{{ $roster->topic }}. {{ $roster->date }}. {{ $roster->attendance }}</div>
    </div>
    <div>
        <a href="{{ route('rosters.rosters') }}">Назад</a>
    </div>
</body>

</html>