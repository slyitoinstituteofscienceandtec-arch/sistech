@extends('layouts.app')
@section('title', 'Library Borrowings')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1">Library Borrowings</h4>
        <p class="text-muted mb-0" style="font-size:13px;">All book borrowing records</p>
    </div>
</div>

<div class="card-sistech mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('admin.library.borrowings') }}" class="row g-3 align-items-end">
            <div class="col-md-3">
                <label class="form-label fw-semibold">Status</label>
                <select name="status" class="form-select">
                    <option value="">All Statuses</option>
                    <option value="borrowed" {{ request('status') === 'borrowed' ? 'selected' : '' }}>Borrowed</option>
                    <option value="returned" {{ request('status') === 'returned' ? 'selected' : '' }}>Returned</option>
                    <option value="overdue" {{ request('status') === 'overdue' ? 'selected' : '' }}>Overdue</option>
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label fw-semibold">Search</label>
                <input type="text" name="search" class="form-control" placeholder="Student or book name..." value="{{ request('search') }}">
            </div>
            <div class="col-md-3">
                <label class="form-label fw-semibold">Date Range</label>
                <input type="date" name="date_from" class="form-control" value="{{ request('date_from') }}">
            </div>
            <div class="col-md-2 d-flex gap-2">
                <button type="submit" class="btn btn-sistech flex-grow-1">
                    <i class="fas fa-filter me-1"></i> Filter
                </button>
                <a href="{{ route('admin.library.borrowings') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-redo"></i>
                </a>
            </div>
        </form>
    </div>
</div>

<div class="card-sistech">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span><i class="fas fa-exchange-alt me-2" style="color: var(--primary);"></i>All Borrowings</span>
        <span class="badge" style="background: var(--primary-light); color: var(--primary);">{{ $borrowings->total() ?? 0 }} Records</span>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-sistech mb-0">
                <thead>
                    <tr>
                        <th>Student</th>
                        <th>Book</th>
                        <th>Borrowed Date</th>
                        <th>Due Date</th>
                        <th>Returned Date</th>
                        <th>Status</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($borrowings ?? [] as $borrowing)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 32px; height: 32px; background: var(--primary); color: white; font-size: 11px; font-weight: 600;">
                                    {{ strtoupper(substr($borrowing->student->user->name ?? 'N', 0, 2)) }}
                                </div>
                                <div>
                                    <div class="fw-semibold" style="font-size: 13px;">{{ $borrowing->student->user->name ?? 'N/A' }}</div>
                                    <small class="text-muted">{{ $borrowing->student->student_id ?? '' }}</small>
                                </div>
                            </div>
                        </td>
                        <td>
                            <strong style="font-size: 13px;">{{ $borrowing->book->title ?? 'N/A' }}</strong>
                        </td>
                        <td>{{ \Carbon\Carbon::parse($borrowing->borrowed_at)->format('M d, Y') }}</td>
                        <td>
                            <span class="{{ \Carbon\Carbon::parse($borrowing->due_date)->isPast() && $borrowing->status !== 'returned' ? 'text-danger fw-bold' : '' }}">
                                {{ \Carbon\Carbon::parse($borrowing->due_date)->format('M d, Y') }}
                            </span>
                        </td>
                        <td>
                            @if($borrowing->returned_at)
                                {{ \Carbon\Carbon::parse($borrowing->returned_at)->format('M d, Y') }}
                            @else
                                <span class="text-muted">—</span>
                            @endif
                        </td>
                        <td>
                            @if($borrowing->status === 'returned')
                                <span class="badge-status badge-active">Returned</span>
                            @elseif($borrowing->status === 'overdue')
                                <span class="badge-status badge-inactive">Overdue</span>
                            @else
                                <span class="badge-status badge-pending">Borrowed</span>
                            @endif
                        </td>
                        <td class="text-end">
                            @if($borrowing->status !== 'returned')
                            <form method="POST" action="{{ route('admin.library.return', $borrowing->id) }}" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-outline-success" title="Mark as Returned" onclick="return confirm('Mark this book as returned?')">
                                    <i class="fas fa-undo me-1"></i> Return
                                </button>
                            </form>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-5 text-muted">
                            <i class="fas fa-exchange-alt" style="font-size: 3rem; opacity: 0.3;"></i>
                            <p class="mt-2 mb-0">No borrowing records found.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if(method_exists($borrowings ?? collect(), 'links'))
    <div class="card-footer d-flex justify-content-center" style="background: var(--bg); border-top: 1px solid var(--border);">
        {{ $borrowings->links() }}
    </div>
    @endif
</div>
@endsection
