@extends("pdf.base")
@section("pdfContent")
<div class="row">
    <div class="col">
        <table width=100%>
            <tr>
                <td class="no-border" width="50%">
                    <img src="./assets/images/logo/logo.png" width="25%" />
                </td>
                <td class="no-border">
                    <h4 class="text-end">PAYMENT RECEIPT</h4>
                    <p class="text-end">{{ $fee->payment_date->format('d.M.Y') }}</p>
                    <p class="text-end">Receipt No: {{ $fee->id }}</p>
                </td>
            </tr>
        </table>
    </div>
</div>
<div class="row">
    <div class="col">
        <table width=100%>
            <tr>
                <td class="no-border" width="50%">
                    <div class="ms-15 mt-30">
                        <p>From: </p>
                        {{ $fee->branch->name }}<br />
                        {{ $fee->branch->code }}<br />
                        {{ $fee->branch->contact_number }}<br />
                        {{ $fee->branch->address }}
                    </div>
                </td>
                <td class="no-border">
                    <div class="ms-15 mt-30">
                        <p>To: </p>
                        {{ $fee->student->name }}<br />
                        {{ $fee->student->mobile }}<br />
                        {{ $fee->student->address }}
                    </div>
                </td>
            </tr>
        </table>
    </div>
</div>
<div class="row">
    <div class="col">
        <table width=100% class="mt-10" cellspacing="0" cellpadding="0">
            <tr>
                <td>SL No</td>
                <td>Description</td>
                <td>Category</td>
                <td>Amount</td>
                <td>Total</td>
            </tr>
            <tr>
                <td class="text-center">1</td>
                <td class="">Fee</td>
                <td class="">{{ ucfirst(($fee->category == 'monthly') ? 'Batch' : $fee->category) }} Fee{{ ($fee->category != 'monthly') ? '' : ', '. $fee->getMonth->name.', '.$fee->year }}</td>
                <td class="text-end">{{ $fee->amount }}</td>
                <td class="text-end">{{ $fee->amount }}</td>
            </tr>
            <tr style="border-top: 1px solid #000;">
                <td colspan="4" class="text-end no-border">Discount</td>
                <td class="text-end no-border">{{ number_format($fee->discount, 2) }}</td>
            </tr>
            <tr style="border-top: 1px solid #000;">
                <td colspan="4" class="text-end no-border">Total</td>
                <td class="text-end no-border fw-bold">{{ number_format($fee->amount - $fee->discount, 2) }}</td>
            </tr>
        </table>
    </div>
    <div class="col text-end mt-50">
        <p class="fw-bold">Authorised Signatory</p>
    </div>
    <div class="col mt-10">
        <p class="fw-bold">Remarks</p>
        {{ $fee->remarks }}
    </div>
</div>
@endsection