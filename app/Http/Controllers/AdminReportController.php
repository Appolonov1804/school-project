<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Http\Controllers\RosterController;
use App\Http\Controllers\AdminTeacherController;
use App\Models\Report;
use App\Models\Roster;
use App\Models\Teacher;
use App\Http\Requests\Controllers\StoreReportRequest;
use App\Http\Requests\Controllers\UpdateReportRequest;



class AdminReportController extends Controller
{
    public function store(StoreReportRequest $request) 
    {
        $data = $request->validated();
        $teachers = Teacher::all();
        $rosters = Roster::all();
        $reports = Report::all();
        return view('admin.report.report', compact('reports', 'rosters', 'teachers'));
    }
}
