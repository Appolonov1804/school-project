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
                'schedule' => $data['schedule'],
                'teachers_id' => $user->teacher->id,
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
            $group->load('students');
        }

        $groupLessons = $group->groupLessons;
        $students = $group->students;
        $teachers = Teacher::all();
        $groupPage = request()->input('page', 1);
        $groups = $teacher->groups()->with('groupLessons')->paginate(2, ['*'], 'page', $groupPage);

        return view('groups.show', compact('group', 'teacher', 'teachers', 'groups', 'students', 'student', 'groupLessons', 'groupLesson'));
    }


    public function edit(Group $group, Teacher $teacher, Student $student)
    {
        $groups = Group::all();
        $teachers = Teacher::all();
        $students = Student::all();
        $groupPage = request()->input('page', 1);
        return view('groups.edit', compact('group', 'teacher', 'teachers', 'groups', 'students', 'student', 'groupPage'));
    }


    public function update(UpdateGroupRequest $request, UpdateStudentRequest $updateStudentRequest, Group $group, Teacher $teacher, Student $student)
    {
        $data = $request->validate($request->rules());
        $studentData = $updateStudentRequest->validate($updateStudentRequest->rules());
        $teacherId = $group->teachers_id;

        $group->update([
            'course' => $data['course'],
            'schedule' => $data['schedule'],
        ]);


        if (isset($studentData['students'])) {
            foreach ($studentData['students'] as $studentId => $studentName) {
                $student = Student::find($studentId);
                if ($student) {
                    $student->update(['student' => $studentName]);
                }
            }
        }

        $teacher = $group->teacher;
        $page = $request->input('page', 1);

        return redirect()->route('groups.show', ['teacher' => $teacherId, 'group' => $group->id, 'page' => $page]);
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
