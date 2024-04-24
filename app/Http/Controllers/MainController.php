<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\Teacher;
use App\Models\Roster;
use App\Models\Report;
use App\Models\User;
use App\Models\LessonDetail;
use App\Models\Group;
use App\Http\Requests\Controllers\UpdateTeacherRequest;
use App\Http\Requests\Controllers\StoreTeacherRequest;


class MainController extends Controller
{
    protected $lessonController;

    public function __construct(LessonController $lessonController)
    {
        $this->lessonController = $lessonController;
    }

    public function create() 
    {
        $teachers = Teacher::all();
        $rosters = Roster::all();
        $reports = Report::all();
        return view('teachers.create');   
    
    }

    public function store(StoreTeacherRequest $request) 
    {
        $data = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'position' => 'required|string',
        ]);
    
        $user = Auth::user();

        $teacher = Teacher::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'position' => $data['position'],
            'user_id' => $user->id,
        ]);
 
    

        return redirect()->route('teachers.show', ['teacher' => $teacher->id]);
    }

    public function updatePaidStatus(Teacher $teacher)
    {
        $teacher->rosters()->each(function ($roster) {
            $roster->lessonDetails()->where('paid', 0)->update(['paid' => 1]);
        });
    }
   
    public function resetSalary(Teacher $teacher, LessonController $lessonController)
{
    // Обновляем значение зарплаты учителя на 0
    $teacher->update(['salary' => 0]);

    // Обновляем статус оплаты уроков через журналы учителя
    $teacher->rosters()->each(function ($roster) {
        $roster->lessonDetails()->update(['paid' => 1]);
    });

    // Вызываем метод обновления статуса оплаты уроков в LessonController
    $lessonController->updatePaidStatus($teacher);

    return redirect()->route('teachers.show', ['teacher' => $teacher->id]);
}
    
    public function show(Teacher $teacher, LessonController $lessonController)
    {
    // Получаем все журналы учителя вместе с деталями уроков
    $rosters = $teacher->rosters()->with('lessonDetails')->get();

    // Фильтруем уроки, чтобы отобразить только непроплаченные
    $filteredLessonDetails = collect();
    foreach ($rosters as $roster) {
        $filteredLessonDetails = $filteredLessonDetails->merge($roster->lessonDetails->where('paid', 0));
    }

    // Вычисляем общую зарплату учителя с помощью метода из LessonController
    $totalSalary = $lessonController->salary($rosters, $teacher);

    return view('teachers.show', compact('teacher', 'rosters', 'filteredLessonDetails', 'totalSalary'));
    }
    
    
    public function showTeachersReports(Teacher $teacher, Roster $roster, Report $report) 
    {
        $teachers = Teacher::all();
        $rosters = Roster::all();
        $reports = Report::all();
        $reports = $teacher->reports;
       return view('teachers.reportShow', compact('teacher', 'roster', 'report', 'teachers', 'reports', 'rosters'));
    }

    public function edit(Teacher $teacher, Roster $roster, Report $report) 
    {
        $teachers = Teacher::all();
        $rosters = Roster::all();
        $reports = Report::all();

        return view('teachers.edit', compact('teacher', 'roster', 'report', 'teachers', 'rosters', 'reports'));
    }

    public function update(UpdateTeacherRequest $request, Teacher $teacher, Roster $roster, Report $report) 
    { 
        $teachers = Teacher::all();
        $rosters = Roster::all();
        $reports = Report::all();
        $data = request()->validate([
            'name' => 'string',
            'email' => 'email',
            'position' => 'string',
        ]);
        $teacher->update($data);
        return redirect()->route('teachers.show', ['teacher' => $teacher->id]);
    }

    public function delete($teacherId)
    {
        $teacher = Teacher::find($teacherId);
        if ($teacher) {
            $teacher->delete();
            return redirect()->route('teachers.create');
        } else {
            return redirect()->route('teachers.create')->with('error', 'Запись не найдена');
        }
    }

    public function destroy(Teacher $teacher)
    {
        $teacher->delete();
        return redirect()->route('teachers.create');
    }

    
}
