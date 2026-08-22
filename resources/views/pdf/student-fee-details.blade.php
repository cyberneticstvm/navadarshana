@extends("pdf.base")
@section("pdfContent")
<table width="100%" class="no-border">
    <tr>
        <td class="no-border" width="55%">
            <img src="{{ public_path('assets/images/logo/pdf-logo1.png') }}" width="230" alt="Navadarshana Educations">
        </td>
        <td class="no-border text-end">
            <h2 style="margin: 0 0 6px;">{{ $student->show_all_fees ? 'FEE STATEMENT' : 'PENDING FEE STATEMENT' }}</h2>
            <span>Generated: {{ now()->format('d M Y, h:i A') }}</span>
        </td>
    </tr>
</table>

<table width="100%" class="mt-30">
    <tr>
        <td width="18%" class="fw-bold">Student</td>
        <td width="32%">{{ $student->name }}</td>
        <td width="18%" class="fw-bold">Student ID</td>
        <td>ND-{{ str_pad($student->id, 5, '0', STR_PAD_LEFT) }}</td>
    </tr>
    <tr>
        <td class="fw-bold">Branch</td>
        <td>{{ $student->branch?->name ?? 'Not available' }}</td>
        <td class="fw-bold">Mobile</td>
        <td>{{ $student->mobile }}</td>
    </tr>
</table>

<table width="100%" class="mt-30" cellspacing="0" cellpadding="0">
    <thead>
        <tr>
            <th width="5%">SL</th>
            <th width="9%">Receipt</th>
            <th width="12%">Date</th>
            <th width="16%">Batch</th>
            <th width="16%">Fee Details</th>
            <th width="12%">Mode</th>
            <th width="10%" class="text-end">Amount</th>
            <th width="10%" class="text-end">Discount</th>
            <th width="10%" class="text-end">Paid</th>
        </tr>
    </thead>
    <tbody>
        @forelse($fees as $key => $fee)
            <tr>
                <td class="text-center">{{ $key + 1 }}</td>
                <td>#{{ str_pad($fee->id, 5, '0', STR_PAD_LEFT) }}</td>
                <td>{{ $fee->payment_date->format('d M Y') }}</td>
                <td>{{ $fee->batch?->name ?? 'N/A' }}</td>
                <td>
                    {{ ucfirst($fee->category === 'monthly' ? 'batch' : $fee->category) }} Fee
                    @if($fee->category === 'monthly' && $fee->getMonth)
                        <br><span class="txt">{{ $fee->getMonth->name }} {{ $fee->year }} · {{ ucfirst($fee->type) }}</span>
                    @endif
                    @if($fee->remarks)
                        <br><span class="txt">{{ $fee->remarks }}</span>
                    @endif
                </td>
                <td>{{ $fee->pmode?->name ?? 'N/A' }}</td>
                <td class="text-end">{{ number_format($fee->amount, 2) }}</td>
                <td class="text-end">{{ number_format($fee->discount ?? 0, 2) }}</td>
                <td class="text-end fw-bold">{{ number_format($fee->amount - ($fee->discount ?? 0), 2) }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="9" class="text-center">{{ $student->show_all_fees ? 'No fee payments found.' : 'No pending fee details found.' }}</td>
            </tr>
        @endforelse
    </tbody>
    @if($fees->isNotEmpty())
        <tfoot>
            <tr>
                <td colspan="6" class="text-end fw-bold">TOTAL</td>
                <td class="text-end fw-bold">{{ number_format($fees->sum('amount'), 2) }}</td>
                <td class="text-end fw-bold">{{ number_format($fees->sum('discount'), 2) }}</td>
                <td class="text-end fw-bold">{{ number_format($fees->sum(fn ($fee) => $fee->amount - ($fee->discount ?? 0)), 2) }}</td>
            </tr>
        </tfoot>
    @endif
</table>

<p class="text-end mt-30 txt">This is a system-generated fee statement.</p>
@endsection
