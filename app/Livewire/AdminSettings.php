<?php
namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use App\Models\User;

class AdminSettings extends Component
{
    use WithFileUploads;

    public $name;
    public $email;
    public $phone;
    public $phone_number;
    public $profile_picture;
    public $current_password;
    public $new_password;
    public $confirm_password;
    public $success_message = '';
    
    protected $rules = [
        'new_password' => [
            'required',
            'string',
            'min:8',                         
            'max:50',                       
            'regex:/[A-Z]/',                
            'regex:/[0-9]/',                
            'regex:/[\W_]/',                
        ],
    ];

    protected $messages = [
        'new_password.min' => 'The new password must be a minimum of 8 characters.',
        'new_password.max' => 'The new password may not be greater than 50 characters.',
        'new_password.regex' => 'The new password must contain at least one uppercase letter, one number, and one special character.',
        'confirm_password.same' => 'The confirmation password does not match the new password.',
    ];

    public function mount()
    {
        $user = Auth::user()->fresh();
        $this->name = $user->name;
        $this->email = $user->email;
        $this->phone = $user->phone;
        $this->phone_number = $user->phone_number;
    }

    public function updatedProfilePicture()
    {
        $this->validate([
            'profile_picture' => 'image|max:2048', // 2MB Max
        ]);
    }

public function updateSettings()
{
    $user = Auth::user();
    if (!$user) return;

    $this->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email,' . $user->id,
        'phone_number' => [
            'nullable',
            'string',
            'regex:/^(\+27|0)[1-8][0-9]{8}$/',
        ],
    ], [
        'phone_number.regex' => 'Phone number must be a valid South African number (10 digits starting with 0).',
    ]);

    $updated = false;

    // Update name and email
    foreach (['name', 'email'] as $field) {
        if ($this->$field !== $user->$field) {
            $user->$field = $this->$field;
            $updated = true;
        }
    }

    // Update phone - clean and store without leading zero
    if ($this->phone_number) {
        $cleanedPhone = preg_replace('/\D/', '', $this->phone_number);
        //$phoneForStorage = ltrim($cleanedPhone, '0'); // <-- define it here

        if ($cleanedPhone !== $user->phone_number) {
            $user->phone_number = $cleanedPhone;
            $updated = true;
        }
    }

    // Profile picture upload
    if ($this->profile_picture) {
        try {
            // Delete old profile picture if exists
            if ($user->profile_picture && Storage::disk('public')->exists($user->profile_picture)) {
                Storage::disk('public')->delete($user->profile_picture);
            }

            // Store new profile picture
            $path = $this->profile_picture->store('profile_pictures', 'public');
            $user->profile_picture = $path;
            $updated = true;

            // Clear the profile_picture property after saving
            $this->profile_picture = null;

        } catch (\Exception $e) {
            $this->addError('profile_picture', 'Upload failed. Please try again.');
            Log::error('Profile picture upload error: ' . $e->getMessage());
            return;
        }
    }

    // Password change
    if ($this->new_password) {
        // Verify current password
        if (!Hash::check($this->current_password, $user->password)) {
            $this->addError('current_password', 'Current password is incorrect');
            return;
        }

        // Prevent reusing the same password
        if (Hash::check($this->new_password, $user->password)) {
            $this->addError('new_password', 'New password cannot be the same as the current password');
            return;
        }

        // Validate new password rules
        $this->validate([
            'new_password' => [
                'required',
                'min:8',
                'regex:/[A-Z]/',
                'regex:/[a-z]/',
                'regex:/[0-9]/',
                'regex:/[!@#$%^&*(),.?":{}|<>]/',
            ],
        ]);

        // If validation passes, update password
        $user->password = Hash::make($this->new_password);
        $updated = true;
    }

    if ($updated) {
        $user->save();
        return redirect()->back()->with('success_message', 'Settings updated successfully!');
    }
}
public function deleteProfilePicture()
{
    $user = Auth::user();

    if (!$user) {
        return;
    }

    try {

        // Delete image from storage
        if ($user->profile_picture && Storage::disk('public')->exists($user->profile_picture)) {
            Storage::disk('public')->delete($user->profile_picture);
        }

        // Remove image path from database
        $user->profile_picture = null;
        $user->save();

        // Clear temporary upload
        $this->profile_picture = null;

        session()->flash('success_message', 'Profile picture deleted successfully!');

    } catch (\Exception $e) {

        Log::error('Delete profile picture error: ' . $e->getMessage());

        $this->addError('profile_picture', 'Failed to delete profile picture.');
    }
}


    public function render()
    {
        return view('livewire.admin-settings')->layout('components.layouts.school-admin', ['title' => 'My Profile | Tekete SafeSpace']);
    }
}