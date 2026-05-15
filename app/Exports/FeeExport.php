<?php

namespace App\Exports;

use App\Models\Fee;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Collection;
use Carbon\Carbon;

class FeeExport implements FromCollection, WithHeadings
{
    protected $from_date;
    protected $to_date;
    protected $category;
    protected $branch;

    public function __construct(array $inputs = [])
    {
        $this->from_date = $inputs[0] ?? date('Y-m-d');
        $this->to_date = $inputs[1] ?? date('Y-m-d');
        $this->category = $inputs[2] ?? 'all';
        $this->branch = $inputs[3] ?? 0;
    }

    public function collection()
    {
        $fees = Fee::whereBetween('payment_date', [Carbon::parse($this->from_date)->startOfDay(), Carbon::parse($this->to_date)->endOfDay()])
            ->when($this->category != 'all', function ($q) {
                return $q->where('category', $this->category);
            })
            ->when($this->branch > 0, function ($q) {
                return $q->where('branch_id', $this->branch);
            })
            ->with(['student', 'batch', 'pmode'])
            ->get()
            ->filter(function ($f) {
                return ($f->amount - ($f->discount ?? 0)) > 0;
            });

        $rows = $fees->map(function ($fee, $key) {
            $type = ($fee->category == 'monthly') ? 'Batch' : (($fee->category == 'admission') ? 'Admission' : $fee->remarks);
            return [
                $key + 1,
                $fee->payment_date?->format('d.M.Y'),
                optional($fee->student)->name,
                optional($fee->batch)->name,
                $type,
                optional($fee->pmode)->name,
                number_format($fee->amount, 2),
                number_format($fee->discount, 2),
                number_format(($fee->amount - ($fee->discount ?? 0)), 2),
            ];
        })->toArray();

        $totalAmount = $fees->sum('amount');
        $totalDiscount = $fees->sum('discount');
        $totalFee = $fees->reduce(function ($carry, $item) {
            return $carry + ($item->amount - ($item->discount ?? 0));
        }, 0);

        $rows[] = ['', '', '', '', '', 'Total', number_format($totalAmount, 2), number_format($totalDiscount, 2), number_format($totalFee, 2)];

        return new Collection($rows);
    }

    public function headings(): array
    {
        return ['SL No', 'Date', 'Student Name', 'Batch', 'Type', 'Pmode', 'Amount', 'Discount', 'Fee'];
    }
}
