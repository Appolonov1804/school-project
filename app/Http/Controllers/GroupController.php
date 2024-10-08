<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Teacher;
use App\Models\Group;
use App\Models\GroupLesson;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Controllers\GroupRequest;
use App\Http\Requests\Controllers\StudentRequest;
use App\Models\Student;

class GroupController extends Controller
{
    public function create(Request $request)
    {
        $groups = Group::all();
        $students = Student::all();
        $teachers = Teacher::all();
        $page = $request->input('page', 1);
        return view('groups.create', compact('teachers', 'groups', 'students', 'page'));
    }

    public function store(GroupRequest $request, StudentRequest $storeStudentRequest)
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
            $page = request()->input('page', 1);
            return redirect()->route('groups.show', ['teacher' => $user->teacher->id, 'page' => $page]);
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


    public function update(GroupRequest $request, StudentRequest $updateStudentRequest, Group $group, Teacher $teacher, Student $student)
    {
        $data = $request->validate($request->rules());
        $studentData = $updateStudentRequest->validate($updateStudentRequest->rules());
        $teacherId = $group->teachers_id;

        $group->update([
            'course' => $data['course'],
            'schedule' => $data['schedule'],
        ]);


        if (isset($studentData['students'])) {
            $existingStudentId = array_keys($studentData['students']);
            $group->students()->whereNotIn('id', $existingStudentId)->delete();
            foreach ($studentData['students'] as $studentId => $studentName) {
                $student = Student::find($studentId);
                if ($student) {
                    $student->update(['student' => $studentName]);
                }
            }
        }

        if ($request->has('new_students')) {
            $newStudents = [];
            foreach ($request->input('new_students') as $newStudentName) {
                $newStudents[] = new Student(['student' => $newStudentName]);
            }
            $group->students()->saveMany($newStudents);
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
            $page = request()->input('page', 1);
            return redirect()->route('groups.show', ['group' => $group->id, 'teacher' => $teacherId, 'page' => $page]);
        } else {
            return redirect()->route('groups.show', ['group' => $group->id, 'teacher' => $teacherId])->with('error', 'Запись не найдена');
        }
    }

    public function destroy(Group $group)
    {
        $group->delete();
        $teacherId = $group->teachers_id;
        $groupId = $group->id;
        $page = request()->input('page', 1);
        return redirect()->route('groups.show', ['group' => $group->id, 'teacher' => $teacherId, 'page' => $page]);
    }

}
