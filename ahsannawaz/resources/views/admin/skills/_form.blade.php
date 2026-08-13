{{-- Shared create/edit form. Expects $skill (may be null) --}}
@php
    $skill = $skill ?? null;
    $gradients = [
        'linear-gradient(90deg,#F97316,var(--accent-hover))' => 'Orange',
        'linear-gradient(90deg,#7c3aed,#a78bfa)' => 'Purple',
        'linear-gradient(90deg,#2563eb,#60a5fa)' => 'Blue',
        'linear-gradient(90deg,#0891b2,#22d3ee)' => 'Cyan',
        'linear-gradient(90deg,#059669,#34d399)' => 'Green',
        'linear-gradient(90deg,#b45309,#fbbf24)' => 'Amber',
        'linear-gradient(90deg,#4338ca,#818cf8)' => 'Indigo',
    ];
    $currentGradient = old('color_gradient', $skill->color_gradient ?? 'linear-gradient(90deg,#F97316,var(--accent-hover))');
@endphp

@csrf
@if ($skill)
    @method('PUT')
@endif

<div class="form-grid">

    <div class="field">
        <label for="name">Skill Name *</label>
        <input id="name" class="input" type="text" name="name"
               value="{{ old('name', $skill->name ?? '') }}"
               placeholder="Laravel" maxlength="100" required autofocus>
        @error('name') <div class="field-error">{{ $message }}</div> @enderror
    </div>

    <div class="field">
        <label for="category">Category *</label>
        <select id="category" class="input" name="category" required>
            @foreach (['backend', 'frontend', 'cms', 'database', 'tools'] as $cat)
                <option value="{{ $cat }}" @selected(old('category', $skill->category ?? '') === $cat)>
                    {{ ucfirst($cat) }}
                </option>
            @endforeach
        </select>
        @error('category') <div class="field-error">{{ $message }}</div> @enderror
    </div>

    <div class="field">
        <label for="level">Level *</label>
        <select id="level" class="input" name="level" required>
            @foreach (['expert', 'advanced', 'good'] as $lvl)
                <option value="{{ $lvl }}" @selected(old('level', $skill->level ?? 'advanced') === $lvl)>
                    {{ ucfirst($lvl) }}
                </option>
            @endforeach
        </select>
        @error('level') <div class="field-error">{{ $message }}</div> @enderror
    </div>

    <div class="field">
        <label for="percentage">Proficiency % *</label>
        <input id="percentage" class="input" type="number" name="percentage"
               value="{{ old('percentage', $skill->percentage ?? 80) }}"
               min="1" max="100" required>
        <div class="hint">Drives the progress bar width on the portfolio (1–100).</div>
        @error('percentage') <div class="field-error">{{ $message }}</div> @enderror
    </div>

    <div class="field">
        <label for="icon">Icon *</label>
        <input id="icon" class="input" type="text" name="icon"
               value="{{ old('icon', $skill->icon ?? '⚡') }}"
               placeholder="🔥" maxlength="10" required>
        <div class="hint">A single emoji works best.</div>
        @error('icon') <div class="field-error">{{ $message }}</div> @enderror
    </div>

    <div class="field">
        <label for="color">Accent Color *</label>
        <input id="color" class="input" type="color" name="color"
               value="{{ old('color', $skill->color ?? '#F97316') }}" required>
        @error('color') <div class="field-error">{{ $message }}</div> @enderror
    </div>

    <div class="field span-2">
        <label for="color_gradient">Bar Gradient *</label>
        <select id="color_gradient" class="input" name="color_gradient" required>
            @foreach ($gradients as $value => $label)
                <option value="{{ $value }}" @selected($currentGradient === $value)>{{ $label }}</option>
            @endforeach
        </select>
        <div class="bar" style="width:100%;height:8px;margin-top:0.6rem">
            <i id="gradient-preview" style="width:{{ old('percentage', $skill->percentage ?? 80) }}%;background:{{ $currentGradient }}"></i>
        </div>
        @error('color_gradient') <div class="field-error">{{ $message }}</div> @enderror
    </div>

    <div class="field">
        <label for="sort_order">Sort Order</label>
        <input id="sort_order" class="input" type="number" name="sort_order"
               value="{{ old('sort_order', $skill->sort_order ?? 0) }}" min="0">
        <div class="hint">Lower numbers appear first.</div>
        @error('sort_order') <div class="field-error">{{ $message }}</div> @enderror
    </div>

    <div class="field" style="display:flex;align-items:flex-end">
        <label class="check" style="padding-bottom:0.7rem">
            <input type="hidden" name="is_active" value="0">
            <input type="checkbox" name="is_active" value="1"
                   @checked(old('is_active', $skill->is_active ?? true))>
            <span>Show this skill on the portfolio</span>
        </label>
    </div>

</div>

<div class="form-actions">
    <a href="{{ route('admin.skills.index') }}" class="btn btn-ghost">Cancel</a>
    <button type="submit" class="btn btn-primary">
        {{ $skill ? 'Save Changes' : 'Create Skill' }}
    </button>
</div>

@push('scripts')
<script>
// Keep the gradient/percentage preview in sync with the inputs.
var gradSelect = document.getElementById('color_gradient');
var pctInput = document.getElementById('percentage');
var preview = document.getElementById('gradient-preview');

gradSelect.addEventListener('change', function () {
    preview.style.background = gradSelect.value;
});

pctInput.addEventListener('input', function () {
    var v = Math.max(0, Math.min(100, Number(pctInput.value) || 0));
    preview.style.width = v + '%';
});
</script>
@endpush
