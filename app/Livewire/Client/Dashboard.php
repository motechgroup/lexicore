<?php

namespace App\Livewire\Client;

use App\Models\Document;
use App\Models\Hearing;
use App\Models\Invoice;
use App\Models\Matter;
use Livewire\Component;

class Dashboard extends Component
{
    /**
     * Render the Livewire component.
     */
    public function render()
    {
        $clientId = auth()->id();

        // 1. Get the first active matter for this client (fallback to a dummy or blank matter if none exists)
        $matterModel = Matter::where('client_id', $clientId)
            ->with(['leadAttorney', 'practiceArea'])
            ->orderBy('created_at', 'desc')
            ->first();

        $case = [
            'title' => $matterModel ? $matterModel->title : 'No Active Matter',
            'practice_area' => $matterModel && $matterModel->practiceArea ? $matterModel->practiceArea->name : 'General Counsel',
            'case_id' => $matterModel ? $matterModel->case_number : 'N/A',
            'status' => $matterModel ? $matterModel->status : 'Pending',
            'counsel' => $matterModel && $matterModel->leadAttorney ? $matterModel->leadAttorney->name : 'N/A',
            'last_update' => $matterModel ? ($matterModel->description ?? 'Case details pending review') : 'Awaiting counselor assignment',
        ];

        // 2. Get the next scheduled hearing or appointment for this client
        $hearingModel = null;
        if ($matterModel) {
            $hearingModel = Hearing::where('matter_id', $matterModel->id)
                ->where('hearing_date', '>=', now())
                ->orderBy('hearing_date', 'asc')
                ->first();
        }

        $appointment = [
            'title' => $hearingModel ? $hearingModel->title : 'No Upcoming Hearings',
            'counsel' => $case['counsel'],
            'date' => $hearingModel ? $hearingModel->hearing_date->format('M d, Y') : 'N/A',
            'time' => $hearingModel ? $hearingModel->hearing_date->format('h:i A T') : 'N/A',
            'location' => $hearingModel ? $hearingModel->location : 'N/A',
            'days_left' => $hearingModel ? now()->diffInDays($hearingModel->hearing_date) : 0,
            'hours_left' => $hearingModel ? now()->diffInHours($hearingModel->hearing_date) % 24 : 0,
        ];

        // 3. Get outstanding invoices for this client
        $invoiceModels = Invoice::where('client_id', $clientId)
            ->where('status', 'unpaid')
            ->orderBy('due_date', 'asc')
            ->get();

        $invoices = $invoiceModels->map(function ($inv) {
            // Find first item description for display
            $desc = $inv->items()->first()?->description ?? 'Legal Services';

            return [
                'number' => $inv->invoice_number,
                'description' => $desc,
                'amount' => (float) $inv->total,
            ];
        })->toArray();

        // 4. Get recent documents uploaded for this client
        $docModels = Document::where('client_id', $clientId)
            ->orderBy('created_at', 'desc')
            ->take(4)
            ->get();

        $documents = $docModels->map(function ($doc) {
            // Choose icon based on file type
            $icon = 'description';
            $color = 'blue';
            $mime = strtolower($doc->mime_type);
            if (str_contains($mime, 'pdf')) {
                $icon = 'picture_as_pdf';
                $color = 'red';
            } elseif (str_contains($mime, 'image')) {
                $icon = 'image';
                $color = 'slate';
            }

            return [
                'name' => $doc->title,
                'time' => $doc->created_at->diffForHumans(),
                'icon' => $icon,
                'icon_color' => $color,
            ];
        })->toArray();

        return view('livewire.client.dashboard', compact('case', 'appointment', 'invoices', 'documents'))
            ->layout('layouts.client');
    }
}
