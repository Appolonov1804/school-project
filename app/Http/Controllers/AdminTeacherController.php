<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Http\Controllers\AdminReportController;
use App\Http\Controllers\AdminRosterController;
use App\Models\Roster;
use App\Models\Report;
use App\Models\Teacher;
use App\Http\Requests\Controllers\TeacherRequest;


class AdminTeacherController extends Controller
{
    public function store(TeacherRequest $request)
    {
        $data = $request->validated();
        $reports = Report::all();
        $rosters = Roster::all();
        $teachers = Teacher::all();
        return view('admin.teacher.teacher', compact('teachers', 'rosters', 'reports'));
    }
}
