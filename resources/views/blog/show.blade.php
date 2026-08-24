@extends('layouts.app')

@section('title', ($post->meta_title ?? $post->title) . ' | Postryx AI')
@section('meta_description', $post->meta_description ?? $post->excerpt)

@section('extra_schema')
<script type="application/ld+json">
{!! json_encode([
  '@context' => 'https://schema.org',
  '@type' => 'Article',
  'headline' => $post->title,
  'description' => $post->meta_description ?? $post->excerpt,
  'image' => $post->image_url,
  'author' => [
    '@type' => 'Person',
    'name' => $post->author_name
  ],
  'publisher' => [
    '@type' => 'Organization',
    'name' => 'Postryx AI',
    'logo' => [
      '@type' => 'ImageObject',
      'url' => asset('images/logo.png')
    ]
  ],
  'datePublished' => $post->created_at->toAtomString(),
  'dateModified' => $post->updated_at->toAtomString()
], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) !!}
</script>
@endsection

@section('content')

<article style="padding: 60px 24px 80px; max-width: 920px; margin: 0 auto;">
    
    {{-- Article Header --}}
    <div style="margin-bottom: 36px; text-align: left;">
        <div style="display: flex; flex-wrap: wrap; gap: 10px; align-items: center; margin-bottom: 18px;">
            <a href="{{ route('blog.index') }}" style="color: #38bdf8; text-decoration: none; font-size: 13px; font-weight: 600;">&larr; Back to All Guides</a>
            <span style="color: var(--text-muted);">•</span>
            <span class="badge-pill" style="font-size: 11px;">{{ $post->category }}</span>
            <span style="color: var(--text-muted); font-size: 13px;">{{ $post->read_time }}</span>
            <span style="color: var(--text-muted);">•</span>
            <span style="color: #6ee7b7; font-size: 13px; font-weight: 600;">👁️ {{ number_format($post->views_count) }} reads</span>
        </div>

        <h1 style="font-size: clamp(32px, 4.5vw, 48px); font-weight: 800; line-height: 1.2; margin-bottom: 20px; color: #fff;">
            {{ $post->title }}
        </h1>

        {{-- Tags Pills --}}
        @if(!empty($post->tags))
        <div style="display: flex; flex-wrap: wrap; gap: 6px; margin-bottom: 20px;">
            @foreach($post->tags as $t)
            <span class="badge-pill-cyan" style="font-size: 10px; padding: 3px 10px;">#{{ $t }}</span>
            @endforeach
        </div>
        @endif

        {{-- Author & Timestamp --}}
        <div style="display: flex; align-items: center; gap: 14px; padding-bottom: 24px; border-bottom: 1px solid var(--border-subtle);">
            <div class="mockup-avatar" style="width: 42px; height: 42px; font-size: 15px;">{{ strtoupper(substr($post->author_name, 0, 1)) }}</div>
            <div>
                <div style="font-weight: 700; color: #fff; font-size: 15px;">{{ $post->author_name }}</div>
                <div style="font-size: 12px; color: var(--text-muted);">Published {{ $post->created_at->format('M d, Y') }} • Postryx AI Editorial</div>
            </div>
        </div>
    </div>

    {{-- Featured Hero Image --}}
    @if(!empty($post->featured_image))
    <div style="margin-bottom: 36px; border-radius: 18px; overflow: hidden; border: 1px solid var(--border-subtle); box-shadow: 0 20px 50px rgba(0,0,0,0.6);">
        <img src="{{ $post->image_url }}" alt="{{ $post->title }}" style="width: 100%; height: auto; max-height: 440px; object-fit: cover; display: block;">
    </div>
    @endif

    {{-- Article Body Content --}}
    <div class="glass-panel" style="padding: 38px; line-height: 1.85; font-size: 16px; color: #e2e8f0;">
        
        @if(!empty($post->excerpt))
        <div style="background: rgba(99,102,241,0.1); border-left: 4px solid #6366f1; padding: 18px 24px; border-radius: 0 14px 14px 0; margin-bottom: 32px; font-size: 17px; font-weight: 500; color: #c7d2fe; line-height: 1.7;">
            {{ $post->excerpt }}
        </div>
        @endif

        {{-- Render HTML Content --}}
        <div class="blog-content-body">
            {!! $post->content !!}
        </div>

    </div>

    {{-- In-Content CTA Widget --}}
    <div class="glass-panel-glow" style="margin-top: 50px; padding: 34px; text-align: center;">
        <span class="badge-pill-cyan" style="margin-bottom: 12px;">Instant AI Generator</span>
        <h3 style="font-size: 24px; color: #fff; margin-bottom: 10px;">Turn These Insights into Viral Posts in 60 Seconds</h3>
        <p style="color: var(--text-secondary); font-size: 15px; max-width: 600px; margin: 0 auto 22px;">
            Use Postryx AI to generate thought leadership LinkedIn posts, Twitter threads, Reels scripts, and long-form SEO articles with automated hooks.
        </p>
        <a href="{{ route('home') }}#studio-section" class="btn-primary" style="padding: 12px 28px; font-size: 15px; font-weight: 700;">
            Launch Free Studio ⚡
        </a>
    </div>

    {{-- Related Articles Section --}}
    @if(isset($recentPosts) && $recentPosts->count() > 0)
    <div style="margin-top: 70px;">
        <h3 style="font-size: 22px; color: #fff; margin-bottom: 24px;">Recommended Growth Playbooks</h3>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 20px;">
            @foreach($recentPosts as $rp)
            <a href="{{ route('blog.show', $rp->slug) }}" class="glass-panel" style="padding: 20px; text-decoration: none; display: flex; flex-direction: column;">
                <span class="badge-pill" style="font-size: 10px; margin-bottom: 10px; align-self: flex-start;">{{ $rp->category }}</span>
                <h4 style="font-size: 15px; color: #fff; line-height: 1.4; margin-bottom: 8px;">{{ $rp->title }}</h4>
                <div style="font-size: 12px; color: var(--text-muted); margin-top: auto;">{{ $rp->read_time }} • Read &rarr;</div>
            </a>
            @endforeach
        </div>
    </div>
    @endif

</article>

@endsection
