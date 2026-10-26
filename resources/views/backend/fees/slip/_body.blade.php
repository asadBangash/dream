<div class="fee-slip">
    <table class="fee-slip-header-table">
        <tr>
            <td style="width: 80px;">
                <img src="{{ $slip['logo_url'] }}" alt="Logo">
            </td>
            <td>
                <h1>{{ $slip['academy_name'] }}</h1>
                @if ($slip['tagline'])
                    <p class="tagline">{{ $slip['tagline'] }}</p>
                @endif
            </td>
            <td class="fee-slip-meta" style="width: 160px;">
                <strong>FEE SLIP</strong>
                {{ $slip['reference'] }}<br>
                {{ $slip['period_label'] }}
            </td>
        </tr>
    </table>

    <table class="fee-slip-info-table">
        <tr>
            <td class="label">Student Name</td>
            <td>{{ $slip['student']['name'] }}</td>
            <td class="label">Father Name</td>
            <td>{{ $slip['student']['father_name'] }}</td>
        </tr>
        <tr>
            <td class="label">Student ID</td>
            <td>{{ $slip['student']['admission_no'] }}</td>
            <td class="label">Class</td>
            <td>
                {{ $slip['student']['class'] }}
                @if ($slip['student']['section'])
                    ({{ $slip['student']['section'] }})
                @endif
            </td>
        </tr>
        <tr>
            <td class="label">Month</td>
            <td>{{ $slip['period_label'] }}</td>
            <td class="label">Year</td>
            <td>{{ $slip['student']['session_year'] }}</td>
        </tr>
        <tr>
            <td class="label">Phone</td>
            <td>{{ $slip['student']['phone'] }}</td>
            <td class="label">Payment Date</td>
            <td>{{ $slip['payment_date'] }}</td>
        </tr>
    </table>

    <table class="fee-slip-table">
        <thead>
            <tr>
                <th>Description</th>
                <th class="text-right" style="width: 140px;">Amount ({{ $slip['currency'] }})</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($slip['lines'] as $line)
                <tr>
                    <td>{{ $line['description'] }}</td>
                    <td class="text-right">{{ number_format($line['amount'], 2) }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="2">No fee assigned</td>
                </tr>
            @endforelse
            <tr class="total-row">
                <td>Paid Amount</td>
                <td class="text-right">{{ number_format($slip['total_paid'], 2) }}</td>
            </tr>
            <tr class="total-row">
                <td>Remaining Amount</td>
                <td class="text-right">{{ number_format($slip['total_remaining'], 2) }}</td>
            </tr>
        </tbody>
    </table>

    <p class="fee-slip-status">Payment Status: <strong>{{ $slip['status'] }}</strong></p>

    <table class="fee-slip-sign-table">
        <tr>
            <td><div class="line">Student Signature</div></td>
            <td><div class="line">Authorized Signature</div></td>
        </tr>
    </table>

    <div class="fee-slip-footer">{{ $slip['footer_note'] }}</div>
</div>
