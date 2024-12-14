<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Team;
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
}
