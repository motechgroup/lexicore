<?php

namespace App\Livewire\Client\Invoices;

use App\Models\Invoice;
use Livewire\Component;

class Show extends Component
{
    public Invoice $invoice;

    /**
     * Mount the component.
     */
    public function mount(Invoice $invoice)
    {
        // Security check: Client must own the invoice
        if ($invoice->client_id !== auth()->id()) {
            abort(403, 'Unauthorized access to this invoice file.');
        }

        $this->invoice = $invoice->load(['client', 'matter', 'items']);
    }

    /**
     * Render the Livewire component.
     */
    public function render()
    {
        return view('livewire.client.invoices.show')
            ->layout('layouts.client');
    }
}
