<?php

namespace App\Livewire\Admin\Clients;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $search = '';

    /**
     * Reset page on search changes.
     */
    public function updatingSearch()
    {
        $this->resetPage();
    }

    /**
     * Render the Livewire component.
     */
    public function render()
    {
        $query = User::role('client')
            ->withCount(['matters', 'invoices'])
            ->with(['invoices']);

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('name', 'like', '%'.$this->search.'%')
                    ->orWhere('email', 'like', '%'.$this->search.'%');
            });
        }

        $clients = $query->orderBy('name', 'asc')->paginate(10);

        return view('livewire.admin.clients.index', compact('clients'))
            ->layout('layouts.admin');
    }
}
