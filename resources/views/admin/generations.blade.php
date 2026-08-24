@extends('layouts.admin')

@section('title', 'AI Generations Activity Stream — Postryx Master Portal')

@section('content')

<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 28px;">
    <div>
        <h1 style="font-size: 28px; font-weight: 800; color: #fff; margin-bottom: 4px;">
            AI Generations Activity Stream
        </h1>
        <p style="color: var(--text-secondary); font-size: 14px;">Live telemetry of what creators and businesses are generating across all 12 tools.</p>
    </div>
    <span class="badge-pill-cyan">{{ $generations->count() }} Recent Logs</span>
</div>

<div class="glass-panel" style="padding: 28px;">
    <table class="postryx-datatable">
        <thead>
            <tr>
                <th>Log #</th>
                <th>User / IP</th>
                <th>Tool Type</th>
                <th>Topic / Core Prompt</th>
                <th>Word Count</th>
                <th>Engine Provider</th>
                <th>Timestamp</th>
                <th>Output</th>
            </tr>
        </thead>
        <tbody>
            @foreach($generations as $g)
            <tr>
                <td style="font-family: monospace; color: #38bdf8;">#GEN-{{ $g->id }}</td>
                <td>
                    @if($g->user)
                    <div style="font-weight: 700; color: #fff;">{{ $g->user->name }}</div>
                    <div style="font-size: 11px; color: var(--text-muted);">{{ $g->user->email }}</div>
                    @else
                    <span class="badge-pill" style="font-size: 10px;">Guest User</span>
                    <div style="font-size: 10px; font-family: monospace; color: var(--text-muted);">{{ $g->ip_address }}</div>
                    @endif
                </td>
                <td>
                    <span class="badge-pill-{{ in_array($g->tool, ['linkedin', 'twitter', 'instagram']) ? 'cyan' : 'emerald' }}" style="font-size: 11px;">
                        {{ strtoupper($g->tool) }}
                    </span>
                </td>
                <td style="color: #e2e8f0; font-size: 13px;">
                    {{ Str::limit($g->topic, 65) }}
                </td>
                <td style="font-weight: 600; color: #f8fafc;">
                    {{ $g->word_count }} words
                </td>
                <td>
                    <span class="badge-pill" style="font-size: 10px;">{{ $g->provider }}</span>
                </td>
                <td style="color: var(--text-muted); font-size: 12px;">{{ $g->created_at->format('M d, Y H:i:s') }}</td>
                <td>
                    <button onclick="viewGenerationContent('{{ $g->id }}', '{{ addslashes(Str::limit($g->topic, 40)) }}', `{{ addslashes($g->content) }}`)" class="btn-secondary" style="padding: 5px 10px; font-size: 11px;">
                        Preview 👁️
                    </button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

{{-- Content Viewer Modal --}}
<div id="gen-modal" style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.85); backdrop-filter: blur(10px); z-index: 1000; align-items: center; justify-content: center; padding: 20px;">
    <div class="glass-panel-glow" style="max-width: 700px; width: 100%; max-height: 80vh; display: flex; flex-direction: column; padding: 28px;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px;">
            <h3 id="gen-modal-title" style="font-size: 17px; color: #fff;">Generation Preview</h3>
            <button onclick="closeGenModal()" style="background: none; border: none; color: #94a3b8; font-size: 20px; cursor: pointer;">✕</button>
        </div>

        <div id="gen-modal-body" class="result-box" style="flex: 1; overflow-y: auto; max-height: 450px; font-size: 14px; line-height: 1.6;">
            <!-- Dynamic Content -->
        </div>

        <div style="display: flex; justify-content: flex-end; margin-top: 16px;">
            <button onclick="closeGenModal()" class="btn-secondary" style="padding: 8px 16px;">Close Window</button>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    function viewGenerationContent(id, topic, content) {
        document.getElementById('gen-modal-title').textContent = `#GEN-${id} • ${topic}`;
        document.getElementById('gen-modal-body').textContent = content;
        document.getElementById('gen-modal').style.display = 'flex';
    }

    function closeGenModal() {
        document.getElementById('gen-modal').style.display = 'none';
    }
</script>
@endsection
