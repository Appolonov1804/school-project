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
        return view('teachers.create');   
    
    }

    public function store() 
    {
        $data = request()->validate([
            'name' => 'string',
            'email' => 'email'
        ]);
        Teacher::create($data);
        return redirect()->route('teachers.index');
    }
    
    public function show(Teacher $teacher) 
    {
       return view('teachers.show', compact('teacher'));
    }

    public function edit(Teacher $teacher) 
    {
        return view('teachers.edit', compact('teacher'));
    }

    public function update(Teacher $teacher) 
    { 
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
