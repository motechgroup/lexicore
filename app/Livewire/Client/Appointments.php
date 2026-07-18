<?php

namespace App\Livewire\Client;

use App\Models\Consultation;
use Livewire\Component;
use Livewire\WithPagination;

class Appointments extends Component
{
    use WithPagination;

    public $search = '';

    // Booking a consultation
    public $showBookingModal = false;

    public $appointment_date;

    public $notes = '';

    protected $rules = [
        'appointment_date' => 'required|date|after:now',
        'notes' => 'nullable|string|max:500',
    ];

    /**
     * Open booking overlay modal.
     */
    public function openBookingModal()
    {
        $this->resetErrorBag();
        $this->appointment_date = '';
        $this->notes = '';
        $this->showBookingModal = true;
    }

    /**
     * Submit booking request.
     */
    public function bookConsultation()
    {
        $this->validate();

        Consultation::create([
            'client_id' => auth()->id(),
            'name' => auth()->user()->name,
            'email' => auth()->user()->email,
            'phone' => auth()->user()->phone ?? '',
            'appointment_date' => $this->appointment_date,
            'notes' => $this->notes,
            'status' => 'pending',
        ]);

        $this->showBookingModal = false;
        session()->flash('status', 'Consultation request submitted successfully. We will confirm shortly!');
    }

    /**
     * Render the Livewire component.
     */
    public function render()
    {
        $query = Consultation::where('client_id', auth()->id())
            ->with(['attorney'])
            ->orderBy('appointment_date', 'desc');

        if ($this->search) {
            $query->where('notes', 'like', '%'.$this->search.'%');
        }

        $appointments = $query->paginate(10);

        return view('livewire.client.appointments', compact('appointments'))
            ->layout('layouts.client');
    }
}
