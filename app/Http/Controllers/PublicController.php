<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Programme;
use App\Models\Department;
use App\Models\AcademicYear;
use App\Models\Semester;
use App\Models\Announcement;
use App\Models\Setting;
use App\Models\Staff;
use App\Models\GalleryItem;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    public function home()
    {
        $settings = \Cache::remember('settings_all', 300, fn() => Setting::all()->pluck('value', 'key')->toArray());
        $departments = Department::withCount('programmes')->where('is_active', true)->get();
        $courses = Course::where('is_active', true)->latest()->take(6)->get();
        $programmes = Programme::where('is_active', true)->get();
        $studentCount = \App\Models\Student::where('status', 'active')->count();
        $staffCount = Staff::where('status', 'active')->count();
        $announcements = Announcement::where('is_active', true)->latest()->take(3)->get();
        $currentYear = AcademicYear::where('is_current', true)->first();

        return view('public.home', compact('settings', 'departments', 'courses', 'programmes', 'studentCount', 'staffCount', 'announcements', 'currentYear'));
    }

    public function courses(Request $request)
    {
        $settings = \Cache::remember('settings_all', 300, fn() => Setting::all()->pluck('value', 'key')->toArray());
        $query = Course::with(['department', 'programme'])->where('is_active', true);

        if ($request->filled('department')) {
            $query->where('department_id', $request->department);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('code', 'like', "%{$search}%");
            });
        }

        $courses = $query->latest()->paginate(12)->withQueryString();
        $departments = Department::where('is_active', true)->get();

        return view('public.courses', compact('settings', 'courses', 'departments'));
    }

    public function about()
    {
        $settings = \Cache::remember('settings_all', 300, fn() => Setting::all()->pluck('value', 'key')->toArray());
        $departments = Department::withCount('programmes', 'students')->where('is_active', true)->get();
        $staff = Staff::with('user')->where('status', 'active')->get();
        $studentCount = \App\Models\Student::where('status', 'active')->count();
        $staffCount = $staff->count();
        $programmes = Programme::where('is_active', true)->get();

        return view('public.about', compact('settings', 'departments', 'staff', 'studentCount', 'staffCount', 'programmes'));
    }

    public function academic()
    {
        $settings = \Cache::remember('settings_all', 300, fn() => Setting::all()->pluck('value', 'key')->toArray());
        $academicYears = AcademicYear::with('semesters')->latest()->get();
        $currentYear = AcademicYear::where('is_current', true)->with('semesters')->first();
        $programmes = Programme::with('department')->where('is_active', true)->get();

        return view('public.academic', compact('settings', 'academicYears', 'currentYear', 'programmes'));
    }

    public function enrollment()
    {
        $settings = \Cache::remember('settings_all', 300, fn() => Setting::all()->pluck('value', 'key')->toArray());
        $programmes = Programme::with('department')->where('is_active', true)->get();
        $academicYears = AcademicYear::all();

        return view('public.enrollment', compact('settings', 'programmes', 'academicYears'));
    }

    public function storeEnrollment(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:applications,email',
            'phone' => 'nullable|string|max:20',
            'gender' => 'required|in:male,female',
            'date_of_birth' => 'required|date|before:today',
            'address' => 'nullable|string',
            'programme_id' => 'required|exists:programmes,id',
            'previous_school' => 'nullable|string',
            'qualification' => 'nullable|string',
            'guardian_name' => 'nullable|string',
            'guardian_phone' => 'nullable|string',
        ]);

        $applicationNumber = \App\Models\Application::generateNumber();

        \App\Models\Application::create(array_merge($validated, [
            'application_number' => $applicationNumber,
        ]));

        \Cache::forget('badge_pending_apps');

        return redirect()->route('public.enrollment')->with('enrollment_success', 'Application submitted successfully! Your application number is ' . $applicationNumber . '. Our admissions team will review your application and contact you shortly.');
    }

    public function gallery()
    {
        $settings = \Cache::remember('settings_all', 300, fn() => Setting::all()->pluck('value', 'key')->toArray());
        $departments = Department::where('is_active', true)->get();
        $galleryItems = GalleryItem::where('is_active', true)->orderBy('sort_order')->latest()->get();
        $categories = $galleryItems->pluck('category')->unique()->values();

        return view('public.gallery', compact('settings', 'departments', 'galleryItems', 'categories'));
    }

    public function contact()
    {
        $settings = \Cache::remember('settings_all', 300, fn() => Setting::all()->pluck('value', 'key')->toArray());

        return view('public.contact', compact('settings'));
    }

    public function submitContact(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        \App\Models\Enquiry::create($validated);

        \Cache::forget('badge_new_enquiries');

        return redirect()->route('public.contact')->with('contact_success', 'Thank you for your message! We will get back to you shortly.');
    }
}
