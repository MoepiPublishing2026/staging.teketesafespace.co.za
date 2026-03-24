@component('mail::message')
# Report Update: Clarification Provided

The reporter for **Case #{{ $report->case_number }}** has submitted an official clarification statement in response to a flagged report.

@if($report->reporter_clarification)
@component('mail::panel')
**Reporter's Statement:**
{{ $report->reporter_clarification }}
@endcomponent
@endif

---

### Report Details
**Case Number:** {{ $report->case_number }}  
**Current Status:** {{ ucfirst($report->status) }}  
**Location:** {{ $report->location ?? 'N/A' }}

@if(!$report->is_anonymous)
**Reporter Name:** {{ $report->full_name ?? 'N/A' }}  
**Email:** {{ $report->reporter_email ?? 'N/A' }}
@else
**Reporter:** Anonymous
@endif

@component('mail::button', ['url' => url('/school-admin')])
Review Clarification & Manage Report
@endcomponent

Thanks,  
{{ config('app.name') }}
@endcomponent