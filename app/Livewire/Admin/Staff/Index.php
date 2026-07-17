<?php

namespace App\Livewire\Admin\Staff;

use App\Models\User;
use Livewire\Component;

class Index extends Component
{
    public $search = '';

    /**
     * Render the Livewire component.
     */
    public function render()
    {
        $query = User::role(['admin', 'staff'])
            ->with(['attorneyProfile', 'roles']);

        if ($this->search) {
            $query->where('name', 'like', '%'.$this->search.'%');
        }

        $members = $query->orderBy('name', 'asc')->get();

        return view('livewire.admin.staff.index', compact('members'))
            ->layout('layouts.admin');
    }
}
