<?php

namespace App\Http\Controllers;

use App\Models\Membership;
use Illuminate\Http\Request;
use App\Http\Requests\Controllers\MembershipRequest;
use App\Models\Roster;
use Illuminate\Support\Facades\Auth;

class MembershipController extends Controller
{
    public function create(Roster $roster)
    {
         return view('membership.create', compact('roster'));
    }

    public function store(MembershipRequest $request, Roster $roster)
    {
        $data = $request->validated();

        $membership = Membership::create([
            'membership' => $data['membership'],
            'roster_id' => $data['roster_id'],
        ]);

        $roster = $membership->roster;
        $teacherId = $roster->teachers_id;
        $page = $request->input('page', 1);

        return redirect()->route('teachers.show', ['teacher' => $teacherId, 'page' => $page]);
    }

    public function edit(MembershipRequest $request, Roster $roster)
    {
        $membership = Membership::where('roster_id', $roster->id)->first();
        $page = $request->input('page', 1);

        return view('membership.edit', compact('membership', 'roster', 'page'));
    }

    public function update(Membership $membership, Roster $roster, MembershipRequest $request, )
    {
        $data = $request->validated();
        $membership->update($data);
        $teacherId = $roster->teachers_id;
        $page = $request->input('page', 1);

        return redirect()->route('rosters.show', ['teacher' => $teacherId, 'page' => $page]);
    }

    public function delete($rosterId, $membershipId)
    {
        $membership = Membership::find($membershipId);
        $roster = $membership->roster;
        $teacherId = $roster->teachers_id;

        if ($membership) {
            $membership->delete();
            $page = request()->input('page', 1);
            return redirect()->route('teachers.show', ['teacher' => $teacherId, 'page' => $page]);
        } else {
            return redirect()->route('teachers.show', ['teacher' => $teacherId])->with('error', 'Урок не найден');
        }
    }

    public function destroy($rosterId, $membershipId)
    {
        $membership = Membership::find($membershipId);
        $roster = $membership->roster;
        $teacherId = $roster->teachers_id;

        if ($membership) {
            $membership->delete();
            $page = request()->input('page', 1);
            return redirect()->route('teachers.show', ['teacher' => $teacherId, 'page' => $page]);
        } else {
                return redirect()->route('teachers.show', ['teacher' => $teacherId])->with('error', 'Урок не найден');
        }

    }
}
