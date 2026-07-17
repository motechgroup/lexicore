<?php

namespace App\Livewire\Client\Cases;

use App\Models\Matter;
use Livewire\Component;

class Index extends Component
{
    /**
     * Render the Livewire component.
     */
    public function render()
    {
        $clientId = auth()->id();
        $matters = Matter::where('client_id', $clientId)
            ->with(['leadAttorney', 'practiceArea'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('livewire.client.cases.index', compact('matters'))
            ->layout('layouts.client');
    }
}
