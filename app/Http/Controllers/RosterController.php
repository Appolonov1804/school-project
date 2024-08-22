<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use App\Models\Teacher;
use App\Models\Report;
use App\Models\Roster;
use App\Models\Course;
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
        $courseTypes = Course::all();
        return view('rosters.create', compact('teachers', 'rosters', 'reports', 'courseTypes'));
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
                'type_id' => $data['type_id'],
                'score' => $data['score'],
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


    public function edit(Roster $roster, Report $report, Teacher $teacher, Course $courseTypes)
    {
        $rosters = Roster::all();
        $reports = Report::all();
        $teachers = Teacher::all();
        $courseTypes = Course::all();
        return view('rosters.edit', compact('roster', 'teacher', 'report', 'teachers', 'reports', 'rosters', 'courseTypes'));
    }


    public function update(UpdateRosterRequest $request, Roster $roster, Report $report, Teacher $teacher, Course $courseTypes)
    {
        $teachers = Teacher::all();
        $rosters = Roster::all();
        $reports = Report::all();
        $courseTypes = Course::all();

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
