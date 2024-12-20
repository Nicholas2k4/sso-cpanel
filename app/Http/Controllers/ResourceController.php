<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use App\Models\Resource;
use App\Models\Team;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ResourceController extends Controller
{
    private $auditObjectType = "resource";

    public function list()
    {
        $resources = Resource::paginate(10);
        return compact('resources');
    }

    public function create(string $type)
    {
        $teams = Team::all();

        if ($type == 'cpanel') {
            return view('resource.create-cpanel', compact('teams'));
        }

        return redirect()->back()->with('error', 'Invalid resource type');
    }

    // public function edit(Resource $resource)
    // {
    //     $teams = Team::all();

    //     if ($resource->type == 'cpanel') {
    //         return view('resource.edit-cpanel', compact('teams', "resource"));
    //     }
    // }

    public function store(string $type, Request $request)
    {
        if ($type == 'cpanel') {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'whmUrl' => 'required|url',
                'whmAuth' => 'required|string|max:255',
                'cpanelUser' => 'required|string|max:255',
                'team_id' => 'required|exists:teams,id',
            ]);

            $resource = new Resource;
            $resource->name = $validated['name'];
            $resource->type = $type;
            $resource->resource_data = [
                'whmUrl' => $validated['whmUrl'],
                'whmAuth' => $validated['whmAuth'],
                'cpanelUser' => $validated['cpanelUser'],
            ];

            $resource->save();
            $resource->teams()->attach($validated['team_id']);

            // Add an audit log entry
            $auditLog = new AuditLog;
            $auditLog->event_type = 'resource.create';
            $auditLog->object_type = $this->auditObjectType;
            $auditLog->object_id = $resource->id;
            $auditLog->action = 'create';
            $auditLog->actor_id = Auth::user()->id;
            $auditLog->save();

            return redirect()->route('resource.show', $resource->id)->with('success', 'Resource created!');
        }

        return redirect()->back()->with('error', 'Invalid resource type');
    }

    public function delete(Resource $resource)
    {
        $resource->teams()->detach();
        $resource->delete();
        return redirect()->back()->with('success', 'Resource deleted!');
    }

    public function edit($room, $keys)
    {
        $resource = [
            'id' => '123',
            'name' => 'Example Resource',
            'type' => 'Type A',
            'teams' => ['Team A', 'Team B', 'Team C'],
            'audit_logs' => [
                [
                    'id' => 1,
                    'type' => 'Update',
                    'team' => 'Team A',
                    'actor' => 'User1',
                    'obj_type' => 'Resource',
                    'obj_id' => '123',
                    'action' => 'Edited',
                    'description' => 'Updated resource details.'
                ]
            ]
        ];

        return view('showEditResource', compact('resource'));
    }
}
