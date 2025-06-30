<?php

namespace App\Http\Controllers;

use App\Models\Branch;
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

    function dayBook(Request $request)
    {
        $inputs = array($request->from_date, $request->to_date, $request->branch);
        $opening_balance = getOpeningBalance($inputs[0], $inputs[1], $inputs[2]);
        $fee = getFee($request, $inputs);
        $ie = getIe($request, $inputs);
        $branch = Branch::findOrFail($request->branch);
        $pdf = Pdf::loadView('pdf.daybook', compact('inputs', 'branch', 'fee', 'ie', 'opening_balance'));
        return $pdf->stream('daybook' . '.pdf');
    }
}
