<?php

namespace App\Http\Controllers;

use App\Models\Fee;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class PdfController extends Controller
{
    function feeReceipt(Request $request)
    {
        $fee = Fee::findOrFail(decrypt($request->id));
        $pdf = Pdf::loadView('pdf.fee-receipt', compact('fee'));
        return $pdf->stream($fee->id . '.pdf');
    }
}
