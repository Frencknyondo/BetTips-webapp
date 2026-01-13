<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\TipsterApplication;

class AccountController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('account', compact('user'));
    }

    public function updateProfilePicture(Request $request)
    {
        $request->validate([
            'profile_picture' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = Auth::user();

        if ($request->hasFile('profile_picture')) {
            // Delete old profile picture if exists
            if ($user->profile_picture && Storage::disk('public')->exists($user->profile_picture)) {
                Storage::disk('public')->delete($user->profile_picture);
            }

            // Store new profile picture
            $path = $request->file('profile_picture')->store('profile_pictures', 'public');

            // Update user
            $user->update(['profile_picture' => $path]);

            return response()->json(['success' => true, 'message' => 'Profile picture updated successfully']);
        }

        return response()->json(['success' => false, 'message' => 'No file uploaded'], 400);
    }

    public function showApplicationForm()
    {
        $user = Auth::user();
        // Check if user already has a pending or approved application
        $existingApplication = TipsterApplication::where('user_id', $user->id)->whereIn('status', ['pending', 'approved'])->first();
        if ($existingApplication) {
            return redirect()->route('account')->with('error', 'You already have a pending or approved application.');
        }
        return view('tipster.apply', compact('user'));
    }

    public function submitApplication(Request $request)
    {
        $request->validate([
            'experience' => 'required|integer|min:0',
            'sports' => 'required|string|max:255',
            'bio' => 'required|string|max:1000',
            'contact' => 'required|string|max:255',
        ]);

        $user = Auth::user();

        // Check if user already has a pending application
        $existingApplication = TipsterApplication::where('user_id', $user->id)->where('status', 'pending')->first();
        if ($existingApplication) {
            return redirect()->back()->with('error', 'You already have a pending application.');
        }

        TipsterApplication::create([
            'user_id' => $user->id,
            'bio' => $request->bio,
            'contact' => $request->contact,
            'experience' => $request->experience,
            'sports' => $request->sports,
            'status' => 'pending',
        ]);

        return redirect()->route('account')->with('success', 'Your application has been submitted successfully. Please wait for admin approval.');
    }
}
