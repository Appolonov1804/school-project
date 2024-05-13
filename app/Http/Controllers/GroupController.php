<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Teacher;
use App\Models\Group;
use App\Models\GroupLesson;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Controllers\StoreGroupRequest;
use App\Http\Requests\Controllers\UpdateGroupRequest;
use App\Http\Requests\Controllers\StoreStudentRequest;
use App\Http\Requests\Controllers\UpdateStudentRequest;
use App\Models\Student;

class GroupController extends Controller
{
    public function create()
    {
        $groups = Group::all();
        $students = Student::all();
        $teachers = Teacher::all();
        return view('groups.create', compact('teachers', 'groups', 'students'));
    }

    public function store(StoreGroupRequest $request, StoreStudentRequest $storeStudentRequest)
    {
        $data = $request->validate($request->rules());
        $studentData = $storeStudentRequest->validate($storeStudentRequest->rules());


        $user = Auth::user();
        
       
        if ($user->teacher) {
            
            $group = Group::create([
                'course' => $data['course'],
                'teachers_id' => $user->teacher->id, /
            ]);

            if (isset($studentData['students'])) {
                $students = [];
                foreach ($studentData['students'] as $studentName) {
                    
                    $students[] = new Student(['student' => $studentName]);
                }
    
              
                $group->students()->saveMany($students);
            } 
            
            
          
            return redirect()->route('groups.show', ['teacher' => $user->teacher->id]);
        } else {
            
            return redirect()->back()->with('error', 'Вы не являетесь учителем.');
        }

    }


    public function showGroup(Group $group, Teacher $teacher, Student $student, GroupLesson $groupLesson)
    {
        
        $teacher->load('groups');
    
       
        $groups = $teacher->groups;

        foreach ($groups as $group) {
            $group->load('students'); // Загружаем студентов для каждой группы
        }
    
        $groupLessons = $group->groupLessons;
        // Остальные переменные
        $students = $group->students;
        $teachers = Teacher::all();
      
    
        return view('groups.show', compact('group', 'teacher', 'teachers', 'groups', 'students', 'student', 'groupLessons', 'groupLesson'));
    }


    public function edit(Group $group, Teacher $teacher, Student $student)
    {
        $groups = Group::all();
        $teachers = Teacher::all();
        $students = Student::all();
        return view('groups.edit', compact('group', 'teacher', 'teachers', 'groups', 'students', 'student')); 
    }


    public function update(UpdateGroupRequest $request, UpdateStudentRequest $updateStudentRequest, Group $group, Teacher $teacher, Student $student)
    {
        $data = $request->validate($request->rules());
        $studentData = $updateStudentRequest->validate($updateStudentRequest->rules());
        $teacherId = $group->teachers_id;
    
        // Обновление данных группы
        $group->update([
            'course' => $data['course'],
            // 'teachers_id' => $data['teachers_id'], // Если требуется обновление ID учителя
        ]);
    
        // Обновление данных студентов
        $group->update([
            'course' => $data['course'],
        ]);
    
        // Обновление данных студентов
        if (isset($studentData['students'])) {
            foreach ($studentData['students'] as $studentId => $studentName) {
                $student = Student::find($studentId);
                if ($student) {
                    $student->update(['student' => $studentName]);
                }
            }
        }
    
        // Получение учителя, связанного с группой
        $teacher = $group->teacher;
    
        // Перенаправление на страницу с информацией о группе
        return redirect()->route('groups.show', ['teacher' => $teacherId, 'group' => $group->id]);
    }


    public function delete($groupId)
    {
        $group = Group::find($groupId);
        $teacherId = $group->teachers_id;
        $groupId = $group->id;
        if ($group) {
            $group->delete();
            return redirect()->route('groups.show', ['group' => $group->id, 'teacher' => $teacherId]);
        } else {
            return redirect()->route('groups.show', ['group' => $group->id, 'teacher' => $teacherId])->with('error', 'Запись не найдена');
        }
    }

    public function destroy(Group $group)
    {
        $group->delete();
        $teacherId = $group->teachers_id;
        $groupId = $group->id;
        return redirect()->route('groups.show', ['group' => $group->id, 'teacher' => $teacherId]);
    }

}
