<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GroupLesson;
use App\Models\Group;
use App\Models\Student;
use App\Models\GroupLessonStudent;
use App\Http\Requests\Controllers\StoreGroupLessonRequest;
use App\Http\Requests\Controllers\UpdateGroupLessonRequest;
use App\Models\Teacher;

class GroupLessonController extends Controller
{
    public function create($groupId) 
    {
        $group = Group::findOrFail($groupId);
        $students = $group->students;
        return view('groupsLessons.create', compact('group', 'students'));
    }

    public function store(StoreGroupLessonRequest $request, Group $group)
    {
        $data = $request->validated();
        
        // Создаем запись об уроке
        $groupLesson = GroupLesson::create([
            'date' => $data['date'],
            'topic' => $data['topic'],
            'time' => $data['time'],
            'group_id' => $group->id,
        ]);
        
        // Сохраняем посещаемость каждого студента
        foreach ($data['attendance'] as $attendanceArray) {
            foreach ($attendanceArray as $attendance) {
                // Проверяем, является ли $attendanceArray массивом
                if (is_array($attendanceArray) && isset($attendanceArray['attendance'])) {
                    GroupLessonStudent::create([
                        'group_lesson_id' => $groupLesson->id,
                        'student_id' => $attendanceArray['student_id'], // Предполагается, что 'student_id' также передается
                        'attendance' => $attendanceArray['attendance'],
                    ]);
                } else {
                    // Обработка, если данные не соответствуют ожидаемому формату
                }
            }
        }
        
        return redirect()->route('groups.show', ['group' => $group->id]);
    }
public function editLesson(Group $group, $group_lesson_id, GroupLesson $groupLesson)
{
    $groupLesson = $group->groupLessons()->findOrFail($group_lesson_id);
    $teachers = Teacher::all();

    return view('groupsLessons.edit', compact('group', 'teachers', 'groupLesson'));
}
        
    public function updateLesson(UpdateGroupLessonRequest $request, Group $roster, $groupLesson_id)
{
    
    $groupLessons = GroupLesson::findOrFail($groupLesson_id);

    $data = $request->validated();

  
    $groupLessons->update([
        'date' => $data['date'],
        'topic' => $data['topic'],
        'time' => $data['time'],
        'attendance' => $data['attendance'],
    ]);


        $group = $groupLessons->group;

        $teacherId = $group->teachers_id;
    
        return redirect()->route('teachers.show', ['teacher' => $teacherId]);
}
    
    
        public function delete($groupId, $groupLesson_id)
        {
            $groupLessons = GroupLesson::find($groupLesson_id);
                $group = $groupLessons->group;

                $teacherId = $group->teachers_id;
        
            if ($groupLessons) {
                $groupLessons->delete();
                
                return redirect()->route('teachers.show', ['teacher' => $teacherId]);
            } else {
                return redirect()->route('teachers.show', ['teacher' => $teacherId])->with('error', 'Урок не найден');
            }
        }

        public function destroy($rosterId, $groupLesson_id)
        {
                $groupLessons = GroupLesson::find($groupLesson_id);
                    $group = $groupLessons->group;

                    $teacherId = $group->teachers_id;
                
                if ($groupLessons) {
                    $groupLessons->delete();
    
                    return redirect()->route('teachers.show', ['teacher' => $teacherId]);
                } else {
                    return redirect()->route('teachers.show', ['teacher' => $teacherId])->with('error', 'Урок не найден');
                }

        }
}
