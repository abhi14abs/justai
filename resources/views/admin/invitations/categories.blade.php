@extends('layouts.admin')

@section('title', 'Manage Categories — Admin Portal')

@section('content')
<div class="admin-content">

    <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 16px; margin-bottom: 28px;">
        <div>
            <h1 style="font-size: 24px; font-weight: 800; color: #FFF; margin: 0 0 4px;">
                📑 Invitation Categories
            </h1>
            <p style="color: var(--text-secondary); font-size: 13px; margin: 0;">
                Manage event categories and subcategories
            </p>
        </div>

        <button type="button" onclick="document.getElementById('create-cat-modal').style.display='flex'" class="btn-primary" style="padding: 8px 16px; font-size: 13px; font-weight: 700; border-radius: 10px;">
            <span>+ Add Category</span>
        </button>
    </div>

    <div class="glass-panel" style="padding: 0; overflow: hidden; border-radius: 18px;">
        <table style="width: 100%; border-collapse: collapse; font-size: 13px;">
            <thead>
                <tr style="background: rgba(15,23,42,0.8); color: #94A3B8; text-align: left;">
                    <th style="padding: 14px 20px;">Category</th>
                    <th style="padding: 14px 20px;">Slug</th>
                    <th style="padding: 14px 20px;">Templates</th>
                    <th style="padding: 14px 20px;">Sort Order</th>
                    <th style="padding: 14px 20px;">Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($categories as $cat)
                <tr style="border-bottom: 1px solid rgba(255,255,255,0.05);">
                    <td style="padding: 14px 20px; color: #FFF; font-weight: 700;">
                        <span style="margin-right: 8px;">{{ $cat->icon ?? '💌' }}</span>
                        {{ $cat->name }}
                    </td>
                    <td style="padding: 14px 20px; color: #94A3B8;"><code>{{ $cat->slug }}</code></td>
                    <td style="padding: 14px 20px; color: var(--gold-primary); font-weight: 700;">{{ $cat->templates_count }}</td>
                    <td style="padding: 14px 20px; color: #FFF;">{{ $cat->sort_order }}</td>
                    <td style="padding: 14px 20px;">
                        <span class="badge-pill" style="font-size: 10px; background: rgba(16,185,129,0.2); color: #34D399;">Active</span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>

{{-- Create Modal --}}
<div id="create-cat-modal" class="mobile-drawer-overlay" style="display: none; align-items: center; justify-content: center; z-index: 1000;">
    <div class="glass-panel" style="width: 100%; max-width: 460px; padding: 24px; border-radius: 20px; background: #0B111E;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <h3 style="font-size: 18px; font-weight: 700; color: #FFF; margin: 0;">Add Category</h3>
            <button type="button" onclick="document.getElementById('create-cat-modal').style.display='none'" style="background: none; border: none; color: #FFF; font-size: 20px; cursor: pointer;">&times;</button>
        </div>

        <form action="{{ route('admin.invitations.categories.store') }}" method="POST">
            @csrf
            <div style="margin-bottom: 14px;">
                <label style="display: block; font-size: 12px; color: #94A3B8; margin-bottom: 4px;">Category Name *</label>
                <input type="text" name="name" required placeholder="e.g. Housewarming & Puja" class="form-control" style="width: 100%; padding: 10px 14px; border-radius: 10px; background: rgba(15,23,42,0.8); border: 1px solid rgba(255,255,255,0.15); color: #FFF; font-size: 13px;">
            </div>

            <div style="margin-bottom: 14px;">
                <label style="display: block; font-size: 12px; color: #94A3B8; margin-bottom: 4px;">Icon / Emoji</label>
                <input type="text" name="icon" placeholder="🏠" class="form-control" style="width: 100%; padding: 10px 14px; border-radius: 10px; background: rgba(15,23,42,0.8); border: 1px solid rgba(255,255,255,0.15); color: #FFF; font-size: 13px;">
            </div>

            <div style="margin-bottom: 20px;">
                <label style="display: block; font-size: 12px; color: #94A3B8; margin-bottom: 4px;">Description</label>
                <textarea name="description" rows="2" class="form-control" style="width: 100%; padding: 10px 14px; border-radius: 10px; background: rgba(15,23,42,0.8); border: 1px solid rgba(255,255,255,0.15); color: #FFF; font-size: 13px;"></textarea>
            </div>

            <button type="submit" class="btn-primary" style="width: 100%; padding: 12px; font-size: 13px; font-weight: 700; border-radius: 10px;">
                <span>Create Category</span>
            </button>
        </form>
    </div>
</div>
@endsection
