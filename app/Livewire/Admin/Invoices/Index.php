<?php

namespace App\Livewire\Admin\Invoices;

use App\Models\Invoice;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $search = '';

    public $status = '';

    protected $queryString = [
        'search' => ['except' => ''],
        'status' => ['except' => ''],
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
        // 1. Fetch billing summaries
        $totalBilled = Invoice::sum('total');
        $collectionsMtd = Invoice::where('status', 'paid')
            ->whereMonth('created_at', now()->month)
            ->sum('total');
        $outstandingBalance = Invoice::where('status', 'unpaid')->sum('total');

        // 2. Query invoices
        $query = Invoice::query()
            ->with(['client', 'matter']);

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('invoice_number', 'like', '%'.$this->search.'%')
                    ->orWhereHas('client', function ($cq) {
                        $cq->where('name', 'like', '%'.$this->search.'%');
                    });
            });
        }

        if ($this->status) {
            $query->where('status', $this->status);
        }

        $invoices = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('livewire.admin.invoices.index', compact('invoices', 'totalBilled', 'collectionsMtd', 'outstandingBalance'))
            ->layout('layouts.admin');
    }
}
