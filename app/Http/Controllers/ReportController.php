<?php

namespace App\Http\Controllers;

use App\Http\Requests\Controllers\StoreReportRequest;
use App\Http\Requests\Controllers\UpdateReportRequest;
use Illuminate\Http\Request;
use App\Models\Report;
use App\Models\Teacher;
use App\Models\Roster;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

class ReportController extends Controller
{
   

    public function create(Report $report, Roster $roster, Teacher $teacher) 
    {
        $reports = Report::all();
        $rosters = Roster::all();
        $teachers = Teacher::all();
        return view('reports.create', compact('teacher', 'reports', 'rosters', 'teachers'));
        
    }

    public function store(StoreReportRequest $request, Report $report, Teacher $teacher) 
    {
        $reports = Report::all();
        $teachers = Teacher::all();
        $data = $request->validated();
        $user = Auth::user();

        if ($user->teacher) {
        $createdReport = Report::create([
            'teachers_id' => $user->teacher->id,
            'student' => $data['student'],
            'course' => $data['course'],
            'topic' => $data['topic'],
            'date' => $data['date'],
            'lesson_description' => $data['lesson_description'],
            'comments' => $data['comments']
        ]);
        
        return redirect()->route('teachers.reportShow', ['teacher' => $user->teacher->id]);
        } else {
            return redirect()->back()->with('error', 'вы не являетесь учителем'); 
        }
    }

    public function show(Report $report, Teacher $teacher) 
    {
        $reports = Report::all();
        $rosters = Roster::all();
        $teachers = Teacher::all();
        return view('reports.show', compact('report', 'teacher', 'reports', 'teachers', 'rosters'));
    }

    public function edit(Report $report, Roster $roster, Teacher $teacher) 
    {
  
        $rosters = Roster::all();
        $teachers = Teacher::all();
        return view('reports.edit', compact('report', 'teacher',  'teachers', 'rosters')); 
    }

    public function update(UpdateReportRequest $request, Report $report,  Teacher $teacher) 
    {
        $reports = Report::all();
        $teachers = Teacher::all();
        $data = $request->validated();
        $user = Auth::user(); 
        if ($user->teacher) {
        $report->update([
            'teachers_id' => $user->teacher->id,
            'student' => $data['student'],
            'course' => $data['course'],
            'topic' => $data['topic'],
            'date' => $data['date'],
            'lesson_description' => $data['lesson_description'],
            'comments' => $data['comments']
        ]);
        
        return redirect()->route('teachers.reportShow', ['teacher' => $user->teacher->id]);
        } else {
        return redirect()->back()->with('error', 'вы не являетесь учителем');
        }
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
