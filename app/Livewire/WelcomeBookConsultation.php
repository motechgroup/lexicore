<?php

namespace App\Livewire;

use App\Models\Consultation;
use Livewire\Component;

class WelcomeBookConsultation extends Component
{
    public $isOpen = false;

    public $name = '';

    public $email = '';

    public $phone = '';

    public $appointment_date = '';

    public $notes = '';

    protected $listeners = ['triggerConsultationModal' => 'openModal'];

    protected $rules = [
        'name' => 'required|string|max:100',
        'email' => 'required|email|max:100',
        'phone' => 'nullable|string|max:30',
        'appointment_date' => 'required|date|after:today',
        'notes' => 'nullable|string|max:500',
    ];

    public function openModal()
    {
        $this->isOpen = true;
    }

    public function closeModal()
    {
        $this->isOpen = false;
        $this->reset(['name', 'email', 'phone', 'appointment_date', 'notes']);
        $this->resetValidation();
    }

    public function submit()
    {
        $this->validate();

        Consultation::create([
            'client_id' => auth()->check() ? auth()->id() : null,
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'appointment_date' => $this->appointment_date,
            'notes' => $this->notes,
            'status' => 'pending',
        ]);

        $this->isOpen = false;
        $this->reset(['name', 'email', 'phone', 'appointment_date', 'notes']);

        session()->flash('status', 'Consultation requested successfully. A partner will contact you shortly to confirm your booking.');
        $this->dispatch('consultation-booked');
    }

    public function render()
    {
        return view('livewire.welcome-book-consultation');
    }
}
