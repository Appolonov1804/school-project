<!DOCTYPE html>
<html>
<head>
    <title>Загрузка файла</title>
</head>
<body>

<h2>Загрузка файла</h2>
@if ($message = Session::get('success'))
    <p>{{ $message }}</p>
@endif

<form action="{{ route('upload.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <input type="file" name="file">
    <button type="submit">Загрузить</button>
</form>

</body>
</html>