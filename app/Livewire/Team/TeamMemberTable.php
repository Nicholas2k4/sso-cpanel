<?php

namespace App\Livewire\Team;

use Livewire\Component;
use App\Models\Team;
use App\Models\User;
use App\Models\TeamMember;
use Livewire\WithPagination;

class TeamMemberTable extends Component
{
    use WithPagination;
    public $teamId;
    public $entries = 10;
    public $search = '';

    protected $listeners = ['refreshTeamMemberTable' => '$refresh'];

    public function render()
    {
        $members = TeamMember::with('user')
            ->where('team_id', $this->teamId)
            ->whereHas('user', function ($query) {
                $query->where('display_name', 'like', '%' . $this->search . '%');
            })
            ->paginate($this->entries);

        // members UID
        $memberUserIds = TeamMember::where('team_id', $this->teamId)->pluck('user_id');

        // users not in team
        $users = User::where('global_role', 'user')
            ->whereNotIn('id', $memberUserIds)
            ->get();

        return view('livewire.team.team-member-table', compact('members', 'users'));
    }

    public function updatingEntries()
    {
        $this->resetPage();
    }
    public function updatingSearch()
    {
        $this->resetPage();
    }
}
