@extends('layouts.app')
@section('title', 'Finance')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1">Finance</h4>
        <p class="text-muted mb-0" style="font-size:13px;">Record payments and view history</p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.finance.income-statement') }}" class="btn btn-outline-primary btn-sm">
            <i class="fas fa-chart-bar me-1"></i> Income Statement
        </a>
        <a href="{{ route('admin.finance.fee-structure') }}" class="btn btn-outline-secondary btn-sm">
            <i class="fas fa-table me-1"></i> Fee Structure
        </a>
    </div>
</div>

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" style="border-radius: 10px; font-size: 13px;">
    <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

@if(session('error'))
<div class="alert alert-danger alert-dismissible fade show" style="border-radius: 10px; font-size: 13px;">
    <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

@if($errors->any())
<div class="alert alert-danger alert-dismissible fade show" style="border-radius: 10px; font-size: 13px;">
    @foreach($errors->all() as $error)
        <div><i class="fas fa-exclamation-triangle me-1"></i>{{ $error }}</div>
    @endforeach
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

<div class="card-sistech mb-4">
    <div class="card-header">
        <i class="fas fa-plus-circle me-2" style="color: var(--green);"></i>Record Deposit / Payment
        <small class="text-muted ms-2 fw-normal">Students can pay in full or bit by bit</small>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('admin.finance.record-payment') }}">
            @csrf
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Student</label>
                    <select name="student_id" id="payment_student" class="form-select" required>
                        <option value="">Select student...</option>
                        @foreach($students as $student)
                            <option value="{{ $student->id }}">{{ $student->student_id }} - {{ $student->user->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Invoice</label>
                    <select name="invoice_id" id="payment_invoice" class="form-select" required>
                        <option value="">Select student first...</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Method</label>
                    <select name="method" class="form-select" required>
                        <option value="cash">Cash</option>
                        <option value="bank_transfer">Bank Transfer</option>
                        <option value="mobile_money">Mobile Money</option>
                        <option value="card">Card</option>
                        <option value="cheque">Cheque</option>
                        <option value="online">Online</option>
                    </select>
                </div>
            </div>

            <div id="deposit_area" class="mt-3" style="display: none;">
                <div class="row g-3 align-items-end">
                    <div class="col-md-5">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <label class="form-label fw-semibold mb-0">Deposit Amount (SLE)</label>
                            <small class="text-muted" id="balance_hint"></small>
                        </div>
                        <input type="number" name="amount" id="payment_amount" class="form-control form-control-lg" step="0.01" min="0.01" placeholder="Enter amount to pay" required>
                        <div class="mt-1">
                            <small class="text-muted">You can pay any amount up to the balance. Pay bit by bit until fully paid.</small>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="progress" style="height: 38px; border-radius: 10px;">
                            <div id="paid_bar" class="progress-bar bg-success" role="progressbar" style="width: 0%"></div>
                            <div id="remain_bar" class="progress-bar bg-warning" role="progressbar" style="width: 100%"></div>
                        </div>
                        <div class="d-flex justify-content-between mt-1">
                            <small class="text-success fw-semibold">Paid: <span id="paid_text">SLE 0.00</span></small>
                            <small class="text-warning fw-semibold">Remaining: <span id="remain_text">SLE 0.00</span></small>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <button type="submit" class="btn btn-sistech btn-lg w-100">
                            <i class="fas fa-check me-1"></i> Record Payment
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="card-sistech">
    <div class="card-header">
        <i class="fas fa-history me-2" style="color: var(--primary);"></i>Payment History
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-sistech mb-0">
                <thead>
                    <tr>
                        <th>Reference</th>
                        <th>Student</th>
                        <th>Invoice</th>
                        <th class="text-end">Amount</th>
                        <th>Method</th>
                        <th>Date</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($payments as $payment)
                    <tr>
                        <td><strong style="color: var(--primary);">{{ $payment->payment_reference }}</strong></td>
                        <td>
                            <div class="fw-semibold" style="font-size: 13px;">{{ $payment->student->user->name ?? 'N/A' }}</div>
                            <small class="text-muted">{{ $payment->student->student_id ?? '' }}</small>
                        </td>
                        <td><span class="badge bg-light text-dark border">{{ $payment->invoice->invoice_number ?? 'N/A' }}</span></td>
                        <td class="text-end"><strong>SLE {{ number_format($payment->amount, 2) }}</strong></td>
                        <td><span class="badge bg-light text-dark border">{{ ucfirst(str_replace('_', ' ', $payment->method)) }}</span></td>
                        <td>{{ $payment->created_at->format('M d, Y') }}</td>
                        <td class="text-end">
                            <a href="{{ route('admin.finance.receipt', $payment->id) }}" target="_blank" class="btn btn-outline-primary btn-sm" title="Receipt">
                                <i class="fas fa-receipt"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-5 text-muted">
                            <i class="fas fa-receipt" style="font-size: 3rem; opacity: 0.3;"></i>
                            <p class="mt-2 mb-0">No payments recorded yet.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if(method_exists($payments, 'links'))
    <div class="card-footer d-flex justify-content-center" style="background: var(--bg); border-top: 1px solid var(--border);">
        {{ $payments->links() }}
    </div>
    @endif
</div>
@endsection

@section('scripts')
<script>
function updateBalanceUI() {
    var invoiceSelect = document.getElementById('payment_invoice');
    var option = invoiceSelect.options[invoiceSelect.selectedIndex];
    var balance = parseFloat(option.getAttribute('data-balance')) || 0;
    var totalAmount = parseFloat(option.getAttribute('data-amount')) || 0;
    var paidAmount = totalAmount - balance;
    var amountInput = document.getElementById('payment_amount');

    if (balance <= 0) return;

    amountInput.max = balance;
    amountInput.placeholder = 'Up to SLE ' + balance.toFixed(2);
    document.getElementById('balance_hint').textContent = 'Outstanding: SLE ' + balance.toFixed(2);

    var paidPct = totalAmount > 0 ? (paidAmount / totalAmount * 100) : 0;
    var remainPct = 100 - paidPct;
    document.getElementById('paid_bar').style.width = paidPct + '%';
    document.getElementById('remain_bar').style.width = remainPct + '%';
    document.getElementById('paid_text').textContent = 'SLE ' + paidAmount.toFixed(2) + ' / ' + totalAmount.toFixed(2);
    document.getElementById('remain_text').textContent = 'SLE ' + balance.toFixed(2);
}

document.getElementById('payment_student').addEventListener('change', function() {
    var studentId = this.value;
    var invoiceSelect = document.getElementById('payment_invoice');
    var depositArea = document.getElementById('deposit_area');
    invoiceSelect.innerHTML = '<option value="">Loading...</option>';
    invoiceSelect.disabled = true;
    depositArea.style.display = 'none';

    if (!studentId) {
        invoiceSelect.innerHTML = '<option value="">Select student first...</option>';
        invoiceSelect.disabled = false;
        return;
    }

    fetch('{{ url("admin/finance/student-invoices") }}/' + studentId)
        .then(function(r) { return r.json(); })
        .then(function(invoices) {
            if (invoices.length === 0) {
                invoiceSelect.innerHTML = '<option value="">No unpaid invoices</option>';
                invoiceSelect.disabled = false;
                depositArea.style.display = 'none';
                return;
            }
            var html = '<option value="">Select invoice...</option>';
            invoices.forEach(function(inv) {
                var st = inv.status.charAt(0).toUpperCase() + inv.status.slice(1);
                html += '<option value="' + inv.id + '" data-balance="' + inv.balance + '" data-amount="' + inv.amount + '">' + inv.invoice_number + ' — SLE ' + parseFloat(inv.balance).toFixed(2) + ' due [' + st + ']</option>';
            });
            invoiceSelect.innerHTML = html;
            invoiceSelect.disabled = false;
        })
        .catch(function() {
            invoiceSelect.innerHTML = '<option value="">Failed to load invoices</option>';
            invoiceSelect.disabled = false;
        });
});

document.getElementById('payment_invoice').addEventListener('change', function() {
    var depositArea = document.getElementById('deposit_area');
    if (!this.value) {
        depositArea.style.display = 'none';
        return;
    }
    depositArea.style.display = 'block';
    updateBalanceUI();
});
</script>
@endsection
