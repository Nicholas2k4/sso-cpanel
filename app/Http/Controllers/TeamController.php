<?php

namespace App\Http\Controllers;

use App\Models\Resource;
use App\Models\TeamResource;
use Illuminate\Http\Request;
use App\Models\Team;
use App\Models\TeamMember;
use App\Models\User;
use Illuminate\Support\Facades\Http;

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
        $authRole = auth()->user()->groupRole($team->id);
        if ($authRole == 'guest' && auth()->user()->global_role != 'admin') {
            return redirect()->route('teams')->with('error', 'Unauthorized');
        }

        $resources = TeamResource::where("team_id", "=", $team->id)->with("resource")->paginate(9);
        return view('team.resource', compact('team', 'resources'));
    }
    public function showMember(Team $team)
    {
        $authRole = auth()->user()->groupRole($team->id);
        if ($authRole == 'guest' && auth()->user()->global_role != 'admin') {
            return redirect()->route('teams')->with('error', 'Unauthorized');
        }
        return view('team.member', compact('team'));
    }
    public function showAudit(Team $team)
    {
        $authRole = auth()->user()->groupRole($team->id);
        if ($authRole == 'guest' && auth()->user()->global_role != 'admin') {
            return redirect()->route('teams')->with('error', 'Unauthorized');
        }
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

        $authRole = auth()->user()->groupRole($member->team_id);
        if (auth()->user()->global_role != 'admin' && ($authRole == 'guest' || $authRole == 'member')) {
            return response()->json([
                'error' => true,
                'message' => "Unauthorized!",
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

        $authRole = auth()->user()->groupRole($member->team_id);
        if (auth()->user()->global_role != 'admin' && ($authRole == 'guest' || $authRole == 'member' || $authRole == 'manager')) {
            return response()->json([
                'error' => true,
                'message' => "Unauthorized!",
            ], 400);
        }

        $member->role = 'member';
        $member->save();
        return response()->json([
            'success' => true,
            'message' => "User demoted!"
        ]);
    }

    public function kick(Request $request)
    {
        $member = TeamMember::findOrFail($request['memberId']);

        if ($member->role == 'leader') {
            return response()->json([
                'error' => true,
                'message' => "Cannot kick this user!",
            ], 400);
        }

        $authRole = auth()->user()->groupRole($member->team_id);
        if (
            (($member->role == 'manager' && ($authRole == 'manager' || $authRole == 'member' || $authRole == 'guest')) ||
                ($member->role == 'member' && ($authRole == 'member' || $authRole == 'guest'))) &&
            auth()->user()->global_role != 'admin'
        ) {
            return response()->json([
                'error' => true,
                'message' => "Unauthorized!",
            ], 400);
        }

        $member->delete();
        return response()->json([
            'success' => true,
            'message' => "User kicked!"
        ]);
    }

    public function addMember(Request $request)
    {
        $authRole = auth()->user()->groupRole($request['teamId']);
        if (auth()->user()->global_role != 'admin' && ($authRole == 'guest' || $authRole == 'member')) {
            return response()->json([
                'error' => true,
                'message' => "Unauthorized!",
            ], 400);
        }

        TeamMember::create([
            'user_id' => $request['userId'],
            'team_id' => $request['teamId'],
            'role' => 'member'
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Member added!'
        ]);
    }

    private function removeSchemeAndHost(string $url): string {
        $parts = parse_url($url);

        $result = '';
        if (isset($parts['path'])) {
            $result .= $parts['path'];
        }
        if (isset($parts['query'])) {
            $result .= '?' . $parts['query'];
        }
        if (isset($parts['fragment'])) {
            $result .= '#' . $parts['fragment'];
        }

        return $result;
    }

    public function accessTeamResource(TeamResource $teamResource) {
        // Person accessing the resource must either be:
        // 1. A member of the team
        // 2. An admin of the team
        $user_global_role = auth()->user()->global_role;
        $user_team_role = auth()->user()->groupRole($teamResource->team_id);

        if ($user_global_role == 'admin' || !($user_team_role == 'guest')) {
            // Currently available resource type: cPanel
            if ($teamResource->resource->type == 'cpanel') {
                // Generate a one-time redirect URL.
                $resoureData = $teamResource->resource->resource_data;

                // These fields must be present in the resource data:
                $requiredFields = ['whmUrl', 'whmAuth', 'cpanelUser'];
                foreach ($requiredFields as $field) {
                    if (!isset($resoureData[$field])) {
                        return response()->setStatusCode(400, "Missing required field in resource '$field'");
                    }
                }

                $response = Http::withUrlParameters([
                    'api.version' => 1,
                    'user' => $resoureData['cpanelUser'],
                    'service' => 'cpaneld'
                ])
                    ->withHeader("Authorization", $teamResource["cpanelUser"])
                    ->get($resoureData['whmUrl'] . '/json-api/create_user_session');

                $responseData = $response->json();

                if ($response->status() != 200) {
                    return response()->setStatusCode(400, $responseData['message']);
                }

                // Obtain the URL from the response data.
                $url = $responseData['data']['url'];

                // Remove the scheme and host from the URL.
                $url = $this->removeSchemeAndHost($url);

                // (temporary workaround) Add the WHM URL to the URL.
                $url = $resoureData['whmUrl'] . '/' . $url;

                return redirect()->away($url);
            } else {
                return response()->setStatusCode(400);
            }
        }

        return response()->setStatusCode(403);
    }
}
