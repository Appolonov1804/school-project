<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use App\Models\Teacher;
use App\Models\Report;
use App\Models\Roster;
use App\Models\LessonDetail;
use Illuminate\Support\Facades\Auth;
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
        $data = $request->validated();
        $user = Auth::user();
        
        if ($user->teacher) {
            $roster = Roster::create([
                'student' => $data['student'],
                'course' => $data['course'],
                'time' => $data['time'],
                'type' => $data['type'],
                'teachers_id' => $user->teacher->id, 
            ]);
            
            return redirect()->route('teachers.show', ['teacher' => $user->teacher->id]);
        } else {
            return redirect()->back()->with('error', 'Вы не являетесь учителем.');
        }

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
        $roster->update($data);
        $teacherId = $roster->teachers_id;
    
        return redirect()->route('teachers.show', ['teacher' => $teacherId]);
    }


    public function delete($rosterId)
    {
        $roster = Roster::find($rosterId);
        $teacherId = $roster->teachers_id;
        if ($roster) {
            $roster->delete();
            return redirect()->route('teachers.show', ['teacher' => $teacherId]);
        } else {
            return redirect()->route('teachers.show', ['teacher' => $teacherId])->with('error', 'Запись не найдена');
        }
    }

    public function destroy(Roster $roster)
    {
        $roster->delete();
        $teacherId = $roster->teachers_id;
        return redirect()->route('teachers.show', ['teacher' => $teacherId]);
    }

}
