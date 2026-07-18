<?php

namespace App\Livewire\Admin\Roles;

use Livewire\Component;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class Index extends Component
{
    public $search = '';

    // Create / Edit Role fields
    public $showModal = false;

    public $roleId = null;

    public $name = '';

    public $selectedPermissions = [];

    protected function rules()
    {
        return [
            'name' => 'required|string|max:100|unique:roles,name,'.($this->roleId ?: 'NULL'),
            'selectedPermissions' => 'nullable|array',
        ];
    }

    /**
     * Open create modal.
     */
    public function openCreateModal()
    {
        $this->resetErrorBag();
        $this->roleId = null;
        $this->name = '';
        $this->selectedPermissions = [];
        $this->showModal = true;
    }

    /**
     * Open edit modal.
     */
    public function openEditModal($id)
    {
        $this->resetErrorBag();
        $role = Role::findOrFail($id);
        $this->roleId = $role->id;
        $this->name = $role->name;
        $this->selectedPermissions = $role->permissions->pluck('name')->toArray();
        $this->showModal = true;
    }

    /**
     * Save role changes.
     */
    public function saveRole()
    {
        $this->validate();

        if ($this->roleId) {
            $role = Role::findOrFail($this->roleId);
            $role->update([
                'name' => strtolower($this->name),
            ]);
            $role->syncPermissions($this->selectedPermissions);
            session()->flash('status', 'Role updated successfully.');
        } else {
            $role = Role::create([
                'name' => strtolower($this->name),
                'guard_name' => 'web',
            ]);
            $role->syncPermissions($this->selectedPermissions);
            session()->flash('status', 'Role created successfully.');
        }

        $this->showModal = false;
    }

    /**
     * Delete role.
     */
    public function deleteRole($id)
    {
        $role = Role::findOrFail($id);

        if (in_array($role->name, ['admin', 'staff', 'client'])) {
            session()->flash('error', 'Core system roles cannot be deleted.');

            return;
        }

        $role->delete();
        session()->flash('status', 'Role deleted successfully.');
    }

    /**
     * Render the Livewire component.
     */
    public function render()
    {
        $query = Role::query()
            ->withCount('users')
            ->orderBy('name', 'asc');

        if ($this->search) {
            $query->where('name', 'like', '%'.$this->search.'%');
        }

        $roles = $query->get();
        $permissions = Permission::all();

        return view('livewire.admin.roles.index', compact('roles', 'permissions'))
            ->layout('layouts.admin');
    }
}
