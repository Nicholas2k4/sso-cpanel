<?php

namespace App\Livewire;

use App\Models\Resource;
use Livewire\Component;
use Livewire\WithPagination;

class ResourceTable extends Component
{
    use WithPagination;
    public $entries = 10;
    public $search = '';

    public function render()
    {
        $resources = Resource::where('name', 'like', '%' . $this->search . '%')->paginate($this->entries);
        return view('livewire.resource-table', compact('resources'));
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
