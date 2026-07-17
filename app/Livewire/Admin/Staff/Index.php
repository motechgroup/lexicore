<?php

namespace App\Livewire\Admin\Staff;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Role;

class Index extends Component
{
    use WithPagination;

    public $search = '';

    // Modal and edit form state
    public $showEditModal = false;

    public $selectedUserId;

    public $editName;

    public $editEmail;

    public $editRole;

    public $editTitle;

    public $editExperienceYears;

    public $editBio;

    protected $rules = [
        'editName' => 'required|string|max:255',
        'editEmail' => 'required|email|max:255',
        'editRole' => 'required|string|in:admin,staff',
        'editTitle' => 'nullable|string|max:100',
        'editExperienceYears' => 'required|integer|min:0',
        'editBio' => 'nullable|string',
    ];

    /**
     * Reset pagination on search updates.
     */
    public function updatingSearch()
    {
        $this->resetPage();
    }

    /**
     * Open the edit modal and populate state.
     */
    public function editUser($userId)
    {
        $user = User::with('attorneyProfile')->findOrFail($userId);

        $this->selectedUserId = $user->id;
        $this->editName = $user->name;
        $this->editEmail = $user->email;
        $this->editRole = $user->roles->first()->name ?? 'staff';

        $profile = $user->attorneyProfile;
        $this->editTitle = $profile->title ?? '';
        $this->editExperienceYears = $profile->experience_years ?? 0;
        $this->editBio = $profile->bio ?? '';

        $this->showEditModal = true;
    }

    /**
     * Save the edited user profile.
     */
    public function saveUser()
    {
        $this->validate();

        $user = User::findOrFail($this->selectedUserId);

        // Update user details
        $user->update([
            'name' => $this->editName,
            'email' => $this->editEmail,
        ]);

        // Sync roles
        $user->syncRoles([$this->editRole]);

        // Update or create attorney profile record
        $user->attorneyProfile()->updateOrCreate(
            ['user_id' => $user->id],
            [
                'title' => $this->editTitle,
                'experience_years' => (int) $this->editExperienceYears,
                'bio' => $this->editBio,
            ]
        );

        $this->showEditModal = false;
        session()->flash('status', 'Staff profile updated successfully.');
    }

    /**
     * Render the Livewire component.
     */
    public function render()
    {
        $query = User::role(['admin', 'staff'])
            ->with(['attorneyProfile', 'roles']);

        if ($this->search) {
            $query->where('name', 'like', '%'.$this->search.'%');
        }

        $members = $query->orderBy('name', 'asc')->paginate(10);
        $roles = Role::whereIn('name', ['admin', 'staff'])->get();

        return view('livewire.admin.staff.index', compact('members', 'roles'))
            ->layout('layouts.admin');
    }
}
