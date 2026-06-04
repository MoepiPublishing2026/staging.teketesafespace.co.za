<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\AbuseType;
use App\Models\Subtype;
use App\Models\Report;
use App\Models\School;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\CaseNumberNotification;
use App\Mail\IncidentReported; 
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule; 
use Carbon\Carbon;

class ReportForm extends Component
{
    use WithFileUploads;

    public $abuseTypeID;
    public $isAnonymous;
    public $subtypeID;
    public $description;
    public $reporterEmail;
    public $phoneNumber;
    public $image = []; // Array to hold uploaded files
    public $newUploads = [];


    public $standardSubtypes; 
    public $otherSubtype; 
    public $selectedAbuseTypeName;

    public $fullName;
    public $age;
    public $location;
    public $schoolProvince;
    public $grade;
    public $schoolName;
    public $schoolId;
    public $schoolPhase;

    public $schoolSearch = ''; 
    public $schoolSuggestions = [];
    public $showSchoolDropdown = false;
    public $latestReport;
    
     
   // Updated Age ranges for grades - 5 grades per age range
protected array $gradeAgeRanges = [
    'Creche' => [0, 5],
    'Grade R' => [4, 7],
    'Grade 1' => [5, 9],
    'Grade 2' => [6, 10],
    'Grade 3' => [7, 11],
    'Grade 4' => [8, 12],
    'Grade 5' => [9, 13],
    'Grade 6' => [10, 14],
    'Grade 7' => [11, 15],
    'Grade 8' => [12, 16],
    'Grade 9' => [13, 17],
    'Grade 10' => [14, 18],
    'Grade 11' => [15, 19],
    'Grade 12' => [16, 22],
];

protected array $phaseGrades = [
    'PRIMARY SCHOOL' => ['Grade R', 'Grade 1', 'Grade 2', 'Grade 3', 'Grade 4', 'Grade 5', 'Grade 6', 'Grade 7'],
    'SECONDARY SCHOOL' => ['Grade 8', 'Grade 9', 'Grade 10', 'Grade 11', 'Grade 12'],
    'COMBINED SCHOOL' => ['Creche', 'Grade R', 'Grade 1', 'Grade 2', 'Grade 3', 'Grade 4', 'Grade 5', 'Grade 6', 'Grade 7', 'Grade 8', 'Grade 9', 'Grade 10', 'Grade 11', 'Grade 12'],
    'INTERMEDIATE SCHOOL' => ['Grade 4', 'Grade 5', 'Grade 6', 'Grade 7', 'Grade 8', 'Grade 9'],
    'ECD' => ['Creche', 'Grade R'],
];


    protected $abuseTypePrefixes = [
        'Bullying' => 'BU',
        'Suspected Sexual Harassment' => 'SH',
'Substance Addiction' => 'SA',
        'Violence' => 'VL',
        'Teenage Pregnancy' => 'TP',
        'Weapons' => 'WP',
        'Theft' => 'TH',
        'Suicidal Thoughts' => 'ST',
        'Learning Issues' => 'LI',
        'Request Sanitary Pads' => 'RP',
    ];

    public function mount($abuseTypeID, $isAnonymous)
    {
        $this->abuseTypeID = $abuseTypeID;
        $this->isAnonymous = ($isAnonymous === 'anonymous');
        $abuseType = AbuseType::find($this->abuseTypeID);
        $this->selectedAbuseTypeName = $abuseType->type_name ?? 'Unknown';

        $this->loadSubtypes();
    }

    protected function loadSubtypes()
    {
        $allSubtypes = Subtype::where('abuse_type_id', $this->abuseTypeID)
                             ->select('id', 'sub_type_name')
                             ->get();

        $this->otherSubtype = $allSubtypes->first(function ($subtype) {
            return Str::lower($subtype->sub_type_name) === 'other';
        });

        if ($this->otherSubtype) {
            $this->standardSubtypes = $allSubtypes
                ->where('id', '!=', $this->otherSubtype->id)
                ->sortBy('sub_type_name');
        } else {
            $this->standardSubtypes = $allSubtypes->sortBy('sub_type_name');
        }
    }
    public function getApplicableGradesProperty()
    {
        // Use blank() to check for null/empty string, but it allows 0
        if (blank($this->age)) {
            return [];
        }
        $age = (int)$this->age;
        $applicableGrades = [];

        $phase = $this->schoolPhase;

        // Fallback: If phase is empty but school name is provided, try to resolve it from the DB
        if (empty($phase) && !empty($this->schoolName)) {
            $school = School::where('school_name', $this->schoolName)->first();
            if ($school) {
                $this->schoolPhase = $school->phase_ped;
                $phase = $this->schoolPhase;
            }
        }

        $phase = !empty($phase) ? strtoupper(trim($phase)) : null;

        foreach ($this->gradeAgeRanges as $grade => $range) {
            [$minAge, $maxAge] = $range;
            if ($age >= $minAge && $age <= $maxAge) {
                // Filter by school phase if it exists and is recognized
                if ($phase && isset($this->phaseGrades[$phase])) {
                    if (in_array($grade, $this->phaseGrades[$phase])) {
                        $applicableGrades[] = $grade;
                    }
                } else {
                    $applicableGrades[] = $grade;
                }
            }
        }
        return $applicableGrades;
    }

    public function updatedAbuseTypeID()
    {
        $this->loadSubtypes();
        $this->reset('subtypeID');
    }

    /**
     * Resolve school phase when school name is updated
     */
   public function updatedSchoolName($value)
{
    if (!empty($value)) {
        $school = \App\Models\School::where('school_name', $value)->first();
        if ($school) {
            $this->schoolPhase = $school->phase_ped;
        } else {
            $this->schoolPhase = null; // reset if school not found
        }
        // Re-evaluate grade based on new phase
        $this->updatedAge($this->age);
    }
}

    //<?php
    /**
     * Reset grade when age changes to ensure valid grade selection
     */
    public function updatedAge($value)
    {
        // Use blank() check - blank is true for null/empty string, but FALSE for 0.
        // We only want to reset the grade if the age is truly empty.
        if (blank($value)) {
            $this->grade = '';
            return;
        }
        $applicableGrades = $this->applicableGrades;

        if (!empty($applicableGrades)) {
            $this->resetErrorBag('age');

            // Check if current grade is still valid for the new age
            if (blank($this->grade) || !in_array($this->grade, $applicableGrades)) {
                // FORCE the selection to the first available grade
                $this->grade = $applicableGrades[0];
            }
        } else {
            $this->grade = '';
            $this->addError('age', 'No grade available for this age.');
        }
    }


    public function updatedSchoolPhase()
    {
        $applicableGrades = $this->applicableGrades;

        if (!empty($applicableGrades)) {
            if (blank($this->grade) || !in_array($this->grade, $applicableGrades)) {
                $this->grade = $applicableGrades[0];
            }
        } else {
            $this->grade = '';
        }
    }

    public function updatedGrade()
    {
        if (is_numeric($this->age)) {
            $this->updatedAge($this->age);
        }
    }

    // ❌ The updatedReporterEmail method has been removed to stop live validation errors.
    // The cleaning logic is now only in submitReport().



    public function getIsOtherSubtypeSelectedProperty()
    {
        return $this->subtypeID && $this->otherSubtype && $this->subtypeID == $this->otherSubtype->id;
    }

    protected function rules()
    {
        $isOtherSelected = $this->isOtherSubtypeSelected;

        return [
            'abuseTypeID' => 'required|numeric|exists:abuse_types,id',
            'subtypeID' => ['required', 'numeric', 'exists:subtypes,id'],
            'description' => [
                Rule::requiredIf($isOtherSelected),
                'nullable',
                'string',
                'max:500'
            ],
            // ✅ Validation changed to be more robust for various TLDs.

            'reporterEmail' => [
            'required',
            'email',
            'max:50',
            // MODIFIED REGEX to REQUIRE at least one letter in the local part
                'regex:/^(?=[a-zA-Z0-9._%+-]*[a-zA-Z])([a-zA-Z0-9._%+-]+)\@([a-z0-9]([a-z0-9-]*[a-z0-9])?\.)+(com|uk|co\.za|org|net|gov|edu|mil|int|biz|info|mobi|name|aero|jobs|museum|ac|ad|ae|af|ag|ai|al|am|an|ao|aq|ar|as|at|au|aw|ax|az|ba|bb|bd|be|bf|bg|bh|bi|bj|bm|bn|bo|br|bs|bt|bv|bw|by|bz|ca|cc|cd|cf|cg|ch|ci|ck|cl|cm|cn|co|cr|cu|cv|cw|cx|cy|cz|de|dj|dk|dm|do|dz|ec|ee|eg|eh|er|es|et|eu|fi|fj|fk|fm|fo|fr|ga|gb|gd|ge|gf|gg|gh|gi|gl|gm|gn|gp|gq|gr|gs|gt|gu|gw|gy|hk|hm|hn|hr|ht|hu|id|ie|il|im|in|io|iq|ir|is|it|je|jm|jo|jp|ke|kg|kh|ki|km|kn|kp|kr|kw|ky|kz|la|lb|lc|li|lk|lr|ls|lt|lu|lv|ly|ma|mc|md|me|mg|mh|mk|ml|mn|mo|mp|mq|mr|ms|mt|mu|mv|mw|mx|my|mz|na|nc|ne|nf|ng|ni|nl|no|np|nr|nu|nz|om|pa|pe|pf|pg|ph|pk|pl|pm|pn|pr|ps|pt|pw|py|qa|re|ro|rs|ru|rw|sa|sb|sc|sd|se|sg|sh|si|sj|sk|sl|sm|sn|so|sr|st|su|sv|sx|sy|sz|tc|td|tf|tg|th|tj|tk|tl|tm|tn|to|tr|tt|tv|tw|tz|ua|ug|us|uy|uz|va|vc|ve|vg|vi|vn|vu|wf|ws|ye|yt|za|zm|zw)$/i',
        ],

            'phoneNumber' => [
            'required', 
            'digits:10', // Ensures it's exactly 10 digits
            // Regex simplified, as spaces are removed. 
            // Ensures it starts with 0 and has 9 more digits (total 10)
           // Complex Regex for basic SA numbers starting with 0
'regex:/^\s*0(1[01234578]|2[12378]|3[1234569]|4[0123456789]|5[134678]|6[0-8]|7[1-9]|8[1-467])(\s*\d){7}\s*$/',
            function($attribute, $value, $fail) {
                // The custom checks below will now run on the space-trimmed value.
                if (preg_match('/[a-zA-Z]/', $value)) {
                    $fail('Invalid phone number format. Only numbers and spaces are allowed.');
                }
                if (preg_match('/^(\d)\1{9}$/', $value)) {
                    $fail('The '.$attribute.' cannot contain all the same digits.');
                }
            },
        ],
          'image.*' => 'file|max:102400|mimetypes:video/mp4,audio/mp4,audio/3gpp,audio/amr,audio/aac,audio/webm,audio/mpeg,audio/wav,audio/ogg,image/jpeg,image/png,image/gif,image/webp,application/pdf,application/msword',
'newUploads.*' => 'file|max:102400|mimetypes:video/mp4,audio/mp4,audio/3gpp,audio/amr,audio/aac,audio/webm,audio/mpeg,audio/wav,audio/ogg,image/jpeg,image/png,image/gif,image/webp,application/pdf,application/msword',


            'fullName' => $this->isAnonymous ? 'nullable' : [
                'required', 
                'string', 
                // Regex: Allows letters (A-Z, a-z), spaces (\s), hyphens (-), and apostrophes (').
                // This prevents numbers and most special characters.
                'regex:/^[a-zA-Z\s\-\']{2,50}$/', 
            ],
            'age' => 'required|numeric|min:0|max:115',
            'location' => [
            'required',
            'string',
            'max:100',
            'min:5',
            
            function ($attribute, $value, $fail) {
               
                $addressCharacters = '[a-zA-Z0-9\s,.\-()\/]';
                
                if (preg_match('/[a-zA-Z]' . $addressCharacters . '*\d/', trim($value))) {
                    $fail('The '.$attribute.' format is incorrect. (e.g., 204 Pretorius, not Pretorius 204).');
                }
            },
        ],
            'grade' => 'required|string|max:100',
            'schoolName' => [
            'required',
            'string',
            'max:100',
            // New general regex allows the user to type anything (min 2, max 100)
            'regex:/^.{2,100}$/u',
            function($attribute, $value, $fail) {
                // This custom rule checks for forbidden characters (numbers, etc.) on submission.
                // It checks for any character that is NOT an allowed letter, space, comma, period, hyphen, apostrophe, or ampersand.
                if (preg_match('/[^a-zA-Z\s.,\-\'&]/', $value)) {
                    $fail('The School Name can only contain letters, spaces, hyphens, apostrophes, commas, periods, and the ampersand (&). Numbers and other special characters are not allowed.');
                }
            },
        ],
        ];
    }

    protected function messages()
    {
        return [
            'description.max' => 'Words exceeding limit of 500 ',
            'schoolName.regex' => 'The School Name can only contain letters, spaces, hyphens, apostrophes, commas, periods, and the ampersand (&). Numbers and other special characters are not allowed.',
             'schoolName.required' => 'Please select or enter the Name of School.', // Recommended to keep a friendly required message too

        ];
    }
     public function updatedPhoneNumber($value)
{
    // Removes ALL non-digit characters (including spaces) for saving
    $this->phoneNumber = preg_replace('/\D/', '', $value); 
}   


public function submitReport()
    {
 ini_set('max_execution_time', 500);

 $this->validate([
        'location' => 'required|string',
    ]);

    if ($this->schoolProvince) {

        $address = strtolower($this->location);
        $province = strtolower($this->schoolProvince);

        if (!str_contains($address, $province)) {

            $this->addError(
                'location',
                "The address must be in {$this->schoolProvince} because the selected school is located there."
            );

            return;
        }
    }

 if (!empty($this->schoolPhase) && !empty($this->age)) {
    $applicableGrades = $this->getApplicableGradesProperty();
    if (empty($applicableGrades)) {
        $this->addError('age', 'This age is not valid for the selected school type.');
        return;
    }
}
        if (isset($this->gradeAgeRanges[$this->grade])) {
            [$min, $max] = $this->gradeAgeRanges[$this->grade];

            if ($this->age < $min || $this->age > $max) {
                $this->addError('age', "Allowed age for {$this->grade} is {$min} & {$max}");
                return;
            }

            // Also validate grade against school phase on submission
            $phase = !empty($this->schoolPhase) ? strtoupper(trim($this->schoolPhase)) : null;
            if ($phase && isset($this->phaseGrades[$phase])) {
                if (!in_array($this->grade, $this->phaseGrades[$phase])) {
                    $this->addError('grade', "The selected grade is not applicable for a {$this->schoolPhase}.");
                    return;
                }
            }
        }


$cleanEmail = trim(strtolower($this->reporterEmail));
    $cleanPhone = preg_replace('/\D/', '', $this->phoneNumber); // Remove non-digits
    $cleanName = trim($this->fullName);

    // 2. THE ENHANCED SUSPENSION CHECK
    // Search for ANY existing report that has a future suspension date 
    // and matches ANY of the provided identifiers.
    $blockCheck = \App\Models\Report::where(function($query) use ($cleanEmail, $cleanPhone, $cleanName) {
            if (!empty($cleanEmail)) {
                $query->whereRaw('LOWER(reporter_email) = ?', [$cleanEmail]);
            }
            if (!empty($cleanPhone)) {
                $query->orWhere('phone_number', $cleanPhone);
            }
            if (!$this->isAnonymous && !empty($cleanName)) {
                $query->orWhere('full_name', $cleanName);
            }
        })
        ->whereNotNull('suspended_until')
        ->where('suspended_until', '>', now())
        ->orderBy('suspended_until', 'desc')
        ->first();

    if ($blockCheck) {
        $expiryDate = \Carbon\Carbon::parse($blockCheck->suspended_until);
        
        if ($expiryDate->year >= 2037) {
            $message = "Your details have been permanently banned from submitting reports.";
        } else {
            $daysLeft = ceil(now()->diffInDays($expiryDate));
            $message = "Your reporting privileges are suspended for another $daysLeft days due to previous false reports.";
        }

        session()->flash('error_message', $message);
        
        if ($expiryDate->year < 2037) {
            session()->flash('expiry_date', $expiryDate->toIso8601String());
        }
        
        $this->dispatch('restart-timer');
        return; 
    }



        $this->validate();

        $report = null;        $caseNumber = null;
        
        try {
        DB::transaction(function () use (&$report, &$caseNumber) {
            
            // 1. Get Prefix and Date
            $prefix = $this->abuseTypePrefixes[$this->selectedAbuseTypeName] ?? 'XX'; // e.g., 'WP'
            $schoolIdentifier = $this->schoolName;
            $today = Carbon::now();
            $datePart = $today->format('dm'); // e.g., '1211'

            // Use a retry mechanism to find a unique sequential number
            $maxAttempts = 5;
            $attempt = 0;
            
            do {
                $attempt++;
                
                // 🔑 KEY CHANGE: Count reports for THIS SCHOOL across ALL TIME (no date constraint).
                $totalSchoolReportsCount = Report::where('school_name', $schoolIdentifier)
                                            // ❌ REMOVED: ->whereDate('created_at', $today)
                                            ->count();

                // The sequential number for the current report is the existing total count + 1
                $sequentialCaseNumber = $totalSchoolReportsCount + $attempt; 
                
                // 3. Format the count part to be 4 digits (e.g., 12 -> 0012)
                $formattedCount = str_pad($sequentialCaseNumber, 4, '0', STR_PAD_LEFT);
                
                // 4. Combine into the final format (e.g., CASE-BU + 0013 + 2811)
                $caseNumber = 'CASE-' . $prefix . $formattedCount . $datePart;
                
                // Check if this specific case number already exists
                $exists = Report::where('case_number', $caseNumber)->exists();
                
                if (!$exists) {
                    break; // Found unique case number
                }
                
                if ($attempt >= $maxAttempts) {
                    // Fallback: Add microtime for absolute uniqueness if standard attempts fail
                    $microseconds = substr(microtime(true), 11, 4);
                    $caseNumber = 'CASE-' . $prefix . $formattedCount . $datePart . $microseconds;
                    Log::warning('Case number generation failed to find a unique standard number after 5 attempts. Using microtime fallback.', ['school' => $schoolIdentifier, 'case_number' => $caseNumber]);
                    break;
                }
            } while ($attempt < $maxAttempts);
                $imagePaths = [];
                if (!empty($this->image)) {
                    foreach ($this->image as $file) {
                        $path = $file->store('reports', 'public');
                        $imagePaths[] = $path;

                        // Copy to public storage for web access
                        $source = storage_path('app/public/' . $path);
                        $destination = public_path('storage/' . $path);
                        $destinationDir = dirname($destination);
                        if (!file_exists($destinationDir)) {
                            mkdir($destinationDir, 0777, true);
                        }
                        if (!@copy($source, $destination)) {
                            Log::error('Failed to copy report attachment for web access', ['source' => $source, 'destination' => $destination]);
                        }
                    }
                }                // Lookup school by name to get foreign key IDs
                $school = $this->findSchoolByName($this->schoolName);
                
                $report = new Report();
                $report->abuse_type_id = $this->abuseTypeID;
                $report->subtype_id = $this->subtypeID;
                $report->description = $this->description;
                $report->image_path = !empty($imagePaths) ? json_encode($imagePaths) : null; 
                $report->is_anonymous = $this->isAnonymous;
                $report->case_number = $caseNumber;
                $report->reporter_email = $this->reporterEmail;
                $report->phone_number = $this->phoneNumber;
                $report->age = $this->age;
                $report->location = $this->location;
                $report->grade = $this->grade;
                $report->school_name = $this->schoolName;
                $report->full_name = $this->isAnonymous ? null : $this->fullName;
                  // Populate foreign key fields if school found
                if ($school) {
                    $report->school_id = $school->school_id;
                    $report->province_id = $school->province_id;
                    $report->district_id = $school->district_id;
                }

                $report->save();
            });
            
            
            
            

            // Notify reporter
            if ($this->reporterEmail) {
                Mail::to($this->reporterEmail)->send(new CaseNumberNotification($caseNumber));
            }
/*
            // Notify only the assigned school admin
            if ($report) {
                try {
                    $schoolAdmins = User::where('role', 'school')
                        ->where('school_name', $report->school_name)
                        ->get();
            
                    if ($schoolAdmins->isNotEmpty()) {
                        foreach ($schoolAdmins as $admin) {
                            Mail::to($admin->email)->send(new IncidentReported($report));
                        }
                        Log::info("School admin emails sent for report #{$caseNumber} to {$schoolAdmins->count()} users.");
                    }
                } catch (\Exception $e) {
                    Log::error("Failed to send school admin email for report #{$caseNumber}: " . $e->getMessage());
                }
            }
*/
            session()->flash('success_message', 'Your report has been submitted successfully! Case number: ' . $caseNumber);

            $this->reset([
                'subtypeID',
                'description',
                'reporterEmail',
                'phoneNumber',
                'image',
                'fullName',
                'age',
                'location',
                'grade',
                'schoolName',
                'schoolSearch',
            ]);

        } catch (\Exception $e) {
            Log::error('Report Submission Error: ' . $e->getMessage());
            session()->flash('error_message', 'Something went wrong. Please try again.');
        }
    }
  
  
  public function updatedNewUploads($files)
{
    // Ensure it's an array
    $files = is_array($files) ? $files : [$files];

    foreach ($files as $file) {
        $alreadyExists = collect($this->image)->contains(function ($existingFile) use ($file) {
            return $existingFile->getFilename() === $file->getFilename();
        });

        if (!$alreadyExists) {
            $this->image[] = $file;
        }
    }

    // Reset the temporary input to allow selecting again
    $this->reset('newUploads');
}

public function removeImage($index)
{
    if (isset($this->image[$index])) {
        unset($this->image[$index]);
        $this->image = array_values($this->image); // Reindex array
    }
}    /**
     * Find school by name with improved matching logic
     */
    private function findSchoolByName($schoolName)
    {
        $schoolName = trim($schoolName);
        
        // Try exact match first
        $school = School::where('school_name', $schoolName)->first();
        if ($school) {
            return $school;
        }

        // Try case-insensitive match
        $school = School::whereRaw('LOWER(school_name) = LOWER(?)', [$schoolName])->first();
        if ($school) {
            return $school;
        }

        // Try partial match (school name contains search term)
        $school = School::where('school_name', 'LIKE', "%{$schoolName}%")->first();
        if ($school) {
            return $school;
        }

        // Try reverse partial match (search term contains school name words)
        $school = School::where(function($query) use ($schoolName) {
            $words = explode(' ', $schoolName);
            foreach ($words as $word) {
                if (strlen($word) > 3) { // Only search meaningful words
                    $query->orWhere('school_name', 'LIKE', "%{$word}%");
                }
            }
        })->first();

        return $school;
    }

    public function render()
    {
        return view('livewire.report-form', [
            'standardSubtypes' => $this->standardSubtypes ?? collect(),
            'otherSubtype' => $this->otherSubtype,
            'isOtherSubtypeSelected' => $this->isOtherSubtypeSelected,
        ]);
    }
}