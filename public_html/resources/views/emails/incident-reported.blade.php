@component('mail::message')
# New Report Submitted

A reporter has submitted a **new report**.

**Case Number:** {{ $report->case_number }}  
**Location:** {{ $report->location ?? 'N/A' }}  
**Submitted At:** {{ $timestamp }}

@if(!$report->is_anonymous)
**Reporter Name:** {{ $report->full_name ?? 'N/A' }}  
**Email:** {{ $report->reporter_email ?? 'N/A' }}  
**Phone:** {{ $report->phone_number ?? 'N/A' }}
@else
**Reporter:** Anonymous
@endif

@component('mail::button', ['url' => url('/school-admin')])
View Report
@endcomponent

Thanks,  
{{ config('app.name') }}
@endcomponent
