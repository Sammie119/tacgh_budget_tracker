<!DOCTYPE>
<html>
<head>
    <title>TAC-GH | Report</title>

    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #0b0b0b;
        }

        .t_align {
            text-align: right;
        }
    </style>
</head>

<body style="width: 100%;" >
    <div style="text-align: center; line-height: 0.5;">
        <h1>THE APOSTOLIC CHURCH-GHANA</h1>
        <H3>{{ $header['header_name'] }}</H3>
    </div>

    @switch($header['type'])
        @case('categoryReport')
            <table>
                <thead>
                    <tr>
                        <th style="width: 20px" class="no-sort">#</th>
                        <th>Date</th>
                        <th>Budget Entry</th>
                        <th>Department</th>
                        <th class="t_align">Amt. Allocated</th>
                        <th class="t_align">Amt. Requested</th>
                        <th class="t_align">Amt. Spent</th>
                        <th class="t_align">Variance</th>
                        <th>%</th>
                    </tr>
                </thead>
                @php
                    $total_amount = 0;
                    $total_amount_requested = 0;
                    $total_amount_spent = 0;
                    $total_variance = 0;
                    $total_percentage = 0;
                @endphp
                <tbody>
                    @forelse($results as $key => $result)
                        @php
                            $total_amount += $result['amount'];
                            $total_amount_requested += $result['amount_requested'];
                            $total_amount_spent += $result['amount_used'];
                            $total_variance += $result['amount'] - $result['amount_used'];
                        @endphp
                        <tr>
                            <td>{{ ++$key }}</td>
                            <td nowrap>{{ $result['date'] }}</td>
                            <td>{{ $result['budget_entry'] }}</td>
                            <td>{{ $result['department'] }}</td>
                            <td class="t_align">{{ number_format($result['amount'], 2) }}</td>
                            <td class="t_align">{{ number_format($result['amount_requested'], 2) }}</td>
                            <td class="t_align">{{ number_format($result['amount_used'], 2) }}</td>
                            <td class="t_align">{{ number_format($result['variance'], 2) }}</td>
                            <td>{{ $result['percentage']}}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="50">No Data Found</td>
                        </tr>
                    @endforelse
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="4">Total</th>
                        <th class="t_align">{{ number_format($total_amount, 2) }}</th>
                        <th class="t_align">{{ number_format($total_amount_requested, 2) }}</th>
                        <th class="t_align">{{ number_format($total_amount_spent, 2) }}</th>
                        <th class="t_align">{{ number_format($total_variance, 2) }}</th>
                        <th>{{ round(($total_amount_spent/$total_amount) * 100, 2) }}%</th>
                    </tr>
                </tfoot>
            </table>
            @break

        @case('summaryReport')
            Coming Soon
        @default
            No Results
    @endswitch

</body>
</html>
