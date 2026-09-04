{{-- Background Audio Player Component --}}
@if(!empty($invitation->music_url))
    <audio id="bg-music-audio" loop preload="auto">
        <source src="{{ $invitation->music_url }}" type="audio/mpeg">
    </audio>

    {{-- Floating Music Player FAB button --}}
    <div class="music-fab" id="music-fab" onclick="toggleMusic()" title="Play / Pause Ambient Music" aria-label="Toggle Background Music">
        <span style="font-size: 22px; filter: drop-shadow(0 2px 4px rgba(0,0,0,0.5));">🎵</span>
    </div>
@endif
