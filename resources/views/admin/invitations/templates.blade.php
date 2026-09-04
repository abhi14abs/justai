@extends('layouts.admin')

@section('title', 'Manage Templates — Admin Portal')

@section('content')
<div class="admin-content">

    <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 16px; margin-bottom: 28px;">
        <div>
            <h1 style="font-size: 24px; font-weight: 800; color: #FFF; margin: 0 0 4px;">
                🎨 Invitation Templates Catalog
            </h1>
            <p style="color: var(--text-secondary); font-size: 13px; margin: 0;">
                Configure designs, section blueprints, and pricing
            </p>
        </div>

        <button type="button" onclick="document.getElementById('create-tpl-modal').style.display='flex'" class="btn-primary" style="padding: 8px 16px; font-size: 13px; font-weight: 700; border-radius: 10px;">
            <span>+ Add New Template</span>
        </button>
    </div>

    <div class="glass-panel" style="padding: 0; overflow: hidden; border-radius: 18px;">
        <table style="width: 100%; border-collapse: collapse; font-size: 13px;">
            <thead>
                <tr style="background: rgba(15,23,42,0.8); color: #94A3B8; text-align: left;">
                    <th style="padding: 14px 20px;">Template</th>
                    <th style="padding: 14px 20px;">Category</th>
                    <th style="padding: 14px 20px;">Base Price</th>
                    <th style="padding: 14px 20px;">Uses / Views</th>
                    <th style="padding: 14px 20px;">Status</th>
                    <th style="padding: 14px 20px; text-align: right;">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($templates as $tpl)
                <tr style="border-bottom: 1px solid rgba(255,255,255,0.05);">
                    <td style="padding: 14px 20px; color: #FFF; font-weight: 700;">
                        <div style="display: flex; align-items: center; gap: 12px;">
                            <img src="{{ $tpl->thumbnail_url }}" alt="{{ $tpl->name }}" style="width: 40px; height: 40px; border-radius: 8px; object-fit: cover;">
                            <div>
                                <div>{{ $tpl->name }}</div>
                                <div style="font-size: 11px; color: #94A3B8;"><code>{{ $tpl->slug }}</code></div>
                            </div>
                        </div>
                    </td>
                    <td style="padding: 14px 20px; color: #CBD5E1;">{{ $tpl->category->name ?? 'General' }}</td>
                    <td style="padding: 14px 20px; color: var(--gold-primary); font-weight: 700;">
                        {{ $tpl->base_price_inr > 0 ? '₹' . number_format($tpl->base_price_inr, 2) : 'Free' }}
                    </td>
                    <td style="padding: 14px 20px; color: #94A3B8;">{{ $tpl->use_count }} / {{ $tpl->view_count }}</td>
                    <td style="padding: 14px 20px;">
                        @if($tpl->is_premium)
                            <span class="badge-pill" style="font-size: 10px; background: rgba(245,158,11,0.2); color: #FBBF24;">Premium</span>
                        @else
                            <span class="badge-pill" style="font-size: 10px; background: rgba(16,185,129,0.2); color: #34D399;">Free</span>
                        @endif
                    </td>
                    <td style="padding: 14px 20px; text-align: right;">
                        <a href="{{ route('invitations.browse.preview', $tpl->slug) }}" target="_blank" style="color: #38BDF8; text-decoration: none; font-size: 12px; margin-right: 8px;">Demo</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>

{{-- Create Template Modal --}}
<div id="create-tpl-modal" class="mobile-drawer-overlay" style="display: none; align-items: center; justify-content: center; z-index: 1000;">
    <div class="glass-panel" style="width: 100%; max-width: 520px; padding: 24px; border-radius: 20px; background: #0B111E;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <h3 style="font-size: 18px; font-weight: 700; color: #FFF; margin: 0;">Add New Template</h3>
            <button type="button" onclick="document.getElementById('create-tpl-modal').style.display='none'" style="background: none; border: none; color: #FFF; font-size: 20px; cursor: pointer;">&times;</button>
        </div>

        <form action="{{ route('admin.invitations.templates.store') }}" method="POST">
            @csrf
            <div style="margin-bottom: 12px;">
                <label style="display: block; font-size: 12px; color: #94A3B8; margin-bottom: 4px;">Category *</label>
                <select name="category_id" required class="form-control" style="width: 100%; padding: 10px 14px; border-radius: 10px; background: #0F172A; border: 1px solid rgba(255,255,255,0.15); color: #FFF; font-size: 13px;">
                    @foreach($categories as $c)
                        <option value="{{ $c->id }}">{{ $c->name }}</option>
                    @endforeach
                </select>
            </div>

            <div style="margin-bottom: 12px;">
                <label style="display: block; font-size: 12px; color: #94A3B8; margin-bottom: 4px;">Template Name *</label>
                <input type="text" name="name" required placeholder="e.g. Celestial Golden Starlight" class="form-control" style="width: 100%; padding: 10px 14px; border-radius: 10px; background: rgba(15,23,42,0.8); border: 1px solid rgba(255,255,255,0.15); color: #FFF; font-size: 13px;">
            </div>

            <div style="margin-bottom: 12px;">
                <label style="display: block; font-size: 12px; color: #94A3B8; margin-bottom: 4px;">Thumbnail URL</label>
                <input type="text" name="thumbnail_url" placeholder="https://..." class="form-control" style="width: 100%; padding: 10px 14px; border-radius: 10px; background: rgba(15,23,42,0.8); border: 1px solid rgba(255,255,255,0.15); color: #FFF; font-size: 13px;">
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-bottom: 16px;">
                <div>
                    <label style="display: block; font-size: 12px; color: #94A3B8; margin-bottom: 4px;">Base Price (INR)</label>
                    <input type="number" name="base_price_inr" value="999" class="form-control" style="width: 100%; padding: 10px 14px; border-radius: 10px; background: rgba(15,23,42,0.8); border: 1px solid rgba(255,255,255,0.15); color: #FFF; font-size: 13px;">
                </div>
                <div>
                    <label style="display: block; font-size: 12px; color: #94A3B8; margin-bottom: 4px;">Base Price (USD)</label>
                    <input type="number" name="base_price_usd" value="12.99" step="0.01" class="form-control" style="width: 100%; padding: 10px 14px; border-radius: 10px; background: rgba(15,23,42,0.8); border: 1px solid rgba(255,255,255,0.15); color: #FFF; font-size: 13px;">
                </div>
            </div>

            <button type="submit" class="btn-primary" style="width: 100%; padding: 12px; font-size: 13px; font-weight: 700; border-radius: 10px;">
                <span>Create Template</span>
            </button>
        </form>
    </div>
</div>
@endsection
