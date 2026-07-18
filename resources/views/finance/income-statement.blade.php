@extends('layouts.app')
@section('title', 'Income Statement')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1">Income Statement</h4>
        <p class="text-muted mb-0" style="font-size:13px;">Revenue vs expenses by academic year</p>
    </div>
    <div class="d-flex gap-2">
        @if($academicYear)
        <button onclick="window.print()" class="btn btn-sistech">
            <i class="fas fa-print me-1"></i> Print
        </button>
        @endif
        <a href="{{ route('admin.finance.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-1"></i> Back
        </a>
    </div>
</div>

<div class="card-sistech mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('admin.finance.income-statement') }}" class="row g-3 align-items-end">
            <div class="col-md-4">
                <label class="form-label fw-semibold">Academic Year</label>
                <select name="academic_year_id" class="form-select" required>
                    <option value="">Select academic year...</option>
                    @foreach($academicYears as $year)
                        <option value="{{ $year->id }}" {{ request('academic_year_id') == $year->id ? 'selected' : '' }}>
                            {{ $year->name }} {{ $year->is_current ? '(Current)' : '' }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-sistech w-100">
                    <i class="fas fa-chart-bar me-1"></i> Generate
                </button>
            </div>
        </form>
    </div>
</div>

@if($academicYear)
<div id="printableArea">
    <div class="text-center mb-4">
        <h5 class="fw-bold">SISTECH COLLEGE</h5>
        <p class="text-muted mb-1" style="font-size: 13px;">"Connecting People to Technology"</p>
        <h4 class="fw-bold mt-2" style="color: var(--primary);">Income Statement</h4>
        <p class="text-muted" style="font-size: 13px;">For the Academic Year: {{ $academicYear->name }}</p>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="stat-card" style="border-left: 4px solid var(--green);">
                <div class="stat-value" style="color: var(--green);">SLE {{ number_format($totalRevenue, 2) }}</div>
                <div class="stat-label">Total Revenue</div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card" style="border-left: 4px solid #DC2626;">
                <div class="stat-value" style="color: #DC2626;">SLE {{ number_format($totalExpenses, 2) }}</div>
                <div class="stat-label">Total Expenses</div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card" style="border-left: 4px solid {{ $netIncome >= 0 ? 'var(--primary)' : '#DC2626' }};">
                <div class="stat-value" style="color: {{ $netIncome >= 0 ? 'var(--primary)' : '#DC2626' }};">SLE {{ number_format($netIncome, 2) }}</div>
                <div class="stat-label">Net {{ $netIncome >= 0 ? 'Income' : 'Loss' }}</div>
            </div>
        </div>
    </div>

    <div class="row g-3">
        <div class="col-md-6">
            <div class="card-sistech h-100">
                <div class="card-header">
                    <i class="fas fa-arrow-up me-2" style="color: var(--green);"></i>Revenue by Fee Type
                </div>
                <div class="card-body p-0">
                    <table class="table table-sistech mb-0">
                        <thead>
                            <tr>
                                <th>Description</th>
                                <th class="text-end">Invoiced</th>
                                <th class="text-end">Collected</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($revenueByType as $rev)
                            <tr>
                                <td><span class="badge bg-light text-dark border">{{ $rev->description ?? 'N/A' }}</span></td>
                                <td class="text-end">SLE {{ number_format($rev->total, 2) }}</td>
                                <td class="text-end fw-bold" style="color: var(--green);">SLE {{ number_format($rev->paid ?? 0, 2) }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="text-center py-3 text-muted">No revenue data for this year.</td>
                            </tr>
                            @endforelse
                        </tbody>
                        <tfoot>
                            <tr style="background: var(--bg);">
                                <td class="fw-bold">Total</td>
                                <td class="text-end fw-bold">SLE {{ number_format($revenueByType->sum('total'), 2) }}</td>
                                <td class="text-end fw-bold" style="color: var(--green);">SLE {{ number_format($totalRevenue, 2) }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card-sistech h-100">
                <div class="card-header">
                    <i class="fas fa-arrow-down me-2" style="color: #DC2626;"></i>Expenses by Category
                </div>
                <div class="card-body p-0">
                    <table class="table table-sistech mb-0">
                        <thead>
                            <tr>
                                <th>Category</th>
                                <th class="text-end">Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($expensesByCategory as $exp)
                            <tr>
                                <td><span class="badge bg-light text-dark border">{{ ucfirst($exp->category) }}</span></td>
                                <td class="text-end fw-bold" style="color: #DC2626;">SLE {{ number_format($exp->total, 2) }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="2" class="text-center py-3 text-muted">No expenses recorded for this year.</td>
                            </tr>
                            @endforelse
                        </tbody>
                        <tfoot>
                            <tr style="background: var(--bg);">
                                <td class="fw-bold">Total</td>
                                <td class="text-end fw-bold" style="color: #DC2626;">SLE {{ number_format($totalExpenses, 2) }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="card-sistech mt-3">
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <div class="d-flex justify-content-between">
                        <span class="text-muted">Total Revenue</span>
                        <strong style="color: var(--green);">SLE {{ number_format($totalRevenue, 2) }}</strong>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="d-flex justify-content-between">
                        <span class="text-muted">Total Expenses</span>
                        <strong style="color: #DC2626;">SLE {{ number_format($totalExpenses, 2) }}</strong>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="d-flex justify-content-between">
                        <span class="text-muted fw-bold">Net {{ $netIncome >= 0 ? 'Income' : 'Loss' }}</span>
                        <strong style="font-size: 18px; color: {{ $netIncome >= 0 ? 'var(--green)' : '#DC2626' }};">
                            SLE {{ number_format($netIncome, 2) }}
                        </strong>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="text-center mt-4" style="font-size: 12px; color: #999;">
        <p class="mb-0">Generated on {{ now()->format('F d, Y \a\t h:i A') }} | SISTECH College Management System</p>
    </div>
</div>
@else
<div class="card-sistech">
    <div class="card-body text-center py-5 text-muted">
        <i class="fas fa-chart-pie" style="font-size: 3rem; opacity: 0.3;"></i>
        <p class="mt-2 mb-0">Select an academic year to generate the income statement.</p>
    </div>
</div>
@endif
@endsection

<style>
@media print {
    .no-print, .btn, .card-sistech .card-header, nav, .sidebar, .topbar { display: none !important; }
    .card-sistech { border: 1px solid #ddd !important; box-shadow: none !important; }
    body { background: white !important; }
}
</style>
