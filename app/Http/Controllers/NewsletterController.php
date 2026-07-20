<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\Newsletter;
use App\Models\NewsletterAdmin;

class NewsletterController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:newsletter')->except([
            'showLogin',
            'handleLogin',
            'showForgotPassword',
            'resetPassword',
            'logout',
        ]);
    }

    public function showLogin()
    {
        // Always show the login form so admins must sign in before upload.
        // Clear any existing newsletter session so /login never skips to the panel.
        if (Auth::guard('newsletter')->check()) {
            Auth::guard('newsletter')->logout();
        }

        return view('admin.newsletter.login');
    }

    public function handleLogin(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $admin = NewsletterAdmin::where('email', $credentials['email'])->first();

        if (! $admin || ! Hash::check($credentials['password'], $admin->getAuthPassword())) {
            return back()
                ->withErrors([
                    'email' => 'The email or password you entered is incorrect.',
                ])
                ->withInput($request->only('email'));
        }

        Auth::guard('newsletter')->login($admin);
        $request->session()->regenerate();

        return redirect()->route('admin.newsletter.create');
    }

    public function logout(Request $request)
    {
        Auth::guard('newsletter')->logout();
        $request->session()->regenerateToken();

        return redirect()->route('newsletter.login');
    }

    public function showForgotPassword()
    {
        return view('admin.newsletter.forgot-password');
    }

    public function resetPassword(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => [
                'required',
                'confirmed',
                'string',
                'min:8',
                'max:50',
            ],
        ]);

        $admin = NewsletterAdmin::where('email', $validated['email'])->first();

        if (!$admin) {
            return back()
                ->withErrors(['email' => 'This email address is not registered in our system.'])
                ->withInput($request->only('email'));
        }

        $admin->forceFill([
            'password' => $validated['password'],
            'remember_token' => Str::random(60),
        ])->save();

        return redirect()->route('newsletter.login')->with('status', 'Your password has been reset. You can log in now.');
    }

    public function index()
    {
        $newsletters = Newsletter::orderByDesc('publish_date')
            ->orderByDesc('created_at')
            ->get();

        return view('admin.newsletter.index', compact('newsletters'));
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

        if (($validated['category'] ?? '') === 'Press Release') {
            $validated['author'] = null;
        }

        // 2. Process image upload if a file exists in the request
        if ($request->hasFile('image')) {
            // Stores file in storage/app/public/newsletters and gets the relative path
            $path = $request->file('image')->store('newsletters', 'public');

            // Swap the file instance in the array with the stored path string
            $validated['image'] = $path;
        }

        // 3. Create record using the array
        Newsletter::create($validated);

        return redirect()->route('admin.newsletter.index')->with('success', 'Published successfully!');
    }

    public function edit(Newsletter $newsletter)
    {
        return view('admin.newsletter.edit', compact('newsletter'));
    }

    public function update(Request $request, Newsletter $newsletter)
    {
        $validated = $request->validate([
            'title'        => 'required|string|max:255',
            'category'     => 'required|string',
            'publish_date' => 'required|date',
            'author'       => 'nullable|string|max:150',
            'image'        => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'full_context' => 'required|string',
        ]);

        if (($validated['category'] ?? '') === 'Press Release') {
            $validated['author'] = null;
        }

        if ($request->hasFile('image')) {
            if ($newsletter->image && Storage::disk('public')->exists($newsletter->image)) {
                Storage::disk('public')->delete($newsletter->image);
            }

            $validated['image'] = $request->file('image')->store('newsletters', 'public');
        }

        $newsletter->update($validated);

        return redirect()->route('admin.newsletter.index')->with('success', 'Article updated successfully!');
    }

    public function destroy(Newsletter $newsletter)
    {
        if ($newsletter->image && Storage::disk('public')->exists($newsletter->image)) {
            Storage::disk('public')->delete($newsletter->image);
        }

        $newsletter->delete();

        return redirect()->route('admin.newsletter.index')->with('success', 'Article deleted successfully!');
    }
}