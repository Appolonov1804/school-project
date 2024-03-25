<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Teacher;
use App\Models\Roster;
use App\Models\Report;

class MainController extends Controller
{
    public function main() 
    {
        $teachers = Teacher::all();
        $rosters = Roster::all();
        $reports = Report::all();
       
        return view('teachers.index', compact('teachers', 'rosters', 'reports'));
    }

    public function create() 
    {
        $teachers = Teacher::all();
        $rosters = Roster::all();
        $reports = Report::all();
        return view('teachers.create');   
    
    }

    public function store() 
    {
        $teachers = Teacher::all();
        $rosters = Roster::all();
        $reports = Report::all();
        $data = request()->validate([
            'name' => 'string',
            'email' => 'email'
        ]);
        Teacher::create($data);
        return redirect()->route('admin.teacher.teacher');
    }
    
    public function show(Teacher $teacher, Roster $roster, Report $report) 
    {
        $teachers = Teacher::all();
        $rosters = Roster::all();
        $reports = Report::all();
        $rosters = $teacher->rosters()->with('lessonDetails')->get();
       return view('teachers.show', compact('teacher', 'roster', 'report', 'teachers', 'reports', 'rosters'));
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

    public function delete() 
    {
        $teacher = Teacher::find(2);
        $teacher->delete();
        dd('deleted');
    }

    public function destroy(Teacher $teacher) 
    {
        $teacher->delete();
        redirect()->route('teachers.index');
    }

    
}
