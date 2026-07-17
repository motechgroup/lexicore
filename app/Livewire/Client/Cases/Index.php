<?php

namespace App\Livewire\Client\Cases;

use App\Models\Matter;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    /**
     * Render the Livewire component.
     */
    public function render()
    {
        $clientId = auth()->id();
        $matters = Matter::where('client_id', $clientId)
            ->with(['leadAttorney', 'practiceArea'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('livewire.client.cases.index', compact('matters'))
            ->layout('layouts.client');
    }
}
