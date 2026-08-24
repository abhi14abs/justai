@extends('layouts.admin')

@section('title', 'Edit Blog Article — Postryx Master Portal')

@section('content')

<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 28px;">
    <div>
        <a href="{{ route('admin.blogs') }}" style="color: #38bdf8; text-decoration: none; font-size: 13px;">&larr; Back to Blog Articles</a>
        <h1 style="font-size: 28px; font-weight: 800; color: #fff; margin-top: 4px;">
            Edit Article: {{ $blog->title }}
        </h1>
    </div>
    <div style="display: flex; gap: 8px;">
        <a href="{{ route('blog.show', $blog->slug) }}" target="_blank" class="btn-secondary" style="padding: 10px 16px;">
            Preview Live 👁️
        </a>
    </div>
</div>

<form action="{{ route('admin.blogs.update', $blog->id) }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 28px; align-items: flex-start;">
        
        {{-- Main Article Details (Left Column) --}}
        <div style="display: flex; flex-direction: column; gap: 24px;">
            
            {{-- Title & Slug Panel --}}
            <div class="glass-panel" style="padding: 28px; display: flex; flex-direction: column; gap: 18px;">
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 700; color: #fff; margin-bottom: 6px;">Article Title *</label>
                    <input type="text" name="title" id="blog-title" class="postryx-input" value="{{ old('title', $blog->title) }}" required>
                </div>

                <div>
                    <label style="display: block; font-size: 13px; font-weight: 600; color: var(--text-secondary); margin-bottom: 6px;">URL Slug (SEO Permalink) *</label>
                    <div style="display: flex; align-items: center; background: rgba(0,0,0,0.4); border: 1px solid var(--border-subtle); border-radius: 12px; padding: 0 14px;">
                        <span style="color: var(--text-muted); font-family: monospace; font-size: 13px;">https://postryx.in/blog/</span>
                        <input type="text" name="slug" id="blog-slug" class="postryx-input" value="{{ old('slug', $blog->slug) }}" required style="border: none; background: transparent; padding: 12px 6px; font-family: monospace; font-size: 13px; color: #38bdf8;">
                    </div>
                </div>

                <div>
                    <label style="display: block; font-size: 13px; font-weight: 600; color: var(--text-secondary); margin-bottom: 6px;">Short Excerpt / Summary</label>
                    <textarea name="excerpt" class="postryx-textarea" style="min-height: 80px;">{{ old('excerpt', $blog->excerpt) }}</textarea>
                </div>
            </div>

            {{-- Rich Article Content Panel --}}
            <div class="glass-panel" style="padding: 28px;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px;">
                    <label style="font-size: 14px; font-weight: 700; color: #fff;">Full Article Content (HTML &amp; Formatting Supported) *</label>
                    <div style="display: flex; gap: 6px;">
                        <button type="button" onclick="insertTag('<h2>', '</h2>')" class="btn-secondary" style="padding: 4px 8px; font-size: 11px;">H2</button>
                        <button type="button" onclick="insertTag('<h3>', '</h3>')" class="btn-secondary" style="padding: 4px 8px; font-size: 11px;">H3</button>
                        <button type="button" onclick="insertTag('<strong>', '</strong>')" class="btn-secondary" style="padding: 4px 8px; font-size: 11px;"><b>B</b></button>
                        <button type="button" onclick="insertTag('<em>', '</em>')" class="btn-secondary" style="padding: 4px 8px; font-size: 11px;"><i>I</i></button>
                        <button type="button" onclick="insertTag('<ul>\n  <li>', '</li>\n</ul>')" class="btn-secondary" style="padding: 4px 8px; font-size: 11px;">List</button>
                    </div>
                </div>
                
                <textarea name="content" id="blog-content" class="postryx-textarea" style="min-height: 440px; font-family: inherit; font-size: 14px; line-height: 1.7;" required>{{ old('content', $blog->content) }}</textarea>
            </div>

            {{-- Search Engine Optimization (SEO Meta) --}}
            <div class="glass-panel" style="padding: 28px; display: flex; flex-direction: column; gap: 16px;">
                <h3 style="font-size: 16px; color: #fff; display: flex; align-items: center; gap: 8px;">
                    <span>🔍</span> Google SEO &amp; Social Meta Tags
                </h3>

                <div>
                    <label style="display: block; font-size: 12px; font-weight: 600; color: var(--text-secondary); margin-bottom: 6px;">Custom Meta Title:</label>
                    <input type="text" name="meta_title" class="postryx-input" value="{{ old('meta_title', $blog->meta_title) }}">
                </div>

                <div>
                    <label style="display: block; font-size: 12px; font-weight: 600; color: var(--text-secondary); margin-bottom: 6px;">Meta Description (For Search CTR):</label>
                    <textarea name="meta_description" class="postryx-textarea" style="min-height: 80px;">{{ old('meta_description', $blog->meta_description) }}</textarea>
                </div>
            </div>

        </div>

        {{-- Sidebar Settings (Right Column) --}}
        <div style="display: flex; flex-direction: column; gap: 24px;">
            
            {{-- Publish Controls --}}
            <div class="glass-panel-glow" style="padding: 24px;">
                <h3 style="font-size: 16px; color: #fff; margin-bottom: 16px;">Publishing Controls</h3>
                
                <div style="margin-bottom: 20px; background: rgba(0,0,0,0.4); border: 1px solid var(--border-subtle); border-radius: 12px; padding: 14px;">
                    <label style="display: flex; align-items: center; justify-content: space-between; cursor: pointer;">
                        <div>
                            <div style="font-weight: 700; color: #fff; font-size: 14px;">Active / Published</div>
                            <div style="font-size: 11px; color: var(--text-secondary);">Visible on public blog feed</div>
                        </div>
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', $blog->is_active) ? 'checked' : '' }} style="accent-color: #10b981; width: 22px; height: 22px; cursor: pointer;">
                    </label>
                </div>

                <button type="submit" class="btn-primary" style="width: 100%; padding: 12px; font-size: 15px; font-weight: 700;">
                    Update Article Changes ✓
                </button>
            </div>

            {{-- Featured Image Replacement --}}
            <div class="glass-panel" style="padding: 24px;">
                <h3 style="font-size: 16px; color: #fff; margin-bottom: 14px;">Featured Hero Image</h3>
                
                <div id="image-preview-container" style="margin-bottom: 14px; border-radius: 10px; overflow: hidden; border: 1px solid var(--border-subtle); background: #000; text-align: center;">
                    <img id="image-preview-tag" src="{{ $blog->image_url }}" alt="Preview" style="width: 100%; height: 160px; object-fit: cover; display: block;">
                </div>

                <div style="margin-bottom: 12px;">
                    <label style="display: block; font-size: 12px; color: var(--text-secondary); margin-bottom: 4px;">Replace with New File Upload:</label>
                    <input type="file" name="image_file" accept="image/*" class="postryx-input" style="padding: 8px; font-size: 12px;" onchange="previewSelectedImage(this)">
                </div>

                <div>
                    <label style="display: block; font-size: 12px; color: var(--text-secondary); margin-bottom: 4px;">Or Custom Image URL / Path:</label>
                    <input type="text" name="image_url" value="{{ old('image_url', $blog->featured_image) }}" class="postryx-input" style="font-size: 12px; padding: 8px 12px;">
                </div>
            </div>

            {{-- Category & Tags --}}
            <div class="glass-panel" style="padding: 24px; display: flex; flex-direction: column; gap: 16px;">
                <h3 style="font-size: 16px; color: #fff;">Category &amp; Author</h3>

                <div>
                    <label style="display: block; font-size: 12px; font-weight: 600; color: var(--text-secondary); margin-bottom: 6px;">Category *</label>
                    <select name="category" class="postryx-input" required>
                        <option value="Viral Social" {{ $blog->category === 'Viral Social' ? 'selected' : '' }}>Viral Social (LinkedIn / Twitter)</option>
                        <option value="SEO Strategies" {{ $blog->category === 'SEO Strategies' ? 'selected' : '' }}>SEO Strategies &amp; Programmatic SEO</option>
                        <option value="AI Growth" {{ $blog->category === 'AI Growth' ? 'selected' : '' }}>AI Growth &amp; Humanizer</option>
                        <option value="Case Studies" {{ $blog->category === 'Case Studies' ? 'selected' : '' }}>Case Studies &amp; Playbooks</option>
                        <option value="Product Updates" {{ $blog->category === 'Product Updates' ? 'selected' : '' }}>Product Updates &amp; Features</option>
                    </select>
                </div>

                <div>
                    <label style="display: block; font-size: 12px; font-weight: 600; color: var(--text-secondary); margin-bottom: 6px;">Author Name:</label>
                    <input type="text" name="author_name" class="postryx-input" value="{{ old('author_name', $blog->author_name) }}">
                </div>

                <div>
                    <label style="display: block; font-size: 12px; font-weight: 600; color: var(--text-secondary); margin-bottom: 6px;">Tags (Comma-separated):</label>
                    <input type="text" name="tags" id="tags-input" class="postryx-input" value="{{ old('tags', !empty($blog->tags) ? implode(', ', $blog->tags) : '') }}">
                </div>
            </div>

        </div>

    </div>
</form>

@endsection

@section('scripts')
<script>
    function previewSelectedImage(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('image-preview-tag').src = e.target.result;
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    function insertTag(openTag, closeTag) {
        const textarea = document.getElementById('blog-content');
        const start = textarea.selectionStart;
        const end = textarea.selectionEnd;
        const selected = textarea.value.substring(start, end);
        const replacement = openTag + selected + closeTag;
        textarea.value = textarea.value.substring(0, start) + replacement + textarea.value.substring(end);
        textarea.focus();
    }
</script>
@endsection
