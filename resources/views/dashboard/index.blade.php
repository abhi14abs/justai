@extends('layouts.app')

@section('title', 'Member Dashboard — Postryx AI')
@section('meta_description', 'Manage your Postryx AI subscription, team seats, API keys, client brand workspaces, and generation history.')

@section('content')

<section style="padding: 50px 24px 80px; max-width: 1200px; margin: 0 auto;">
    
    {{-- Flash Notifications --}}
    @if(session('success'))
    <div style="background: rgba(16, 185, 129, 0.15); border: 1px solid rgba(16, 185, 129, 0.4); border-radius: 12px; padding: 14px 20px; margin-bottom: 24px; color: #6ee7b7; font-size: 14px; font-weight: 600;">
        {{ session('success') }}
    </div>
    @endif

    @if(session('error'))
    <div style="background: rgba(244, 63, 94, 0.15); border: 1px solid rgba(244, 63, 94, 0.4); border-radius: 12px; padding: 14px 20px; margin-bottom: 24px; color: #fca5a5; font-size: 14px; font-weight: 600;">
        {{ session('error') }}
    </div>
    @endif

    {{-- Header Banner --}}
    <div style="display: flex; flex-wrap: wrap; justify-content: space-between; align-items: center; gap: 20px; margin-bottom: 36px; padding-bottom: 24px; border-bottom: 1px solid var(--border-subtle);">
        <div>
            <h1 style="font-size: 32px; font-weight: 800; color: #fff; margin-bottom: 4px;">
                Welcome, {{ $user->name }} 👋
            </h1>
            <p style="color: var(--text-secondary); font-size: 14px;">Member since {{ $user->created_at->format('M Y') }} • Account ID: #{{ $user->id }}</p>
        </div>

        <div style="display: flex; align-items: center; gap: 12px;">
            <div class="glass-panel" style="padding: 10px 18px; display: flex; align-items: center; gap: 10px;">
                <div style="font-size: 12px; color: var(--text-muted);">Current Plan:</div>
                <span class="badge-pill-cyan" style="font-size: 13px; font-weight: 700;">
                    {{ strtoupper($user->plan) }}
                </span>
            </div>

            @if(!$user->hasActivePaidPlan())
            <a href="{{ route('pricing') }}" class="btn-primary" style="padding: 10px 20px; font-size: 14px;">
                Upgrade to Pro / Agency (50% Off) 🚀
            </a>
            @else
            <div class="badge-pill-emerald">
                ✓ Active Paid Subscription
            </div>
            @endif

            <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                @csrf
                <button type="submit" class="btn-secondary" style="padding: 10px 16px; font-size: 13px;">Logout</button>
            </form>
        </div>
    </div>

    {{-- Stats Cards Row --}}
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 20px; margin-bottom: 36px;">
        <div class="glass-panel" style="padding: 24px;">
            <div style="font-size: 12px; color: var(--text-muted); text-transform: uppercase; margin-bottom: 6px;">Credits Status</div>
            <div style="font-size: 28px; font-weight: 800; color: #38bdf8;">
                {{ $user->hasActivePaidPlan() ? 'Unlimited ⚡' : $user->credits_remaining . ' Credits' }}
            </div>
            <div style="font-size: 12px; color: var(--text-secondary); margin-top: 4px;">
                {{ $user->hasActivePaidPlan() ? 'Priority AI models enabled' : '5 daily free credits' }}
            </div>
        </div>

        <div class="glass-panel" style="padding: 24px;">
            <div style="font-size: 12px; color: var(--text-muted); text-transform: uppercase; margin-bottom: 6px;">Total Generations</div>
            <div style="font-size: 28px; font-weight: 800; color: #a855f7;">
                {{ $generations->count() }}
            </div>
            <div style="font-size: 12px; color: var(--text-secondary); margin-top: 4px;">Across all 12 AI tools</div>
        </div>

        <div class="glass-panel" style="padding: 24px;">
            <div style="font-size: 12px; color: var(--text-muted); text-transform: uppercase; margin-bottom: 6px;">Affiliate Earnings</div>
            <div style="font-size: 28px; font-weight: 800; color: #10b981;">
                ₹{{ number_format($user->affiliate->total_earnings ?? 0, 2) }}
            </div>
            <div style="font-size: 12px; color: var(--text-secondary); margin-top: 4px;">
                <a href="{{ route('affiliate.dashboard') }}" style="color: #38bdf8; text-decoration: none;">View Partner Portal &rarr;</a>
            </div>
        </div>

        <div class="glass-panel" style="padding: 24px;">
            <div style="font-size: 12px; color: var(--text-muted); text-transform: uppercase; margin-bottom: 6px;">Team &amp; API Status</div>
            <div style="font-size: 28px; font-weight: 800; color: #f59e0b;">
                {{ $user->isAgency() ? count($teamMembers) . ' / 5 Seats' : ($user->isPro() ? 'Pro Tier' : 'Free Tier') }}
            </div>
            <div style="font-size: 12px; color: var(--text-secondary); margin-top: 4px;">
                {{ $user->isAgency() ? '5 Member Seats Included' : 'Upgrade to Agency for Seats' }}
            </div>
        </div>
    </div>

    {{-- Agency & Scale Command Hub (Team Seats, API Keys, Brand Workspaces, Slack Support) --}}
    @if($user->isAgency() || $user->isPro() || $user->isAdmin())
    <div style="margin-bottom: 44px;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <div>
                <h3 style="font-size: 22px; color: #fff; margin-bottom: 4px;">
                    👑 {{ $user->isAgency() ? 'Agency & Scale Enterprise Hub' : 'Pro Growth Developer Hub' }}
                </h3>
                <p style="color: var(--text-secondary); font-size: 14px;">Manage team collaboration seats, client brand voice separations, and REST API credentials.</p>
            </div>
            <span class="badge-pill-emerald">Enterprise Active</span>
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(340px, 1fr)); gap: 24px;">
            
            {{-- 1. Team Seats Manager (5 Seats for Agency) --}}
            <div class="glass-panel" style="padding: 28px;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px;">
                    <div>
                        <h4 style="font-size: 17px; color: #fff;">👥 Team Member Seats</h4>
                        <div style="font-size: 12px; color: var(--text-muted);">{{ count($teamMembers) }} of 5 seats assigned</div>
                    </div>
                    <span class="badge-pill-cyan">{{ count($teamMembers) }}/5 Seats</span>
                </div>

                @if($user->isAgency())
                    {{-- Invite Member Form --}}
                    @if(count($teamMembers) < 5)
                    <form action="{{ route('dashboard.team.add') }}" method="POST" style="margin-bottom: 20px; display: flex; flex-direction: column; gap: 10px;">
                        @csrf
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 8px;">
                            <input type="text" name="name" class="postryx-input" placeholder="Member Name" required style="padding: 8px 12px; font-size: 13px;">
                            <select name="role" class="postryx-input" style="padding: 8px 12px; font-size: 13px;">
                                <option value="creator">Creator / Writer</option>
                                <option value="editor">Editor / Reviewer</option>
                                <option value="manager">Account Manager</option>
                            </select>
                        </div>
                        <div style="display: flex; gap: 8px;">
                            <input type="email" name="email" class="postryx-input" placeholder="member@agency.com" required style="padding: 8px 12px; font-size: 13px; flex: 1;">
                            <button type="submit" class="btn-primary" style="padding: 8px 16px; font-size: 13px; white-space: nowrap;">+ Add Seat</button>
                        </div>
                    </form>
                    @endif

                    {{-- Members List --}}
                    @if(count($teamMembers) > 0)
                    <div style="display: flex; flex-direction: column; gap: 8px;">
                        @foreach($teamMembers as $m)
                        <div style="background: rgba(11, 17, 33, 0.8); border: 1px solid var(--border-subtle); border-radius: 10px; padding: 10px 14px; display: flex; justify-content: space-between; align-items: center;">
                            <div>
                                <div style="font-weight: 600; color: #fff; font-size: 13px;">{{ $m['name'] }} <span style="font-size: 11px; color: #38bdf8; margin-left: 4px;">({{ ucfirst($m['role']) }})</span></div>
                                <div style="font-size: 11px; color: var(--text-muted);">{{ $m['email'] }} • Added {{ $m['added_at'] ?? 'Recently' }}</div>
                            </div>
                            <form action="{{ route('dashboard.team.delete', $m['id']) }}" method="POST" onsubmit="return confirm('Revoke this team seat?');">
                                @csrf
                                <button type="submit" style="background: none; border: none; color: #f43f5e; cursor: pointer; font-size: 12px;">Revoke ✕</button>
                            </form>
                        </div>
                        @endforeach
                    </div>
                    @else
                    <div style="text-align: center; padding: 20px; color: var(--text-muted); font-size: 13px;">
                        No team members invited yet. Invite up to 5 writers/editors to collaborate.
                    </div>
                    @endif
                @else
                    <div style="text-align: center; padding: 24px 16px;">
                        <p style="font-size: 13px; color: var(--text-secondary); margin-bottom: 14px;">5 Team Member Seats are included with the <strong>Agency &amp; Scale</strong> plan.</p>
                        <a href="{{ route('checkout', ['plan' => 'agency']) }}" class="btn-primary" style="padding: 8px 16px; font-size: 13px;">Upgrade to Agency &rarr;</a>
                    </div>
                @endif
            </div>

            {{-- 2. Client Brand Workspaces Separation --}}
            <div class="glass-panel" style="padding: 28px;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px;">
                    <div>
                        <h4 style="font-size: 17px; color: #fff;">🏢 Client Brand Workspaces</h4>
                        <div style="font-size: 12px; color: var(--text-muted);">Custom brand voice &amp; tone presets</div>
                    </div>
                    <span class="badge-pill-purple">{{ count($brandWorkspaces) }} Brands</span>
                </div>

                {{-- Add Workspace Form --}}
                <form action="{{ route('dashboard.workspace.add') }}" method="POST" style="margin-bottom: 18px; display: flex; flex-direction: column; gap: 8px;">
                    @csrf
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 8px;">
                        <input type="text" name="brand_name" class="postryx-input" placeholder="Client Name (e.g. Acme Tech)" required style="padding: 8px 12px; font-size: 13px;">
                        <input type="text" name="industry" class="postryx-input" placeholder="Niche (e.g. B2B SaaS)" required style="padding: 8px 12px; font-size: 13px;">
                    </div>
                    <input type="text" name="tone_guidelines" class="postryx-input" placeholder="Voice rules (e.g. Bold, contrarian, no corporate jargon, use statistics)" required style="padding: 8px 12px; font-size: 13px;">
                    <button type="submit" class="btn-secondary" style="padding: 8px 14px; font-size: 13px; align-self: flex-end;">+ Save Brand Profile</button>
                </form>

                {{-- Workspaces List --}}
                @if(count($brandWorkspaces) > 0)
                <div style="display: flex; flex-direction: column; gap: 8px;">
                    @foreach($brandWorkspaces as $ws)
                    <div style="background: rgba(11, 17, 33, 0.8); border: 1px solid var(--border-subtle); border-radius: 10px; padding: 10px 14px; display: flex; justify-content: space-between; align-items: flex-start;">
                        <div>
                            <div style="font-weight: 600; color: #fff; font-size: 13px;">{{ $ws['brand_name'] }} <span style="font-size: 11px; color: #a855f7;">({{ $ws['industry'] }})</span></div>
                            <div style="font-size: 11px; color: var(--text-secondary); margin-top: 2px;">{{ $ws['tone_guidelines'] }}</div>
                        </div>
                        <form action="{{ route('dashboard.workspace.delete', $ws['id']) }}" method="POST">
                            @csrf
                            <button type="submit" style="background: none; border: none; color: #f43f5e; cursor: pointer; font-size: 12px; margin-left: 8px;">✕</button>
                        </form>
                    </div>
                    @endforeach
                </div>
                @else
                <div style="text-align: center; padding: 14px; color: var(--text-muted); font-size: 12px;">
                    No client brand profiles saved. Add profiles to maintain client-specific tones.
                </div>
                @endif
            </div>

            {{-- 3. Developer REST API & Webhooks --}}
            <div class="glass-panel" style="padding: 28px;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px;">
                    <div>
                        <h4 style="font-size: 17px; color: #fff;">⚡ Developer REST API &amp; Webhooks</h4>
                        <div style="font-size: 12px; color: var(--text-muted);">Programmatic AI generation via Bearer tokens</div>
                    </div>
                    <span class="badge-pill-amber">API v2.0 Active</span>
                </div>

                <div style="margin-bottom: 16px;">
                    <label style="display: block; font-size: 12px; font-weight: 600; color: var(--text-secondary); margin-bottom: 6px;">Your Secret API Key:</label>
                    <div style="display: flex; gap: 8px;">
                        <input type="password" id="api-key-field" value="{{ $user->api_token ?? 'pst_' . str_repeat('x', 28) }}" readonly class="postryx-input" style="font-family: monospace; font-size: 12px; padding: 8px 12px; background: rgba(0,0,0,0.5);">
                        <button onclick="toggleApiKeyVisibility()" class="btn-secondary" style="padding: 8px 12px; font-size: 12px;">👁️</button>
                        <button onclick="Postryx.copy(document.getElementById('api-key-field').value, this)" class="btn-secondary" style="padding: 8px 12px; font-size: 12px; white-space: nowrap;">Copy Key</button>
                    </div>
                </div>

                {{-- Interactive cURL Example --}}
                <div style="background: #06090e; border: 1px solid var(--border-subtle); border-radius: 10px; padding: 12px; font-family: monospace; font-size: 11px; color: #94a3b8; line-height: 1.5; margin-bottom: 14px; overflow-x: auto;">
                    <span style="color: #38bdf8;">curl</span> -X POST https://postryx.in/api/generate \<br>
                    &nbsp;&nbsp;-H <span style="color: #a5b4fc;">"Authorization: Bearer {{ $user->api_token ?? 'pst_YOUR_KEY' }}"</span> \<br>
                    &nbsp;&nbsp;-H <span style="color: #a5b4fc;">"Content-Type: application/json"</span> \<br>
                    &nbsp;&nbsp;-d '<span style="color: #34d399;">{"tool":"linkedin","topic":"5 AI growth tactics in 2026"}</span>'
                </div>

                <form action="{{ route('dashboard.apiToken') }}" method="POST" onsubmit="return confirm('Rotate API key? Any existing integrations will need the new token.');">
                    @csrf
                    <button type="submit" class="btn-secondary" style="width: 100%; padding: 8px; font-size: 12px;">🔄 Regenerate / Rotate API Key</button>
                </form>
            </div>

            {{-- 4. 24/7 Dedicated Slack Concierge & Support --}}
            <div class="glass-panel" style="padding: 28px; display: flex; flex-direction: column; justify-content: space-between;">
                <div>
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px;">
                        <h4 style="font-size: 17px; color: #fff;">💬 24/7 Dedicated Slack Support</h4>
                        <span class="badge-pill-emerald">VIP Hotline</span>
                    </div>
                    <p style="color: var(--text-secondary); font-size: 13px; line-height: 1.6; margin-bottom: 16px;">
                        As an Agency subscriber, you get a dedicated Slack channel with our core AI engineering team for custom prompts, webhook debugging, and guaranteed &lt;1-hour SLA response.
                    </p>
                </div>

                <div style="background: rgba(16, 185, 129, 0.08); border: 1px solid rgba(16, 185, 129, 0.3); border-radius: 12px; padding: 14px; margin-bottom: 16px;">
                    <div style="font-size: 13px; font-weight: 700; color: #6ee7b7; margin-bottom: 4px;">VIP Slack Workspace:</div>
                    <div style="font-size: 12px; color: var(--text-primary); font-family: monospace;">slack.postryx.in/#vip-agency</div>
                    <div style="font-size: 11px; color: var(--text-muted); margin-top: 4px;">Priority Support Email: <strong>vip@postryx.in</strong></div>
                </div>

                <a href="mailto:vip@postryx.in?subject=Agency%20VIP%20Support%20Request%20-%20Account%20%23{{ $user->id }}" class="btn-primary" style="padding: 10px; font-size: 13px; font-weight: 700; width: 100%; text-align: center;">
                    Open Priority Ticket / Slack &rarr;
                </a>
            </div>

        </div>
    </div>
    @endif

    {{-- Quick AI Tools Launcher --}}
    <div style="margin-bottom: 40px;">
        <h3 style="font-size: 20px; color: #fff; margin-bottom: 16px;">Quick AI Studio Launcher</h3>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px;">
            <a href="{{ route('tool.show', 'linkedin-post-generator') }}" class="glass-panel" style="padding: 16px; text-decoration: none; display: flex; align-items: center; gap: 12px;">
                <span style="font-size: 24px;">💼</span>
                <div>
                    <div style="font-weight: 600; color: #fff; font-size: 14px;">LinkedIn Post</div>
                    <div style="font-size: 11px; color: var(--text-muted);">Hooks &amp; Carousels</div>
                </div>
            </a>
            <a href="{{ route('tool.show', 'viral-tweet-thread-generator') }}" class="glass-panel" style="padding: 16px; text-decoration: none; display: flex; align-items: center; gap: 12px;">
                <span style="font-size: 24px;">🧵</span>
                <div>
                    <div style="font-weight: 600; color: #fff; font-size: 14px;">Twitter / X Thread</div>
                    <div style="font-size: 11px; color: var(--text-muted);">5-Tweet Unroller</div>
                </div>
            </a>
            <a href="{{ route('tool.show', 'ai-seo-blog-writer') }}" class="glass-panel" style="padding: 16px; text-decoration: none; display: flex; align-items: center; gap: 12px;">
                <span style="font-size: 24px;">📄</span>
                <div>
                    <div style="font-weight: 600; color: #fff; font-size: 14px;">SEO Blog Writer</div>
                    <div style="font-size: 11px; color: var(--text-muted);">2,000+ Word Articles</div>
                </div>
            </a>
            <a href="{{ route('tool.show', 'ai-content-humanizer') }}" class="glass-panel" style="padding: 16px; text-decoration: none; display: flex; align-items: center; gap: 12px;">
                <span style="font-size: 24px;">✨</span>
                <div>
                    <div style="font-weight: 600; color: #fff; font-size: 14px;">AI Humanizer</div>
                    <div style="font-size: 11px; color: var(--text-muted);">Bypass Detection</div>
                </div>
            </a>
            <a href="{{ route('tool.show', 'content-repurposer') }}" class="glass-panel" style="padding: 16px; text-decoration: none; display: flex; align-items: center; gap: 12px;">
                <span style="font-size: 24px;">🔄</span>
                <div>
                    <div style="font-weight: 600; color: #fff; font-size: 14px;">Repurposer</div>
                    <div style="font-size: 11px; color: var(--text-muted);">1-to-5 Channels</div>
                </div>
            </a>
        </div>
    </div>

    {{-- Billing & Orders History Table --}}
    <div class="glass-panel" style="padding: 28px; margin-bottom: 40px;">
        <h3 style="font-size: 18px; color: #fff; margin-bottom: 16px;">Billing &amp; Subscription Receipts</h3>
        
        @if($orders->count() > 0)
        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 13px;">
                <thead>
                    <tr style="border-bottom: 1px solid var(--border-subtle); color: var(--text-muted);">
                        <th style="padding: 12px 16px;">Order #</th>
                        <th style="padding: 12px 16px;">Plan</th>
                        <th style="padding: 12px 16px;">Gateway</th>
                        <th style="padding: 12px 16px;">Amount</th>
                        <th style="padding: 12px 16px;">Date</th>
                        <th style="padding: 12px 16px;">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $o)
                    <tr style="border-bottom: 1px solid var(--border-subtle);">
                        <td style="padding: 14px 16px; font-family: monospace; color: #38bdf8;">{{ $o->order_number }}</td>
                        <td style="padding: 14px 16px; font-weight: 600; color: #fff;">{{ ucfirst($o->plan) }} ({{ ucfirst($o->billing_cycle) }})</td>
                        <td style="padding: 14px 16px; text-transform: uppercase;">{{ $o->payment_gateway }}</td>
                        <td style="padding: 14px 16px; font-weight: 700; color: #fff;">{{ $o->currency === 'INR' ? '₹' : '$' }}{{ number_format($o->amount, 2) }}</td>
                        <td style="padding: 14px 16px; color: var(--text-muted);">{{ $o->created_at->format('M d, Y') }}</td>
                        <td style="padding: 14px 16px;">
                            <span class="badge-pill-{{ $o->status === 'completed' ? 'emerald' : 'amber' }}" style="font-size: 11px;">
                                {{ strtoupper($o->status) }}
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div style="text-align: center; padding: 24px; color: var(--text-muted); font-size: 14px;">
            No past orders or invoices found.
        </div>
        @endif
    </div>

</section>

@endsection

@section('scripts')
<script>
    function toggleApiKeyVisibility() {
        const field = document.getElementById('api-key-field');
        if (field.type === 'password') {
            field.type = 'text';
        } else {
            field.type = 'password';
        }
    }
</script>
@endsection
