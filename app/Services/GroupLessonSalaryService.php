<?php

namespace App\Services;

use App\Models\Teacher;

class GroupLessonSalaryService
{
    public function updatePaidStatus(Teacher $teacher)
    {
        $teacher->groups()->each(function ($group) {
            $group->groupLessons()->where('paid', 0)->update(['paid' => 1]);
        });
    }

    public function salary($groupLessons, $teacher)
    {
        $totalSalary = 0;

        foreach ($groupLessons as $groupLesson) {
            $allAbsent = true;

            foreach ($groupLesson->attendance as $attendance) {
                if ($attendance != 'не было') {
                    $allAbsent = false;
                    break;
            }
        }
        if ($allAbsent) {
            if ($teacher->position == 'junior') {
                $totalSalary += 1150;
            } elseif ($teacher->position == 'senior') {
                $totalSalary += 1250;
            }
        } else {
            $totalSalary += $this->calculateSalary($teacher, $groupLesson,);
        }
      }
            return $totalSalary;
    }

    public function calculateSalary($teacher, $groupLesson)
    {
        $time = $groupLesson->time;

        if ($teacher->position == 'junior') {
            if ($time == 40) {
                return 1250;
            } elseif ($time == 60) {
                return 1900;
            } elseif ($time == 90) {
                return 2200;
            }
        } elseif ($teacher->position == 'senior') {
            if ($time == 40) {
                return 1550;
            } elseif ($time == 60) {
                return 2300;
            } elseif ($time == 90) {
                return 2500;
            }
        }
            return 0;
    }
}
