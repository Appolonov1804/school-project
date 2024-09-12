<?php

namespace App\Http\Controllers;

use App\Http\Requests\Controllers\StoreReportRequest;
use App\Http\Requests\Controllers\UpdateReportRequest;
use Illuminate\Http\Request;
use App\Models\Report;
use App\Models\Teacher;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

class ReportController extends Controller
{


    public function create(Report $report, Teacher $teacher, Request $request)
    {
        $reports = Report::all();
        $teachers = Teacher::all();
        $page = $request->input('page', 1);
        $student = $request->query('student');
        $course = $request->query('course');
        $date = $request->query('date');
        $topic = $request->query('topic');
        return view('reports.create', compact('teacher', 'reports', 'teachers', 'page', 'student', 'course', 'date', 'topic'));

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
        $page = $request->input('page', 1);
        return redirect()->route('teachers.reportShow', ['teacher' => $user->teacher->id, 'page' => $page]);
        } else {
            return redirect()->back()->with('error', 'вы не являетесь учителем');
        }
    }

    public function show(Report $report, Teacher $teacher)
    {
        $reports = Report::all();
        $teachers = Teacher::all();
        return view('reports.show', compact('report', 'teacher', 'reports', 'teachers', 'rosters'));
    }

    public function edit(Report $report, Teacher $teacher, Request $request)
    {
        $teachers = Teacher::all();
        $page = $request->input('page', 1);
        return view('reports.edit', compact('report', 'teacher',  'teachers', 'page'));
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
            $page = $request->input('page', 1);
            return redirect()->route('teachers.reportShow', ['teacher' => $user->teacher->id, 'page' => $page]);
            } else {
            return redirect()->back()->with('error', 'вы не являетесь учителем');
        }
    }

    public function delete($reportId, Request $request)
    {
        $report = Report::find($reportId);
        $teacherId = $report->teachers_id;
        if ($report) {
            $report->delete();
            $page = $request->input('page', 1);
            return redirect()->route('teachers.reportShow', ['teacher' => $teacherId, 'page' => $page]);
        } else {
            return redirect()->route('teachers.reportShow', ['teacher' => $teacherId])->with('error', 'Запись не найдена');
        }
    }

    public function destroy(Report $report, Request $request)
    {
        $report->delete();
        $teacherId = $report->teachers_id;
        $page = $request->input('page', 1);
        return redirect()->route('teachers.reportShow', ['teacher' => $teacherId, 'page'=> $page]);
    }
}
