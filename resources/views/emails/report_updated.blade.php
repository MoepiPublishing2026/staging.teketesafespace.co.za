@component('mail::message')
# Report Updated

A reporter has **edited a report**.

**Case Number:**  
{{ $report->case_number }}

**Location:**  
{{ $report->location }}

**Updated At:**  
{{ $timestamp }}

@component('mail::button', ['url' => url('/school-admin')])
View Report
@endcomponent

Thanks,  
{{ config('app.name') }}
@endcomponent
