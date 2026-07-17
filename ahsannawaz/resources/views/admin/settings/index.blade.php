@extends('admin.layout')

@section('title', 'Settings')
@section('heading', 'Settings')
@section('crumb', 'Site-wide options')

@section('content')

    <div class="card" style="max-width:720px">
        <div class="card-head">
            <h2>📄 Curriculum Vitae</h2>
            @if ($cvPath)
                <span class="badge" style="color:var(--green)">● Live</span>
            @else
                <span class="badge badge-muted">Not uploaded</span>
            @endif
        </div>

        <p class="hint" style="margin-bottom:1.4rem">
            Upload your CV as a PDF. Every <b>Download CV</b> button on the site links to it automatically.
            While no CV is uploaded, those buttons stay hidden.
        </p>

        @if ($cvPath)
            {{-- Current file --}}
            <div class="cv-current">
                <span class="cv-ico">PDF</span>

                <div class="cv-meta">
                    <span class="cv-name">{{ $cvName }}</span>
                    <span class="cv-sub">
                        {{ $cvSize ? number_format($cvSize / 1024, 0) . ' KB' : '' }}
                        @if ($cvUploadedAt)
                            · uploaded {{ \Carbon\Carbon::parse($cvUploadedAt)->diffForHumans() }}
                        @endif
                    </span>
                </div>

                <div class="cv-actions">
                    <a href="{{ route('cv.download') }}" target="_blank" rel="noopener" class="btn btn-ghost btn-sm">↓ Download</a>
                    <form method="POST" action="{{ route('admin.settings.cv.delete') }}"
                          data-confirm="Remove the current CV? The Download CV buttons will disappear from the site.">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">Remove</button>
                    </form>
                </div>
            </div>
        @endif

        {{-- Upload --}}
        <form method="POST" action="{{ route('admin.settings.cv.upload') }}" enctype="multipart/form-data">
            @csrf

            <div class="field">
                <label for="cv">{{ $cvPath ? 'Replace CV' : 'Upload CV' }}</label>
                <input id="cv" class="input" type="file" name="cv" accept="application/pdf" required>
                <div class="hint">PDF only · max 5 MB{{ $cvPath ? ' · this replaces the current file' : '' }}</div>
                @error('cv') <div class="field-error">{{ $message }}</div> @enderror
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">
                    {{ $cvPath ? 'Replace CV' : 'Upload CV' }}
                </button>
            </div>
        </form>
    </div>

@endsection

@push('scripts')
<style>
.cv-current {
    display: flex;
    align-items: center;
    gap: 0.9rem;
    background: var(--surface2);
    border: 1px solid var(--border);
    border-radius: 12px;
    padding: 1rem 1.1rem;
    margin-bottom: 1.5rem;
    flex-wrap: wrap;
}
.cv-ico {
    width: 42px; height: 42px;
    flex-shrink: 0;
    display: grid; place-items: center;
    border-radius: 9px;
    background: rgba(248, 113, 113, 0.12);
    border: 1px solid rgba(248, 113, 113, 0.3);
    color: var(--red);
    font-size: 0.62rem;
    font-weight: 800;
    letter-spacing: 0.04em;
}
.cv-meta { flex: 1; min-width: 0; display: flex; flex-direction: column; gap: 2px; }
.cv-name {
    font-size: 0.88rem; font-weight: 600; color: var(--text);
    white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
}
.cv-sub { font-size: 0.74rem; color: var(--muted); }
.cv-actions { display: flex; gap: 0.4rem; flex-shrink: 0; }
</style>
@endpush
