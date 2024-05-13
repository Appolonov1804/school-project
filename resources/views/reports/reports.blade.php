<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div>
       Отчёты        
    </div>
        <div>
            <nav>
                <ul>
                    <li><a href=" {{ route('teachers.index') }} ">Преподаватели</a></li>
                    <li><a href=" {{ route('rosters.rosters') }} ">Журналы</a></li>
                </ul>
            </nav>
        </div>
        <div>
            <a href=" {{ route('reports.create') }} ">Добавить отчёт</a>
        </div>
        <div>
            <?php foreach ($reports as $report) : ?>
                <div>
                    <div><a href=" {{ route('reports.show', $report->id) }} ">{{ ($report->student) }}</a></div>
                    <div>{{ $report->teachers_id }}. {{ $report->course }}. {{ $report->topic }}. {{ $report->date }}. {{ $report->lesson_description }}. {{ $report->comments }}</div>
                </div>
            <?php endforeach ; ?>
        </div>
</body>
</html>