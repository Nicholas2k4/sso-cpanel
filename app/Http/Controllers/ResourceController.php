<?php

namespace App\Http\Controllers;

class ResourceController extends Controller
{
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
