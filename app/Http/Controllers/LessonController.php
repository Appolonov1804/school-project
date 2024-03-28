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

    public function store(StoreLessonRequest $request)
    {
        $teachers = Teacher::all();
        $rosters = Roster::all();
        $lessonDetails = LessonDetail::all();
        $data = $request->validated();
      
        $lessonDetail = LessonDetail::addDetails([
            'date' => $data['date'],
            'topic' => $data['topic'],
            'attendance' => $data['attendance'],
            'roster_id' => $data['roster_id'],
        ]);
    
        return redirect()->route('admin.teacher.teacher');
    }
    public function editLesson(Roster $roster, $lesson_id, LessonDetail $lessonDetail)
    {
        // Находим урок по lesson_id и убеждаемся, что он принадлежит данному журналу
        $lessonDetail = $roster->lessonDetails()->findOrFail($lesson_id);
    
        $teachers = Teacher::all();
        $reports = Report::all();
    
        return view('rosters.editLesson', compact('roster', 'teachers', 'reports', 'lessonDetail'));
    }
        
    public function updateLesson(UpdateLessonRequest $request, Roster $roster, LessonDetail $lessonDetail)
    {
        // Получаем уроки для данного Roster
        $lessonDetails = $roster->lessonDetails;
    
        // Перебираем каждый урок для обновления
        foreach ($lessonDetails as $lessonDetail) {
            // Ищем урок по идентификатору
            $lesson_id = $lessonDetail->id;
    
            // Получаем данные из запроса
            $data = $request->validated();
    
            // Обновляем данные урока
            $lesson = LessonDetail::findOrFail($lesson_id);
            $lesson->update([
                'date' => $data['date'],
                'topic' => $data['topic'],
                'attendance' => $data['attendance'],
            ]);
        }
    
        // Возвращаем редирект на соответствующую страницу
        return redirect()->route('admin.teacher.teacher', $roster->id);
    }
    
        public function addDetails($rosterId)
        {
        $roster = Roster::findOrFail($rosterId);
        return view('rosters.add_details', compact('roster'));
        }
    
        public function saveDetails(UpdateRosterRequest $request, $rosterId)
        {
            $roster = Roster::findOrFail($rosterId);
            $validatedData = $request->validated();
    
            $lessonDetail = new LessonDetail([
                'date' => $validatedData['date'],
                'topic' => $validatedData['topic'],
                'attendance' => $validatedData['attendance'],
                'roster_id' => $roster->id, // Передаем значение roster_id
            ]);
    
            $lessonDetail->save();
    
            return redirect()->route('admin.teacher.teacher');
        }
}