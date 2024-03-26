<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use App\Models\Teacher;
use App\Models\Report;
use App\Models\Roster;
use App\Models\LessonDetail;
use App\Http\Requests\Controllers\StoreRosterRequest;
use App\Http\Requests\Controllers\UpdateRosterRequest;

class RosterController extends Controller
{
    public function roster()
    {
        $rosters = Roster::all();
        $reports = Report::all();
        $teachers = Teacher::all();
        return view('rosters.rosters', compact('rosters', 'reports', 'teachers'));
          // $teachers = Teacher::find(1);
        // $rosters = Roster::find(1);
        // dd($rosters->teachers);
    }

    public function create()
    {
        $rosters = Roster::all();
        $reports = Report::all();
        $teachers = Teacher::all();
        return view('rosters.create', compact('teachers', 'rosters', 'reports'));
    }

    public function store(StoreRosterRequest $request)
    {
        $teachers = Teacher::all();
        $rosters = Roster::all();
        $reports = Report::all();
        $data = $request->validated();
      
        $roster = Roster::create([
            'student' => $data['student'],
            'course' => $data['course'],
            'teachers_id' => $data['teachers_id'],
        ]);
    
        return redirect()->route('admin.roster.roster');
    }

    public function show(Roster $roster, Report $report, Teacher $teacher)
    {
        $teachers = Teacher::all();
        $rosters = Roster::all();
        $reports = Report::all();
        return view('rosters.show', compact('roster', 'teacher', 'report', 'teachers', 'reports', 'rosters'));
    }

    // public function showTeachersRosters(Teacher $teacher) 
    // {
    //     $rosters = $teacher->rosters->get();
    //     return view('rosters.rosters', compact('rosters', 'teacher'));
    // }

    public function edit(Roster $roster, Report $report, Teacher $teacher)
    {
        $rosters = Roster::all();
        $reports = Report::all();
        $teachers = Teacher::all();
        return view('rosters.edit', compact('roster', 'teacher', 'report', 'teachers', 'reports', 'rosters'));
    }


    public function update(UpdateRosterRequest $request, Roster $roster, Report $report, Teacher $teacher)
    {
        $teachers = Teacher::all();
        $rosters = Roster::all();
        $reports = Report::all();

        $data = $request->validated();
        $data['date'] = Carbon::createFromFormat('Y-m-d', $data['date'])->toDateString();
        $roster->update($data);
        return redirect()->route('rosters.show', $roster->id);
    }

    public function addDetails($rosterId)
{
    $roster = Roster::findOrFail($rosterId);
    return view('rosters.add_details', compact('roster'));
}

public function saveDetails(UpdateRosterRequest $request, $rosterId)
{
    $roster = Roster::findOrFail($rosterId);
    $validatedData = $request->validated();

    $lessonDetail = new LessonDetail([
        'date' => $validatedData['date'],
        'topic' => $validatedData['topic'],
        'attendance' => $validatedData['attendance'],
        'roster_id' => $roster->id, // Передаем значение roster_id
    ]);

    $lessonDetail->save();

    return redirect()->route('admin.roster.roster');
}


    public function delete()
    {
        $roster = Roster::find(5);
        $roster->delete();
        dd('deleted');
    }

    public function destroy(Roster $roster)
    {
        $roster->delete();
        return redirect()->route('rosters.rosters');
    }

    // public function firstOrCreate()
    // {
    //     $anotherRoster = [
    //         'teachers_id' => 1,
    //         'student' => 'Tatyana',
    //         'course' => 'General pre-intermediate',
    //         'topic' => '5A',
    //         'date' => 21.02,
    //         'attendance' => 'была'
    //     ];

    //     $roster = Roster::firstOrCreate([
    //         'student' => 'Tatyana'
    //     ], [
    //         'teachers_id' => 1,
    //         'student' => 'Tatyana',
    //         'course' => 'General pre-intermediate',
    //         'topic' => '5A',
    //         'date' => 21.02,
    //         'attendance' => 'была'
    //     ]);
    //     dump($roster->student);
    //     dd('finished');
    // }

    // public function updateOrCreate() 
    // {
    //     $anotherRoster = [
    //         'teachers_id' => 1,
    //         'student' => 'Kamila',
    //         'course' => 'Upper-intermediate',
    //         'topic' => '10B part 1',
    //         'date' => 19.02,
    //         'attendance' => 'не было'
    //     ];

    //     $roster = Roster::updateOrCreate([
    //         'course' => 'Advanced',
    //     ],[
    //         'teachers_id' => 1,
    //         'student' => 'Egor',
    //         'course' => 'Advanced',
    //         'topic' => '7B part 1',
    //         'date' => 18.02,
    //         'attendance' => 'был'
    //     ]);
    //     dump($roster->course);
    // }
}
