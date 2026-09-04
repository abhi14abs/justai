@extends('layouts.admin')

@section('title', 'Digital Invitations Master Control — Admin Portal')

@section('content')
<div class="admin-content">

    {{-- Header --}}
    <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 16px; margin-bottom: 32px;">
        <div>
            <h1 style="font-size: 26px; font-weight: 800; color: #FFF; margin: 0 0 6px;">
                💌 Digital Invitations Management Center
            </h1>
            <p style="color: var(--text-secondary); font-size: 14px; margin: 0;">
                Control templates, categories, feature pricing, orders, and RSVP responses.
            </p>
        </div>

        <div style="display: flex; gap: 10px;">
            <a href="{{ route('invitations.browse.index') }}" target="_blank" class="btn-secondary" style="padding: 9px 16px; font-size: 13px; text-decoration: none; border-radius: 10px;">
                🌐 View Marketplace
            </a>
            <a href="{{ route('admin.invitations.templates') }}" class="btn-primary" style="padding: 9px 18px; font-size: 13px; font-weight: 700; text-decoration: none; border-radius: 10px;">
                <span>+ Manage Templates</span>
            </a>
        </div>
    </div>

    {{-- Metrics Grid --}}
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 18px; margin-bottom: 36px;">
        <div class="glass-panel" style="padding: 22px; border-radius: 18px;">
            <div style="font-size: 12px; color: #94A3B8; text-transform: uppercase; font-weight: 700;">Total Invitations</div>
            <div style="font-size: 30px; font-weight: 900; color: #FFF; margin-top: 4px;">{{ $metrics['total_invitations'] }}</div>
            <div style="font-size: 12px; color: #34D399; margin-top: 4px;">{{ $metrics['published_invitations'] }} Published Live</div>
        </div>

        <div class="glass-panel" style="padding: 22px; border-radius: 18px;">
            <div style="font-size: 12px; color: #94A3B8; text-transform: uppercase; font-weight: 700;">Total Revenue</div>
            <div style="font-size: 30px; font-weight: 900; color: var(--gold-primary); margin-top: 4px;">₹{{ number_format($metrics['total_revenue'], 2) }}</div>
            <div style="font-size: 12px; color: #CBD5E1; margin-top: 4px;">{{ $metrics['total_orders'] }} Paid Orders</div>
        </div>

        <div class="glass-panel" style="padding: 22px; border-radius: 18px;">
            <div style="font-size: 12px; color: #94A3B8; text-transform: uppercase; font-weight: 700;">Active Templates</div>
            <div style="font-size: 30px; font-weight: 900; color: #38BDF8; margin-top: 4px;">{{ $metrics['total_templates'] }}</div>
            <div style="font-size: 12px; color: #BAE6FD; margin-top: 4px;">Across {{ $metrics['total_categories'] }} Categories</div>
        </div>

        <div class="glass-panel" style="padding: 22px; border-radius: 18px;">
            <div style="font-size: 12px; color: #94A3B8; text-transform: uppercase; font-weight: 700;">RSVP Submissions</div>
            <div style="font-size: 30px; font-weight: 900; color: #FBBF24; margin-top: 4px;">{{ $metrics['total_rsvps'] }}</div>
            <div style="font-size: 12px; color: #FDE68A; margin-top: 4px;">{{ $metrics['total_guests'] }} Guests Registered</div>
        </div>
    </div>

    {{-- Quick CMS Links --}}
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 14px; margin-bottom: 36px;">
        <a href="{{ route('admin.invitations.categories') }}" class="glass-panel" style="padding: 16px; border-radius: 14px; text-decoration: none; color: #FFF; transition: transform 0.2s;" onmouseover="this.style.transform='translateY(-3px)'" onmouseout="this.style.transform='translateY(0)'">
            <div style="font-size: 24px; margin-bottom: 6px;">📑</div>
            <div style="font-weight: 700; font-size: 14px;">Categories</div>
            <div style="font-size: 11px; color: #94A3B8;">Organize catalogue</div>
        </a>

        <a href="{{ route('admin.invitations.templates') }}" class="glass-panel" style="padding: 16px; border-radius: 14px; text-decoration: none; color: #FFF; transition: transform 0.2s;" onmouseover="this.style.transform='translateY(-3px)'" onmouseout="this.style.transform='translateY(0)'">
            <div style="font-size: 24px; margin-bottom: 6px;">🎨</div>
            <div style="font-weight: 700; font-size: 14px;">Templates</div>
            <div style="font-size: 11px; color: #94A3B8;">Design &amp; sections</div>
        </a>

        <a href="{{ route('admin.invitations.features') }}" class="glass-panel" style="padding: 16px; border-radius: 14px; text-decoration: none; color: #FFF; transition: transform 0.2s;" onmouseover="this.style.transform='translateY(-3px)'" onmouseout="this.style.transform='translateY(0)'">
            <div style="font-size: 24px; margin-bottom: 6px;">💰</div>
            <div style="font-weight: 700; font-size: 14px;">Feature Pricing</div>
            <div style="font-size: 11px; color: #94A3B8;">Addon matrix</div>
        </a>

        <a href="{{ route('admin.invitations.orders') }}" class="glass-panel" style="padding: 16px; border-radius: 14px; text-decoration: none; color: #FFF; transition: transform 0.2s;" onmouseover="this.style.transform='translateY(-3px)'" onmouseout="this.style.transform='translateY(0)'">
            <div style="font-size: 24px; margin-bottom: 6px;">💳</div>
            <div style="font-weight: 700; font-size: 14px;">Orders &amp; Invoices</div>
            <div style="font-size: 11px; color: #94A3B8;">Revenue logs</div>
        </a>

        <a href="{{ route('admin.invitations.submissions') }}" class="glass-panel" style="padding: 16px; border-radius: 14px; text-decoration: none; color: #FFF; transition: transform 0.2s;" onmouseover="this.style.transform='translateY(-3px)'" onmouseout="this.style.transform='translateY(0)'">
            <div style="font-size: 24px; margin-bottom: 6px;">📝</div>
            <div style="font-weight: 700; font-size: 14px;">RSVP Responses</div>
            <div style="font-size: 11px; color: #94A3B8;">Attendee records</div>
        </a>

        <a href="{{ route('admin.invitations.coupons') }}" class="glass-panel" style="padding: 16px; border-radius: 14px; text-decoration: none; color: #FFF; transition: transform 0.2s;" onmouseover="this.style.transform='translateY(-3px)'" onmouseout="this.style.transform='translateY(0)'">
            <div style="font-size: 24px; margin-bottom: 6px;">🎟️</div>
            <div style="font-weight: 700; font-size: 14px;">Coupons</div>
            <div style="font-size: 11px; color: #94A3B8;">Discounts &amp; promos</div>
        </a>
    </div>

    {{-- Recent Orders & Recent Invitations Tables --}}
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(400px, 1fr)); gap: 24px;">
        
        {{-- Recent Orders --}}
        <div class="glass-panel" style="padding: 0; overflow: hidden; border-radius: 18px;">
            <div style="padding: 16px 20px; border-bottom: 1px solid rgba(255,255,255,0.08); font-size: 15px; font-weight: 700; color: #FFF;">
                💳 Recent Invitation Orders
            </div>
            <div style="overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse; font-size: 13px;">
                    <thead>
                        <tr style="background: rgba(15,23,42,0.8); color: #94A3B8; text-align: left;">
                            <th style="padding: 12px 16px;">Order</th>
                            <th style="padding: 12px 16px;">Amount</th>
                            <th style="padding: 12px 16px;">Status</th>
                            <th style="padding: 12px 16px;">Gateway</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentOrders as $ro)
                        <tr style="border-bottom: 1px solid rgba(255,255,255,0.05);">
                            <td style="padding: 12px 16px; color: #FFF; font-weight: 600;">{{ $ro->order_number }}</td>
                            <td style="padding: 12px 16px; color: var(--gold-primary); font-weight: 700;">₹{{ number_format($ro->final_amount, 2) }}</td>
                            <td style="padding: 12px 16px;">
                                <span class="badge-pill" style="font-size: 10px; background: {{ $ro->isCompleted() ? 'rgba(16, 185, 129, 0.2)' : 'rgba(245, 158, 11, 0.2)' }}; color: {{ $ro->isCompleted() ? '#34D399' : '#FBBF24' }};">
                                    {{ $ro->status }}
                                </span>
                            </td>
                            <td style="padding: 12px 16px; color: #94A3B8; text-transform: uppercase; font-size: 11px;">{{ $ro->payment_gateway }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="4" style="text-align: center; padding: 24px; color: #94A3B8;">No orders recorded yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Recent Invitations --}}
        <div class="glass-panel" style="padding: 0; overflow: hidden; border-radius: 18px;">
            <div style="padding: 16px 20px; border-bottom: 1px solid rgba(255,255,255,0.08); font-size: 15px; font-weight: 700; color: #FFF;">
                💌 Recent Invitations Created
            </div>
            <div style="overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse; font-size: 13px;">
                    <thead>
                        <tr style="background: rgba(15,23,42,0.8); color: #94A3B8; text-align: left;">
                            <th style="padding: 12px 16px;">Title</th>
                            <th style="padding: 12px 16px;">Status</th>
                            <th style="padding: 12px 16px;">RSVPs</th>
                            <th style="padding: 12px 16px; text-align: right;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentInvitations as $ri)
                        <tr style="border-bottom: 1px solid rgba(255,255,255,0.05);">
                            <td style="padding: 12px 16px; color: #FFF; font-weight: 600;">{{ Str::limit($ri->title, 24) }}</td>
                            <td style="padding: 12px 16px;">
                                <span class="badge-pill" style="font-size: 10px; background: {{ $ri->isPublished() ? 'rgba(16, 185, 129, 0.2)' : 'rgba(245, 158, 11, 0.2)' }}; color: {{ $ri->isPublished() ? '#34D399' : '#FBBF24' }};">
                                    {{ $ri->status }}
                                </span>
                            </td>
                            <td style="padding: 12px 16px; color: #38BDF8; font-weight: 700;">{{ $ri->form_responses_count }}</td>
                            <td style="padding: 12px 16px; text-align: right;">
                                <a href="{{ route('invitations.public.show', $ri->slug) }}" target="_blank" style="color: var(--gold-primary); text-decoration: none; font-size: 12px;">View &rarr;</a>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="4" style="text-align: center; padding: 24px; color: #94A3B8;">No invitations created yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>

</div>
@endsection
