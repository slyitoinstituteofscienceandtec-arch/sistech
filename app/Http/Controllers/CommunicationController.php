<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\Notification;
use Illuminate\Http\Request;

class CommunicationController extends Controller
{
    public function announcements(Request $request)
    {
        $query = Announcement::with('creator');

        if ($request->type) {
            $query->where('type', $request->type);
        }

        $announcements = $query->latest()->paginate(20);
        return view('communication.announcements', compact('announcements'));
    }

    public function createAnnouncement()
    {
        return view('communication.create-announcement');
    }

    public function storeAnnouncement(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'type' => 'required|in:general,academic,finance,event,events,emergency,urgent,exam',
            'audience' => 'required|in:all,students,lecturers,staff,parents',
            'publish_date' => 'nullable|date',
        ]);

        Announcement::create(array_merge($validated, [
            'created_by' => auth()->id(),
            'is_active' => true,
            'publish_date' => $validated['publish_date'] ?? now(),
            'target' => $validated['audience'],
        ]));

        return redirect()->route('admin.communication.announcements')->with('success', 'Announcement published successfully.');
    }

    public function updateAnnouncement(Request $request, Announcement $announcement)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'type' => 'required|in:general,academic,finance,event,events,emergency,urgent,exam',
            'target' => 'required|in:all,students,lecturers,staff,parents',
            'publish_date' => 'nullable|date',
        ]);

        $announcement->update($validated);
        return redirect()->route('admin.communication.announcements')->with('success', 'Announcement updated successfully.');
    }

    public function destroyAnnouncement(Announcement $announcement)
    {
        $announcement->delete();
        return back()->with('success', 'Announcement deleted.');
    }

    public function notifications()
    {
        $notifications = Notification::where('user_id', auth()->id())->latest()->paginate(20);
        return view('communication.notifications', compact('notifications'));
    }

    public function markRead(Notification $notification)
    {
        $notification->update(['is_read' => true]);
        return back();
    }

    public function markAllRead()
    {
        Notification::where('user_id', auth()->id())->update(['is_read' => true]);
        return back();
    }
}
