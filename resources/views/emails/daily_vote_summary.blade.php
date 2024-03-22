@component('mail::message')
# Daily Vote Summary

Here are the vote totals for {{ \Carbon\Carbon::now()->toDateString() }}:

## Today's Totals

@foreach ($dailyTotals as $item => $total)
- **{{ $item }}**: {{ $total }}
@endforeach

## Overall Totals

@foreach ($overallTotals as $item => $total)
- **{{ $item }}**: {{ $total }}
@endforeach

Thanks,<br>
{{ config('app.name') }}
@endcomponent
