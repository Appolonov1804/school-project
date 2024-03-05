<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div>
        <a href="{{ route('reports.edit', $report->id) }}">Редактировать</a>
    </div>
    <div>
        <form action="{{ route('reports.delete', $report->id) }}" method="post">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        @method('delete')
        <input type="submit" value="Удалить" class="btn btn-danger">
        </form>
        <div>
            <div>{{ $report->teachers_id }}. {{ $report->student }}. {{ $report->course }}. {{ $report->topic }}. {{ $report->date }}. {{ $report->lesson_description }}. {{ $report->comments }}</div>
        </div>
    </div>
    <div>
        <a href="{{ route('reports.reports') }}">Назад</a>
    </div>
</body>
</html>