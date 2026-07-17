<?php

namespace App\Livewire\Client\Invoices;

use App\Models\Invoice;
use Livewire\Component;

class Index extends Component
{
    /**
     * Render the Livewire component.
     */
    public function render()
    {
        $clientId = auth()->id();
        $invoices = Invoice::where('client_id', $clientId)
            ->with(['matter'])
            ->orderBy('due_date', 'asc')
            ->get();

        // Calculate total outstanding balance
        $outstandingBalance = Invoice::where('client_id', $clientId)
            ->where('status', 'unpaid')
            ->sum('total');

        return view('livewire.client.invoices.index', compact('invoices', 'outstandingBalance'))
            ->layout('layouts.client');
    }
}
