<?php

namespace App\Livewire\Admin\Logs;

use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Activitylog\Models\Activity;

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
        $query = Activity::query()
            ->with(['causer']);

        if ($this->search) {
            $query->where('description', 'like', '%'.$this->search.'%')
                ->orWhere('log_name', 'like', '%'.$this->search.'%');
        }

        $activities = $query->orderBy('created_at', 'desc')->paginate(20);

        return view('livewire.admin.logs.index', compact('activities'))
            ->layout('layouts.admin');
    }
}
