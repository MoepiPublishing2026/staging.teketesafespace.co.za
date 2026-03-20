<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class ProvincialAdminSettingsController extends Controller
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
                $user = Auth::user();
                if (!$user || $user->role !== 'provincial') {
                    abort(403, 'Unauthorized');
                }
                
                // Validate input with custom rules
                $request->validate([
                    'name' => 'sometimes|string|max:255',
                     'phone_number' => [
                            'nullable',
                            'string',
                            'regex:/^(\+27|0)[1-8][0-9]{8}$/',
                        ],      
                    'profile_picture' => 'nullable|image|max:2048',
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
                ]);
                
                $updated = false;
            
                // Conditionally update name
                if ($request->has('name') && !is_null($request->name) && $request->name !== $user->name) {
                    $user->name = $request->name;
                    $updated = true;
                }
            
                // Update phone
                if ($request->phone_number) {
                    $cleanedPhone = preg_replace('/\D/', '', $request->phone_number);
                    //$phoneForStorage = ltrim($cleanedPhone, '0'); // <-- define it here

                    if ($cleanedPhone !== $user->phone_number) {
                        $user->phone_number = $cleanedPhone;
                        $updated = true;
                    }
                }
            
                // Profile Picture Upload
                if ($request->hasFile('profile_picture')) {
                    try {
                        if ($user->profile_picture) {
                            Storage::disk('public')->delete($user->profile_picture);
                            $publicPath = public_path('storage/' . $user->profile_picture);
                            if (file_exists($publicPath)) {
                                @unlink($publicPath);
                            }
                        }
                        
                        $path = $request->file('profile_picture')->store('profile_pictures', 'public');
                        $user->profile_picture = $path;
            
                        $source = storage_path('app/public/' . $path);
                        $destination = public_path('storage/' . $path);
                        $destinationDir = dirname($destination);
                        if (!file_exists($destinationDir)) {
                            mkdir($destinationDir, 0777, true);
                        }
            
                        $updated = true;
                    } catch (\Exception $e) {
                        return back()->withErrors(['profile_picture' => 'Upload failed. Please try again.']);
                    }
                }
            
                // Password change
                if ($request->filled('new_password')) {
                    // Verify current password
                    if (!Hash::check($request->current_password, $user->password)) {
                        return back()->withErrors(['current_password' => 'Current password is incorrect']);
                    }
            
                    // Prevent reusing the same password
                    if (Hash::check($request->new_password, $user->password)) {
                        return back()->withErrors(['new_password' => 'New password cannot be the same as the current password']);
                    }
            
                    // Update password
                    $user->password = Hash::make($request->new_password);
                    $updated = true;
                }
            
                         if ($updated) {
                                    $user->save();
                                    return redirect()->back()->with('success_message', 'Settings updated successfully!');
                                }
        
        return back()->with('success_message', 'No changes detected.');
            }

}

