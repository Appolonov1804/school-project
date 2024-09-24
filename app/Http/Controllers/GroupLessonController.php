<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GroupLesson;
use App\Models\Group;
use App\Models\Student;
use App\Models\GroupLessonStudent;
use App\Http\Requests\Controllers\GroupLessonRequest;
use App\Models\Teacher;

class GroupLessonController extends Controller
{
    public function create($groupId, Request $request)
    {
        $group = Group::findOrFail($groupId);
        $students = $group->students;
        $page = $request->input('page', 1);
        return view('groupsLessons.create', compact('group', 'students', 'page'));
    }

    public function store(GroupLessonRequest $request, Group $group, LessonController $lessonController)
    {
        $data = $request->validated();

        $groupLesson = GroupLesson::create([
            'date' => $data['date'],
            'topic' => $data['topic'],
            'time' => $data['time'],
            'group_id' => $group->id,
        ]);

        foreach ($data['attendance'] as $studentId => $attendanceData) {
            if (isset($attendanceData['attendance'])) {

                GroupLessonStudent::create([
                    'group_lesson_id' => $groupLesson->id,
                    'student_id' => $studentId,
                    'attendance' => $attendanceData['attendance'],
                    'score' => isset($data['score'][$studentId]['score']) ? $data['score'][$studentId]['score'] : null,
                ]);
            } else {
                return redirect()->back()->with('error', 'Отметьте посещаемость для всех студентов');
            }
        }

        $attendances = $groupLesson->attendance;
        $teacherId = $group->teachers_id;
        $page = $request->input('page', 1);

        return redirect()->route('groups.show', ['group' => $group->id, 'teacher' => $teacherId, 'page' => $page]);
    }

    public function editLesson(Group $group, $group_lesson_id, Request $request)
    {

        $lesson = GroupLesson::where('group_id', $group->id)
                            ->findOrFail($group_lesson_id);

        $page = $request->input('page', 1);
        return view('groupsLessons.edit', [
            'group' => $group,
            'lesson' => $lesson,
            'page' => $page,
        ]);

    }

    public function updateLesson(GroupLessonRequest $request, Group $group, GroupLesson $lesson)
    {
        $data = $request->validated();

        $lesson->update([
            'date' => $data['date'],
            'topic' => $data['topic'],
            'time' => $data['time'],
        ]);

        foreach ($data['attendance'] as $studentId => $attendanceData) {

            $attendance = GroupLessonStudent::where('group_lesson_id', $lesson->id)
                                             ->where('student_id', $studentId)
                                             ->first();

            if ($attendance) {

                $attendance->update([
                    'attendance' => $attendanceData['attendance'],
                    'score' => isset($data['score'][$studentId]['score']) ? $data['score'][$studentId]['score'] : null,

                ]);
            }
        }

        $teacherId = $group->teachers_id;

        return redirect()->route('groups.show', ['group' => $group->id, 'teacher' => $teacherId, 'page' => $data['number_page']]);
    }

    public function delete($groupId, $groupLesson_id, Request $request)
    {
        $groupLessons = GroupLesson::find($groupLesson_id);
        $group = $groupLessons->group;
        $teacherId = $group->teachers_id;

        if ($groupLessons) {
            $groupLessons->delete();
            $page = $request->input('page', 1);
            return redirect()->route('groups.show', ['group' => $group->id, 'teacher' => $teacherId, 'page' => $page]);
        } else {
                return redirect()->route('groups.show', ['group' => $group->id, 'teacher' => $teacherId])->with('error', 'Урок не найден');
        }
    }

    public function destroy($rosterId, $groupLesson_id, Request $request)
    {
        $groupLessons = GroupLesson::find($groupLesson_id);
        $group = $groupLessons->group;
        $teacherId = $group->teachers_id;

            if ($groupLessons) {
                $groupLessons->delete();
                $page = $request->input('page', 1);
                return redirect()->route('groups.show', ['group' => $group->id, 'teacher' => $teacherId, 'page' => $page]);
            } else {
                return redirect()->route('groups.show', ['group' => $group->id, 'teacher' => $teacherId])->with('error', 'Урок не найден');
            }

    }
}
