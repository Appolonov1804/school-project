<?php

namespace App\Http\Controllers;

use App\Http\Requests\Controllers\StoreReportRequest;
use App\Http\Requests\Controllers\UpdateReportRequest;
use Illuminate\Http\Request;
use App\Models\Report;
use App\Models\Teacher;
use App\Models\Roster;
use Illuminate\Support\Carbon;

class ReportController extends Controller
{
   

    public function create(Report $report, Roster $roster, Teacher $teacher) 
    {
        $reports = Report::all();
        $rosters = Roster::all();
        $teachers = Teacher::all();
        return view('reports.create', compact('teacher', 'reports', 'rosters'));
       
    }

    public function store(StoreReportRequest $request, Report $report) 
    {
        $reports = Report::all();
        $rosters = Roster::all();
        $teachers = Teacher::all();
        $data = $request->validated();
        $data['date'] = Carbon::createFromFormat('Y-m-d', $data['date'])->toDateString();
        Report::create($data);
        $teacherId = $report->teachers_id;
        return redirect()->route('teachers.show', ['teacher' => $teacherId]);
    }

    public function show(Report $report, Roster $roster, Teacher $teacher) 
    {
        $reports = Report::all();
        $rosters = Roster::all();
        $teachers = Teacher::all();
        return view('reports.show', compact('report', 'teacher', 'roster', 'reports', 'teachers', 'rosters'));
    }

    public function edit(Report $report, Roster $roster, Teacher $teacher) 
    {
        $reports = Report::all();
        $rosters = Roster::all();
        $teachers = Teacher::all();
        return view('reports.edit', compact('report', 'teacher', 'roster', 'reports', 'teachers', 'rosters')); 
    }

    public function update(UpdateReportRequest $request, Report $report, Roster $roster, Teacher $teacher) 
    {
        $reports = Report::all();
        $rosters = Roster::all();
        $teachers = Teacher::all();
        $data = $request->validated();
        $data['date'] = Carbon::createFromFormat('Y-m-d', $data['date'])->toDateString();
        $report->update($data);
        $teacherId = $report->teachers_id;
        return redirect()->route('teachers.reportShow', ['teacher' => $teacherId]);
    }

    public function delete($reportId)
    {
        $report = Report::find($reportId);
        $teacherId = $report->teachers_id;
        if ($report) {
            $report->delete();
            return redirect()->route('teachers.reportShow', ['teacher' => $teacherId]);
        } else {
            return redirect()->route('teachers.reportShow', ['teacher' => $teacherId])->with('error', 'Запись не найдена');
        }
    }

    public function destroy(Report $report)
    {
        $report->delete();
        $teacherId = $report->teachers_id;
        return redirect()->route('teachers.reportShow', ['teacher' => $teacherId]);
    }
}
