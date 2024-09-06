<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Teacher;
use App\Models\TrialLesson;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Controllers\TrialRequest;

class TrialLessonController extends Controller
{
    public function create(TrialLesson $trialLesson, Teacher $teacher, Request $request)
    {
        $page = $request->input('page', 1);

        return view('trial.create', compact('trialLesson', 'teacher', 'page'));
    }

    public function store(TrialRequest $request, TrialLesson $trialLesson, Teacher $teacher)
    {
        $user = Auth::user();

        $data = $request->validated();
        if ($user->teacher) {
            $trialLesson = TrialLesson::create([
                'teachers_id' => $user->teacher->id,
                'date' => $data['date'],
                'student' => $data['student'],
                'course' => $data['course'],
                'type' => $data['type'],
                'time' => $data['time'],
                'form' => $data['form'],

            ]);
            $page = request()->input('page', 1);
            return redirect()->route('trial.show', ['teacher' => $user->teacher->id, 'page' => $page]);
        } else {
            return redirect()->back()->with('error', 'вы не являетесь учителем');
        }

    }

    public function show(Teacher $teacher)
    {
        $page = request()->input('page', 1);
        $trialLessons = $teacher->trialLesson()->paginate(5, ['*'], 'page', $page);

        return view('trial.show', compact('trialLessons', 'teacher', 'page'));
    }

    public function edit(TrialLesson $trialLesson)
    {
        $page = request()->input('page', 1);
        return view('trial.edit', compact('trialLesson', 'page'));
    }

    public function update(TrialRequest $request, TrialLesson $trialLesson)
    {
        $user = Auth::user();

        $data = $request->validated();
        if ($user->teacher) {
            $trialLesson->update([
                'teachers_id' => $user->teacher->id,
                'date' => $data['date'],
                'student' => $data['student'],
                'course' => $data['course'],
                'type' => $data['type'],
                'time' => $data['time'],
                'form' => $data['form'],

            ]);
            $page = request()->input('page', 1);
            return redirect()->route('trial.show', ['teacher' => $user->teacher->id, 'page' => $page]);
        } else {
            return redirect()->back()->with('error', 'вы не являетесь учителем');
        }
    }

    public function delete($trialLessonId)
    {
        $trialLesson = TrialLesson::find($trialLessonId);
        $teacherId = $trialLesson->teachers_id;
        if ($trialLesson) {
            $trialLesson->delete();
            $page = request()->input('page', 1);
            return redirect()->route('trial.show', ['teacher' => $teacherId, 'page' => $page]);
        } else {
            return redirect()->route('trial.show', ['teacher' => $teacherId])->with('error', 'Запись не найдена');
        }
    }

    public function destroy(TrialLesson $trialLesson)
    {
        $trialLesson->delete();
        $teacherId = $trialLesson->teachers_id;
        $page = request()->input('page', 1);
        return redirect()->route('trial.show', ['teacher' => $teacherId, 'page' => $page]);
    }

}
