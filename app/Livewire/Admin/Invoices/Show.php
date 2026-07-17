<?php

namespace App\Livewire\Admin\Invoices;

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
        $this->invoice = $invoice->load(['client', 'matter', 'items']);
    }

    /**
     * Mark the invoice as paid.
     */
    public function markAsPaid()
    {
        $this->invoice->update(['status' => 'paid']);
        session()->flash('status', 'Invoice has been marked as fully paid.');
    }

    /**
     * Mark the invoice as unpaid.
     */
    public function markAsUnpaid()
    {
        $this->invoice->update(['status' => 'unpaid']);
        session()->flash('status', 'Invoice has been marked as unpaid.');
    }

    /**
     * Render the Livewire component.
     */
    public function render()
    {
        return view('livewire.admin.invoices.show')
            ->layout('layouts.admin');
    }
}
