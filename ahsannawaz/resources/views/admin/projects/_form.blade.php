{{-- Shared create/edit form. Expects $project (may be null) --}}
@php
    $project = $project ?? null;
    $stackValue = old('tech_stack', $project ? implode(', ', $project->tech_stack ?? []) : '');
@endphp

@csrf
@if ($project)
    @method('PUT')
@endif

<div class="form-grid">

    <div class="field span-2">
        <label for="title">Title *</label>
        <input id="title" class="input" type="text" name="title"
               value="{{ old('title', $project->title ?? '') }}"
               placeholder="SaaS CRM Platform" maxlength="200" required autofocus>
        @error('title') <div class="field-error">{{ $message }}</div> @enderror
    </div>

    <div class="field span-2">
        <label for="description">Description *</label>
        <textarea id="description" class="input" name="description"
                  placeholder="What the project does, the stack, and your role." required>{{ old('description', $project->description ?? '') }}</textarea>
        @error('description') <div class="field-error">{{ $message }}</div> @enderror
    </div>

    <div class="field">
        <label for="category">Category *</label>
        <select id="category" class="input" name="category" required>
            @foreach (['web', 'mobile', 'api', 'wordpress'] as $cat)
                <option value="{{ $cat }}" @selected(old('category', $project->category ?? 'web') === $cat)>
                    {{ ucfirst($cat) }}
                </option>
            @endforeach
        </select>
        @error('category') <div class="field-error">{{ $message }}</div> @enderror
    </div>

    <div class="field">
        <label for="sort_order">Sort Order</label>
        <input id="sort_order" class="input" type="number" name="sort_order"
               value="{{ old('sort_order', $project->sort_order ?? 0) }}" min="0">
        <div class="hint">Lower numbers appear first.</div>
        @error('sort_order') <div class="field-error">{{ $message }}</div> @enderror
    </div>

    <div class="field span-2">
        <label for="tech_stack">Tech Stack</label>
        <input id="tech_stack" class="input" type="text" name="tech_stack"
               value="{{ $stackValue }}"
               placeholder="Laravel, React, MySQL">
        <div class="hint">Separate each technology with a comma.</div>
        @error('tech_stack') <div class="field-error">{{ $message }}</div> @enderror
    </div>

    <div class="field">
        <label for="live_url">Live URL</label>
        <input id="live_url" class="input" type="url" name="live_url"
               value="{{ old('live_url', $project->live_url ?? '') }}"
               placeholder="https://example.com" maxlength="500">
        @error('live_url') <div class="field-error">{{ $message }}</div> @enderror
    </div>

    <div class="field">
        <label for="github_url">GitHub URL</label>
        <input id="github_url" class="input" type="url" name="github_url"
               value="{{ old('github_url', $project->github_url ?? '') }}"
               placeholder="https://github.com/user/repo" maxlength="500">
        @error('github_url') <div class="field-error">{{ $message }}</div> @enderror
    </div>

    <div class="field span-2">
        <label for="image">Cover Image</label>
        <input id="image" class="input" type="file" name="image" accept="image/jpeg,image/png,image/webp">
        <div class="hint">JPG, PNG or WebP · max 2 MB{{ $project && $project->image ? ' · uploading replaces the current image' : '' }}</div>
        @error('image') <div class="field-error">{{ $message }}</div> @enderror

        <img id="image-preview"
             src="{{ $project?->image_url }}"
             alt="Current cover"
             class="preview-img"
             @style(['display:none' => !$project])>
    </div>

    <div class="field">
        <label class="check" style="padding-top:0.5rem">
            <input type="hidden" name="is_featured" value="0">
            <input type="checkbox" name="is_featured" value="1"
                   @checked(old('is_featured', $project->is_featured ?? false))>
            <span>★ Feature this project</span>
        </label>
    </div>

    <div class="field">
        <label class="check" style="padding-top:0.5rem">
            <input type="hidden" name="is_active" value="0">
            <input type="checkbox" name="is_active" value="1"
                   @checked(old('is_active', $project->is_active ?? true))>
            <span>Show on the portfolio</span>
        </label>
    </div>

</div>

<div class="form-actions">
    <a href="{{ route('admin.projects.index') }}" class="btn btn-ghost">Cancel</a>
    <button type="submit" class="btn btn-primary">
        {{ $project ? 'Save Changes' : 'Create Project' }}
    </button>
</div>

@push('scripts')
<script>
// Preview the chosen cover image before upload.
document.getElementById('image').addEventListener('change', function (e) {
    var file = e.target.files[0];
    var preview = document.getElementById('image-preview');
    if (!file) return;
    preview.src = URL.createObjectURL(file);
    preview.style.display = 'block';
});
</script>
@endpush
