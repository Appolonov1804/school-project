@extends('layouts.admin')

@section('content')

<div>
    <div>
        <?php foreach ($teachers as $teacher) : ?>
        <div>
        <div>{{ $teacher->id }}. {{ $teacher->email }}</div>
        <div><a href="{{ route('teachers.show', $teacher->id) }}">{{ $teacher->name }}</a></div>
        </div>
        <?php endforeach ; ?>
    </div>
</div>

@endsection