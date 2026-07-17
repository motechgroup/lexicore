<?php

namespace App\Livewire\Client\Cases;

use App\Models\Matter;
use Livewire\Component;

class Show extends Component
{
    public Matter $matter;

    /**
     * Mount the component.
     */
    public function mount(Matter $matter)
    {
        // Security check: Verify client owns the case
        if ($matter->client_id !== auth()->id()) {
            abort(403, 'Unauthorized access to this case file.');
        }

        $this->matter = $matter->load(['leadAttorney.attorneyProfile', 'practiceArea']);
    }

    /**
     * Render the Livewire component.
     */
    public function render()
    {
        $hearings = $this->matter->hearings()->orderBy('hearing_date', 'asc')->get();
        $documents = $this->matter->documents()->orderBy('created_at', 'desc')->get();
        $tasks = $this->matter->tasks()->orderBy('due_date', 'asc')->get();

        return view('livewire.client.cases.show', compact('hearings', 'documents', 'tasks'))
            ->layout('layouts.client');
    }
}
