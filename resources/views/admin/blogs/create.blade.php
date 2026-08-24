@extends('layouts.admin')

@section('title', 'Create New Blog Article — Postryx Master Portal')

@section('content')

<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 28px;">
    <div>
        <a href="{{ route('admin.blogs') }}" style="color: #38bdf8; text-decoration: none; font-size: 13px;">&larr; Back to Blog Articles</a>
        <h1 style="font-size: 28px; font-weight: 800; color: #fff; margin-top: 4px;">
            Publish New SEO Article
        </h1>
    </div>
</div>

<form action="{{ route('admin.blogs.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 28px; align-items: flex-start;">
        
        {{-- Main Article Details (Left Column) --}}
        <div style="display: flex; flex-direction: column; gap: 24px;">
            
            {{-- Title & Slug Panel --}}
            <div class="glass-panel" style="padding: 28px; display: flex; flex-direction: column; gap: 18px;">
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 700; color: #fff; margin-bottom: 6px;">Article Title *</label>
                    <input type="text" name="title" id="blog-title" class="postryx-input" placeholder="e.g. 7 Proven Hooks That Generated 1M+ Views on LinkedIn" value="{{ old('title') }}" required oninput="generateSlug(this.value)">
                </div>

                <div>
                    <label style="display: block; font-size: 13px; font-weight: 600; color: var(--text-secondary); margin-bottom: 6px;">URL Slug (SEO Permalink) *</label>
                    <div style="display: flex; align-items: center; background: rgba(0,0,0,0.4); border: 1px solid var(--border-subtle); border-radius: 12px; padding: 0 14px;">
                        <span style="color: var(--text-muted); font-family: monospace; font-size: 13px;">https://postryx.in/blog/</span>
                        <input type="text" name="slug" id="blog-slug" class="postryx-input" placeholder="7-proven-hooks-1m-views" value="{{ old('slug') }}" style="border: none; background: transparent; padding: 12px 6px; font-family: monospace; font-size: 13px; color: #38bdf8;">
                    </div>
                </div>

                <div>
                    <label style="display: block; font-size: 13px; font-weight: 600; color: var(--text-secondary); margin-bottom: 6px;">Short Excerpt / Summary (Appears in blog feed &amp; preview cards)</label>
                    <textarea name="excerpt" class="postryx-textarea" style="min-height: 80px;" placeholder="Brief 1-2 sentence overview of the article...">{{ old('excerpt') }}</textarea>
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
                
                <textarea name="content" id="blog-content" class="postryx-textarea" style="min-height: 420px; font-family: inherit; font-size: 14px; line-height: 1.7;" placeholder="Write your long-form article here with H2, H3 headers, bullet points, and actionable takeaways..." required>{{ old('content') }}</textarea>
            </div>

            {{-- Search Engine Optimization (SEO Meta) --}}
            <div class="glass-panel" style="padding: 28px; display: flex; flex-direction: column; gap: 16px;">
                <h3 style="font-size: 16px; color: #fff; display: flex; align-items: center; gap: 8px;">
                    <span>🔍</span> Google SEO &amp; Social Meta Tags
                </h3>

                <div>
                    <label style="display: block; font-size: 12px; font-weight: 600; color: var(--text-secondary); margin-bottom: 6px;">Custom Meta Title (Defaults to Article Title):</label>
                    <input type="text" name="meta_title" class="postryx-input" placeholder="e.g. 7 Proven Viral LinkedIn Hooks in 2026 | Postryx AI" value="{{ old('meta_title') }}">
                </div>

                <div>
                    <label style="display: block; font-size: 12px; font-weight: 600; color: var(--text-secondary); margin-bottom: 6px;">Meta Description (For Google Snippets &amp; Social Previews):</label>
                    <textarea name="meta_description" class="postryx-textarea" style="min-height: 80px;" placeholder="Compelling 150-160 character description designed for high organic CTR...">{{ old('meta_description') }}</textarea>
                </div>
            </div>

        </div>

        {{-- Sidebar Settings (Right Column) --}}
        <div style="display: flex; flex-direction: column; gap: 24px;">
            
            {{-- Publish & Status Action Card --}}
            <div class="glass-panel-glow" style="padding: 24px;">
                <h3 style="font-size: 16px; color: #fff; margin-bottom: 16px;">Publishing Controls</h3>
                
                <div style="margin-bottom: 20px; background: rgba(0,0,0,0.4); border: 1px solid var(--border-subtle); border-radius: 12px; padding: 14px;">
                    <label style="display: flex; align-items: center; justify-content: space-between; cursor: pointer;">
                        <div>
                            <div style="font-weight: 700; color: #fff; font-size: 14px;">Publish Status</div>
                            <div style="font-size: 11px; color: var(--text-secondary);">Show live on postryx.in/blog</div>
                        </div>
                        <input type="checkbox" name="is_active" value="1" checked style="accent-color: #10b981; width: 22px; height: 22px; cursor: pointer;">
                    </label>
                </div>

                <button type="submit" class="btn-primary" style="width: 100%; padding: 12px; font-size: 15px; font-weight: 700;">
                    Save &amp; Publish Article 🚀
                </button>
            </div>

            {{-- Featured Image Upload & Storage --}}
            <div class="glass-panel" style="padding: 24px;">
                <h3 style="font-size: 16px; color: #fff; margin-bottom: 14px;">Featured Hero Image</h3>
                
                <div id="image-preview-container" style="margin-bottom: 14px; border-radius: 10px; overflow: hidden; border: 1px solid var(--border-subtle); background: #000; text-align: center;">
                    <img id="image-preview-tag" src="{{ asset('images/postryx-hero-banner.png') }}" alt="Preview" style="width: 100%; height: 160px; object-fit: cover; display: block;">
                </div>

                <div style="margin-bottom: 12px;">
                    <label style="display: block; font-size: 12px; color: var(--text-secondary); margin-bottom: 4px;">Upload Image File (Saved to public/uploads/blogs):</label>
                    <input type="file" name="image_file" accept="image/*" class="postryx-input" style="padding: 8px; font-size: 12px;" onchange="previewSelectedImage(this)">
                </div>

                <div>
                    <label style="display: block; font-size: 12px; color: var(--text-secondary); margin-bottom: 4px;">Or Use Existing Image URL / Asset:</label>
                    <input type="text" name="image_url" placeholder="images/postryx-hero-banner.png" class="postryx-input" style="font-size: 12px; padding: 8px 12px;">
                </div>
            </div>

            {{-- Category & Metadata --}}
            <div class="glass-panel" style="padding: 24px; display: flex; flex-direction: column; gap: 16px;">
                <h3 style="font-size: 16px; color: #fff;">Category &amp; Author</h3>

                <div>
                    <label style="display: block; font-size: 12px; font-weight: 600; color: var(--text-secondary); margin-bottom: 6px;">Category *</label>
                    <select name="category" class="postryx-input" required>
                        <option value="Viral Social">Viral Social (LinkedIn / Twitter)</option>
                        <option value="SEO Strategies">SEO Strategies &amp; Programmatic SEO</option>
                        <option value="AI Growth">AI Growth &amp; Humanizer</option>
                        <option value="Case Studies">Case Studies &amp; Playbooks</option>
                        <option value="Product Updates">Product Updates &amp; Features</option>
                    </select>
                </div>

                <div>
                    <label style="display: block; font-size: 12px; font-weight: 600; color: var(--text-secondary); margin-bottom: 6px;">Author Name:</label>
                    <input type="text" name="author_name" class="postryx-input" value="{{ Auth::user()->name ?? 'Postryx AI Team' }}" placeholder="e.g. Alex Johnson">
                </div>

                <div>
                    <label style="display: block; font-size: 12px; font-weight: 600; color: var(--text-secondary); margin-bottom: 6px;">Tags (Comma-separated):</label>
                    <input type="text" name="tags" id="tags-input" class="postryx-input" placeholder="LinkedIn, Viral Hooks, B2B Growth" value="{{ old('tags') }}">
                    <div style="display: flex; flex-wrap: wrap; gap: 4px; margin-top: 8px;">
                        <button type="button" onclick="addTag('LinkedIn')" class="badge-pill" style="font-size: 9px; cursor: pointer; border: none;">+ LinkedIn</button>
                        <button type="button" onclick="addTag('SEO')" class="badge-pill" style="font-size: 9px; cursor: pointer; border: none;">+ SEO</button>
                        <button type="button" onclick="addTag('Viral Marketing')" class="badge-pill" style="font-size: 9px; cursor: pointer; border: none;">+ Viral Marketing</button>
                        <button type="button" onclick="addTag('AI Humanizer')" class="badge-pill" style="font-size: 9px; cursor: pointer; border: none;">+ AI Humanizer</button>
                    </div>
                </div>
            </div>

        </div>

    </div>
</form>

@endsection

@section('scripts')
<script>
    function generateSlug(text) {
        const slug = text.toString().toLowerCase().trim()
            .replace(/\s+/g, '-')
            .replace(/[^\w\-]+/g, '')
            .replace(/\-\-+/g, '-');
        document.getElementById('blog-slug').value = slug;
    }

    function previewSelectedImage(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('image-preview-tag').src = e.target.result;
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    function addTag(tagName) {
        const input = document.getElementById('tags-input');
        const current = input.value.trim();
        if (current === '') {
            input.value = tagName;
        } else if (!current.includes(tagName)) {
            input.value = current + ', ' + tagName;
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
