@extends('layouts.admin')

@section('title', 'User Management — Postryx Master Portal')

@section('content')

<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 28px;">
    <div>
        <h1 style="font-size: 28px; font-weight: 800; color: #fff; margin-bottom: 4px;">
            User Accounts &amp; Subscriptions
        </h1>
        <p style="color: var(--text-secondary); font-size: 14px;">Manage member accounts, upgrade subscription plans, assign credits, and configure roles.</p>
    </div>
    <span class="badge-pill-cyan">{{ $users->count() }} Registered Accounts</span>
</div>

<div class="glass-panel" style="padding: 28px;">
    <table class="postryx-datatable">
        <thead>
            <tr>
                <th>ID</th>
                <th>User Details</th>
                <th>Role</th>
                <th>Plan Tier</th>
                <th>Credits</th>
                <th>Generations</th>
                <th>Orders</th>
                <th>Joined Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $u)
            <tr>
                <td style="font-family: monospace; color: #38bdf8;">#{{ $u->id }}</td>
                <td>
                    <div style="font-weight: 700; color: #fff;">{{ $u->name }}</div>
                    <div style="font-size: 11px; color: var(--text-muted);">{{ $u->email }}</div>
                    @if(!empty($u->affiliate_code))
                    <div style="font-size: 10px; color: #a855f7; font-family: monospace;">Ref: {{ $u->affiliate_code }}</div>
                    @endif
                </td>
                <td>
                    <span class="badge-pill-{{ $u->role === 'admin' ? 'amber' : 'cyan' }}" style="font-size: 10px;">
                        {{ strtoupper($u->role) }}
                    </span>
                </td>
                <td>
                    <span class="badge-pill-{{ in_array($u->plan, ['agency', 'lifetime', 'pro']) ? 'emerald' : 'purple' }}" style="font-size: 11px;">
                        {{ strtoupper($u->plan) }}
                    </span>
                </td>
                <td style="font-weight: 700; color: #fff;">
                    {{ in_array($u->plan, ['pro', 'agency', 'lifetime']) ? 'Unlimited ⚡' : $u->credits_remaining }}
                </td>
                <td style="font-size: 13px; color: #e2e8f0;">{{ $u->generations_count }}</td>
                <td style="font-size: 13px; color: #e2e8f0;">{{ $u->orders_count }}</td>
                <td style="color: var(--text-muted); font-size: 12px;">{{ $u->created_at->format('M d, Y') }}</td>
                <td>
                    <div style="display: flex; gap: 8px; align-items: center;">
                        {{-- Edit Plan & Role Button / Inline Modal Trigger --}}
                        <button onclick="openEditUserModal({{ $u->id }}, '{{ $u->name }}', '{{ $u->email }}', '{{ $u->role }}', '{{ $u->plan }}', {{ $u->credits_remaining }})" class="btn-secondary" style="padding: 6px 12px; font-size: 11px;">
                            Edit ✏️
                        </button>
                        
                        @if($u->id !== Auth::id())
                        <form action="{{ route('admin.users.delete', $u->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to permanently delete user {{ $u->email }}?');">
                            @csrf
                            <button type="submit" style="background: none; border: none; color: #f43f5e; cursor: pointer; font-size: 12px; padding: 4px;">✕</button>
                        </form>
                        @endif
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

{{-- Edit User Modal --}}
<div id="edit-user-modal" style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.8); backdrop-filter: blur(10px); z-index: 1000; align-items: center; justify-content: center; padding: 20px;">
    <div class="glass-panel-glow" style="max-width: 480px; width: 100%; padding: 32px;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <h3 style="font-size: 18px; color: #fff;">Edit User Subscription &amp; Role</h3>
            <button onclick="closeEditUserModal()" style="background: none; border: none; color: #94a3b8; font-size: 20px; cursor: pointer;">✕</button>
        </div>

        <form id="edit-user-form" method="POST" style="display: flex; flex-direction: column; gap: 16px;">
            @csrf
            <div>
                <label style="display: block; font-size: 12px; color: var(--text-secondary); margin-bottom: 4px;">User:</label>
                <input type="text" id="modal-user-info" class="postryx-input" readonly style="background: rgba(0,0,0,0.4);">
            </div>

            <div>
                <label style="display: block; font-size: 12px; color: var(--text-secondary); margin-bottom: 4px;">Subscription Plan:</label>
                <select name="plan" id="modal-user-plan" class="postryx-input">
                    <option value="free">FREE (5 Daily Credits)</option>
                    <option value="starter">STARTER (500 Credits/mo)</option>
                    <option value="pro">PRO GROWTH (Unlimited AI)</option>
                    <option value="agency">AGENCY &amp; SCALE (5 Seats + API)</option>
                    <option value="lifetime">LIFETIME PASS (Zero Fees Forever)</option>
                </select>
            </div>

            <div>
                <label style="display: block; font-size: 12px; color: var(--text-secondary); margin-bottom: 4px;">Credits Remaining:</label>
                <input type="number" name="credits_remaining" id="modal-user-credits" class="postryx-input" min="0" required>
            </div>

            <div>
                <label style="display: block; font-size: 12px; color: var(--text-secondary); margin-bottom: 4px;">Account Role:</label>
                <select name="role" id="modal-user-role" class="postryx-input">
                    <option value="user">Standard User</option>
                    <option value="admin">Super Administrator 👑</option>
                </select>
            </div>

            <div style="display: flex; gap: 10px; margin-top: 10px;">
                <button type="button" onclick="closeEditUserModal()" class="btn-secondary" style="flex: 1; padding: 10px;">Cancel</button>
                <button type="submit" class="btn-primary" style="flex: 1; padding: 10px;">Save Changes ✓</button>
            </div>
        </form>
    </div>
</div>

@endsection

@section('scripts')
<script>
    function openEditUserModal(id, name, email, role, plan, credits) {
        const modal = document.getElementById('edit-user-modal');
        const form = document.getElementById('edit-user-form');
        form.action = `/admin/users/${id}/update`;
        document.getElementById('modal-user-info').value = `${name} (${email})`;
        document.getElementById('modal-user-plan').value = plan;
        document.getElementById('modal-user-credits').value = credits;
        document.getElementById('modal-user-role').value = role;
        modal.style.display = 'flex';
    }

    function closeEditUserModal() {
        document.getElementById('edit-user-modal').style.display = 'none';
    }
</script>
@endsection
