<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Student;
use App\Models\Staff;
use App\Models\Department;
use App\Models\Programme;
use App\Models\Course;
use App\Models\AcademicYear;
use App\Models\Semester;
use App\Models\Invoice;
use App\Models\Payment;
use App\Models\Book;
use App\Models\Announcement;
use App\Models\Setting;
use App\Models\CourseRegistration;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Super Admin
        $admin = User::create([
            'name' => 'Super Admin',
            'email' => 'admin@sistech.edu',
            'password' => Hash::make('password'),
            'role' => 'super_admin',
            'status' => 'active',
            'phone' => '+233200000001',
        ]);

        // Principal
        $principal = User::create([
            'name' => 'Dr. Kwame Mensah',
            'email' => 'principal@sistech.edu',
            'password' => Hash::make('password'),
            'role' => 'principal',
            'status' => 'active',
            'phone' => '+233200000002',
        ]);

        // Registrar
        $registrar = User::create([
            'name' => 'Mrs. Akua Boateng',
            'email' => 'registrar@sistech.edu',
            'password' => Hash::make('password'),
            'role' => 'registrar',
            'status' => 'active',
            'phone' => '+233200000003',
        ]);

        // Accountant
        $accountant = User::create([
            'name' => 'Mr. Kofi Asante',
            'email' => 'accountant@sistech.edu',
            'password' => Hash::make('password'),
            'role' => 'accountant',
            'status' => 'active',
            'phone' => '+233200000004',
        ]);

        // Academic Year
        $year2026 = AcademicYear::create(['name' => '2026/2027', 'start_date' => '2026-09-01', 'end_date' => '2027-07-31', 'is_current' => true]);
        $year2025 = AcademicYear::create(['name' => '2025/2026', 'start_date' => '2025-09-01', 'end_date' => '2026-07-31', 'is_current' => false]);

        // Semesters
        $sem1 = Semester::create(['academic_year_id' => $year2026->id, 'name' => 'First Semester', 'semester_num' => '1', 'start_date' => '2026-09-01', 'end_date' => '2027-01-31', 'is_current' => true]);
        $sem2 = Semester::create(['academic_year_id' => $year2026->id, 'name' => 'Second Semester', 'semester_num' => '2', 'start_date' => '2027-02-01', 'end_date' => '2027-07-31', 'is_current' => false]);

        // Departments
        $departments = [
            ['name' => 'Computer Science', 'code' => 'CS'],
            ['name' => 'Information Technology', 'code' => 'IT'],
            ['name' => 'Business Studies', 'code' => 'BS'],
            ['name' => 'Digital Marketing', 'code' => 'DM'],
            ['name' => 'Graphic Design', 'code' => 'GD'],
            ['name' => 'Web Development', 'code' => 'WD'],
            ['name' => 'Data Analysis', 'code' => 'DA'],
            ['name' => 'Computer Hardware Engineering', 'code' => 'CHE'],
        ];

        $deptModels = [];
        foreach ($departments as $dept) {
            $deptModels[] = Department::create($dept);
        }

        // Programmes
        $programmes = [
            ['name' => 'Diploma in Computer Science', 'code' => 'DCS', 'department_id' => $deptModels[0]->id, 'level' => 'diploma', 'duration_months' => 24],
            ['name' => 'HND Computer Science', 'code' => 'HCS', 'department_id' => $deptModels[0]->id, 'level' => 'hnd', 'duration_months' => 36],
            ['name' => 'Certificate in IT', 'code' => 'CIT', 'department_id' => $deptModels[1]->id, 'level' => 'certificate', 'duration_months' => 12],
            ['name' => 'Diploma in IT', 'code' => 'DIT', 'department_id' => $deptModels[1]->id, 'level' => 'diploma', 'duration_months' => 24],
            ['name' => 'Diploma in Business Studies', 'code' => 'DBS', 'department_id' => $deptModels[2]->id, 'level' => 'diploma', 'duration_months' => 24],
            ['name' => 'Certificate in Digital Marketing', 'code' => 'CDM', 'department_id' => $deptModels[3]->id, 'level' => 'certificate', 'duration_months' => 6],
            ['name' => 'Diploma in Graphic Design', 'code' => 'DGD', 'department_id' => $deptModels[4]->id, 'level' => 'diploma', 'duration_months' => 24],
            ['name' => 'Diploma in Web Development', 'code' => 'DWD', 'department_id' => $deptModels[5]->id, 'level' => 'diploma', 'duration_months' => 24],
            ['name' => 'Certificate in Data Analysis', 'code' => 'CDA', 'department_id' => $deptModels[6]->id, 'level' => 'certificate', 'duration_months' => 6],
            ['name' => 'Diploma in Computer Hardware', 'code' => 'DCH', 'department_id' => $deptModels[7]->id, 'level' => 'diploma', 'duration_months' => 24],
        ];

        $progModels = [];
        foreach ($programmes as $prog) {
            $progModels[] = Programme::create($prog);
        }

        // Lecturers (Staff)
        $lecturers = [
            ['name' => 'Dr. Ama Darko', 'email' => 'ama@sistech.edu', 'position' => 'lecturer', 'department_id' => $deptModels[0]->id, 'qualification' => 'PhD Computer Science', 'specialization' => 'Artificial Intelligence'],
            ['name' => 'Mr. Yaw Frimpong', 'email' => 'yaw@sistech.edu', 'position' => 'lecturer', 'department_id' => $deptModels[1]->id, 'qualification' => 'MSc IT', 'specialization' => 'Networking'],
            ['name' => 'Mrs. Esi Appiah', 'email' => 'esi@sistech.edu', 'position' => 'lecturer', 'department_id' => $deptModels[2]->id, 'qualification' => 'MBA', 'specialization' => 'Accounting'],
            ['name' => 'Mr. Kojo Mensah', 'email' => 'kojo@sistech.edu', 'position' => 'hod', 'department_id' => $deptModels[3]->id, 'qualification' => 'MSc Digital Marketing', 'specialization' => 'SEO & Social Media'],
            ['name' => 'Ms. Abena Osei', 'email' => 'abena@sistech.edu', 'position' => 'lecturer', 'department_id' => $deptModels[4]->id, 'qualification' => 'MFA Graphic Design', 'specialization' => 'UI/UX Design'],
            ['name' => 'Mr. Kofi Adjei', 'email' => 'kofi@sistech.edu', 'position' => 'lecturer', 'department_id' => $deptModels[5]->id, 'qualification' => 'MSc Web Engineering', 'specialization' => 'Full Stack Development'],
            ['name' => 'Dr. Nana Owusu', 'email' => 'nana@sistech.edu', 'position' => 'hod', 'department_id' => $deptModels[6]->id, 'qualification' => 'PhD Data Science', 'specialization' => 'Machine Learning'],
            ['name' => 'Mr. Kwaku Boateng', 'email' => 'kwaku@sistech.edu', 'position' => 'lecturer', 'department_id' => $deptModels[7]->id, 'qualification' => 'MEng Computer Engineering', 'specialization' => 'Hardware Systems'],
        ];

        $lecturerUsers = [];
        foreach ($lecturers as $lec) {
            $user = User::create([
                'name' => $lec['name'],
                'email' => $lec['email'],
                'password' => Hash::make('password'),
                'role' => 'lecturer',
                'status' => 'active',
            ]);
            Staff::create([
                'user_id' => $user->id,
                'staff_id' => 'STF-' . str_pad(count($lecturerUsers) + 1, 4, '0', STR_PAD_LEFT),
                'department_id' => $lec['department_id'],
                'position' => $lec['position'],
                'employment_type' => 'full_time',
                'hire_date' => '2022-09-01',
                'salary' => rand(5000, 12000),
                'qualification' => $lec['qualification'],
                'specialization' => $lec['specialization'],
            ]);
            $lecturerUsers[] = $user;
        }

        // Courses
        $coursesData = [
            ['code' => 'CS101', 'name' => 'Introduction to Programming', 'dept' => 0, 'prog' => 0, 'credits' => 3, 'semester' => '1', 'level' => 100],
            ['code' => 'CS102', 'name' => 'Data Structures & Algorithms', 'dept' => 0, 'prog' => 0, 'credits' => 3, 'semester' => '2', 'level' => 100],
            ['code' => 'CS201', 'name' => 'Object-Oriented Programming', 'dept' => 0, 'prog' => 1, 'credits' => 3, 'semester' => '1', 'level' => 200],
            ['code' => 'CS202', 'name' => 'Database Management Systems', 'dept' => 0, 'prog' => 1, 'credits' => 3, 'semester' => '2', 'level' => 200],
            ['code' => 'IT101', 'name' => 'Computer Fundamentals', 'dept' => 1, 'prog' => 2, 'credits' => 3, 'semester' => '1', 'level' => 100],
            ['code' => 'IT102', 'name' => 'Operating Systems', 'dept' => 1, 'prog' => 3, 'credits' => 3, 'semester' => '2', 'level' => 100],
            ['code' => 'IT201', 'name' => 'Computer Networks', 'dept' => 1, 'prog' => 3, 'credits' => 3, 'semester' => '1', 'level' => 200],
            ['code' => 'BS101', 'name' => 'Principles of Management', 'dept' => 2, 'prog' => 4, 'credits' => 3, 'semester' => '1', 'level' => 100],
            ['code' => 'DM101', 'name' => 'Digital Marketing Fundamentals', 'dept' => 3, 'prog' => 5, 'credits' => 2, 'semester' => '1', 'level' => 100],
            ['code' => 'GD101', 'name' => 'Design Principles', 'dept' => 4, 'prog' => 6, 'credits' => 3, 'semester' => '1', 'level' => 100],
            ['code' => 'WD101', 'name' => 'HTML & CSS Fundamentals', 'dept' => 5, 'prog' => 7, 'credits' => 2, 'semester' => '1', 'level' => 100],
            ['code' => 'WD201', 'name' => 'JavaScript Programming', 'dept' => 5, 'prog' => 7, 'credits' => 3, 'semester' => '2', 'level' => 100],
            ['code' => 'DA101', 'name' => 'Introduction to Data Analysis', 'dept' => 6, 'prog' => 8, 'credits' => 2, 'semester' => '1', 'level' => 100],
            ['code' => 'CHE101', 'name' => 'Computer Hardware Basics', 'dept' => 7, 'prog' => 9, 'credits' => 3, 'semester' => '1', 'level' => 100],
            ['code' => 'CS301', 'name' => 'Software Engineering', 'dept' => 0, 'prog' => 1, 'credits' => 3, 'semester' => '1', 'level' => 300],
        ];

        $courseModels = [];
        foreach ($coursesData as $c) {
            $courseModels[] = Course::create([
                'code' => $c['code'],
                'name' => $c['name'],
                'department_id' => $deptModels[$c['dept']]->id,
                'programme_id' => $progModels[$c['prog']]->id,
                'credit_units' => $c['credits'],
                'semester' => $c['semester'],
                'level' => $c['level'],
                'lecturer_id' => $lecturerUsers[array_rand($lecturerUsers)]->id,
            ]);
        }

        // Students
        $studentNames = [
            ['name' => 'Ama Serwaa', 'email' => 'ama.s@student.sistech.edu', 'gender' => 'female'],
            ['name' => 'Kwame Nkrumah', 'email' => 'kwame.n@student.sistech.edu', 'gender' => 'male'],
            ['name' => 'Abena Mansa', 'email' => 'abena.m@student.sistech.edu', 'gender' => 'female'],
            ['name' => 'Yaw Boateng', 'email' => 'yaw.b@student.sistech.edu', 'gender' => 'male'],
            ['name' => 'Efua Addai', 'email' => 'efua.a@student.sistech.edu', 'gender' => 'female'],
            ['name' => 'Kofi Asare', 'email' => 'kofi.a@student.sistech.edu', 'gender' => 'male'],
            ['name' => 'Adwoa Pokua', 'email' => 'adwoa.p@student.sistech.edu', 'gender' => 'female'],
            ['name' => 'Kwaku Opoku', 'email' => 'kwaku.o@student.sistech.edu', 'gender' => 'male'],
            ['name' => 'Nana Agyeman', 'email' => 'nana.a@student.sistech.edu', 'gender' => 'male'],
            ['name' => 'Esi Oforiwaa', 'email' => 'esi.o@student.sistech.edu', 'gender' => 'female'],
            ['name' => 'Kojo Mensah', 'email' => 'kojo.m@student.sistech.edu', 'gender' => 'male'],
            ['name' => 'Ama Gyamfua', 'email' => 'ama.g@student.sistech.edu', 'gender' => 'female'],
            ['name' => 'Yaw Antwi', 'email' => 'yaw.a@student.sistech.edu', 'gender' => 'male'],
            ['name' => 'Abena Osei', 'email' => 'abena.o@student.sistech.edu', 'gender' => 'female'],
            ['name' => 'Kwame Asante', 'email' => 'kwame.a@student.sistech.edu', 'gender' => 'male'],
        ];

        $progIndexes = [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 0, 1, 2, 3, 4];

        foreach ($studentNames as $i => $s) {
            $user = User::create([
                'name' => $s['name'],
                'email' => $s['email'],
                'password' => Hash::make('password'),
                'role' => 'student',
                'status' => 'active',
            ]);

            $progIndex = $progIndexes[$i];
            $prog = $progModels[$progIndex];

            Student::create([
                'user_id' => $user->id,
                'student_id' => 'STU-2026-' . str_pad($i + 1, 4, '0', STR_PAD_LEFT),
                'index_number' => 'IDX-2026-' . str_pad($i + 1, 4, '0', STR_PAD_LEFT),
                'programme_id' => $prog->id,
                'department_id' => $prog->department_id,
                'academic_year_id' => $year2026->id,
                'status' => 'active',
                'level' => 100,
                'semester' => 1,
                'admission_date' => '2026-09-15',
                'date_of_birth' => rand(800000000, 999999999) > 500000000 ? '2002-05-15' : '2003-08-20',
                'gender' => $s['gender'],
                'address' => 'Freetown, Sierra Leone',
                'guardian_name' => 'Mr. ' . $s['name'] . ' Guardian',
                'guardian_phone' => '+23276' . str_pad(rand(100000, 999999), 6, '0', STR_PAD_LEFT),
            ]);
        }

        // Course Registrations - register each student to courses in their programme
        $allStudents = Student::all();
        foreach ($allStudents as $student) {
            $sem = $sem1;
            $progCourses = Course::where('programme_id', $student->programme_id)->get();
            foreach ($progCourses as $course) {
                CourseRegistration::create([
                    'student_id' => $student->id,
                    'course_id' => $course->id,
                    'academic_year_id' => $year2026->id,
                    'semester_id' => $sem->id,
                    'status' => 'registered',
                ]);
            }
        }

        // Books for Library
        $books = [
            ['title' => 'Introduction to Algorithms', 'author' => 'Thomas H. Cormen', 'isbn' => '978-0262033848', 'category' => 'Computer Science', 'quantity' => 5, 'shelf_location' => 'A1'],
            ['title' => 'Clean Code', 'author' => 'Robert C. Martin', 'isbn' => '978-0132350884', 'category' => 'Software Engineering', 'quantity' => 3, 'shelf_location' => 'A2'],
            ['title' => 'Database System Concepts', 'author' => 'Abraham Silberschatz', 'isbn' => '978-0078022159', 'category' => 'Databases', 'quantity' => 4, 'shelf_location' => 'B1'],
            ['title' => 'Design Patterns', 'author' => 'Gang of Four', 'isbn' => '978-0201633610', 'category' => 'Software Engineering', 'quantity' => 3, 'shelf_location' => 'A2'],
            ['title' => 'Computer Networking', 'author' => 'James Kurose', 'isbn' => '978-0133594140', 'category' => 'Networking', 'quantity' => 4, 'shelf_location' => 'C1'],
            ['title' => 'Marketing Management', 'author' => 'Philip Kotler', 'isbn' => '978-0133856460', 'category' => 'Business', 'quantity' => 6, 'shelf_location' => 'D1'],
            ['title' => 'Python Programming', 'author' => 'John Zelle', 'isbn' => '978-1590282571', 'category' => 'Programming', 'quantity' => 5, 'shelf_location' => 'A3'],
            ['title' => 'The Art of Computer Programming', 'author' => 'Donald Knuth', 'isbn' => '978-0201896831', 'category' => 'Computer Science', 'quantity' => 2, 'shelf_location' => 'A1'],
        ];

        foreach ($books as $book) {
            Book::create(array_merge($book, ['available' => $book['quantity'], 'price' => rand(20, 200)]));
        }

        // Announcements
        $announcements = [
            ['title' => 'Welcome to 2026/2027 Academic Year', 'content' => 'We welcome all new and returning students to SISTECH for the 2026/2027 academic year. Registration is now open.', 'type' => 'academic', 'target' => 'all'],
            ['title' => 'Fee Payment Deadline', 'content' => 'All students are reminded that tuition fees for the first semester must be paid by October 31, 2026. Late payments will incur penalties.', 'type' => 'finance', 'target' => 'students'],
            ['title' => 'Mid-Semester Examinations', 'content' => 'Mid-semester examinations will commence from November 18-29, 2026. Please check your timetables for specific dates and venues.', 'type' => 'exam', 'target' => 'students'],
            ['title' => 'Career Fair 2026', 'content' => 'SISTECH will host its annual career fair on December 5, 2026. Students are encouraged to attend and bring their CVs.', 'type' => 'event', 'target' => 'all'],
            ['title' => 'Staff Meeting Notice', 'content' => 'All staff members are required to attend a general meeting on Friday, October 11, 2026 at the main auditorium.', 'type' => 'general', 'target' => 'staff'],
        ];

        foreach ($announcements as $ann) {
            Announcement::create(array_merge($ann, [
                'created_by' => $admin->id,
                'academic_year_id' => $year2026->id,
                'publish_date' => now(),
            ]));
        }

        // Settings
        $settings = [
            ['key' => 'institution_name', 'value' => 'Slyito Institute of Science and Technology', 'group' => 'institution'],
            ['key' => 'institution_short_name', 'value' => 'SISTECH', 'group' => 'institution'],
            ['key' => 'institution_motto', 'value' => 'Connecting People to Technology', 'group' => 'institution'],
            ['key' => 'institution_address', 'value' => 'P.O. Box 1234, Freetown, Sierra Leone', 'group' => 'institution'],
            ['key' => 'institution_phone', 'value' => '+232 76 123 456', 'group' => 'institution'],
            ['key' => 'institution_email', 'value' => 'sistech2025@gmail.com', 'group' => 'institution'],
            ['key' => 'institution_website', 'value' => 'https://sistech.website', 'group' => 'institution'],
            ['key' => 'primary_color', 'value' => '#0066CC', 'group' => 'appearance'],
            ['key' => 'secondary_color', 'value' => '#00B050', 'group' => 'appearance'],
        ];

        foreach ($settings as $s) {
            Setting::create($s);
        }

        // Sample Invoices
        $students = Student::all();
        foreach ($students->take(10) as $student) {
            Invoice::create([
                'invoice_number' => Invoice::generateNumber(),
                'student_id' => $student->id,
                'academic_year_id' => $year2026->id,
                'description' => 'Tuition Fee - 2026/2027 Academic Year',
                'amount' => 5500000,
                'paid_amount' => rand(0, 5500000),
                'balance' => 0,
                'due_date' => '2026-10-31',
                'status' => 'unpaid',
            ]);
        }

        echo "Database seeded successfully!\n";
        echo "Admin Login: admin@sistech.edu / password\n";
        echo "Principal: principal@sistech.edu / password\n";
        echo "Student: ama.s@student.sistech.edu / password\n";
    }
}
