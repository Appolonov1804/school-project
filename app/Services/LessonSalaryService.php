<?php

namespace App\Services;

use App\Models\Teacher;

class LessonSalaryService
{
    public function updatePaidStatus(Teacher $teacher)
    {
        $teacher->rosters()->each(function ($roster) {
            $roster->lessonDetails()->where('paid', 0)->update(['paid' => 1]);
        });
    }

    public function salary($rosters, $teacher)
    {
        $totalSalary = 0;

        foreach ($rosters as $roster) {
            $lessonDetails = $roster->lessonDetails()->where('paid', 0)->get();

            foreach ($lessonDetails as $lessonDetail) {
                $salary = $this->calculateSalary($teacher, $roster, $lessonDetail);
                $totalSalary += $salary;
            }
        }

        return $totalSalary;
    }

    private function calculateSalary($teacher, $roster, $lessonDetail)
    {
        $salary = 0;

        if (!empty($lessonDetail->attendance) && !empty($roster->time)) {

            $attendance = $lessonDetail->attendance;
            if ($roster->courseTypes && $roster->courseTypes->name == 'Персональный') {
                if ($teacher->position == 'junior') {
                    if ($roster->time == 40) {
                        $salary += ($attendance == 'был/была') ? 1450 : 725;
                    } elseif ($roster->time == 60) {
                        $salary += ($attendance == 'был/была') ? 2100 : 1050;
                    } elseif ($roster->time == 90) {
                        $salary += ($attendance == 'был/была') ? 2400 : 1200;
                    } elseif ($roster->time == 30) {
                        $salary += ($attendance == 'был/была') ? 1150 : 575;
                    }
                } elseif ($teacher->position == 'senior') {
                    if ($roster->time == 40) {
                        $salary += ($attendance == 'был/была') ? 1750 : 875;
                    } elseif ($roster->time == 60) {
                        $salary += ($attendance == 'был/была') ? 2500 : 1250;
                    } elseif ($roster->time == 90) {
                        $salary += ($attendance == 'был/была') ? 2700 : 1350;
                    } elseif ($roster->time == 30) {
                        $salary += ($attendance == 'был/была') ? 1350 : 675;
                    }
                }
            } else {
                if ($teacher->position == 'junior') {
                    if ($roster->time == 40) {
                        $salary += ($attendance == 'был/была') ? 1250 : 625;
                    } elseif ($roster->time == 60) {
                        $salary += ($attendance == 'был/была') ? 1900 : 950;
                    } elseif ($roster->time == 90) {
                        $salary += ($attendance == 'был/была') ? 2200 : 1100;
                    } elseif ($roster->time == 30) {
                        $salary += ($attendance == 'был/была') ? 950 : 475;
                    }
                } elseif ($teacher->position == 'senior') {
                    if ($roster->time == 40) {
                        $salary += ($attendance == 'был/была') ? 1550 : 775;
                    } elseif ($roster->time == 60) {
                        $salary += ($attendance == 'был/была') ? 2300 : 1150;
                    } elseif ($roster->time == 90) {
                        $salary += ($attendance == 'был/была') ? 2500 : 1250;
                    } elseif ($roster->time == 30) {
                        $salary += ($attendance == 'был/была') ? 1150 : 575;
                    }
                }
            }
        }
        return $salary;
    }
}