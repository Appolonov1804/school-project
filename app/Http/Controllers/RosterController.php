<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use App\Models\Teacher;
use App\Models\Roster;
use App\Models\Course;
use App\Models\Report;
use App\Models\LessonDetail;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Controllers\RosterRequest;
use App\Http\Requests\Controllers\LessonRequest;
use App\Models\Membership;
use Illuminate\Http\Request;
use App\Services\SalaryCalculator;

class RosterController extends Controller
{
    protected $salaryCalculator;

    public function __construct(SalaryCalculator $salaryCalculator)
    {
        $this->salaryCalculator = $salaryCalculator;
    }

    public function create(Request $request)
    {
        $rosters = Roster::all();
        $teachers = Teacher::all();
        $courseTypes = Course::all();
        $page = $request->input('page', 1);
        return view('rosters.create', compact('teachers', 'rosters', 'courseTypes', 'page'));
    }

    public function store(RosterRequest $request)
    {
        $data = $request->validated();
        $user = Auth::user();

        if ($user->teacher) {
            $roster = Roster::create([
                'student' => $data['student'],
                'course' => $data['course'],
                'type_id' => $data['type_id'],
                'schedule' => $data['schedule'],
                'teachers_id' => $user->teacher->id,
            ]);
            $page = request()->input('page', 1);

            return redirect()->route('teachers.show', ['teacher' => $user->teacher->id, 'page' => $page]);
        } else {
            return redirect()->back()->with('error', 'Вы не являетесь учителем.');
        }

    }

    public function show(Teacher $teacher, Roster $roster, Membership $membership)
    {
        $rosters = $teacher->rosters()->with('membership')->paginate(10);
        $totalSalary = $this->salaryCalculator->calculateTotalSalary($teacher);

        return view('rosters.show', compact('teacher', 'rosters', 'totalSalary', 'roster', 'membership'));
    }

    public function showSchedule(Teacher $teacher)
    {
        $rosters = $teacher->rosters()->paginate(10);
        $teacher->load('groups');
        $groups = $teacher->groups;


        return view('rosters.showSchedule', compact('teacher', 'rosters', 'groups'));
    }

    public function edit(Roster $roster, Teacher $teacher, Course $courseTypes)
    {
        $rosters = Roster::all();
        $teachers = Teacher::all();
        $courseTypes = Course::all();
        $currentPage = request()->input('page', 1);

        return view('rosters.edit', compact('roster', 'teacher', 'teachers', 'rosters', 'courseTypes', 'currentPage'));
    }


    public function update(RosterRequest $request, Roster $roster, Teacher $teacher, Course $courseTypes)
    {
        $teachers = Teacher::all();
        $rosters = Roster::all();
        $courseTypes = Course::all();

        $data = $request->validated();
        $roster->update($data);
        $teacherId = $roster->teachers_id;
        $page = $request->input('page', 1);

        return redirect()->route('teachers.show', ['teacher' => $teacherId, 'page' => $page]);
    }


    public function delete($rosterId)
    {
        $roster = Roster::find($rosterId);
        $teacherId = $roster->teachers_id;
        if ($roster) {
            $roster->delete();
            $page = request()->input('page', 1);
            return redirect()->route('teachers.show', ['teacher' => $teacherId, 'page' => $page]);
        } else {
            return redirect()->route('teachers.show', ['teacher' => $teacherId])->with('error', 'Запись не найдена');
        }
    }

    public function destroy(Roster $roster)
    {
        $roster->delete();
        $teacherId = $roster->teachers_id;
        $page = request()->input('page', 1);
        return redirect()->route('teachers.show', ['teacher' => $teacherId, 'page' => $page]);
    }

}
