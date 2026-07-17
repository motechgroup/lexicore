<?php

namespace App\Livewire\Admin\Appointments;

use App\Models\Consultation;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $search = '';

    // Create Appointment Form Fields
    public $client_id;

    public $attorney_id;

    public $scheduled_at;

    public $duration_minutes = 60;

    public $status = 'scheduled';

    public $notes;

    protected $rules = [
        'client_id' => 'required|exists:users,id',
        'attorney_id' => 'required|exists:users,id',
        'scheduled_at' => 'required|date',
        'duration_minutes' => 'required|integer|min:15',
        'status' => 'required|string',
        'notes' => 'nullable|string',
    ];

    /**
     * Reset pagination on search updates.
     */
    public function updatingSearch()
    {
        $this->resetPage();
    }

    /**
     * Schedule a new appointment.
     */
    public function schedule()
    {
        $this->validate();

        Consultation::create([
            'client_id' => $this->client_id,
            'attorney_id' => $this->attorney_id,
            'scheduled_at' => $this->scheduled_at,
            'duration_minutes' => $this->duration_minutes,
            'status' => $this->status,
            'notes' => $this->notes,
        ]);

        $this->reset(['client_id', 'attorney_id', 'scheduled_at', 'duration_minutes', 'status', 'notes']);
        session()->flash('status', 'Consultation scheduled successfully.');
    }

    /**
     * Render the Livewire component.
     */
    public function render()
    {
        $query = Consultation::query()
            ->with(['client', 'attorney'])
            ->orderBy('scheduled_at', 'asc');

        if ($this->search) {
            $query->where(function ($q) {
                $q->whereHas('client', function ($cq) {
                    $cq->where('name', 'like', '%'.$this->search.'%');
                })->orWhereHas('attorney', function ($aq) {
                    $aq->where('name', 'like', '%'.$this->search.'%');
                });
            });
        }

        $appointments = $query->paginate(10);
        $clients = User::role('client')->orderBy('name', 'asc')->get();
        $attorneys = User::role(['staff', 'admin'])->orderBy('name', 'asc')->get();

        return view('livewire.admin.appointments.index', compact('appointments', 'clients', 'attorneys'))
            ->layout('layouts.admin');
    }
}
