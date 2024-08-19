<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use App\Models\Teacher;
use App\Models\Report;
use App\Models\Roster;
use App\Models\LessonDetail;
use App\Models\Group;
use App\Http\Requests\Controllers\StoreRosterRequest;
use App\Http\Requests\Controllers\UpdateRosterRequest;
use App\Http\Requests\Controllers\StoreLessonRequest;
use App\Http\Requests\Controllers\UpdateLessonRequest;

class LessonController extends Controller 
{

    public function create($rosterId) 
    {
        $roster = Roster::findOrFail($rosterId);
        return view('lessons.create', compact('roster'));
    }

    public function store(StoreLessonRequest $request, Roster $roster)
    {
        $rosters = Roster::all();
        $lessonDetails = LessonDetail::all();
        $data = $request->validated();
      
        $lessonDetail = LessonDetail::create([
            'date' => $data['date'],
            'topic' => $data['topic'],
            'attendance' => $data['attendance'],
            'roster_id' => $data['roster_id'],
        ]);
        $roster = $lessonDetail->roster;

        $teacherId = $roster->teachers_id;
    
        return redirect()->route('teachers.show', ['teacher' => $teacherId]);
    }

    public function editLesson(Roster $roster, $lesson_id, LessonDetail $lessonDetail)
    {
        
        $lessonDetail = $roster->lessonDetails()->findOrFail($lesson_id);
    
        $teachers = Teacher::all();
        $reports = Report::all();
    
        return view('lessons.edit', compact('roster', 'teachers', 'reports', 'lessonDetail'));
    }
        
    public function updateLesson(UpdateLessonRequest $request, Roster $roster, $lesson_id)
    { 
        $lessonDetail = LessonDetail::findOrFail($lesson_id);
        $data = $request->validated();
        
        $lessonDetail->update([
            'date' => $data['date'],
            'topic' => $data['topic'],
            'attendance' => $data['attendance'],
        ]);

        $roster = $lessonDetail->roster;
        $teacherId = $roster->teachers_id;
    
        return redirect()->route('teachers.show', ['teacher' => $teacherId]);
    }
    
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
            if ($roster->type == 'Персональный') {
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
    
    public function delete($rosterId, $lessonId)
    {
        $lessonDetail = LessonDetail::find($lessonId);
        $roster = $lessonDetail->roster;
        $teacherId = $roster->teachers_id;
        
        if ($lessonDetail) {
            $lessonDetail->delete();
                
            return redirect()->route('teachers.show', ['teacher' => $teacherId]);
        } else {
            return redirect()->route('teachers.show', ['teacher' => $teacherId])->with('error', 'Урок не найден');
        }
    }

    public function destroy($rosterId, $lessonId)
    {
        $lessonDetail = LessonDetail::find($lessonId);
        $roster = $lessonDetail->roster;
        $teacherId = $roster->teachers_id;
                
        if ($lessonDetail) {
            $lessonDetail->delete();
    
            return redirect()->route('teachers.show', ['teacher' => $teacherId]);
        } else {
                return redirect()->route('teachers.show', ['teacher' => $teacherId])->with('error', 'Урок не найден');
        }

    }
}