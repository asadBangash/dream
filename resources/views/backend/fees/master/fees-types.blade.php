
@php
    $total = 0;
@endphp
@foreach ($types as $item)
<tr>
    <td>{{ $item->type->name }}</td>
    <td>{{ $item->amount }}</td>
</tr>
@php
    $total += $item->amount;
@endphp
@endforeach
@if ($total > 0)
<tr>
    <td><strong>{{ ___('common.total') }}</strong></td>
    <td><strong>{{ $total }}</strong></td>
</tr>
@endif

