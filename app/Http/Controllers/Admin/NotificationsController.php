<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Notification;
use App\Models\User;

class NotificationsController extends Controller
{
    public function index()
    {
        $notifications = Notification::with('creator')->orderBy('created_at', 'desc')->paginate(20);
        return view('admin.notifications.index', compact('notifications'));
    }

    public function create()
    {
        $users = User::orderBy('name')->get();
        return view('admin.notifications.create', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        // Handle recipients
        if ($request->has('send_to_all')) {
            $recipientIds = User::pluck('id')->toArray();
        } else {
            $recipientIds = $request->input('recipients', []);
            if (empty($recipientIds)) {
                return back()->withErrors(['recipients' => 'Please select at least one user or check "Send to ALL users".']);
            }
            // Validate that all recipient IDs exist
            $existingUserIds = User::whereIn('id', $recipientIds)->pluck('id')->toArray();
            $recipientIds = $existingUserIds;
            if (empty($recipientIds)) {
                return back()->withErrors(['recipients' => 'Selected users do not exist.']);
            }
        }

        // Create notification
        $notification = Notification::create([
            'title' => $request->title,
            'message' => $request->message,
            'created_by' => $request->user()->id,
        ]);

        // Attach users to notification
        $notification->users()->attach($recipientIds, ['is_read' => false]);

        return redirect()->route('admin.notifications.index')->with('success', 'Notification sent successfully');
    }

    public function show(Notification $notification)
    {
        $notification->load(['creator', 'users']);
        return view('admin.notifications.show', compact('notification'));
    }

    public function destroy(Notification $notification)
    {
        $notification->delete();
        return redirect()->route('admin.notifications.index')->with('success', 'Notification deleted successfully');
    }
}