@component('mail::message')
# New Report Submitted

A reporter has submitted a **new report**.

**Case Number:** {{ $report->case_number }}  
**Location:** {{ \App\Support\MailText::line($report->location ?? 'N/A') }}  
**Submitted At:** {{ $timestamp }}

@if(!$report->is_anonymous)
**Reporter Name:** {{ \App\Support\MailText::line($report->full_name ?? 'N/A') }}  
**Email:** {{ \App\Support\MailText::line($report->reporter_email ?? 'N/A') }}  
**Phone:** {{ \App\Support\MailText::line($report->phone_number ?? 'N/A') }}
@else
**Reporter:** Anonymous
@endif

@component('mail::button', ['url' => route('school-admin')])
View Report
@endcomponent

Thanks,  
{{ config('app.name') }}
@endcomponent
