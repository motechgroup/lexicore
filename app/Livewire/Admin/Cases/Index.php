<?php

namespace App\Livewire\Admin\Cases;

use App\Models\Matter;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $search = '';

    public $status = '';

    public $priority = '';

    protected $queryString = [
        'search' => ['except' => ''],
        'status' => ['except' => ''],
        'priority' => ['except' => ''],
    ];

    /**
     * Reset pagination on search updates.
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
        $query = Matter::query()
            ->with(['client', 'leadAttorney', 'practiceArea']);

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('title', 'like', '%'.$this->search.'%')
                    ->orWhere('case_number', 'like', '%'.$this->search.'%');
            });
        }

        if ($this->status) {
            $query->where('status', $this->status);
        }

        if ($this->priority) {
            $query->where('priority', $this->priority);
        }

        $matters = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('livewire.admin.cases.index', compact('matters'))
            ->layout('layouts.admin');
    }
}
