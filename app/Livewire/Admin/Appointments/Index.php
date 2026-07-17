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

    // Edit/Manage Appointment Form Fields
    public $showEditModal = false;

    public $selectedAppointmentId;

    public $editClientId;

    public $editAttorneyId;

    public $editScheduledAt;

    public $editDurationMinutes = 60;

    public $editStatus = 'scheduled';

    public $editNotes;

    protected $rules = [
        'client_id' => 'required|exists:users,id',
        'attorney_id' => 'nullable|exists:users,id',
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
            'assigned_attorney_id' => $this->attorney_id,
            'appointment_date' => $this->scheduled_at,
            'notes' => $this->notes,
            'status' => $this->status,
        ]);

        $this->reset(['client_id', 'attorney_id', 'scheduled_at', 'duration_minutes', 'status', 'notes']);
        session()->flash('status', 'Consultation scheduled successfully.');
    }

    /**
     * Open manage appointment modal.
     */
    public function editAppointment($id)
    {
        $app = Consultation::findOrFail($id);

        $this->selectedAppointmentId = $app->id;
        $this->editClientId = $app->client_id;
        $this->editAttorneyId = $app->assigned_attorney_id;
        $this->editScheduledAt = $app->appointment_date ? $app->appointment_date->format('Y-m-d\TH:i') : '';
        $this->editStatus = $app->status;
        $this->editNotes = $app->notes;

        $this->showEditModal = true;
    }

    /**
     * Save managed appointment changes.
     */
    public function saveAppointment()
    {
        $this->validate([
            'editClientId' => 'nullable|exists:users,id',
            'editAttorneyId' => 'nullable|exists:users,id',
            'editScheduledAt' => 'required|date',
            'editStatus' => 'required|string',
            'editNotes' => 'nullable|string',
        ]);

        $app = Consultation::findOrFail($this->selectedAppointmentId);

        $app->update([
            'client_id' => $this->editClientId ?: null,
            'assigned_attorney_id' => $this->editAttorneyId ?: null,
            'appointment_date' => $this->editScheduledAt,
            'status' => $this->editStatus,
            'notes' => $this->editNotes,
        ]);

        $this->showEditModal = false;
        session()->flash('status', 'Consultation details updated successfully.');
    }

    /**
     * Render the Livewire component.
     */
    public function render()
    {
        $query = Consultation::query()
            ->with(['client', 'attorney'])
            ->orderBy('appointment_date', 'asc');

        if ($this->search) {
            $query->where(function ($q) {
                $q->whereHas('client', function ($cq) {
                    $cq->where('name', 'like', '%'.$this->search.'%');
                })->orWhereHas('attorney', function ($aq) {
                    $aq->where('name', 'like', '%'.$this->search.'%');
                })->orWhere('name', 'like', '%'.$this->search.'%');
            });
        }

        $appointments = $query->paginate(10);
        $clients = User::role('client')->orderBy('name', 'asc')->get();
        $attorneys = User::role(['staff', 'admin'])->orderBy('name', 'asc')->get();

        return view('livewire.admin.appointments.index', compact('appointments', 'clients', 'attorneys'))
            ->layout('layouts.admin');
    }
}
