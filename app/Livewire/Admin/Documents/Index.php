<?php

namespace App\Livewire\Admin\Documents;

use App\Models\Document;
use Livewire\Component;
use Livewire\WithPagination;

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
        $query = Document::query()
            ->with(['client', 'matter', 'uploader']);

        if ($this->search) {
            $query->where('title', 'like', '%'.$this->search.'%');
        }

        $documents = $query->orderBy('created_at', 'desc')->paginate(15);

        return view('livewire.admin.documents.index', compact('documents'))
            ->layout('layouts.admin');
    }
}
