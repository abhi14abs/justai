@extends('layouts.admin')

@section('title', 'Payout Requests Queue — Postryx Master Portal')

@section('content')

<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 28px;">
    <div>
        <h1 style="font-size: 28px; font-weight: 800; color: #fff; margin-bottom: 4px;">
            Affiliate Payout Requests &amp; Disbursals
        </h1>
        <p style="color: var(--text-secondary); font-size: 14px;">Review partner withdrawal requests, disburse funds via UPI/PayPal/Bank, and record UTR transaction proofs.</p>
    </div>
    <span class="badge-pill-amber">{{ $payouts->where('status', 'pending')->count() }} Pending Approvals</span>
</div>

<div class="glass-panel" style="padding: 28px;">
    <table class="postryx-datatable">
        <thead>
            <tr>
                <th>Request #</th>
                <th>Partner Name</th>
                <th>Amount</th>
                <th>Method</th>
                <th>Account Details</th>
                <th>UTR / Ref ID</th>
                <th>Status</th>
                <th>Requested Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($payouts as $p)
            <tr>
                <td style="font-family: monospace; color: #38bdf8; font-weight: 700;">#PO-{{ $p->id }}</td>
                <td>
                    <div style="font-weight: 700; color: #fff;">{{ $p->affiliate->user->name ?? 'Partner #' . $p->affiliate_id }}</div>
                    <div style="font-size: 11px; color: var(--text-muted);">{{ $p->affiliate->user->email ?? '-' }}</div>
                </td>
                <td style="font-weight: 800; color: #10b981; font-size: 15px;">₹{{ number_format($p->amount, 2) }}</td>
                <td style="text-transform: uppercase;">
                    <span class="badge-pill" style="font-size: 10px;">{{ $p->payment_method }}</span>
                </td>
                <td style="font-family: monospace; color: #cbd5e1; font-size: 12px;">{{ $p->account_details }}</td>
                <td style="font-family: monospace; color: var(--text-muted); font-size: 12px;">{{ $p->transaction_ref ?? '-' }}</td>
                <td>
                    <span class="badge-pill-{{ $p->status === 'completed' ? 'emerald' : 'amber' }}" style="font-size: 11px;">
                        {{ strtoupper($p->status) }}
                    </span>
                </td>
                <td style="color: var(--text-muted); font-size: 12px;">{{ $p->created_at->format('M d, Y H:i') }}</td>
                <td>
                    @if($p->status === 'pending')
                    <form action="{{ route('admin.payouts.process', $p->id) }}" method="POST" style="display: flex; gap: 6px; align-items: center;">
                        @csrf
                        <input type="text" name="transaction_ref" placeholder="Enter UTR #" class="postryx-input" style="padding: 6px 10px; font-size: 12px; width: 130px;" required>
                        <button type="submit" class="btn-primary" style="padding: 6px 12px; font-size: 12px; white-space: nowrap;">
                            Mark Paid ✓
                        </button>
                    </form>
                    @else
                    <span style="color: #6ee7b7; font-size: 12px;">✓ Paid ({{ $p->processed_at?->format('M d') }})</span>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection
