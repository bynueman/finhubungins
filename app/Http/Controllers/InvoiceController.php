<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Barryvdh\DomPDF\Facade\Pdf;
use ZipArchive;
use Illuminate\Support\Facades\Storage;

class InvoiceController extends Controller
{
    public function bulkDownload($ids)
    {
        // Split IDs
        $idArray = explode(',', $ids);
        
        // Get invoices
        $invoices = Invoice::whereIn('id', $idArray)->get();
        
        if ($invoices->isEmpty()) {
            return back()->with('error', 'No invoices found');
        }

        // Create ZIP file
        $zipFileName = 'invoices_' . now()->format('Y-m-d_H-i-s') . '.zip';
        $zipPath = storage_path('app/temp/' . $zipFileName);
        
        // Ensure temp directory exists
        if (!is_dir(storage_path('app/temp'))) {
            mkdir(storage_path('app/temp'), 0755, true);
        }

        $zip = new ZipArchive;
        if ($zip->open($zipPath, ZipArchive::CREATE) === true) {
            foreach ($invoices as $invoice) {
                // Generate PDF for each invoice
                $pdf = Pdf::loadView('invoices.pdf', ['invoice' => $invoice]);
                
                // Add PDF to ZIP
                $pdfFileName = 'INV-' . str_pad($invoice->id, 4, '0', STR_PAD_LEFT) . '.pdf';
                $zip->addFromString($pdfFileName, $pdf->output());
            }
            $zip->close();

            // Download ZIP
            return response()->download($zipPath)->deleteFileAfterSend(true);
        }

        return back()->with('error', 'Failed to create ZIP file');
    }
}
