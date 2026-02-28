<?php

namespace App\Services;

use App\Models\Invoice;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Response;

class InvoicePdfService
{
    /**
     * Generate PDF for an invoice.
     *
     * @param Invoice $invoice
     * @return \Barryvdh\DomPDF\PDF
     */
    public function generatePdf(Invoice $invoice): \Barryvdh\DomPDF\PDF
    {
        // Load relationships for PDF content
        $invoice->load('deal.lead', 'items', 'payments');

        // Generate PDF from Blade template
        return Pdf::loadView('invoices.pdf', [
            'invoice' => $invoice,
        ])
            ->setPaper('a4', 'portrait')
            ->setOption('defaultFont', 'sans-serif');
    }

    /**
     * Generate and download PDF for an invoice.
     *
     * @param Invoice $invoice
     * @return Response
     */
    public function downloadPdf(Invoice $invoice): Response
    {
        $pdf = $this->generatePdf($invoice);

        // Generate filename: INVOICE-INV001-2025-12-21.pdf
        $filename = sprintf(
            'INVOICE-%s-%s.pdf',
            $invoice->invoice_number,
            now()->format('Y-m-d')
        );

        return $pdf->download($filename);
    }
}
