<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\Notification;
use Illuminate\Http\Request;

class StudentPortalController extends Controller
{
    public function profile()
    {
        $student = auth()->user()->student()->with([
            'user',
            'programme.department',
            'academicYear',
        ])->firstOrFail();

        return view('student.profile', compact('student'));
    }

    public function courses()
    {
        $student = auth()->user()->student()->with([
            'courseRegistrations.course.department',
        ])->firstOrFail();

        return view('student.courses', compact('student'));
    }

    public function results()
    {
        $student = auth()->user()->student()->with([
            'results.course',
        ])->firstOrFail();

        return view('student.results', compact('student'));
    }

    public function attendance()
    {
        $student = auth()->user()->student()->with([
            'attendances.course',
        ])->firstOrFail();

        return view('student.attendance', compact('student'));
    }

    public function announcements()
    {
        $announcements = Announcement::active()
            ->orderBy('publish_date', 'desc')
            ->paginate(20);

        return view('student.announcements', compact('announcements'));
    }

    public function notifications()
    {
        $notifications = Notification::where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('student.notifications', compact('notifications'));
    }

    public function markRead(Notification $notification)
    {
        if ($notification->user_id !== auth()->id()) {
            abort(403);
        }

        $notification->update(['is_read' => true]);

        return back();
    }

    public function markAllRead()
    {
        Notification::where('user_id', auth()->id())
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return back();
    }
}
