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

        // Получаем текущего авторизованного пользователя
        $user = Auth::user();
        
        // Проверяем наличие ассоциированного учителя
        if ($user->teacher) {
            // Создаем запись в журнале, передавая id учителя, который создал запись
            $group = Group::create([
                'course' => $data['course'],
                'teachers_id' => $user->teacher->id, // Используем id учителя, ассоциированного с пользователем
            ]);

            if (isset($studentData['students'])) {
                $students = [];
                foreach ($studentData['students'] as $studentName) {
                    // Создаем данные для студента, включая group_id
                    $students[] = new Student(['student' => $studentName]);
                }
    
                // Создаем всех студентов и связываем их с текущей группой
                $group->students()->saveMany($students);
            } 
            
            
            // После создания записи перенаправляем пользователя на страницу учителя
            return redirect()->route('groups.show', ['teacher' => $user->teacher->id]);
        } else {
            // Если у пользователя нет ассоциированного учителя, обрабатываем это соответствующим образом
            return redirect()->back()->with('error', 'Вы не являетесь учителем.');
        }

    }


    public function showGroup(Group $group, Teacher $teacher, Student $student, GroupLesson $groupLesson)
    {
        // Загрузка всех групп, связанных с учителем
        $teacher->load('groups');
    
        // Получение загруженных групп учителя
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


    public function edit(Group $group, Teacher $teacher)
    {
        $groups = Group::all();
        $teachers = Teacher::all();
        return view('groups.edit', compact('group', 'teacher', 'teachers', 'groups'));
    }


    public function update(UpdateGroupRequest $request, Group $group, Teacher $teacher)
    {
        $teachers = Teacher::all();
        $groups = Group::all();
  

        $data = $request->validated();
 
        $group->update($data);
        $teacherId = $group->teachers_id;
        $groupId = $group->id;
    
        return redirect()->route('groups.show', ['group' => $group->id, 'teacher' => $teacherId]);
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
