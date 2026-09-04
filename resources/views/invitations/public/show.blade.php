@extends('invitations.layouts.invitation-public')

@section('content')
    {{-- Dynamically Render Configured Sections --}}
    @foreach($invitation->sections as $section)
        @if(view()->exists('invitations.sections.' . $section->section_type))
            <div id="section-wrapper-{{ $section->id }}" 
                 class="invitation-section-wrapper" 
                 data-section-id="{{ $section->id }}" 
                 data-section-type="{{ $section->section_type }}" 
                 style="{{ $section->is_enabled ? '' : 'display: none;' }}">
                @include('invitations.sections.' . $section->section_type, ['section' => $section, 'invitation' => $invitation, 'guest' => $guest ?? null])
            </div>
        @endif
    @endforeach
@endsection
