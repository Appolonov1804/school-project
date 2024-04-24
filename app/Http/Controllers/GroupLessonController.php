<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GroupLesson;
use App\Models\Group;
use App\Models\Student;
use App\Http\Requests\Controllers\StoreGroupLessonRequest;
use App\Http\Requests\Controllers\UpdateGroupLessonRequest;

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
            'attendance' => $data['attendance'],
            'group_id' => $group->id,
        ]);
    
        // Связываем каждого студента с уроком и указываем посещаемость
        foreach ($data['student_id'] as $index => $studentId) {
            $attendance = $data['attendance'][$index];
            $groupLesson->students()->attach($studentId, ['attendance' => $attendance]);
        }
    
        return redirect()->route('groups.show', ['group' => $group->id]);
    }
    public function editLesson(Group $group, $groupLesson_id, GroupLesson $groupLesson)
    {
        
        $groupLessons = $group->groupLessons()->findOrFail($groupLesson_id);
    
    
        return view('groupsLessons.edit', compact('group', 'teachers', 'groupLessons'));
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
