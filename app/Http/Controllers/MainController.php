<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Teacher;
use App\Models\Roster;
use App\Models\Report;
use App\Models\LessonDetail;

class MainController extends Controller
{

    public function create() 
    {
        $teachers = Teacher::all();
        $rosters = Roster::all();
        $reports = Report::all();
        return view('teachers.create');   
    
    }

    public function store() 
{
    $data = request()->validate([
        'name' => 'required|string',
        'email' => 'required|email|unique:users,email',
        'password' => ['required', 'string', 'min:8', 'confirmed'],
        // Добавьте другие необходимые поля для пользователя
    ]);

    $teacher = Teacher::create([
        'name' => $data['name'],
        'email' => $data['email'],
        'password' => Hash::make($data['password']),
        'role' => 'user',
        // Добавьте другие поля для учителя
    ]);


    return redirect()->route('admin.teacher.teacher');
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
        return view('teachers.edit', compact('teacher', 'roster', 'report', 'teachers', 'rosters', 'reports'));
    }

    public function update(Teacher $teacher, Roster $roster, Report $report) 
    { 
        $teachers = Teacher::all();
        $rosters = Roster::all();
        $reports = Report::all();
        $data = request()->validate([
            'name' => 'string',
            'email' => 'email'
        ]);
        $teacher->update($data);
        return redirect()->route('teachers.show', $teacher->id);
    }

    public function delete($teacherId)
    {
        $teacher = Teacher::find($teacherId);
        if ($teacher) {
            $teacher->delete();
            return redirect()->route('admin.teacher.teacher');
        } else {
            return redirect()->route('admin.teacher.teacher')->with('error', 'Запись не найдена');
        }
    }

    public function destroy(Teacher $teacher)
    {
        $teacher->delete();
        return redirect()->route('admin.teacher.teacher');
    }

    
}
