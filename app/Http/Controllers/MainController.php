<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\Teacher;
use App\Models\Roster;
use App\Models\Report;
use App\Models\User;
use App\Models\LessonDetail;
use App\Http\Requests\Controllers\UpdateTeacherRequest;
use App\Http\Requests\Controllers\StoreTeacherRequest;


class MainController extends Controller
{

    public function create() 
    {
        $teachers = Teacher::all();
        $rosters = Roster::all();
        $reports = Report::all();
        return view('teachers.create');   
    
    }

    public function store(StoreTeacherRequest $request) 
    {
        $data = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
        ]);
    
        $user = Auth::user();
    
        // Создаем учителя
        $teacher = Teacher::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'user_id' => $user->id,
        ]);
    
        // Ассоциируем учителя с пользователем
        $user->teacher()->associate($teacher);
    
       
    
        // Перенаправляем на страницу учителя
        return redirect()->route('teachers.show', ['teacher' => $teacher->id]);
    }
    
    public function show(Teacher $teacher, Roster $roster, Report $report, LessonDetail $lessonDetail) 
    {
        $teachers = Teacher::all();
        $rosters = Roster::all();
        $reports = Report::all();
        $lessonDetails = LessonDetail::all();
        $rosters = $teacher->rosters()->with('lessonDetails')->get();
       return view('teachers.show', compact('teacher', 'roster', 'report', 'teachers', 'reports', 'rosters', 'lessonDetails', 'lessonDetail'));
    }

    public function showTeachersReports(Teacher $teacher, Roster $roster, Report $report) 
    {
        $teachers = Teacher::all();
        $rosters = Roster::all();
        $reports = Report::all();
        $reports = $teacher->reports;
       return view('teachers.reportShow', compact('teacher', 'roster', 'report', 'teachers', 'reports', 'rosters'));
    }

    public function edit(Teacher $teacher, Roster $roster, Report $report) 
    {
        $teachers = Teacher::all();
        $rosters = Roster::all();
        $reports = Report::all();
        $report->load('date');
        return view('teachers.edit', compact('teacher', 'roster', 'report', 'teachers', 'rosters', 'reports'));
    }

    public function update(UpdateTeacherRequest $request, Teacher $teacher, Roster $roster, Report $report) 
    { 
        $teachers = Teacher::all();
        $rosters = Roster::all();
        $reports = Report::all();
        $data = request()->validate([
            'name' => 'string',
            'email' => 'email'
        ]);
        $teacher->update($data);
        return redirect()->route('teachers.show', ['teacher' => $teacher->id]);
    }

    public function delete($teacherId)
    {
        $teacher = Teacher::find($teacherId);
        if ($teacher) {
            $teacher->delete();
            return redirect()->route('teachers.create');
        } else {
            return redirect()->route('teachers.create')->with('error', 'Запись не найдена');
        }
    }

    public function destroy(Teacher $teacher)
    {
        $teacher->delete();
        return redirect()->route('teachers.create');
    }

    
}
