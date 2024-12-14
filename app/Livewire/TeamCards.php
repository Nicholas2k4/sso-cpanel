<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Team;
use Livewire\WithPagination;

class TeamCards extends Component
{
    use WithPagination;
    public $entries = 6;
    public $search = '';

    public function render()
    {
        return view('livewire.team-cards', [
            'teams' => Team::where('name', 'like', '%' . $this->search . '%')->paginate($this->entries),
        ]);
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
