<?php

namespace App\Http\Controllers;

use App\Models\Enquiry;
use Illuminate\Http\Request;

class InboxController extends Controller
{
    public function index()
    {
        $enquiries = Enquiry::latest()->paginate(15);
        $newCount = Enquiry::where('status', 'new')->count();
        return view('admin.inbox.index', compact('enquiries', 'newCount'));
    }

    public function show(Enquiry $enquiry)
    {
        if ($enquiry->status === 'new') {
            $enquiry->update(['status' => 'read']);
            \Cache::forget('badge_new_enquiries');
        }
        return view('admin.inbox.show', compact('enquiry'));
    }

    public function reply(Request $request, Enquiry $enquiry)
    {
        $validated = $request->validate([
            'admin_reply' => 'required|string',
        ]);

        $enquiry->update([
            'admin_reply' => $validated['admin_reply'],
            'status' => 'replied',
            'replied_by' => auth()->id(),
            'replied_at' => now(),
        ]);

        return back()->with('success', 'Reply sent successfully.');
    }

    public function destroy(Enquiry $enquiry)
    {
        $enquiry->delete();
        \Cache::forget('badge_new_enquiries');
        return back()->with('success', 'Enquiry deleted.');
    }
}
