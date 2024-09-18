<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\Teacher;
use App\Models\Roster;
use App\Models\Report;
use App\Models\User;
use App\Models\LessonDetail;
use App\Models\Group;
use App\Http\Requests\Controllers\UpdateTeacherRequest;
use App\Http\Requests\Controllers\StoreTeacherRequest;
use App\Models\TrialLesson;
use App\Services\SalaryCalculator;
use App\Services\LessonSalaryService;
use App\Services\GroupLessonSalaryService;
use App\Services\TrialLessonSalaryService;

class MainController extends Controller
{
    protected $salaryCalculator;
    protected $lessonSalaryService;
    protected $groupLessonSalaryService;
    protected $trialLessonSalaryService;

    public function __construct(
        LessonSalaryService $lessonSalaryService,
        GroupLessonSalaryService $groupLessonSalaryService,
        TrialLessonSalaryService $trialLessonSalaryService,
        SalaryCalculator $salaryCalculator
    ) {
        $this->lessonSalaryService = $lessonSalaryService;
        $this->groupLessonSalaryService = $groupLessonSalaryService;
        $this->trialLessonSalaryService = $trialLessonSalaryService;
        $this->salaryCalculator = $salaryCalculator;
    }

    public function create()
    {
        $teachers = Teacher::all();
        $rosters = Roster::all();
        $reports = Report::all();
        return view('teachers.create');

    }

    public function store(StoreTeacherRequest $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'position' => 'required|string',
        ]);

        $user = Auth::user();

        $teacher = Teacher::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'position' => $data['position'],
            'user_id' => $user->id,
        ]);

        return redirect()->route('teachers.show', ['teacher' => $teacher->id]);
    }

    public function updatePaidStatus(Teacher $teacher)
    {
        $teacher->rosters()->each(function ($roster) {
            $roster->lessonDetails()->where('paid', 0)->update(['paid' => 1]);
        });
    }

    public function resetSalary(Teacher $teacher)
    {
        $teacher->update(['salary' => 0]);
        $this->lessonSalaryService->updatePaidStatus($teacher);
        $this->groupLessonSalaryService->updatePaidStatus($teacher);
        $teacher->trialLesson()->update(['paid' => 1]);

        return redirect()->route('teachers.show', ['teacher' => $teacher->id]);
    }

    public function show(Teacher $teacher, Report $report)
    {
        $currentPage = request()->input('page', 1);
        $rosters = $teacher->rosters()->with('lessonDetails')->paginate(3, ['*'], 'page', $currentPage);

        $filteredLessonDetails = collect();
        foreach ($rosters as $roster) {
            $filteredLessonDetails = $filteredLessonDetails->merge($roster->lessonDetails->where('paid', 0));
        }

        $groups = $teacher->groups()->with(['groupLessons' => function($query) {
            $query->with('attendance');
        }])->get();

        $filteredGroupLessons = collect();
        foreach ($groups as $group) {
            $filteredGroupLessons = $filteredGroupLessons->merge($group->groupLessons->where('paid', 0));
        }

        $totalSalary = $this->salaryCalculator->calculateTotalSalary($teacher);

        return view('teachers.show', compact('teacher', 'rosters', 'filteredLessonDetails', 'filteredGroupLessons', 'totalSalary', 'report'));
    }

    public function showTeachersReports(Teacher $teacher, Report $report)
    {
        $teachers = Teacher::all();
        $page = request()->input('page', 1);
        $reports = $teacher->reports()->paginate(5, ['*'], 'page', $page);
       return view('teachers.reportShow', compact('teacher', 'report', 'teachers', 'reports', 'page'));
    }

    public function showRosters(Teacher $teacher, Roster $roster, Report $report)
    {
        $rosters = $teacher->rosters()->paginate(10);

        return view('teachers.showRosters', compact('teacher', 'rosters', 'roster', 'report'));
    }

    public function edit(Teacher $teacher, Roster $roster, Report $report)
    {
        $teachers = Teacher::all();
        $rosters = Roster::all();
        $reports = Report::all();

        return view('teachers.edit', compact('teacher', 'roster', 'report', 'teachers', 'rosters', 'reports'));
    }

    public function update(UpdateTeacherRequest $request, Teacher $teacher, Roster $roster, Report $report)
    {
        $teachers = Teacher::all();
        $rosters = Roster::all();
        $reports = Report::all();
        $data = request()->validate([
            'name' => 'string',
            'email' => 'email',
            'position' => 'string',
        ]);
        $teacher->update($data);
        return redirect()->route('teachers.show', ['teacher' => $teacher->id]);
    }

    public function delete($teacherId)
    {
        $teacher = Teacher::find($teacherId);
        if ($teacher) {
            $teacher->delete();
            return redirect()->route('teachers.create');
        } else {
            return redirect()->route('teachers.create')->with('error', 'Запись не найдена');
        }
    }

    public function destroy(Teacher $teacher)
    {
        $teacher->delete();
        return redirect()->route('teachers.create');
    }

}
