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
        foreach ($data['attendance'] as $studentId => $attendanceData) {
            if (isset($attendanceData['attendance'])) {
                // Создаем запись о посещаемости для конкретного студента на данном уроке
                GroupLessonStudent::create([
                    'group_lesson_id' => $groupLesson->id,
                    'student_id' => $studentId,
                    'attendance' => $attendanceData['attendance'],
                ]);
            } else {
                return redirect()->back()->with('error', 'Отметьте посещаемость для всех студентов');
            }
        }
    
        // Получаем данные о посещаемости для данного урока через связь в модели GroupLesson
        $attendances = $groupLesson->attendance;
    
        $teacherId = $group->teachers_id;
        
        return redirect()->route('groups.show', ['group' => $group->id, 'teacher' => $teacherId]);
    }
    public function editLesson(Group $group, $group_lesson_id)
    {
        // Находим урок по идентификатору в рамках указанной группы
        $lesson = GroupLesson::where('group_id', $group->id)
                            ->findOrFail($group_lesson_id);

        // Загружаем вид с формой редактирования урока и передаем данные в вид
        return view('groupsLessons.edit', [
            'group' => $group,
            'lesson' => $lesson,
        ]);
    }
    
    public function updateLesson(UpdateGroupLessonRequest $request, Group $group, GroupLesson $lesson)
    {
        $data = $request->validated();
    
        // Обновляем данные о уроке
        $lesson->update([
            'date' => $data['date'],
            'topic' => $data['topic'],
            'time' => $data['time'],
        ]);
    
        // Обновляем посещаемость каждого студента
        foreach ($data['attendance'] as $studentId => $attendanceData) {
            // Находим запись о посещаемости для конкретного студента на данном уроке
            $attendance = GroupLessonStudent::where('group_lesson_id', $lesson->id)
                                             ->where('student_id', $studentId)
                                             ->first();
    
            if ($attendance) {
                // Обновляем данные о посещаемости для студента на уроке
                $attendance->update([
                    'attendance' => $attendanceData['attendance'],
                ]);
            }
        }
        
        $teacherId = $group->teachers_id;

        return redirect()->route('groups.show', ['group' => $group->id, 'teacher' => $teacherId]);
    }
    
        public function delete($groupId, $groupLesson_id)
        {
            $groupLessons = GroupLesson::find($groupLesson_id);
                $group = $groupLessons->group;

                $teacherId = $group->teachers_id;
        
            if ($groupLessons) {
                $groupLessons->delete();
                
                return redirect()->route('groups.show', ['group' => $group->id, 'teacher' => $teacherId]);
            } else {
                return redirect()->route('groups.show', ['group' => $group->id, 'teacher' => $teacherId])->with('error', 'Урок не найден');
            }
        }

        public function destroy($rosterId, $groupLesson_id)
        {
                $groupLessons = GroupLesson::find($groupLesson_id);
                    $group = $groupLessons->group;

                    $teacherId = $group->teachers_id;
                
                if ($groupLessons) {
                    $groupLessons->delete();
    
                    return redirect()->route('groups.show', ['group' => $group->id, 'teacher' => $teacherId]);
                } else {
                    return redirect()->route('groups.show', ['group' => $group->id, 'teacher' => $teacherId])->with('error', 'Урок не найден');
                }

        }
}