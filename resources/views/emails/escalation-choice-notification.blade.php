<!DOCTYPE html>
<html>
<head>
<title>Case Status Update</title>
</head>
<body>
 <h1>Case Status Update - {{ $report->case_number }}</h1>
 
 <p>Dear User/Admin,</p>
<p>This is an automated notification regarding case **{{ $report->case_number }}**.</p>
<p>The reporter has interacted with the status tracker and made a choice:</>
 
<p style="font-weight: bold; color: #1e7e34;">Action Taken: {{ $reason }}</p>
 
<p>The current status of the report is: **{{ ucfirst(str_replace('-', ' ', $report->status)) }}**.</p>
 
 <hr>
 
<p>You can check the latest status using the case number on the platform.</p>
 <p>Thank you.</p>
     {{ config('app.name') }}
</body>
</html>