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

    // Возвращаем редирект на страницу с журналами
    return redirect()->route('admin.teacher.teacher', ['roster' => $roster->id, 'lesson_id' => $lessonDetail->id]);
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

        public function delete($lessonId)
        {
        $lessonDetail = Roster::find($lessonId);
        if ($lessonDetail) {
            $lessonDetail->delete();
            return redirect()->route('admin.teacher.teacher');
        } else {
            return redirect()->route('rosters.rosters')->with('error', 'Запись не найдена');
        }
        }

        public function destroy(LessonDetail $lessonDetail)
        {
            $lessonDetail->delete();
            return redirect()->route('admin.teacher.teacher');
        }
}