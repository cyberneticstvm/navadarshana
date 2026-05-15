<?php

namespace App\Exports;

use App\Models\IncomeExpense;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Collection;
use Carbon\Carbon;

class IeExport implements FromCollection, WithHeadings
{
    protected $from_date;
    protected $to_date;
    protected $category;
    protected $branch;
    protected $head;

    public function __construct(array $inputs = [])
    {
        $this->from_date = $inputs[0] ?? date('Y-m-d');
        $this->to_date = $inputs[1] ?? date('Y-m-d');
        $this->category = $inputs[2] ?? 'all';
        $this->branch = $inputs[3] ?? 0;
        $this->head = $inputs[4] ?? 0;
    }

    public function collection()
    {
        $ies = IncomeExpense::whereBetween('date', [Carbon::parse($this->from_date)->startOfDay(), Carbon::parse($this->to_date)->endOfDay()])
            ->when($this->category != 'all', function ($q) {
                return $q->where('category', $this->category);
            })
            ->when($this->head > 0, function ($q) {
                return $q->where('head_id', $this->head);
            })
            ->when($this->branch > 0, function ($q) {
                return $q->where('branch_id', $this->branch);
            })
            ->get();

        $rows = $ies->map(function ($ie, $key) {
            return [
                $key + 1,
                $ie->date?->format('d.M.Y'),
                ucfirst($ie->category),
                optional($ie->head)->name,
                $ie->notes,
                number_format($ie->amount, 2),
            ];
        })->toArray();

        // append totals row
        $total = $ies->sum('amount');
        $rows[] = ['', '', '', '', 'Total', number_format($total, 2)];

        return new Collection($rows);
    }

    public function headings(): array
    {
        return ['SL No', 'Date', 'Category', 'Head', 'Notes', 'Amount'];
    }
}
