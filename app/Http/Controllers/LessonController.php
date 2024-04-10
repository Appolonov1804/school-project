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
        // Находим урок по lesson_id и убеждаемся, что он принадлежит данному журналу
        $lessonDetail = $roster->lessonDetails()->findOrFail($lesson_id);
    
        $teachers = Teacher::all();
        $reports = Report::all();
    
        return view('lessons.edit', compact('roster', 'teachers', 'reports', 'lessonDetail'));
    }
        
    public function updateLesson(UpdateLessonRequest $request, Roster $roster, $lesson_id)
{
    // Находим урок, который нужно обновить
    $lessonDetail = LessonDetail::findOrFail($lesson_id);

    // Получаем данные из запроса
    $data = $request->validated();

    // Обновляем данные урока
    $lessonDetail->update([
        'date' => $data['date'],
        'topic' => $data['topic'],
        'attendance' => $data['attendance'],
    ]);


        $roster = $lessonDetail->roster;

        $teacherId = $roster->teachers_id;
    
        return redirect()->route('teachers.show', ['teacher' => $teacherId]);
}


public function salary(Roster $roster, Teacher $teacher, LessonDetail $lessonDetail) 
{
    $salary = 0;
    if ($teacher->position == 'junior' || $roster->time == 40 || $lessonDetail == 'был' || $lessonDetail == 'была') {
        $salary += 1250;
    } elseif ($teacher->position == 'junior' || $roster->time == 60 || $lessonDetail == 'был' || $lessonDetail == 'была') {
        $salary += 1900;
    } elseif ($teacher->position == 'junior' || $roster->time == 90 || $lessonDetail == 'был' || $lessonDetail == 'была') {
        $salary += 2200;
    } elseif ($teacher->position == 'senior' || $roster->time == 40 || $lessonDetail == 'был' || $lessonDetail == 'была') {
        $salary += 1550;
    } elseif ($teacher->position == 'senior' || $roster->time == 60 || $lessonDetail == 'был' || $lessonDetail == 'была') {
        $salary += 2300;
    } elseif ($teacher->position == 'senior' || $roster->time == 90 || $lessonDetail == 'был' || $lessonDetail == 'была') {
        $salary += 2500;
    } elseif ($teacher->position == 'junior' || $roster->time == 40 || $lessonDetail == 'не был' || $lessonDetail == 'не была') {
        $salary += 625;
    } elseif ($teacher->position == 'junior' || $roster->time == 60 || $lessonDetail == 'не был' || $lessonDetail == 'не была') {
        $salary += 950;
    } elseif ($teacher->position == 'junior' || $roster->time == 90 || $lessonDetail == 'не был' || $lessonDetail == 'не была') {
        $salary += 1100;
    } elseif ($teacher->position == 'senior' || $roster->time == 40 || $lessonDetail == 'не был' || $lessonDetail == 'не была') {
        $salary += 775;
    } elseif ($teacher->position == 'senior' || $roster->time == 60 || $lessonDetail == 'не был' || $lessonDetail == 'не была') {
        $salary += 1150;
    } elseif ($teacher->position == 'senior' || $roster->time == 90 || $lessonDetail == 'не был' || $lessonDetail == 'не была') {
        $salary += 1250;
    } else {
        $salary;
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