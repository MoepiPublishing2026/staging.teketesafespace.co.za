<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ProvincialAdminSettingsController extends AdminController
{
    public function index()
    {
        $user = Auth::user();

        if (!$user || $user->role !== 'provincial') {
            abort(403, 'Unauthorized');
        }

        return view('provincial-admin-settings.index', compact('user'));
    }

    public function update(Request $request)
    {
        return $this->safeAdmin(function () use ($request) {
            return $this->performUpdate($request);
        }, $request);
    }

    private function performUpdate(Request $request)
    {
        $user = Auth::user();

        if (!$user || $user->role !== 'provincial') {
            abort(403, 'Unauthorized');
        }

        $request->validate([
            'name' => 'sometimes|string|max:255',
            'phone_number' => [
                'nullable',
                'string',
                'regex:/^(\+27|0)[1-8][0-9]{8}$/',
            ],
            'profile_picture' => [
                'nullable',
                'image',
                'mimes:jpeg,png,jpg,gif,webp',
                'max:2048',
            ],
            'current_password' => 'nullable|required_with:new_password|string',
            'new_password' => [
                'nullable',
                'string',
                'min:8',
                'confirmed',
                'regex:/[A-Z]/',
                'regex:/[a-z]/',
                'regex:/[0-9]/',
                'regex:/[!@#$%^&*(),.?":{}|<>]/',
            ],
        ], [
            'phone.regex' => 'Phone number must be a valid South African number (10 digits starting with 0).',
            'new_password.regex' => 'Password must contain at least one uppercase letter, one lowercase letter, one number, and one special character.',
            'profile_picture.image' => 'The file must be an image.',
            'profile_picture.mimes' => 'The image must be jpeg, png, jpg, gif, or webp.',
            'profile_picture.max' => 'The image may not be greater than 2MB.',
        ]);

        $updated = false;

        if ($request->filled('name') && $request->name !== $user->name) {
            $user->name = $request->name;
            $updated = true;
        }

        if ($request->phone_number) {
            $cleanedPhone = preg_replace('/\D/', '', $request->phone_number);
            if ($cleanedPhone !== $user->phone_number) {
                $user->phone_number = $cleanedPhone;
                $updated = true;
            }
        }

        if ($request->hasFile('profile_picture')) {
            try {
                $file = $request->file('profile_picture');
                if (!$file->isValid()) {
                    throw new \Exception('Invalid file upload');
                }

                if ($user->profile_picture) {
                    $oldPath = str_replace('public/', '', $user->profile_picture);
                    if (Storage::disk('public')->exists($oldPath)) {
                        Storage::disk('public')->delete($oldPath);
                    }
                }

                $filename = 'profile_' . $user->id . '_' . time() . '.' . $file->getClientOriginalExtension();
                $path = $file->storeAs('profile_pictures', $filename, 'public');
                $user->profile_picture = $path;
                $updated = true;
            } catch (\Exception $e) {
                Log::error('Provincial admin profile picture upload failed', [
                    'error' => $e->getMessage(),
                    'user_id' => $user->id,
                ]);
                return back()->withErrors(['profile_picture' => 'Failed to upload profile picture. Please try again.'])->withInput();
            }
        }

        if ($request->filled('new_password')) {
            if (!Hash::check($request->current_password, $user->password)) {
                return back()->withErrors(['current_password' => 'Current password is incorrect.'])->withInput();
            }

            if (Hash::check($request->new_password, $user->password)) {
                return back()->withErrors(['new_password' => 'New password must be different from your current password.'])->withInput();
            }

            $user->password = Hash::make($request->new_password);
            $updated = true;
            $user->save();
            return redirect()->back()->with('success_message', 'Password updated successfully!');
        }

        if ($updated) {
            $user->save();
            return redirect()->back()->with('success_message', 'Settings updated successfully!');
        }

        return back()->with('success_message', 'No changes detected.');
    }
}
