@extends('layouts.app')

@section('title', 'Viral Growth & Programmatic SEO Blog | Postryx AI')
@section('meta_description', 'In-depth guides, algorithm breakdowns, and actionable case studies on viral social media, programmatic SEO, AI humanization, and organic audience growth.')
@section('meta_keywords', 'viral growth blog, programmatic SEO guide, AI LinkedIn algorithm 2026, bypass AI detectors guide, Twitter X growth playbook, content repurposing formula, postryx.in')

@section('content')

<section style="padding: 70px 24px 40px; text-align: center;">
    <div style="max-width: 960px; margin: 0 auto;">
        <span class="badge-pill-cyan" style="margin-bottom: 16px;">Organic Growth Playbooks</span>
        <h1 style="font-size: clamp(34px, 5vw, 54px); font-weight: 800; margin-bottom: 18px;">
            The <span class="gradient-text">Viral Social &amp; SEO</span> Resource Hub
        </h1>
        <p style="font-size: 18px; color: var(--text-secondary); max-width: 700px; margin: 0 auto; line-height: 1.6;">
            Deep-dive frameworks, algorithm teardowns, and programmatic SEO blueprints to help you scale organic traffic and revenue.
        </p>
    </div>
</section>

{{-- Blog Grid --}}
<section style="padding: 20px 24px 80px; max-width: 1240px; margin: 0 auto;">
    @if(isset($posts) && $posts->count() > 0)
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(340px, 1fr)); gap: 32px;">
        @foreach($posts as $post)
        <article class="glass-panel" style="display: flex; flex-direction: column; overflow: hidden; padding: 0; transition: transform 0.3s ease;">
            
            {{-- Featured Image --}}
            <a href="{{ route('blog.show', $post->slug) }}" style="display: block; overflow: hidden; max-height: 200px; position: relative;">
                <img src="{{ $post->image_url }}" alt="{{ $post->title }}" style="width: 100%; height: 200px; object-fit: cover; transition: transform 0.4s ease;" onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'">
                <span class="badge-pill" style="position: absolute; top: 14px; left: 14px; font-size: 11px; background: rgba(6, 9, 15, 0.85); backdrop-filter: blur(8px);">{{ $post->category }}</span>
            </a>

            <div style="padding: 24px; display: flex; flex-direction: column; flex: 1;">
                
                {{-- Tags Row --}}
                @if(!empty($post->tags))
                <div style="display: flex; flex-wrap: wrap; gap: 6px; margin-bottom: 12px;">
                    @foreach($post->tags as $tag)
                    <span class="badge-pill-cyan" style="font-size: 10px; padding: 2px 8px;">#{{ $tag }}</span>
                    @endforeach
                </div>
                @endif

                <h2 style="font-size: 20px; line-height: 1.35; color: #fff; margin-bottom: 12px; font-weight: 700;">
                    <a href="{{ route('blog.show', $post->slug) }}" style="color: inherit; text-decoration: none;">
                        {{ $post->title }}
                    </a>
                </h2>

                <p style="color: var(--text-secondary); font-size: 14px; line-height: 1.6; margin-bottom: 20px;">
                    {{ $post->excerpt }}
                </p>

                <div style="border-top: 1px solid var(--border-subtle); padding-top: 16px; margin-top: auto; display: flex; justify-content: space-between; align-items: center;">
                    <div style="font-size: 12px; color: var(--text-muted);">
                        By <strong style="color:#e2e8f0;">{{ $post->author_name }}</strong> • {{ $post->read_time }}
                    </div>
                    <a href="{{ route('blog.show', $post->slug) }}" style="color: #38bdf8; font-weight: 700; font-size: 13px; text-decoration: none;">
                        Read Guide &rarr;
                    </a>
                </div>

            </div>
        </article>
        @endforeach
    </div>

    {{-- Pagination --}}
    @if(method_exists($posts, 'links'))
    <div style="margin-top: 40px; display: flex; justify-content: center;">
        {{ $posts->links() }}
    </div>
    @endif
    @elseif(isset($staticPosts) && count($staticPosts) > 0)
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(340px, 1fr)); gap: 32px;">
        @foreach($staticPosts as $slug => $sp)
        <article class="glass-panel" style="display: flex; flex-direction: column; overflow: hidden; padding: 0; transition: transform 0.3s ease;">
            
            {{-- Featured Image --}}
            <a href="{{ route('blog.show', $sp['slug']) }}" style="display: block; overflow: hidden; max-height: 200px; position: relative;">
                <img src="{{ asset('images/postryx-hero-banner.png') }}" alt="{{ $sp['title'] }}" style="width: 100%; height: 200px; object-fit: cover; transition: transform 0.4s ease;" onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'">
                <span class="badge-pill" style="position: absolute; top: 14px; left: 14px; font-size: 11px; background: rgba(6, 9, 15, 0.85); backdrop-filter: blur(8px);">{{ $sp['category'] }}</span>
            </a>

            <div style="padding: 24px; display: flex; flex-direction: column; flex: 1;">
                
                <h2 style="font-size: 20px; line-height: 1.35; color: #fff; margin-bottom: 12px; font-weight: 700;">
                    <a href="{{ route('blog.show', $sp['slug']) }}" style="color: inherit; text-decoration: none;">
                        {{ $sp['title'] }}
                    </a>
                </h2>

                <p style="color: var(--text-secondary); font-size: 14px; line-height: 1.6; margin-bottom: 20px;">
                    {{ $sp['excerpt'] }}
                </p>

                <div style="border-top: 1px solid var(--border-subtle); padding-top: 16px; margin-top: auto; display: flex; justify-content: space-between; align-items: center;">
                    <div style="font-size: 12px; color: var(--text-muted);">
                        By <strong style="color:#e2e8f0;">{{ $sp['author'] }}</strong> • {{ $sp['read_time'] }}
                    </div>
                    <a href="{{ route('blog.show', $sp['slug']) }}" style="color: #38bdf8; font-weight: 700; font-size: 13px; text-decoration: none;">
                        Read Guide &rarr;
                    </a>
                </div>

            </div>
        </article>
        @endforeach
    </div>
    @else
    <div class="glass-panel" style="padding: 60px 24px; text-align: center;">
        <h3 style="font-size: 20px; color: #fff; margin-bottom: 8px;">No Articles Published Yet</h3>
        <p style="color: var(--text-secondary); font-size: 14px;">Check back soon for new organic growth guides.</p>
    </div>
    @endif
</section>

@endsection
