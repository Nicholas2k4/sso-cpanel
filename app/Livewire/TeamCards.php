<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Team;
use App\Models\TeamMember;
use Livewire\WithPagination;

class TeamCards extends Component
{
    use WithPagination;
    public $entries = 6;
    public $search = '';

    public function render()
    {
        $teams = Team::where('name', 'like', '%' . $this->search . '%')->paginate($this->entries);
        if (auth()->user()->global_role == 'user') {
            $teamIds = TeamMember::where('user_id', auth()->user()->id)->pluck('team_id');
            $teams = Team::where('name', 'like', '%' . $this->search . '%')->whereIn('id', $teamIds)->paginate($this->entries);
        }
        return view('livewire.team-cards', compact('teams'));
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
