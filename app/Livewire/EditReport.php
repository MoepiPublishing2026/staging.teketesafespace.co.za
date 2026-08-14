<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads; 
use App\Models\Report;
use App\Models\AbuseType;
use App\Models\Subtype;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use App\Mail\ReportUpdatedMail;

class EditReport extends Component
{
    use WithFileUploads;
    
    public $caseNumber;
    public $report;
    public $isAppeal = false;

    public $showSuccessModal = false;
    public $successMessage = '';

    public $abuseTypeID;
    public $subtypeID;
    public $otherSubtypeText;
    public $description;
    public $location;
    public $grade;
    public $schoolName;
    public $phoneNumber;
    public $fullName;
    public $age;
    public $isAnonymous;
    public $schoolPhase;
    public $schoolProvince;
    public $schoolId;

    public $schoolSearch = ''; 
    public $schoolSuggestions = [];
    public $showSchoolDropdown = false;
    
    public $email = '';
    public $abuseTypes;
    public $standardSubtypes;
    public $otherSubtype;
    public $selectedAbuseTypeName;
    
    public $existingAttachments = [];
    public $newAttachments = [];
    public $attachmentsToDelete = [];
    public $newUploads = [];
    public $image = [];

    // Updated Age ranges for grades - 5 grades per age range
    protected array $gradeAgeRanges = [
        'Creche'   => [0,  5],
        'Grade R'  => [4,  7],
        'Grade 1'  => [5,  9],
        'Grade 2'  => [6,  10],
        'Grade 3'  => [7,  11],
        'Grade 4'  => [8,  12],
        'Grade 5'  => [9,  13],
        'Grade 6'  => [10, 14],
        'Grade 7'  => [11, 15],
        'Grade 8'  => [12, 16],
        'Grade 9'  => [13, 17],
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

    public function mount($caseNumber)
    {
        $this->caseNumber = $caseNumber;
        $this->report = Report::where('case_number', $caseNumber)->firstOrFail();
        $this->email = $this->report->reporter_email ?? '';
        $this->isAppeal = ($this->report->status === 'false-report');
        $this->abuseTypes = AbuseType::orderBy('type_name')->get();
        $this->abuseTypeID = $this->report->abuse_type_id;
        $this->description = $this->report->description;
        $this->subtypeID = $this->report->subtype_id;
        $this->location = $this->report->location;
        $this->grade = $this->report->grade;
        $this->schoolName = $this->report->school_name;
        $this->schoolSearch = $this->report->school_name;

        // Try to find the school to set the phase and province
        if ($this->schoolName) {
            $school = $this->findSchoolByName($this->schoolName);
            if ($school) {
                $this->schoolPhase = $school->phase_ped;
                $this->schoolProvince = $school->province;
                $this->schoolId = $school->school_id;
            }
        }

        $this->phoneNumber = preg_replace('/\D/', '', (string) $this->report->phone_number);
        $this->fullName = $this->report->full_name;
        $this->age = $this->report->age;
        $this->isAnonymous = $this->report->is_anonymous;

        $abuseType = AbuseType::find($this->abuseTypeID);
        $this->selectedAbuseTypeName = $abuseType->type_name ?? 'Unknown';

        $this->loadSubtypes();

       
        
        $this->existingAttachments = $this->report->image_path
            ? json_decode($this->report->image_path, true)
            : [];
    }

    protected function loadSubtypes()
    {
        $allSubtypes = Subtype::where('abuse_type_id', $this->abuseTypeID)
            ->select('id', 'sub_type_name')
            ->get();

        $this->otherSubtype = $allSubtypes->first(fn($s) => Str::lower($s->sub_type_name) === 'other');

        if ($this->otherSubtype) {
            $this->standardSubtypes = $allSubtypes->where('id', '!=', $this->otherSubtype->id)->sortBy('sub_type_name');
        } else {
            $this->standardSubtypes = $allSubtypes->sortBy('sub_type_name');
        }
    }

    public function updatedAbuseTypeID()
    {
        $this->loadSubtypes();
        $this->reset('subtypeID', 'description', 'otherSubtypeText');
        $abuseType = AbuseType::find($this->abuseTypeID);
        $this->selectedAbuseTypeName = $abuseType->type_name ?? 'Unknown';
    }

    public function updatedSubtypeID()
    {
        if (!$this->otherSubtype || $this->subtypeID != $this->otherSubtype->id) {
            $this->otherSubtypeText = '';
        }
    }

    public function getApplicableGradesProperty(): array
    {
        if ($this->age === null || $this->age === '') return [];
        $age = (int) $this->age;
        $applicable = [];
        
        $phase = $this->schoolPhase;

        // Fallback: If phase is empty but school name is provided, try to resolve it from the DB
        if (empty($phase) && !empty($this->schoolName)) {
            $school = \App\Models\School::where('school_name', $this->schoolName)->first();
            if ($school) {
                $this->schoolPhase = $school->phase_ped;
                $phase = $this->schoolPhase;
            }
        }

        $phase = !empty($phase) ? strtoupper(trim($phase)) : null;

        foreach ($this->gradeAgeRanges as $grade => [$min, $max]) {
            if ($age >= $min && $age <= $max) {
                 // Filter by school phase if it exists and is recognized
                if ($phase && isset($this->phaseGrades[$phase])) {
                    if (in_array($grade, $this->phaseGrades[$phase])) {
                        $applicable[] = $grade;
                    }
                } else {
                    $applicable[] = $grade;
                }
            }
        }
        return $applicable;
    }

    /**
     * Resolve school phase when school name is updated
     */
   public function updatedSchoolName($value)
{
    if (!empty($value)) {
        $school = $this->findSchoolByName($value);
        if ($school) {
            $this->schoolPhase = $school->phase_ped;
            $this->schoolProvince = $school->province;
            $this->schoolId = $school->school_id;
        } else {
            $this->schoolPhase = null;
            $this->schoolProvince = null;
            $this->schoolId = null;
        }
        // Re-evaluate grade based on new phase
        $this->updatedAge($this->age);
    } else {
        $this->schoolPhase = null;
        $this->schoolProvince = null;
        $this->schoolId = null;
    }
}

    /**
     * Exact (case-insensitive) school match only — unknown names must not resolve.
     */
    private function findSchoolByName($schoolName)
    {
        if (blank($schoolName)) {
            return null;
        }

        return \App\Models\School::whereRaw('LOWER(school_name) = LOWER(?)', [trim($schoolName)])->first();
    }

    public function updatedPhoneNumber($value)
    {
        $this->phoneNumber = preg_replace('/\D/', '', (string) $value);
    }

   public function updatedAge($value)
{
    // Use blank() to treat 0 as a valid age, but catch null/empty strings
    if (blank($value)) {
        $this->grade = '';
        return;
    }

    // Force call the computed property method to get the fresh list
    $applicableGrades = $this->getApplicableGradesProperty();

    if (!empty($applicableGrades)) {
        $this->resetErrorBag('age');

        // If the current grade is no longer valid for the new age, 
        // or if no grade is selected, auto-select the first one.
        if (blank($this->grade) || !in_array($this->grade, $applicableGrades)) {
            $this->grade = $applicableGrades[0];
        }
    } else {
        $this->grade = '';
        $this->addError('age', 'No grade available for this age.');
    }
}

    public function updatedGrade() { if ($this->age) $this->updatedAge($this->age); }

    public function removeExistingAttachment($index)
    {
        if (isset($this->existingAttachments[$index])) {
            unset($this->existingAttachments[$index]);
            $this->existingAttachments = array_values($this->existingAttachments);
        }
    }

    public function updatedNewUploads($files)
    {
        $files = is_array($files) ? $files : [$files];
        foreach ($files as $file) {
            $alreadyExists = collect($this->image)->contains(fn($f) => $f->getFilename() === $file->getFilename());
            if (!$alreadyExists) $this->image[] = $file;
        }
        $this->reset('newUploads');
    }

    public function removeImage($index)
    {
        if (isset($this->image[$index])) {
            unset($this->image[$index]);
            $this->image = array_values($this->image);
        }
    }
    
    public function getIsOtherSubtypeSelectedProperty()
    {
        return $this->subtypeID && $this->otherSubtype && $this->subtypeID == $this->otherSubtype->id;
    }

    public function updatedSchoolSearch($value)
    {
        if (strlen($value) > 0) {
            $this->schoolSuggestions = \App\Models\School::where('school_name', 'LIKE', $value . '%')
                ->orderBy('school_name')->limit(10)->get(['school_name', 'phase_ped'])->toArray();
            $this->showSchoolDropdown = count($this->schoolSuggestions) > 0;
        } else {
            $this->schoolSuggestions = [];
            $this->showSchoolDropdown = false;
        }
    }

    public function selectSchool($schoolName, $phase = null)
    {
        $school = $this->findSchoolByName($schoolName);

        $this->schoolName = $schoolName;
        $this->schoolSearch = $schoolName;
        $this->schoolPhase = $phase ?? $school?->phase_ped;
        $this->schoolProvince = $school?->province;
        $this->schoolId = $school?->school_id;
        $this->showSchoolDropdown = false;

        $this->updatedAge($this->age);
    }

    public function hideSchoolDropdown() { $this->showSchoolDropdown = false; }

    protected function messages()
    {
        return [
            'fullName.regex' => 'The full name may only contain letters and spaces.',
            'schoolName.required' => 'Please select or enter the Name of School.',
            'location.regex' => 'Address must be in the format: Street Number Street Name, Province (e.g. 123 Main Street, Gauteng)',
            'location.required' => 'Please enter the Address.',
            'phoneNumber.digits' => 'The phone number must be exactly 10 digits.',
            'phoneNumber.regex' => 'Please enter a valid South African phone number starting with 0.',
            'description.required' => 'Additional details are required when "Other" is selected.',
            'description.max' => 'Additional details may not be greater than 500 characters.',
        ];
    }

    public function updateReport()
    {
        $this->phoneNumber = preg_replace('/\D/', '', (string) $this->phoneNumber);

        // Recover schoolId from an exact name match if the dropdown was not clicked.
        if (blank($this->schoolId) && filled($this->schoolName)) {
            $matchedSchool = $this->findSchoolByName($this->schoolName);
            if ($matchedSchool) {
                $this->schoolId = $matchedSchool->school_id;
                $this->schoolPhase = $this->schoolPhase ?: $matchedSchool->phase_ped;
                $this->schoolProvince = $this->schoolProvince ?: $matchedSchool->province;
            }
        }

            // Block submission if age doesn't match school phase
    if (!empty($this->schoolPhase) && $this->age !== null && $this->age !== '') {
        $applicableGrades = $this->getApplicableGradesProperty();
        if (empty($applicableGrades)) {
            $this->addError('age', 'This age is not valid for the selected school type.');
            return;
        }
    }

        if ($this->grade && $this->age !== null && $this->age !== '' && isset($this->gradeAgeRanges[$this->grade])) {
            [$min, $max] = $this->gradeAgeRanges[$this->grade];
            if ((int) $this->age < $min || (int) $this->age > $max) {
                $this->addError('age', "Allowed age for {$this->grade} is {$min} to {$max}.");
                return;
            }
        }

        $isOther = $this->isOtherSubtypeSelected;

        $this->validate([
            'abuseTypeID' => 'required|numeric|exists:abuse_types,id',
            'subtypeID' => 'required|numeric|exists:subtypes,id',
            'otherSubtypeText' => 'nullable',
            'description' => $isOther ? 'required|string|max:500' : 'nullable|string|max:500',
            'location' => [
                'required',
                'string',
                'max:100',
                'min:5',
                'regex:/^\d+\s+[A-Za-z0-9\s\-]+,\s*[A-Za-z\s\-]+$/',
                function ($attribute, $value, $fail) {
                    $addressCharacters = '[a-zA-Z0-9\s,.\-()\/]';
                    if (preg_match('/[a-zA-Z]' . $addressCharacters . '*\d/', trim($value))) {
                        $fail('The '.$attribute.' format is incorrect. (e.g., 204 Pretorius, not Pretorius 204).');
                    }
                },
            ],
            'grade' => 'required|string|max:255',
            'email' => 'nullable|email:rfc,dns|max:255',
            'phoneNumber' => [
                'required',
                'digits:10',
                'regex:/^\s*0(1[01234578]|2[12378]|3[1234569]|4[0123456789]|5[134678]|6[0-8]|7[1-9]|8[1-467])(\s*\d){7}\s*$/',
                function ($attribute, $value, $fail) {
                    if (preg_match('/[a-zA-Z]/', $value)) {
                        $fail('Invalid phone number format. Only numbers and spaces are allowed.');
                    }
                    if (preg_match('/^(\d)\1{9}$/', $value)) {
                        $fail('The '.$attribute.' cannot contain all the same digits.');
                    }
                },
            ],
            'schoolName' => [
                'required',
                'string',
                'max:100',
                'regex:/^.{2,100}$/u',
                function ($attribute, $value, $fail) {
                    if (preg_match('/[^a-zA-Z\s.,\-\'&]/', $value)) {
                        $fail('The School Name can only contain letters, spaces, hyphens, apostrophes, commas, periods, and the ampersand (&). Numbers and other special characters are not allowed.');
                    }
                    if (! $this->findSchoolByName($value)) {
                        $fail('The school you entered was not found in our database. Please select a school from the list.');
                    }
                },
            ],
            'fullName' => $this->isAnonymous ? 'nullable|string' : 'required|string|max:50|regex:/^[a-zA-Z\s]+$/u',
            'age' => 'nullable|numeric|min:0|max:115',
        ]);

        // Re-resolve province from the database rather than trusting stale component state.
        $school = $this->findSchoolByName($this->schoolName);
        $this->schoolProvince = $school?->province;

        if ($this->schoolProvince && ! str_contains(strtolower((string) $this->location), strtolower($this->schoolProvince))) {
            $this->addError(
                'location',
                "The address must be in {$this->schoolProvince} because the selected school is located there."
            );

            return;
        }

        $wasAppeal = ($this->report->status === 'false-report');

        $this->report->fill([
            'abuse_type_id' => $this->abuseTypeID,
            'subtype_id' => $this->subtypeID,
            'location' => $this->location,
            'grade' => $this->grade,
            'school_name' => $this->schoolName,
            'reporter_email' => $this->email,
            'phone_number' => $this->phoneNumber,
            'full_name' => $this->isAnonymous ? $this->report->full_name : $this->fullName,
            'age' => $this->age,
        ]);

        if ($school) {
            $this->report->school_id = $school->school_id;
            $this->report->province_id = $school->province_id;
            $this->report->district_id = $school->district_id;
        }

        $newPaths = [];
        foreach ($this->image as $file) {
           // New Code
        $originalName = $file->getClientOriginalName(); // Get original filename
        $path = $file->storeAs('reports', $originalName, 'public'); // Store using that name
            $newPaths[] = $path;
            @copy(storage_path('app/public/' . $path), public_path('storage/' . $path));
        }

        $this->report->image_path = json_encode(array_merge($this->existingAttachments, $newPaths));
        
        
            $this->report->description = $this->description;
        

        if ($wasAppeal) {
            $this->report->status = 'pending';
            $this->report->latest_status_reason = 'Report appealed and resubmitted with updated information';
        }

        $this->report->save();

        $this->successMessage = $wasAppeal ? 'Your appeal has been submitted successfully!' : 'Your report has been updated successfully!';
        $this->showSuccessModal = true;
    }

    /**
     * Updated method to redirect with caseNumber query parameter
     */
    public function closeSuccessModal()
    {
        $this->showSuccessModal = false;
        return redirect()->to(route('check-status', ['caseNumber' => $this->caseNumber]));
    }

    public function render()
    {
        return view('livewire.edit-report', ['report' => $this->report]);
    }
}
