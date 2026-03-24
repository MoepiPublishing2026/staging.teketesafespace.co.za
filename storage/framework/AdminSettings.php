<?php
namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminSettings extends Component
{
    use WithFileUploads;

    public $name;
    public $email;
    public $phone;
    public $profile_picture;
    public $current_password;
    public $new_password;
    public $confirm_password;
    public $success_message = '';

    public function mount()
    {
        $user = Auth::user();
        $this->name = $user->name;
        $this->email = $user->email;
        $this->phone = $user->phone; // make sure phone column exists in DB
    }

    public function updateSettings()
    {
        $user = Auth::user();
        $updated = false;

        // Update name
        if ($this->name !== $user->name) {
            $user->name = $this->name;
            $updated = true;
        }

        // Update email
        if ($this->email !== $user->email) {
            $user->email = $this->email;
            $updated = true;
        }

        // Update phone
        if ($this->phone !== $user->phone) {
            $user->phone = $this->phone;
            $updated = true;
        }

        // Update profile picture
        if ($this->profile_picture) {
            $path = $this->profile_picture->store('profile_pictures', 'public');
            $user->profile_picture = $path; // make sure profile_picture column exists in DB
            $updated = true;
        }

        if ($updated) {
            $user->save();
        }

        // Handle password change
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
            $user->save();
            $updated = true;
        }

       session()->flash('success_message', 'Settings updated successfully!');
    }

    public function render()
    {
        return view('livewire.admin-settings');
    }
}
