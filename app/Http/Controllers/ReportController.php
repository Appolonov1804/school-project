<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Report;
use App\Models\Teacher;
use Illuminate\Support\Carbon;

class ReportController extends Controller
{
    public function report() 
    {
        $reports = Report::all();
        return view('reports.reports', compact('reports'));
          // $teachers = Teacher::find(1);
        // $reports = Report::find(1);
        // dd($reports->teachers);
    }

    public function create(Report $report) 
    {
        $teachers = Teacher::all();
        return view('reports.create', compact('teachers'));
       
    }

    public function store() 
    {
        $data = request()->validate([
            'student' => 'string',
            'course' => 'string',
            'topic' => 'string',
            'date' => 'date',
            'lesson_description' => 'string',
            'comments' => 'nullable',
            'teachers_id' => ['nullable', 'integer'], 
        ]);
        $data['date'] = Carbon::createFromFormat('Y-m-d', $data['date'])->toDateString();
        Report::create($data);
        return redirect()->route('reports.reports');
    }

    public function show(Report $report) 
    {
        return view('reports.show', compact('report'));
    }

    public function edit(Report $report) 
    {
        $teachers = Teacher::all();
        return view('reports.edit', compact('report', 'teachers')); 
    }

    public function update(Report $report) 
    {
        $data = request()->validate([
            'student' => 'string',
            'course' => 'string',
            'topic' => 'string',
            'date' => 'date',
            'lesson_description' => 'string',
            'comments' => 'nullable',
            'teachers_id' => ['nullable', 'integer'], 
        ]);
        $data['date'] = Carbon::createFromFormat('Y-m-d', $data['date'])->toDateString();
        $report->update($data);
        return redirect()->route('reports.show', $report->id);
    }

    public function delete() 
    {
        $report = Report::find(5);
        $report->delete();
        dd('deleted');
    }

    public function destroy(Report $report) 
    {
        $report->delete();
        return redirect()->route('reports.reports');
    }
}
