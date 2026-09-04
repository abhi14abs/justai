@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation" style="display: flex; align-items: center; justify-content: center; gap: 8px; margin: 30px 0;">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <span style="display: inline-flex; align-items: center; justify-content: center; padding: 8px 16px; border-radius: 12px; background: rgba(255, 255, 255, 0.03); border: 1px solid rgba(255, 255, 255, 0.08); color: #64748B; font-size: 13px; font-weight: 600; cursor: not-allowed; opacity: 0.5;">
                &larr; Previous
            </span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" rel="prev" style="display: inline-flex; align-items: center; justify-content: center; padding: 8px 16px; border-radius: 12px; background: rgba(255, 255, 255, 0.06); border: 1px solid rgba(255, 255, 255, 0.15); color: #F1F5F9; font-size: 13px; font-weight: 600; text-decoration: none; transition: all 0.2s ease;">
                &larr; Previous
            </a>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <span style="display: inline-flex; align-items: center; justify-content: center; width: 36px; height: 36px; color: #64748B; font-size: 14px;">{{ $element }}</span>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span style="display: inline-flex; align-items: center; justify-content: center; min-width: 36px; height: 36px; padding: 0 10px; border-radius: 10px; background: linear-gradient(135deg, #D4AF37, #996515); color: #FFFFFF; font-size: 13px; font-weight: 800; box-shadow: 0 4px 12px rgba(212, 175, 55, 0.35);">
                            {{ $page }}
                        </span>
                    @else
                        <a href="{{ $url }}" style="display: inline-flex; align-items: center; justify-content: center; min-width: 36px; height: 36px; padding: 0 10px; border-radius: 10px; background: rgba(255, 255, 255, 0.05); border: 1px solid rgba(255, 255, 255, 0.1); color: #CBD5E1; font-size: 13px; font-weight: 600; text-decoration: none; transition: all 0.2s ease;">
                            {{ $page }}
                        </a>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" rel="next" style="display: inline-flex; align-items: center; justify-content: center; padding: 8px 16px; border-radius: 12px; background: rgba(255, 255, 255, 0.06); border: 1px solid rgba(255, 255, 255, 0.15); color: #F1F5F9; font-size: 13px; font-weight: 600; text-decoration: none; transition: all 0.2s ease;">
                Next &rarr;
            </a>
        @else
            <span style="display: inline-flex; align-items: center; justify-content: center; padding: 8px 16px; border-radius: 12px; background: rgba(255, 255, 255, 0.03); border: 1px solid rgba(255, 255, 255, 0.08); color: #64748B; font-size: 13px; font-weight: 600; cursor: not-allowed; opacity: 0.5;">
                Next &rarr;
            </span>
        @endif
    </nav>
@endif
