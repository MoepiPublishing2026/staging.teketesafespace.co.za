<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use App\Models\District;

class DistrictAdminSettings extends Component
{
    use WithFileUploads;

    // profile fields
    public $name;
    public $email;
    public $phone;
    public $district_name;
    public $profile_picture;
    public $current_password;
    public $new_password;
    public $confirm_password;

    // --- Sidebar / UI state ---
    public $activeTab = 'dashboard'; // avoids "undefined variable" in blade

    public function mount()
    {
        $user = Auth::user()->fresh();

        $this->name  = $user->name;
        $this->email = $user->email;
        $this->phone = $user->phone ?? $user->phone_number ?? null;

        // set district name (read-only shown on page)
        if ($user->district) {
            $district = District::where('district_id', $user->district)->first();
            $this->district_name = $district ? $district->district_name : $user->district;
        } else {
            $this->district_name = 'Not Assigned';
        }

        // If this component is loaded on the profile/settings route, mark the profile tab active
        if (request()->is('district/settings') || request()->is('district/profile')) {
            $this->activeTab = 'profile';
        }
    }

    // allow the Blade sidebar to change the active tab
    public function setActiveTab($tab)
    {
        $this->activeTab = $tab;
    }

    public function updatedProfilePicture()
    {
        $this->validate([
            'profile_picture' => 'image|max:2048', // 2MB Max
        ]);
    }

    public function updateSettings()
    {
        $user = User::find(Auth::id());
        $updated = false;

        // Update name/email/phone
        if ($this->name !== $user->name) { $user->name = $this->name; $updated = true; }
        if ($this->email !== $user->email) { $user->email = $this->email; $updated = true; }
        if ($this->phone !== ($user->phone ?? $user->phone_number)) {
            // adapt field name whichever you use
            if (isset($user->phone)) $user->phone = $this->phone;
            else $user->phone_number = $this->phone;
            $updated = true;
        }

        // Handle profile picture upload (same logic you had)
        if ($this->profile_picture) {
            try {
                if ($user->profile_picture) {
                    Storage::disk('public')->delete($user->profile_picture);
                }
                $path = $this->profile_picture->store('profile_pictures', 'public');
                $user->profile_picture = $path;
                // copy to public/storage for direct access (if you rely on that)
                $source = storage_path('app/public/' . $path);
                $destination = public_path('storage/' . $path);
                $destinationDir = dirname($destination);
                if (!file_exists($destinationDir)) mkdir($destinationDir, 0777, true);
                @copy($source, $destination);
                $this->profile_picture = null;
                $updated = true;
            } catch (\Exception $e) {
                Log::error('District admin profile picture upload failed', [
                    'error' => $e->getMessage(),
                    'user_id' => $user->id ?? null
                ]);
                $this->addError('profile_picture', 'Failed to upload profile picture: ' . $e->getMessage());
                return;
            }
        }

        // Password change
        if ($this->new_password) {
            if (!Hash::check($this->current_password, $user->password)) {
                $this->addError('current_password', 'Current password is incorrect.');
                return;
            }
            if ($this->new_password !== $this->confirm_password) {
                $this->addError('confirm_password', 'Passwords do not match.');
                return;
            }
            $user->password = Hash::make($this->new_password);
            $updated = true;
        }

        if ($updated) {
            $user->save();
            session()->flash('success_message', 'Settings updated successfully!');
            // keep user on this page; also update active tab to profile
            $this->activeTab = 'profile';
            return redirect()->route('district.settings'); // or route('district.profile') depending on your routes
        }
    }

    public function render()
    {
        return view('livewire.district-admin-settings');
    }
}
