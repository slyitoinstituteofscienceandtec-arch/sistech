<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Payment;
use App\Models\Student;
use App\Models\AcademicYear;
use App\Models\Expense;
use App\Models\FeeStructure;
use App\Models\Setting;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class FinanceController extends Controller
{
    public function index()
    {
        if (Cache::get('last_overdue_check') !== now()->toDateString()) {
            $this->markOverdueInvoices();
            Cache::put('last_overdue_check', now()->toDateString());
        }

        $this->generateMissingInvoices();

        $totalRevenue = Payment::where('status', 'verified')->sum('amount');
        $outstanding = Invoice::whereIn('status', ['unpaid', 'partial', 'overdue'])->sum('balance');
        $totalInvoiced = Invoice::sum('amount');
        $totalExpenses = Expense::sum('amount');

        $invoices = Invoice::with(['student.user', 'academicYear'])->latest()->paginate(15);
        $payments = Payment::with(['student.user', 'invoice'])->latest()->paginate(15);
        $students = Student::with('user')->get();
        $academicYears = AcademicYear::all();

        return view('finance.index', compact('totalRevenue', 'outstanding', 'totalInvoiced', 'totalExpenses', 'invoices', 'payments', 'students', 'academicYears'));
    }

    public function getStudentInvoices(Student $student)
    {
        $invoices = Invoice::where('student_id', $student->id)
            ->whereIn('status', ['unpaid', 'partial', 'overdue'])
            ->get()
            ->map(function ($inv) {
                return [
                    'id' => $inv->id,
                    'invoice_number' => $inv->invoice_number,
                    'description' => $inv->description,
                    'amount' => $inv->amount,
                    'paid_amount' => $inv->paid_amount ?? 0,
                    'balance' => $inv->balance,
                    'status' => $inv->status,
                ];
            });

        return response()->json($invoices);
    }

    public function recordPayment(Request $request)
    {
        $validated = $request->validate([
            'invoice_id' => 'required|exists:invoices,id',
            'student_id' => 'required|exists:students,id',
            'amount' => 'required|numeric|min:0.01',
            'method' => 'required|in:cash,bank_transfer,mobile_money,card,cheque,online',
        ]);

        $invoice = Invoice::find($validated['invoice_id']);
        $balance = $invoice->balance;

        if ($validated['amount'] > $balance) {
            return back()->with('error', 'Amount exceeds the outstanding balance of SLE ' . number_format($balance, 2));
        }

        DB::transaction(function () use ($validated, $invoice, &$payment) {
            $payment = Payment::create([
                'payment_reference' => Payment::generateReference(),
                'invoice_id' => $validated['invoice_id'],
                'student_id' => $validated['student_id'],
                'amount' => $validated['amount'],
                'method' => $validated['method'],
                'status' => 'verified',
                'verified_by' => auth()->id(),
                'verified_at' => now(),
            ]);

            $invoice->paid_amount = ($invoice->paid_amount ?? 0) + $validated['amount'];
            $invoice->balance = $invoice->amount - $invoice->paid_amount;

            if ($invoice->balance <= 0) {
                $invoice->status = 'paid';
            } else {
                $invoice->status = 'partial';
            }
            $invoice->save();
        });

        return redirect()->route('admin.finance.receipt', $payment)->with('success', 'Payment recorded successfully!');
    }

    public function storeExpense(Request $request)
    {
        $validated = $request->validate([
            'description' => 'required|string|max:255',
            'category' => 'required|string',
            'amount' => 'required|numeric|min:0.01',
            'date' => 'required|date',
            'academic_year_id' => 'nullable|exists:academic_years,id',
        ]);

        Expense::create(array_merge($validated, [
            'recorded_by' => auth()->id(),
        ]));

        return back()->with('success', 'Expense recorded successfully.');
    }

    public function incomeStatement(Request $request)
    {
        $academicYear = null;
        $revenueByType = collect();
        $expensesByCategory = collect();
        $totalRevenue = 0;
        $totalExpenses = 0;

        if ($request->academic_year_id) {
            $academicYear = AcademicYear::find($request->academic_year_id);

            if ($academicYear) {
                $paymentIds = Payment::where('status', 'verified')
                    ->whereHas('invoice', function ($q) use ($academicYear) {
                        $q->where('academic_year_id', $academicYear->id);
                    })
                    ->pluck('id');

                $revenueByType = Invoice::where('academic_year_id', $academicYear->id)
                    ->selectRaw('description, sum(amount) as total, sum(paid_amount) as paid')
                    ->groupBy('description')
                    ->get();

                $totalRevenue = Payment::whereIn('id', $paymentIds)->sum('amount');

                $expensesByCategory = Expense::where('academic_year_id', $academicYear->id)
                    ->selectRaw('category, sum(amount) as total')
                    ->groupBy('category')
                    ->get();

                $totalExpenses = Expense::where('academic_year_id', $academicYear->id)->sum('amount');
            }
        }

        $netIncome = $totalRevenue - $totalExpenses;

        $data = compact('academicYear', 'revenueByType', 'expensesByCategory', 'totalRevenue', 'totalExpenses', 'netIncome');
        return view('finance.income-statement', $data + [
            'academicYears' => AcademicYear::all(),
        ]);
    }

    public function receipt(Payment $payment)
    {
        $payment->load(['student.user', 'invoice', 'verifiedBy']);
        $settings = Setting::all()->pluck('value', 'key')->toArray();
        $amountInWords = $this->numberToWords($payment->amount);
        return view('finance.receipt', compact('payment', 'settings', 'amountInWords'));
    }

    public function feeStructure(Request $request)
    {
        $query = FeeStructure::with(['programme', 'academicYear']);

        if ($request->academic_year_id) {
            $query->where('academic_year_id', $request->academic_year_id);
        }

        if ($request->programme_id) {
            $query->where('programme_id', $request->programme_id);
        }

        $feeStructures = $query->latest()->get();
        $programmes = \App\Models\Programme::where('is_active', true)->get();
        $academicYears = AcademicYear::all();
        return view('finance.fee-structure', compact('feeStructures', 'programmes', 'academicYears'));
    }

    public function storeFeeStructure(Request $request)
    {
        $validated = $request->validate([
            'programme_id' => 'required|exists:programmes,id',
            'academic_year_id' => 'required|exists:academic_years,id',
            'amount' => 'required|numeric|min:0',
            'description' => 'nullable|string|max:255',
        ]);

        $validated['description'] = $validated['description'] ?? 'Fee structure';

        FeeStructure::create($validated);
        return back()->with('success', 'Fee structure added successfully.');
    }

    public function updateFeeStructure(Request $request, FeeStructure $feeStructure)
    {
        $validated = $request->validate([
            'programme_id' => 'required|exists:programmes,id',
            'academic_year_id' => 'required|exists:academic_years,id',
            'amount' => 'required|numeric|min:0',
            'description' => 'nullable|string|max:255',
        ]);

        $feeStructure->update($validated);
        return back()->with('success', 'Fee structure updated successfully.');
    }

    public function destroyFeeStructure(FeeStructure $feeStructure)
    {
        $feeStructure->delete();
        return back()->with('success', 'Fee structure deleted successfully.');
    }

    public function destroyInvoice(Invoice $invoice)
    {
        $invoice->update(['status' => 'cancelled']);
        return back()->with('success', 'Invoice cancelled.');
    }

    private function generateMissingInvoices()
    {
        $currentYear = AcademicYear::where('is_current', true)->first();
        if (!$currentYear) return;

        $studentsWithoutInvoice = Student::where('status', 'active')
            ->whereDoesntHave('invoices', function ($q) use ($currentYear) {
                $q->where('academic_year_id', $currentYear->id);
            })
            ->get();

        foreach ($studentsWithoutInvoice as $student) {
            $feeStructure = FeeStructure::where('programme_id', $student->programme_id)
                ->where('academic_year_id', $currentYear->id)
                ->first();

            if (!$feeStructure) continue;

            Invoice::create([
                'invoice_number' => Invoice::generateNumber(),
                'student_id' => $student->id,
                'academic_year_id' => $currentYear->id,
                'description' => $feeStructure->description ?? 'Tuition fees for ' . $currentYear->name,
                'amount' => $feeStructure->amount,
                'paid_amount' => 0,
                'balance' => $feeStructure->amount,
                'due_date' => $currentYear->end_date,
                'status' => 'unpaid',
            ]);
        }
    }

    private function markOverdueInvoices()
    {
        Invoice::where('status', 'unpaid')
            ->where('due_date', '<', now())
            ->update(['status' => 'overdue']);

        Invoice::where('status', 'partial')
            ->where('due_date', '<', now())
            ->update(['status' => 'overdue']);
    }

    private function numberToWords($number)
    {
        $number = number_format($number, 2, '.', '');
        $ones = ['', 'One', 'Two', 'Three', 'Four', 'Five', 'Six', 'Seven', 'Eight', 'Nine', 'Ten', 'Eleven', 'Twelve', 'Thirteen', 'Fourteen', 'Fifteen', 'Sixteen', 'Seventeen', 'Eighteen', 'Nineteen'];
        $tens = ['', '', 'Twenty', 'Thirty', 'Forty', 'Fifty', 'Sixty', 'Seventy', 'Eighty', 'Ninety'];

        list($whole, $decimal) = explode('.', $number);
        $whole = (int) $whole;
        $result = '';

        if ($whole == 0) {
            $result = 'Zero';
        } else {
            if ($whole >= 1000000) { $result .= $ones[intval($whole / 1000000)] . ' Million '; $whole %= 1000000; }
            if ($whole >= 1000) { $result .= $ones[intval($whole / 1000)] . ' Thousand '; $whole %= 1000; }
            if ($whole >= 100) { $result .= $ones[intval($whole / 100)] . ' Hundred '; $whole %= 100; }
            if ($whole >= 20) { $result .= $tens[intval($whole / 10)] . ' '; $whole %= 10; }
            if ($whole > 0) { $result .= $ones[$whole]; }
        }

        $result = trim($result) . ' Leones';
        if ($decimal > 0) {
            $result .= ' and ' . $decimal . ' Cents';
        }
        return $result;
    }
}
