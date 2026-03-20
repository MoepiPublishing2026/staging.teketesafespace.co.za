@component('mail::message')
# Account Status Update

Hello {{ $report->full_name ?? 'Reporter' }},

This is a formal notification that your access to our reporting platform has been restricted by the administration.

**Reason:** Violation of reporting policies (e.g., repeated false reports).
**Status:** {{ $isPermanent ? 'Permanently Blocked' : 'Suspended for 90 Days' }}

@if($isPermanent)
This decision is final and applies to all future attempts to access the platform.
@else
Your access will remain restricted until {{ \Carbon\Carbon::parse($report->suspended_until)->format('F d, Y') }}.
@endif

If you believe this is an error, please contact the administration directly.

Thanks,<br>
{{ config('app.name') }} Team
@endcomponent