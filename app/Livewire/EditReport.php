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

    public function mount($caseNumber)
    {
        $this->caseNumber = $caseNumber;
        $this->report = Report::where('case_number', $caseNumber)->firstOrFail();
        $this->email = $this->report->reporter_email ?? '';
        $this->isAppeal = ($this->report->status === 'false-report');
        $this->abuseTypes = AbuseType::all();
        $this->abuseTypeID = $this->report->abuse_type_id;
        $this->description = $this->report->description;
        $this->subtypeID = $this->report->subtype_id;
        $this->location = $this->report->location;
        $this->grade = $this->report->grade;
        $this->schoolName = $this->report->school_name;
        $this->schoolSearch = $this->report->school_name;
        $this->phoneNumber = $this->report->phone_number;
        $this->fullName = $this->report->full_name;
        $this->age = $this->report->age;
        $this->isAnonymous = $this->report->is_anonymous;

        $abuseType = AbuseType::find($this->abuseTypeID);
        $this->selectedAbuseTypeName = $abuseType->type_name ?? 'Unknown';

        $this->loadSubtypes();

        if ($this->otherSubtype && $this->subtypeID == $this->otherSubtype->id) {
            $desc = $this->report->description ?? '';
            if (preg_match('/^\[Other:\s*(.*?)\]\s*/i', $desc, $matches)) {
                $this->otherSubtypeText = $matches[1];
                $this->description = preg_replace('/^\[Other:\s*.*?\]\s*/i', '', $desc);
            }
        }
        
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
        foreach ($this->gradeAgeRanges as $grade => [$min, $max]) {
            if ($age >= $min && $age <= $max) $applicable[] = $grade;
        }
        return $applicable;
    }

    public function updatedAge($value)
    {
        $applicableGrades = $this->applicableGrades;
        if (empty($applicableGrades)) {
            $this->grade = '';
            $this->addError('age', 'No grade available for this age.');
            return;
        }
        $this->resetErrorBag('age');
        if (!$this->grade || !in_array($this->grade, $applicableGrades)) {
            $this->grade = $applicableGrades[0];
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
                ->orderBy('school_name')->limit(10)->pluck('school_name')->toArray();
            $this->showSchoolDropdown = count($this->schoolSuggestions) > 0;
        } else {
            $this->schoolSuggestions = [];
            $this->showSchoolDropdown = false;
        }
    }

    public function selectSchool($schoolName)
    {
        $this->schoolName = $schoolName;
        $this->schoolSearch = $schoolName;
        $this->showSchoolDropdown = false;
    }

    public function hideSchoolDropdown() { $this->showSchoolDropdown = false; }

    protected function messages()
    {
        return [
            'fullName.regex' => 'The full name may only contain letters and spaces.',
            'schoolName.regex' => 'The school name may only contain letters and spaces.',
            'otherSubtypeText.required' => 'Please specify the "Other" subtype.',
            'description.required' => 'Additional details are required when "Other" is selected.',
            'description.max' => 'Additional details may not be greater than 500 characters.',
        ];
    }

    public function updateReport()
    {
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
            'otherSubtypeText' => $isOther ? 'required|string|max:255' : 'nullable',
            'description' => $isOther ? 'required|string|max:500' : 'nullable|string|max:500',
            'location' => 'required|string|max:100|min:5',
            'grade' => 'required|string|max:255',
            'email' => 'nullable|email:rfc,dns|max:255',
            'schoolName' => 'required|string|max:255|regex:/^[a-zA-Z\s]+$/u',
            'fullName' => $this->isAnonymous ? 'nullable|string' : 'required|string|max:50|regex:/^[a-zA-Z\s]+$/u',
            'age' => 'nullable|numeric|min:0|max:115',
        ]);

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

        $newPaths = [];
        foreach ($this->image as $file) {
           // New Code
        $originalName = $file->getClientOriginalName(); // Get original filename
        $path = $file->storeAs('reports', $originalName, 'public'); // Store using that name
            $newPaths[] = $path;
            @copy(storage_path('app/public/' . $path), public_path('storage/' . $path));
        }

        $this->report->image_path = json_encode(array_merge($this->existingAttachments, $newPaths));
        
        if ($isOther && $this->otherSubtypeText) {
            $otherSubtypeText = trim((string) $this->otherSubtypeText);
            $details = trim((string) ($this->description ?? ''));
            $this->report->description = '[Other: ' . $otherSubtypeText . '] ' . $details;
        } else {
            $this->report->description = $this->description;
        }

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
