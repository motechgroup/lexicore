<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Barryvdh\DomPDF\Facade\Pdf;

class InvoicePdfController extends Controller
{
    /**
     * Download the invoice as a PDF file.
     */
    public function download(Invoice $invoice)
    {
        $user = auth()->user();

        // Security check: Client must own the invoice, or user must be staff/admin
        if ($user->hasRole('client') && $invoice->client_id !== $user->id) {
            abort(403, 'Unauthorized access to this invoice file.');
        }

        $invoice->load(['client', 'matter', 'items']);

        $pdf = Pdf::loadView('invoices.pdf', compact('invoice'));

        return $pdf->download('Invoice-'.$invoice->invoice_number.'.pdf');
    }
}
