<?php

namespace App\Livewire\Admin\Invoices;

use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Matter;
use App\Models\User;
use Livewire\Component;

class Create extends Component
{
    public $invoice_number;

    public $client_id;

    public $matter_id;

    public $due_date;

    public $tax_rate = 0;

    public $discount = 0;

    public $notes;

    // Line items list
    public $items = [];

    protected $rules = [
        'invoice_number' => 'required|string|max:100|unique:invoices,invoice_number',
        'client_id' => 'required|exists:users,id',
        'matter_id' => 'nullable|exists:matters,id',
        'due_date' => 'required|date',
        'tax_rate' => 'required|numeric|min:0|max:100',
        'discount' => 'required|numeric|min:0',
        'notes' => 'nullable|string',
        'items' => 'required|array|min:1',
        'items.*.description' => 'required|string|max:191',
        'items.*.qty' => 'required|numeric|min:0.1',
        'items.*.unit_price' => 'required|numeric|min:0',
    ];

    /**
     * Mount the component.
     */
    public function mount()
    {
        $this->invoice_number = 'INV-'.date('Y').'-'.str_pad(Invoice::count() + 1, 5, '0', STR_PAD_LEFT);
        $this->due_date = date('Y-m-d', strtotime('+30 days'));

        // Add one initial line item row
        $this->items[] = [
            'description' => '',
            'qty' => 1.0,
            'unit_price' => 0.0,
        ];
    }

    /**
     * Add a line item.
     */
    public function addItem()
    {
        $this->items[] = [
            'description' => '',
            'qty' => 1.0,
            'unit_price' => 0.0,
        ];
    }

    /**
     * Remove a line item.
     */
    public function removeItem($index)
    {
        unset($this->items[$index]);
        $this->items = array_values($this->items);
    }

    /**
     * Get computed subtotal.
     */
    public function getSubtotalProperty()
    {
        $subtotal = 0;
        foreach ($this->items as $item) {
            $subtotal += ($item['qty'] ?: 0) * ($item['unit_price'] ?: 0);
        }

        return $subtotal;
    }

    /**
     * Get computed tax amount.
     */
    public function getTaxAmountProperty()
    {
        return $this->subtotal * ($this->tax_rate / 100);
    }

    /**
     * Get computed total.
     */
    public function getTotalProperty()
    {
        return $this->subtotal + $this->tax_amount - $this->discount;
    }

    /**
     * Save the new invoice.
     */
    public function save()
    {
        $this->validate();

        $invoice = Invoice::create([
            'invoice_number' => $this->invoice_number,
            'client_id' => $this->client_id,
            'matter_id' => $this->matter_id ?: null,
            'due_date' => $this->due_date,
            'subtotal' => $this->subtotal,
            'tax_rate' => $this->tax_rate,
            'tax_amount' => $this->tax_amount,
            'discount' => $this->discount,
            'total' => $this->total,
            'status' => 'unpaid',
            'notes' => $this->notes,
        ]);

        foreach ($this->items as $item) {
            InvoiceItem::create([
                'invoice_id' => $invoice->id,
                'description' => $item['description'],
                'qty' => $item['qty'],
                'unit_price' => $item['unit_price'],
                'total' => $item['qty'] * $item['unit_price'],
            ]);
        }

        session()->flash('status', 'Retainer invoice generated successfully.');

        return redirect()->route('admin.invoices.index');
    }

    /**
     * Render the Livewire component.
     */
    public function render()
    {
        $clients = User::role('client')->orderBy('name', 'asc')->get();

        $matters = [];
        if ($this->client_id) {
            $matters = Matter::where('client_id', $this->client_id)->orderBy('title', 'asc')->get();
        }

        return view('livewire.admin.invoices.create', compact('clients', 'matters'))
            ->layout('layouts.admin');
    }
}
