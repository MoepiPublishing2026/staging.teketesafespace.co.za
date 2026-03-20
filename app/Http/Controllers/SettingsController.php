<?php

namespace App\Http\Controllers;

use Livewire\WithFileUploads;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class SettingsController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('national-admin-settings.index', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        $successMessage = "";
        
        // Validate input
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
        
        // Update name
        if ($request->filled('name') && $request->name !== $user->name) {
            $user->name = $request->name;
            $updated = true;
        }
        
        // Update phone - remove any leading zeros from input, then store without leading zero
        if ($request->phone_number) {
            $cleanedPhone = preg_replace('/\D/', '', $request->phone_number);
            //$phoneForStorage = ltrim($cleanedPhone, '0'); // <-- define it here

            if ($cleanedPhone !== $user->phone_number) {
                $user->phone_number = $cleanedPhone;
                $updated = true;
            }
        }
        
        // Handle Profile Picture Upload
        if ($request->hasFile('profile_picture')) {
            try {
                $file = $request->file('profile_picture');
                
                if (!$file->isValid()) {
                    throw new \Exception('Invalid file upload');
                }
                
                // Delete old profile picture if exists
                if ($user->profile_picture) {
                    $oldPath = str_replace('public/', '', $user->profile_picture);
                    if (Storage::disk('public')->exists($oldPath)) {
                        Storage::disk('public')->delete($oldPath);
                        Log::info('Old profile picture deleted', [
                            'user_id' => $user->id,
                            'old_path' => $oldPath
                        ]);
                    }
                }
                
                // Generate unique filename
                $filename = 'profile_' . $user->id . '_' . time() . '.' . $file->getClientOriginalExtension();
                
                // Store file in public/storage/profile_pictures
                $path = $file->storeAs('profile_pictures', $filename, 'public');
                
                // Save path to database
                $user->profile_picture = $path;
                
                Log::info('Profile picture uploaded successfully', [
                    'user_id' => $user->id,
                    'path' => $path,
                    'full_url' => Storage::url($path)
                ]);
                
                $updated = true;
            } catch (\Exception $e) {
                Log::error('Profile picture upload failed', [
                    'error' => $e->getMessage(),
                    'user_id' => $user->id,
                    'trace' => $e->getTraceAsString()
                ]);
                return back()->withErrors(['profile_picture' => 'Failed to upload profile picture. Please try again.'])->withInput();
            }
        }
        
        // Password update
        if ($request->filled('new_password')) {
            if (!$request->filled('current_password')) {
                return back()->withErrors(['current_password' => 'Current password is required to set a new password.'])->withInput();
            }
            
            if (!Hash::check($request->current_password, $user->password)) {
                return back()->withErrors(['current_password' => 'Current password is incorrect.'])->withInput();
            }
            
            if (Hash::check($request->new_password, $user->password)) {
                return back()->withErrors(['new_password' => 'New password must be different from your current password.'])->withInput();
            }
            
            $user->password = Hash::make($request->new_password);
            $updated = true;
            
            Log::info('Password updated successfully', ['user_id' => $user->id]);
            //$successMessage = "Password updated Successfully";
            return redirect()->back()->with('success_message', 'Password updated successfully!');
        }
        
        // Save if something changed
        if ($updated) {
            $user->save();
            return redirect()->back()->with('success_message', 'Settings updated successfully!');
        }
        
        return back()->with('success_message', 'No changes detected.');
    }
    
    public function deleteProfilePicture()
    {
        $user = Auth::user();
        
        if ($user->profile_picture) {
            try {
                $path = str_replace('public/', '', $user->profile_picture);
                if (Storage::disk('public')->exists($path)) {
                    Storage::disk('public')->delete($path);
                }
                
                $user->profile_picture = null;
                $user->save();
                
                Log::info('Profile picture deleted', ['user_id' => $user->id]);
                
                return response()->json(['success' => true]);
            } catch (\Exception $e) {
                Log::error('Failed to delete profile picture', [
                    'error' => $e->getMessage(),
                    'user_id' => $user->id
                ]);
                return response()->json(['success' => false], 500);
            }
        }
        
        return response()->json(['success' => false, 'message' => 'No profile picture to delete'], 404);
    }
}