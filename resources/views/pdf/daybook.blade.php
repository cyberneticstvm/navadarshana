@extends("pdf.base")
@section("pdfContent")
<div class="row">
    <div class="col">
        <table width=100%>
            <tr>
                <td class="no-border" width="100%">
                    <img src="./assets/images/logo/pdf-logo1.png" width="20%" />
                </td>
            </tr>
        </table>
    </div>
</div>
<div class="row">
    <div class="col">
        <h2 class="text-center">Daybook - {{ $branch->name }}</h2>
        <p class="text-center">{{ $inputs[0] }} to {{ $inputs[1] }}</p>
        <table class="table no-border" width="100%">
            <thead>
                <tr>
                    <th width="10%" class="no-border">SL No</th>
                    <th class="no-border">Particulars</th>
                    <th class="no-border">Income</th>
                    <th class="no-border">Expenses</th>
                    <th class="no-border"></th>
                </tr>
            </thead>
            <tbody class="">
                <tr class="no-border">
                    <td class="no-border">1</td>
                    <td class="no-border">Admission Fee Collected</td>
                    <td class="no-border">{{ number_format($fee->sum('admission_fee'), 2) }}</td>
                    <td class="no-border"></td>
                    <td class="no-border"></td>
                </tr>
                <tr>
                    <td class="no-border">2</td>
                    <td class="no-border">Batch Fee Collected</td>
                    <td class="no-border">{{ number_format($fee->sum('batch_fee'), 2) }}</td>
                    <td class="no-border"></td>
                    <td class="no-border"></td>
                </tr>
                <tr>
                    <td class="no-border">3</td>
                    <td class="no-border">Material Fee Collected</td>
                    <td class="no-border">{{ number_format($fee->sum('material_fee'), 2) }}</td>
                    <td class="no-border"></td>
                    <td class="no-border"></td>
                </tr>
                <tr>
                    <td class="no-border">4</td>
                    <td class="no-border">Other Income</td>
                    <td class="no-border">{{ number_format($ie->sum('income'), 2) }}</td>
                    <td class="no-border"></td>
                    <td class="no-border"></td>
                </tr>
                <tr>
                    <td class="no-border">5</td>
                    <td class="no-border">Other Expenses</td>
                    <td class="no-border"></td>
                    <td class="no-border">{{ number_format($ie->sum('expense'), 2) }}</td>
                    <td class="no-border"></td>
                </tr>
                <tr>
                    <td class="no-border"></td>
                    <td class="fw-bold no-border">Total</td>
                    <td class="fw-bold no-border">{{ number_format($fee->sum('admission_fee') + $fee->sum('batch_fee') + $fee->sum('material_fee') + $ie->sum('income'), 2) }}</td>
                    <td class="fw-bold no-border">{{ number_format($ie->sum('expense'), 2) }}</td>
                    <td class="fw-bold no-border">{{ number_format($fee->sum('admission_fee') + $fee->sum('batch_fee') + $fee->sum('material_fee') + $ie->sum('income') - $ie->sum('expense'), 2) }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection