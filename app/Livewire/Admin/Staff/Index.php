<?php

namespace App\Livewire\Admin\Staff;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
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

    public $editPassword;

    protected function rules()
    {
        return [
            'editName' => 'required|string|max:255',
            'editEmail' => 'required|email|max:255|unique:users,email,'.($this->selectedUserId ?: 'NULL'),
            'editRole' => 'required|string|in:admin,staff,client',
            'editTitle' => 'nullable|string|max:100',
            'editExperienceYears' => 'required|integer|min:0',
            'editBio' => 'nullable|string',
            'editPassword' => $this->selectedUserId ? 'nullable|string|min:6' : 'required|string|min:6',
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
     * Open modal to register a new staff member.
     */
    public function openCreateModal()
    {
        $this->resetErrorBag();
        $this->selectedUserId = null;
        $this->editName = '';
        $this->editEmail = '';
        $this->editRole = 'staff';
        $this->editTitle = '';
        $this->editExperienceYears = 0;
        $this->editBio = '';
        $this->editPassword = '';
        $this->showEditModal = true;
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
        $this->editPassword = '';

        $this->showEditModal = true;
    }

    /**
     * Save/Create the user profile.
     */
    public function saveUser()
    {
        $this->validate();

        if ($this->selectedUserId) {
            $user = User::findOrFail($this->selectedUserId);
            $user->update([
                'name' => $this->editName,
                'email' => $this->editEmail,
            ]);

            if ($this->editPassword) {
                $user->update([
                    'password' => Hash::make($this->editPassword),
                ]);
            }

            $user->syncRoles([$this->editRole]);
            session()->flash('status', 'Staff profile updated successfully.');
        } else {
            $user = User::create([
                'name' => $this->editName,
                'email' => $this->editEmail,
                'password' => Hash::make($this->editPassword),
                'email_verified_at' => now(),
            ]);
            $user->assignRole($this->editRole);

            session()->flash('status', 'New staff profile registered successfully.');
        }

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
    }

    /**
     * Delete a staff user profile.
     */
    public function deleteUser($id)
    {
        $user = User::findOrFail($id);

        if ($user->id === auth()->id()) {
            session()->flash('error', 'You cannot delete your own account.');

            return;
        }

        $user->attorneyProfile()->delete();
        $user->attorneyMatters()->update(['lead_attorney_id' => null]);
        $user->delete();

        session()->flash('status', 'Staff profile deleted successfully.');
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
