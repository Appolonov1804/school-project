<?php

namespace App\Services;

use App\Models\Teacher;

class TrialLessonSalaryService
{
    public function updatePaidStatus(Teacher $teacher)
    {
        $teacher->trialLesson()->where('paid', 0)->update(['paid' => 1]);
    }

    public function salary($trialLessons, $teacher)
    {
        $totalSalary = 0;
        foreach ($trialLessons as $trialLesson) {
            if ($trialLesson->paid == 0) {
                $totalSalary += $this->calculateSalary($teacher, $trialLesson);
            }
        }
        return $totalSalary;
    }

    public function calculateSalary($teacher, $trialLesson)
    {
        $time = $trialLesson->time;
        $form = $trialLesson->form;

        if ($form !== 'Пробный') {
            if ($teacher->position === 'junior') {
                if ($time == 40) {
                    return 1250;
                } elseif ($time == 60) {
                    return 1900;
                } elseif ($time == 90) {
                    return 2200;
                }
            } elseif ($teacher->position === 'senior') {
                if ($time == 40) {
                    return 1550;
                } elseif ($time == 60) {
                    return 2300;
                } elseif ($time == 90) {
                    return 2500;
                }
            }
        } elseif ($teacher->position === 'junior') {
            if ($time == 40) {
                return 850;
            } elseif ($time == 60) {
                return 1500;
            } elseif ($time == 90) {
                return 1800;
            }
        } elseif ($teacher->position === 'senior') {
            if ($time == 40) {
                return 1150;
            } elseif ($time == 60) {
                return 1900;
            } elseif ($time == 90) {
                return 2100;
            }
        }
                return 0;
    }
}
