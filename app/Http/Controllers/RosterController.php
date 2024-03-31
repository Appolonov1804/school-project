<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use App\Models\Teacher;
use App\Models\Report;
use App\Models\Roster;
use App\Models\LessonDetail;
use App\Http\Requests\Controllers\StoreRosterRequest;
use App\Http\Requests\Controllers\UpdateRosterRequest;
use App\Http\Requests\Controllers\StoreLessonRequest;
use App\Http\Requests\Controllers\UpdateLessonRequest;

class RosterController extends Controller
{


    public function create()
    {
        $rosters = Roster::all();
        $reports = Report::all();
        $teachers = Teacher::all();
        return view('rosters.create', compact('teachers', 'rosters', 'reports'));
    }

    public function store(StoreRosterRequest $request)
    {
        $teachers = Teacher::all();
        $rosters = Roster::all();
        $reports = Report::all();
        $data = $request->validated();
      
        $roster = Roster::create([
            'student' => $data['student'],
            'course' => $data['course'],
            'teachers_id' => $data['teachers_id'],
        ]);
    
        return redirect()->route('admin.roster.roster');
    }

    public function show(Roster $roster, Report $report, Teacher $teacher)
    {
        $teachers = Teacher::all();
        $rosters = Roster::all();
        $reports = Report::all();
        return view('rosters.show', compact('roster', 'teacher', 'report', 'teachers', 'reports', 'rosters'));
    }


    public function edit(Roster $roster, Report $report, Teacher $teacher)
    {
        $rosters = Roster::all();
        $reports = Report::all();
        $teachers = Teacher::all();
        return view('rosters.edit', compact('roster', 'teacher', 'report', 'teachers', 'reports', 'rosters'));
    }


    public function update(UpdateRosterRequest $request, Roster $roster, Report $report, Teacher $teacher)
    {
        $teachers = Teacher::all();
        $rosters = Roster::all();
        $reports = Report::all();

        $data = $request->validated();
        // $data['date'] = Carbon::createFromFormat('Y-m-d', $data['date'])->toDateString();
        $roster->update($data);
        return redirect()->route('admin.teacher.teacher', $roster->id);
    }


    public function delete($rosterId)
    {
        $roster = Roster::find($rosterId);
        if ($roster) {
            $roster->delete();
            return redirect()->route('admin.teacher.teacher');
        } else {
            return redirect()->route('admin.roster.roster')->with('error', 'Запись не найдена');
        }
    }

    public function destroy(Roster $roster)
    {
        $roster->delete();
        return redirect()->route('admin.teacher.teacher');
    }


}
