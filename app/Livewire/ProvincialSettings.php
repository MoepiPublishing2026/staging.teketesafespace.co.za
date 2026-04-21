<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use App\Models\User;

class ProvincialSettings extends Component
{
    use WithFileUploads;

    public $name;
    public $email;
    public $phone_number;
    public $profile_picture;
    public $current_password;
    public $new_password;
    public $confirm_password;

    public function mount()
    {
        $user = Auth::user()->fresh();
        $this->name = $user->name;
        $this->email = $user->email;
        $this->phone = $user->phone;
    }

    public function updatedProfilePicture()
    {
        $this->validate([
            'profile_picture' => 'image|max:2048', // 2MB
        ]);
    }

    public function updateSettings()
    {
        $user = Auth::user();
        $updated = false;

        if ($this->phone_number !== $user->phone_number) {
            $user->phone_number = $this->phone_number;
            $updated = true;
        }

        if ($this->profile_picture) {
            if ($user->profile_picture) {
                Storage::disk('public')->delete($user->profile_picture);
            }
            $path = $this->profile_picture->store('profile_pictures', 'public');
            $user->profile_picture = $path;
            $updated = true;
        }

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
        }
    }

    public function render()
    {
        return view('livewire.provincial-settings')
            ->layout('components.layouts.app', ['title' => 'My Profile | Tekete SafeSpace']);
    }
}
