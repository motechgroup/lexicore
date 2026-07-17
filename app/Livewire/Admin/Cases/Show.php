<?php

namespace App\Livewire\Admin\Cases;

use App\Models\Document;
use App\Models\Hearing;
use App\Models\Matter;
use App\Models\Task;
use Livewire\Component;

class Show extends Component
{
    public Matter $matter;

    public $activeTab = 'overview';

    // Hearing form properties
    public $newHearingTitle;

    public $newHearingDate;

    public $newHearingLocation;

    public $newHearingNotes;

    // Task form properties
    public $newTaskTitle;

    public $newTaskPriority = 'medium';

    public $newTaskDueDate;

    // Document form properties
    public $newDocTitle;

    /**
     * Mount the component.
     */
    public function mount(Matter $matter)
    {
        $this->matter = $matter->load(['client', 'leadAttorney', 'practiceArea']);
    }

    /**
     * Switch active panel tab.
     */
    public function setTab($tab)
    {
        $this->activeTab = $tab;
    }

    /**
     * Schedule a new hearing.
     */
    public function addHearing()
    {
        $this->validate([
            'newHearingTitle' => 'required|string|max:191',
            'newHearingDate' => 'required|date',
            'newHearingLocation' => 'nullable|string|max:191',
            'newHearingNotes' => 'nullable|string',
        ]);

        Hearing::create([
            'matter_id' => $this->matter->id,
            'title' => $this->newHearingTitle,
            'hearing_date' => $this->newHearingDate,
            'location' => $this->newHearingLocation,
            'notes' => $this->newHearingNotes,
            'status' => 'scheduled',
        ]);

        $this->reset(['newHearingTitle', 'newHearingDate', 'newHearingLocation', 'newHearingNotes']);
        session()->flash('status', 'Hearing scheduled successfully.');
    }

    /**
     * Create a task for the matter.
     */
    public function addTask()
    {
        $this->validate([
            'newTaskTitle' => 'required|string|max:191',
            'newTaskPriority' => 'required|string|in:low,medium,high',
            'newTaskDueDate' => 'nullable|date',
        ]);

        Task::create([
            'matter_id' => $this->matter->id,
            'title' => $this->newTaskTitle,
            'priority' => $this->newTaskPriority,
            'due_date' => $this->newTaskDueDate ?: null,
            'status' => 'pending',
            'creator_id' => auth()->id(),
            'assignee_id' => $this->matter->lead_attorney_id,
        ]);

        $this->reset(['newTaskTitle', 'newTaskPriority', 'newTaskDueDate']);
        session()->flash('status', 'Task created successfully.');
    }

    /**
     * Toggle a task's status.
     */
    public function toggleTask(Task $task)
    {
        $newStatus = $task->status === 'completed' ? 'pending' : 'completed';
        $task->update([
            'status' => $newStatus,
            'completed_at' => $newStatus === 'completed' ? now() : null,
        ]);
    }

    /**
     * Attach a document to the case file.
     */
    public function addDocument()
    {
        $this->validate([
            'newDocTitle' => 'required|string|max:191',
        ]);

        Document::create([
            'title' => $this->newDocTitle,
            'filename' => $this->newDocTitle,
            'filepath' => 'documents/'.uniqid().'.pdf',
            'file_size' => rand(150, 4500) * 1024,
            'mime_type' => 'application/pdf',
            'uploader_id' => auth()->id(),
            'client_id' => $this->matter->client_id,
            'matter_id' => $this->matter->id,
            'version' => '1.0',
        ]);

        $this->reset('newDocTitle');
        session()->flash('status', 'Document added to case file.');
    }

    /**
     * Render the Livewire component.
     */
    public function render()
    {
        $hearings = $this->matter->hearings()->orderBy('hearing_date', 'asc')->get();
        $tasks = $this->matter->tasks()->orderBy('status', 'asc')->orderBy('due_date', 'asc')->get();
        $documents = $this->matter->documents()->orderBy('created_at', 'desc')->get();

        return view('livewire.admin.cases.show', compact('hearings', 'tasks', 'documents'))
            ->layout('layouts.admin');
    }
}
