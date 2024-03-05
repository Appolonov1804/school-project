<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Report;
use Illuminate\Support\Carbon;

class ReportController extends Controller
{
    public function report() 
    {
        $reports = Report::all();

        return view('reports.reports', compact('reports'));
    }

    public function create(Report $report) 
    {
        return view('reports.create');
       
    }

    public function store() 
    {
        $data = request()->validate([
            'teachers_id' => ['nullable', 'integer'],
            'student' => 'string',
            'course' => 'string',
            'topic' => 'string',
            'date' => 'date',
            'lesson_description' => 'string',
            'comments' => 'nullable',
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
        return view('reports.edit', compact('report'));
    }

    public function update(Report $report) 
    {
        $data = request()->validate([
            'teachers_id' => ['nullable', 'integer'],
            'student' => 'string',
            'course' => 'string',
            'topic' => 'string',
            'date' => 'date',
            'lesson_description' => 'string',
            'comments' => 'nullable',
        ]);
        $data['date'] = Carbon::createFromFormat('Y-m-d', $data['date'])->toDateString();
        $report->update($data);
        return redirect()->route('reports.show', $report->teachers_id);
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
