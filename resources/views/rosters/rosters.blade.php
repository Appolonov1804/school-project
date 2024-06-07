<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div>
        Журналы
    </div>
    <div>
        <nav>
            <ul>
                <li><a href="{{ route('reports.reports') }}">Отчёты</a></li>
                <li><a href="{{ route('teachers.index') }}">Преподаватели</a></li> 
            </ul>
        </nav>
    </div>
    <div>
        <a href="{{ route('rosters.create') }}">Добавить журнал</a>
    </div>
    <br>
    <div>
        <?php foreach ($rosters as $roster) : ?>
    <div>
        <div><a href="{{ route('rosters.show', $roster->id) }}">{{ $roster->student }}</a></div>
        <div>{{ $roster->teachers_id }}. {{ $roster->course }}. {{ $roster->topic }}. {{ $roster->date }}. {{ $roster->attendance }}</div>
        
    </div>
        <?php endforeach ; ?>
    </div>
</body>
</html>