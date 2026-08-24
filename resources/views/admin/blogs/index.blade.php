@extends('layouts.admin')

@section('title', 'Blog Articles CMS — Postryx Master Portal')

@section('content')

<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 28px;">
    <div>
        <h1 style="font-size: 28px; font-weight: 800; color: #fff; margin-bottom: 4px;">
            Blog &amp; SEO Content CMS
        </h1>
        <p style="color: var(--text-secondary); font-size: 14px;">Publish high-converting programmatic SEO articles, guides, and growth case studies.</p>
    </div>
    <a href="{{ route('admin.blogs.create') }}" class="btn-primary" style="padding: 10px 20px; font-size: 14px;">
        + Create New Article 📝
    </a>
</div>

<div class="glass-panel" style="padding: 28px;">
    <table class="postryx-datatable">
        <thead>
            <tr>
                <th>Thumbnail</th>
                <th>Title &amp; Slug</th>
                <th>Category</th>
                <th>Tags</th>
                <th>Status</th>
                <th>Views</th>
                <th>Read Time</th>
                <th>Last Updated</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($blogs as $b)
            <tr>
                <td>
                    <img src="{{ $b->image_url }}" alt="{{ $b->title }}" style="width: 54px; height: 38px; border-radius: 6px; object-fit: cover; border: 1px solid var(--border-subtle);">
                </td>
                <td>
                    <div style="font-weight: 700; color: #fff; font-size: 14px;">{{ $b->title }}</div>
                    <div style="font-family: monospace; font-size: 11px; color: #38bdf8;">/blog/{{ $b->slug }}</div>
                    <div style="font-size: 11px; color: var(--text-muted);">By {{ $b->author_name }}</div>
                </td>
                <td>
                    <span class="badge-pill" style="font-size: 10px;">{{ $b->category }}</span>
                </td>
                <td>
                    <div style="display: flex; flex-wrap: wrap; gap: 4px; max-width: 160px;">
                        @if(!empty($b->tags))
                            @foreach($b->tags as $t)
                            <span class="badge-pill-cyan" style="font-size: 9px; padding: 2px 6px;">{{ $t }}</span>
                            @endforeach
                        @else
                            <span style="color: var(--text-muted); font-size: 11px;">No tags</span>
                        @endif
                    </div>
                </td>
                <td>
                    <form action="{{ route('admin.blogs.toggle', $b->id) }}" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit" style="background: none; border: none; cursor: pointer;" title="Click to toggle status">
                            @if($b->is_active)
                            <span class="badge-pill-emerald" style="font-size: 10px; cursor: pointer;">
                                ● Active (Live)
                            </span>
                            @else
                            <span class="badge-pill" style="font-size: 10px; color: #94a3b8; background: rgba(255,255,255,0.05); border-color: rgba(255,255,255,0.2); cursor: pointer;">
                                ○ Inactive (Draft)
                            </span>
                            @endif
                        </button>
                    </form>
                </td>
                <td style="font-weight: 700; color: #f8fafc; font-size: 13px;">{{ number_format($b->views_count) }}</td>
                <td style="color: var(--text-muted); font-size: 12px;">{{ $b->read_time }}</td>
                <td style="color: var(--text-muted); font-size: 12px;">{{ $b->updated_at->format('M d, Y') }}</td>
                <td>
                    <div style="display: flex; gap: 6px; align-items: center;">
                        <a href="{{ route('blog.show', $b->slug) }}" target="_blank" class="btn-secondary" style="padding: 5px 8px; font-size: 11px;" title="View Live Article">
                            👁️
                        </a>
                        <a href="{{ route('admin.blogs.edit', $b->id) }}" class="btn-secondary" style="padding: 5px 10px; font-size: 11px;">
                            Edit ✏️
                        </a>
                        <form action="{{ route('admin.blogs.delete', $b->id) }}" method="POST" onsubmit="return confirm('Permanently delete blog: {{ $b->title }}?');">
                            @csrf
                            <button type="submit" style="background: none; border: none; color: #f43f5e; cursor: pointer; font-size: 14px; padding: 4px;" title="Delete">
                                🗑️
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection
