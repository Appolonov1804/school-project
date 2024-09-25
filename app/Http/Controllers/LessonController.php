<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use App\Models\Teacher;
use App\Models\Report;
use App\Models\Roster;
use App\Models\LessonDetail;
use App\Models\Group;
use App\Http\Requests\Controllers\RosterRequest;
use Illuminate\Http\Request;
use App\Http\Requests\Controllers\LessonRequest;

class LessonController extends Controller
{

    public function create($rosterId, Request $request)
    {
        $roster = Roster::findOrFail($rosterId);
        $page = $request->input('page', 1);
        return view('lessons.create', compact('roster', 'page'));
    }

    public function store(LessonRequest $request, Roster $roster)
    {
        $rosters = Roster::all();
        $lessonDetails = LessonDetail::all();
        $data = $request->validated();

        $lessonDetail = LessonDetail::create([
            'date' => $data['date'],
            'topic' => $data['topic'],
            'attendance' => $data['attendance'],
            'time' => $data['time'],
            'score' => $data['score'],
            'roster_id' => $data['roster_id'],
        ]);
        $roster = $lessonDetail->roster;

        $teacherId = $roster->teachers_id;
        $page = $request->input('page', 1);

        return redirect()->route('teachers.show', ['teacher' => $teacherId, 'page' => $page]);
    }

    public function editLesson(Roster $roster, $lesson_id, LessonDetail $lessonDetail, Request $request)
    {
        $page = $request->input('page', 1);
        $lessonDetail = $roster->lessonDetails()->findOrFail($lesson_id);

        $teachers = Teacher::all();
        $reports = Report::all();

        return view('lessons.edit', compact('roster', 'teachers', 'reports', 'lessonDetail', 'page'));
    }

    public function updateLesson(LessonRequest $request, Roster $roster, $lesson_id)
    {
        $lessonDetail = LessonDetail::findOrFail($lesson_id);
        $data = $request->validated();

        $lessonDetail->update([
            'date' => $data['date'],
            'topic' => $data['topic'],
            'attendance' => $data['attendance'],
            'time' => $data['time'],
            'score' => $data['score'],
        ]);

        $roster = $lessonDetail->roster;
        $teacherId = $roster->teachers_id;

        return redirect()->route('teachers.show', ['teacher' => $teacherId, 'page' => $data['number_page']]);
    }

    public function delete($rosterId, $lessonId)
    {
        $lessonDetail = LessonDetail::find($lessonId);
        $roster = $lessonDetail->roster;
        $teacherId = $roster->teachers_id;

        if ($lessonDetail) {
            $lessonDetail->delete();
            $page = request()->input('page', 1);
            return redirect()->route('teachers.show', ['teacher' => $teacherId, 'page' => $page]);
        } else {
            return redirect()->route('teachers.show', ['teacher' => $teacherId])->with('error', 'Урок не найден');
        }
    }

    public function destroy($rosterId, $lessonId)
    {
        $lessonDetail = LessonDetail::find($lessonId);
        $roster = $lessonDetail->roster;
        $teacherId = $roster->teachers_id;

        if ($lessonDetail) {
            $lessonDetail->delete();
            $page = request()->input('page', 1);
            return redirect()->route('teachers.show', ['teacher' => $teacherId, 'page' => $page]);
        } else {
                return redirect()->route('teachers.show', ['teacher' => $teacherId])->with('error', 'Урок не найден');
        }

    }
}
