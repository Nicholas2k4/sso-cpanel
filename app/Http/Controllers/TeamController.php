<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use App\Models\Resource;
use App\Models\TeamResource;
use Illuminate\Http\Request;
use App\Models\Team;
use App\Models\TeamMember;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

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

        $team = Team::create([
            'name' => $request->name,
            'logo_link' => Storage::url($logoPath),
            'leader_user_id' => $request->leader_user_id,
        ]);

        $auditLog = new AuditLog;
        $auditLog->event_type = 'team.create';
        $auditLog->team_id = $team->id;
        $auditLog->actor_id = Auth::user()->id;
        $auditLog->object_type = "team";
        $auditLog->object_id = $team->id;
        $auditLog->action = 'create';
        $auditLog->save();

        return redirect()->route('teams');
    }

    public function searchLeader(Request $request)
    {
        $search = $request->input('search', '');
        $limit = $request->input('limit', 10);

        $users = User::where('display_name', 'LIKE', '%' . $search . '%')
            ->take($limit)
            ->get(['id', 'display_name']);

        return response()->json($users);
    }

    public function searchTeams(Request $request)
    {
        $search = $request->input('search', '');
        $limit = $request->input('limit', 10);

        $teams = Team::where('name', 'LIKE', '%' . $search . '%')
            ->take($limit)
            ->get(['id', 'name']);

        return response()->json($teams);
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

        // Add an audit log entry
        $auditLog = new AuditLog();
        $auditLog->event_type = 'team.promote';
        $auditLog->team_id = $member->team_id;
        $auditLog->actor_id = Auth::user()->id;
        $auditLog->object_type = "user";
        $auditLog->object_id = $member->user_id;
        $auditLog->action = 'promote';
        $auditLog->description = "User {$member->user->display_name}({$member->user->email}) promoted to manager of team {$member->team->name}";
        $auditLog->save();

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

        // Add an audit log entry
        $auditLog = new AuditLog();
        $auditLog->event_type = 'team.demote';
        $auditLog->team_id = $member->team_id;
        $auditLog->actor_id = Auth::user()->id;
        $auditLog->object_type = "user";
        $auditLog->object_id = $member->user_id;
        $auditLog->action = 'demote';
        $auditLog->description = "User {$member->user->display_name}({$member->user->email}) demoted to member of team {$member->team->name}";
        $auditLog->save();

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

        // Add an audit log entry
        $auditLog = new AuditLog();
        $auditLog->event_type = 'team.kick';
        $auditLog->team_id = $member->team_id;
        $auditLog->actor_id = Auth::user()->id;
        $auditLog->object_type = "user";
        $auditLog->object_id = $member->user_id;
        $auditLog->action = 'kick';
        $auditLog->description = "User {$member->user->display_name}({$member->user->email}) kicked from team {$member->team->name}";
        $auditLog->save();

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

        $newMember = TeamMember::create([
            'user_id' => $request['userId'],
            'team_id' => $request['teamId'],
            'role' => 'member'
        ]);

        // Add an audit log entry for the new member
        $auditLog = new AuditLog();
        $auditLog->event_type = 'team.addMember';
        $auditLog->team_id = $request['teamId'];
        $auditLog->actor_id = Auth::user()->id;
        $auditLog->object_type = "user";
        $auditLog->object_id = $newMember->user_id;
        $auditLog->action = 'add member';
        $auditLog->description = "User {$newMember->user->display_name}({$newMember->user->email}) added to team {$newMember->team->name}";
        $auditLog->save();

        return response()->json([
            'success' => true,
            'message' => 'Member added!'
        ]);
    }

    private function removeSchemeAndHost(string $url): string
    {
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

    public function accessTeamResource(TeamResource $teamResource)
    {
        // Person accessing the resource must either be:
        // 1. A member of the team
        // 2. An admin of the team
        $user_global_role = auth()->user()->global_role;
        $user_team_role = auth()->user()->groupRole($teamResource->team_id);

        if ($user_global_role == 'admin' || !($user_team_role == 'guest')) {
            // Currently available resource type: cPanel
            if ($teamResource->resource->type == 'cpanel') {
                // Generate a one-time redirect URL.
                $resourceData = $teamResource->resource->resource_data;

                // These fields must be present in the resource data:
                $requiredFields = ['whmUrl', 'whmAuth', 'cpanelUser'];
                foreach ($requiredFields as $field) {
                    if (!isset($resourceData[$field])) {
                        return response()->setStatusCode(400, "Missing required field in resource '$field'");
                    }
                }

                $response = Http::withHeader("Authorization", $resourceData["whmAuth"])
                    ->withOptions(["verify" => false])
                    ->get($resourceData['whmUrl'] . '/json-api/create_user_session', [
                        'api.version' => '1',
                        'user' => $resourceData['cpanelUser'],
                        'service' => 'cpaneld'
                    ]);

                $responseData = $response->json();

                if ($response->status() != 200) {
                    Log::error('cPanel API Error: ' . json_encode($responseData));
                    abort(400, "API Error, please contact admin.");
                }

                // Obtain the URL from the response data.
                $url = $responseData['data']['url'];

                // Remove the scheme and host from the URL.
                $url = $this->removeSchemeAndHost($url);

                // (temporary workaround) Add the WHM URL to the URL.
                $cpanelHost = parse_url($resourceData['whmUrl'], PHP_URL_HOST);
                $url = 'https://' . $cpanelHost . ':2083/' . $url;

                // Add an audit log entry
                $user = Auth::user();
                $auditLog = new AuditLog();
                $auditLog->event_type = 'team.accessResource';
                $auditLog->team_id = $teamResource->team_id;
                $auditLog->actor_id = Auth::user()->id;
                $auditLog->object_type = "resource";
                $auditLog->object_id = $teamResource->resource_id;
                $auditLog->action = 'access resource';
                $auditLog->description = "User {$user->display_name}({$user->email}) accessed resource {$teamResource->resource->name}";
                $auditLog->save();

                return redirect()->away($url);
            } else {
                abort(400);
            }
        }

        abort(403);
    }
}
