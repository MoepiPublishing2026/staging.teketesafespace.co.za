<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Newsletter;

class NewsletterController extends Controller
{
    public function showLogin()
    {
        return view('admin.newsletter.login');
    }

    public function handleLogin(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // 🔍 STEP 1: Check if the email exists in the correct table
        $adminCheck = \App\Models\NewsletterAdmin::where('email', $credentials['email'])->first();
        if (!$adminCheck) {
            return back()
                ->withErrors([
                    'email' => 'This email address is not registered in our system.'
                ])
                ->withInput($request->only('email'));
        }

        // 🔍 STEP 2: Check if the password hash matches perfectly
        $passwordMatches = \Illuminate\Support\Facades\Hash::check($credentials['password'], $adminCheck->password);
        if (!$passwordMatches) {
            return back()
                ->withErrors([
                    'email' => 'The password you entered is incorrect.'
                ])
                ->withInput($request->only('email'));
        }

        // 🔐 STEP 3: Attempt login using the ISOLATED 'newsletter' guard track
        if (Auth::guard('newsletter')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('admin.newsletter.create');
        }

        return back()
            ->withErrors([
                'email' => 'The credentials passed manual checks, but the guard authentication session failed.',
            ])
            ->withInput($request->only('email'));
    }

    public function create()
    {
        return view('admin.newsletter.create');
    }

    public function store(Request $request)
    {
        // 1. Added image validation rules (supports common formats, max 2MB)
        $validated = $request->validate([
            'title'        => 'required|string|max:255',
            'category'     => 'required|string',
            'publish_date' => 'required|date',
            'author'       => 'nullable|string|max:150',
            'image'        => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048', 
            'full_context' => 'required|string',
        ]);

        // 2. Process image upload if a file exists in the request
        if ($request->hasFile('image')) {
            // Stores file in storage/app/public/newsletters and gets the relative path
            $path = $request->file('image')->store('newsletters', 'public');
            
            // Swap the file instance in the array with the stored path string
            $validated['image'] = $path;
        }

        // 3. Create record using the array
        Newsletter::create($validated);

        return redirect()->route('admin.newsletter.create')->with('success', 'Published successfully!');
    }
}