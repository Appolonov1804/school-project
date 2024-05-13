<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Http\Controllers\AdminReportController;
use App\Http\Controllers\AdminTeacherController;
use App\Models\Roster;
use App\Models\Report;
use App\Models\Teacher;
use App\Http\Requests\Controllers\StoreRosterRequest;
use App\Http\Requests\Controllers\UpdateRosterRequest;



class AdminRosterController extends Controller
{
    public function store(StoreRosterRequest $request) 
    {
        $data = $request->validated();
        $teachers = Teacher::all();
        $reports = Report::all();
        $rosters = Roster::all();
        return view('admin.roster.roster', compact('rosters', 'reports', 'teachers'));
    }
}
