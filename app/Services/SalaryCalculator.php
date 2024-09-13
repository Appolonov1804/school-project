<?php


namespace App\Services;

use App\Models\Teacher;

class SalaryCalculator
{
    protected $lessonSalaryService;
    protected $groupLessonSalaryService;
    protected $trialLessonSalaryService;

    public function __construct(
        LessonSalaryService $lessonSalaryService,
        GroupLessonSalaryService $groupLessonSalaryService,
        TrialLessonSalaryService $trialLessonSalaryService
    ) {
        $this->lessonSalaryService = $lessonSalaryService;
        $this->groupLessonSalaryService = $groupLessonSalaryService;
        $this->trialLessonSalaryService = $trialLessonSalaryService;
    }

    public function calculateTotalSalary(Teacher $teacher)
    {
        $rosters = $teacher->rosters()->with('lessonDetails')->get();
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

        $trialLessons = $teacher->trialLesson()->where('paid', 0)->get();

        $totalSalary = $this->lessonSalaryService->salary($rosters, $teacher);
        $groupTotalSalary = $this->groupLessonSalaryService->salary($filteredGroupLessons, $teacher);
        $totalSalary += $groupTotalSalary;
        $trialTotalSalary = $this->trialLessonSalaryService->salary($trialLessons, $teacher);
        $totalSalary += $trialTotalSalary;

        return $totalSalary;
    }
}

