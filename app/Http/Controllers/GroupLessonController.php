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

    public function store(StoreGroupLessonRequest $request, Group $group, LessonController $lessonController)
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

        return redirect()->route('groups.show', ['group' => $group->id, 'teacher' => $teacherId]);
    }

    public function editLesson(Group $group, $group_lesson_id)
    {

        $lesson = GroupLesson::where('group_id', $group->id)
                            ->findOrFail($group_lesson_id);
        
        return view('groupsLessons.edit', [
            'group' => $group,
            'lesson' => $lesson,
        ]);
    }

    public function updateLesson(UpdateGroupLessonRequest $request, Group $group, GroupLesson $lesson)
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

        return redirect()->route('groups.show', ['group' => $group->id, 'teacher' => $teacherId]);
    }

    public function updatePaidStatus(Teacher $teacher)
    {
        $teacher->groups()->each(function ($group) {
            $group->groupLessons()->where('paid', 0)->update(['paid' => 1]);
        });
    }


    public function salary($groupLessons, $teacher)
    {
        $totalSalary = 0;

        foreach ($groupLessons as $groupLesson) {
            $allAbsent = true;

            foreach ($groupLesson->attendance as $attendance) {
                if ($attendance != 'не было') {
                    $allAbsent = false;
                    break;
            }
        }
        if ($allAbsent) {
            if ($teacher->position == 'junior') {
                $totalSalary += 1150;
            } elseif ($teacher->position == 'senior') {
                $totalSalary += 1250;
            }
        } else {
            $totalSalary += $this->calculateSalary($teacher, $groupLesson,);
        }
      }
            return $totalSalary;
    }

    public function calculateSalary($teacher, $groupLesson)
    {
        $time = $groupLesson->time;

        if ($teacher->position == 'junior') {
            if ($time == 40) {
                return 1250;
            } elseif ($time == 60) {
                return 1900;
            } elseif ($time == 90) {
                return 2500;
            }
        } elseif ($teacher->position == 'senior') {
            if ($time == 40) {
                return 1550;
            } elseif ($time == 60) {
                return 2300;
            } elseif ($time == 90) {
                return 2500;
            }
        }
            return 0;
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
