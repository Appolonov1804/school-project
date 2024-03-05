<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div>
        Преподаватели
    </div>
    <div>
        <nav>
            <ul>
                <li><a href="{{ route('reports.reports') }}">Отчёты</a></li>
                <li><a href="{{ route('rosters.rosters') }}">Журналы</a></li> 
            </ul>
        </nav>
    </div>
    <div>
        <a href="{{ route('teachers.create') }}">Добавить учителя</a>
    </div>
    <br>
    <div>
        <?php foreach ($teachers as $teacher) : ?>
    <div>
        <div>{{ $teacher->id }}. {{ $teacher->email }}</div>
        <div><a href="{{ route('teachers.show', $teacher->id) }}">{{ $teacher->name }}</a></div>
    </div>
        <?php endforeach ; ?>
    </div>
</body>
</html>