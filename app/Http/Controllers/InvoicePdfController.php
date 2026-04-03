<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Response;

class InvoicePdfController extends Controller
{
    public function download($id)
    {
        $invoice = Invoice::with(['klien', 'jasas'])->findOrFail($id);
        
        $pdf = Pdf::loadView('invoices.pdf', compact('invoice'))
            ->setPaper('a4', 'portrait');
        
        $filename = 'Invoice-' . str_pad($invoice->id, 4, '0', STR_PAD_LEFT) . '-' . $invoice->klien->nama . '.pdf';
        
        return $pdf->download($filename);
    }
    
    public function stream($id)
    {
        $invoice = Invoice::with(['klien', 'jasas'])->findOrFail($id);
        
        $pdf = Pdf::loadView('invoices.pdf', compact('invoice'))
            ->setPaper('a4', 'portrait');
        
        return $pdf->stream('invoice.pdf');
    }
}
