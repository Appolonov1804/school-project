<?php

namespace App\Http\Controllers;

use App\Models\Roster;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use App\Models\Teacher;

class RosterController extends Controller
{
    public function roster()
    {
        $rosters = Roster::all();
        return view('rosters.rosters', compact('rosters'));
          // $teachers = Teacher::find(1);
        // $rosters = Roster::find(1);
        // dd($rosters->teachers);
    }

    public function create()
    {
        $teachers = Teacher::all();
        return view('rosters.create', compact('teachers'));
    }

    public function store()
    {
        $data = request()->validate([
            'student' => 'string',
            'course' => 'string',
            'topic' => 'string',
            'date' => 'date',
            'attendance' => 'string',
            'teachers_id' => ['nullable', 'integer'], 
        ]);

        $data['date'] = Carbon::createFromFormat('Y-m-d', $data['date'])->toDateString();

        Roster::create($data);
        return redirect()->route('rosters.rosters');
    }

    public function show(Roster $roster)
    {
        return view('rosters.show', compact('roster'));
    }

    public function edit(Roster $roster)
    {
        return view('rosters.edit', compact('roster'));
    }


    public function update(Roster $roster)
    {

        $data = request()->validate([
            'student' => 'string',
            'course' => 'string',
            'topic' => 'string',
            'date' => 'date',
            'attendance' => 'string',
            'teachers_id' => ['nullable', 'integer'], 
        ]);
        $data['date'] = Carbon::createFromFormat('Y-m-d', $data['date'])->toDateString();
        $roster->update($data);
        return redirect()->route('rosters.show', $roster->id);
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
