<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Team;
use App\Models\TeamMember;
use App\Models\User;

class TeamController extends Controller
{
    public function create()
    {
        $users = User::all();
        return view('createTeams', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'logo' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'leader_user_id' => 'required|exists:users,id',
        ]);

        $logoPath = $request->file('logo')->store('logos', 'public');

        Team::create([
            'name' => $request->name,
            'logo_link' => $logoPath,
            'leader_user_id' => $request->leader_user_id,
        ]);

        return redirect()->route('teams');
    }

    public function show()
    {
        return view('teams');
    }

    public function showResource(Team $team)
    {
        return view('team.resource', compact('team'));
    }
    public function showMember(Team $team)
    {
        return view('team.member', compact('team'));
    }
    public function showAudit(Team $team)
    {
        return view('team.audit', compact('team'));
    }

    public function promote(Request $request)
    {
        $member = TeamMember::findOrFail($request['memberId']);

        if ($member->role != 'member') {
            return response()->json([
                'error' => true,
                'message' => "Cannot promote this user!",
            ], 400);
        }

        $member->role = 'manager';
        $member->save();

        return response()->json([
            'success' => true,
            'message' => "User promoted!"
        ]);
    }

    public function demote(Request $request)
    {
        $member = TeamMember::findOrFail($request['memberId']);

        if ($member->role != 'manager') {
            return response()->json([
                'error' => true,
                'message' => "Cannot demote this user!",
            ], 400);
        }

        $member->role = 'member';
        $member->save();
        return response()->json([
            'success' => true,
            'message' => "User demoted!"
        ]);
    }

    public function kick(Request $request) {
        $member = TeamMember::findOrFail($request['memberId']);

        if ($member->role == 'leader') {
            return response()->json([
                'error' => true,
                'message' => "Cannot kick this user!",
            ], 400);
        }

        $member->delete();
        return response()->json([
            'success' => true,
            'message' => "User kicked!"
        ]);
    }
}
