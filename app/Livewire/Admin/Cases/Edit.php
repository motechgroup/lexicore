<?php

namespace App\Livewire\Admin\Cases;

use App\Models\Matter;
use App\Models\PracticeArea;
use App\Models\User;
use Livewire\Component;

class Edit extends Component
{
    public Matter $matter;

    public $case_number;

    public $title;

    public $description;

    public $client_id;

    public $practice_area_id;

    public $lead_attorney_id;

    public $status;

    public $priority;

    public $court;

    public $judge;

    public $opposing_party;

    public $opposing_counsel;

    public $start_date;

    public $case_value;

    protected function rules()
    {
        return [
            'case_number' => 'required|string|max:100|unique:matters,case_number,'.$this->matter->id,
            'title' => 'required|string|max:191',
            'client_id' => 'required|exists:users,id',
            'practice_area_id' => 'nullable|exists:practice_areas,id',
            'lead_attorney_id' => 'nullable|exists:users,id',
            'status' => 'required|string|max:50',
            'priority' => 'required|string|max:20',
            'court' => 'nullable|string|max:191',
            'judge' => 'nullable|string|max:191',
            'opposing_party' => 'nullable|string|max:191',
            'opposing_counsel' => 'nullable|string|max:191',
            'start_date' => 'nullable|date',
            'case_value' => 'nullable|numeric|min:0',
            'description' => 'nullable|string',
        ];
    }

    /**
     * Mount the component.
     */
    public function mount(Matter $matter)
    {
        $this->matter = $matter;
        $this->case_number = $matter->case_number;
        $this->title = $matter->title;
        $this->description = $matter->description;
        $this->client_id = $matter->client_id;
        $this->practice_area_id = $matter->practice_area_id;
        $this->lead_attorney_id = $matter->lead_attorney_id;
        $this->status = $matter->status;
        $this->priority = $matter->priority;
        $this->court = $matter->court;
        $this->judge = $matter->judge;
        $this->opposing_party = $matter->opposing_party;
        $this->opposing_counsel = $matter->opposing_counsel;
        $this->start_date = $matter->start_date ? $matter->start_date->format('Y-m-d') : null;
        $this->case_value = $matter->case_value;
    }

    /**
     * Save the updated matter.
     */
    public function save()
    {
        $this->validate();

        $this->matter->update([
            'case_number' => $this->case_number,
            'title' => $this->title,
            'description' => $this->description,
            'client_id' => $this->client_id,
            'practice_area_id' => $this->practice_area_id,
            'lead_attorney_id' => $this->lead_attorney_id,
            'status' => $this->status,
            'priority' => $this->priority,
            'court' => $this->court,
            'judge' => $this->judge,
            'opposing_party' => $this->opposing_party,
            'opposing_counsel' => $this->opposing_counsel,
            'start_date' => $this->start_date,
            'case_value' => $this->case_value ?: null,
        ]);

        session()->flash('status', 'Matter updated successfully.');

        return redirect()->route('admin.cases.index');
    }

    /**
     * Render the Livewire component.
     */
    public function render()
    {
        $clients = User::role('client')->orderBy('name', 'asc')->get();
        $attorneys = User::role(['staff', 'admin'])->orderBy('name', 'asc')->get();
        $practiceAreas = PracticeArea::where('is_active', true)->orderBy('name', 'asc')->get();

        return view('livewire.admin.cases.edit', compact('clients', 'attorneys', 'practiceAreas'))
            ->layout('layouts.admin');
    }
}
