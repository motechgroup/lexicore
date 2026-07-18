<?php

namespace App\Livewire\Admin\Clients;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Role;

class Index extends Component
{
    use WithPagination;

    public $search = '';

    // Modal and client CRUD state
    public $showModal = false;

    public $clientId = null;

    public $name = '';

    public $email = '';

    public $phone = '';

    public $password = '';

    protected function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,'.($this->clientId ?: 'NULL'),
            'phone' => 'nullable|string|max:50',
            'password' => $this->clientId ? 'nullable|string|min:6' : 'required|string|min:6',
        ];
    }

    /**
     * Reset pagination on search updates.
     */
    public function updatingSearch()
    {
        $this->resetPage();
    }

    /**
     * Open modal to create a new client.
     */
    public function openCreateModal()
    {
        $this->resetErrorBag();
        $this->clientId = null;
        $this->name = '';
        $this->email = '';
        $this->phone = '';
        $this->password = '';
        $this->showModal = true;
    }

    /**
     * Open modal to edit an existing client.
     */
    public function openEditModal($id)
    {
        $this->resetErrorBag();
        $user = User::findOrFail($id);
        $this->clientId = $user->id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->phone = $user->phone;
        $this->password = '';
        $this->showModal = true;
    }

    /**
     * Create or update client.
     */
    public function saveClient()
    {
        $this->validate();

        if ($this->clientId) {
            $user = User::findOrFail($this->clientId);
            $user->update([
                'name' => $this->name,
                'email' => $this->email,
                'phone' => $this->phone,
            ]);

            if ($this->password) {
                $user->update([
                    'password' => Hash::make($this->password),
                ]);
            }

            session()->flash('status', 'Client updated successfully.');
        } else {
            $user = User::create([
                'name' => $this->name,
                'email' => $this->email,
                'phone' => $this->phone,
                'password' => Hash::make($this->password),
                'email_verified_at' => now(),
            ]);
            $clientRole = Role::firstOrCreate(['name' => 'client']);
            $user->assignRole($clientRole);

            session()->flash('status', 'New client registered successfully.');
        }

        $this->showModal = false;
    }

    /**
     * Delete client.
     */
    public function deleteClient($id)
    {
        $user = User::findOrFail($id);

        // Remove matters client constraints (set client_id to null or delete depending on cascading)
        $user->matters()->update(['client_id' => null]);
        $user->invoices()->update(['client_id' => null]);

        $user->delete();

        session()->flash('status', 'Client deleted successfully.');
    }

    /**
     * Render the Livewire component.
     */
    public function render()
    {
        $query = User::role('client')
            ->withCount(['matters', 'invoices'])
            ->with(['invoices']);

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('name', 'like', '%'.$this->search.'%')
                    ->orWhere('email', 'like', '%'.$this->search.'%');
            });
        }

        $clients = $query->orderBy('name', 'asc')->paginate(10);

        return view('livewire.admin.clients.index', compact('clients'))
            ->layout('layouts.admin');
    }
}
