<?php

namespace App\Http\Controllers;

use App\Mail\SendReceipt;
use App\Models\Fee;
use Barryvdh\DomPDF\Facade\Pdf;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class EmailController extends Controller
{
    protected $bcc;

    public function __construct()
    {
        $this->bcc = 'navadarshana.in@gmail.com';
    }

    public function sendFeeReceipt(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'body' => 'required',
        ]);
        try {
            $fee = Fee::findOrFail($request->fee_id);
            $data = ['body' => $request->body, 'sname' => $fee->student->name];
            $data['receipt'] = Pdf::loadView('pdf.fee-receipt', compact('fee'));
            Mail::to($request->email)->bcc($this->bcc)->send(new SendReceipt($data));
        } catch (Exception $e) {
            return redirect()->back()->with("error", $e->getMessage())->withInput($request->all());
        }
        return redirect()->back()->with("success", "Email sent successfully");
    }
}
