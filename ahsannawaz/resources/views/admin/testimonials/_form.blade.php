{{-- Shared create/edit form. Expects $testimonial. --}}
@csrf
@if ($testimonial->exists) @method('PUT') @endif

<div class="form-grid">
    <div class="field">
        <label for="name">Client name *</label>
        <input id="name" class="input" type="text" name="name" required autofocus maxlength="120"
               value="{{ old('name', $testimonial->name) }}" placeholder="John Smith">
        @error('name') <div class="field-error">{{ $message }}</div> @enderror
    </div>

    <div class="field">
        <label for="role">Role</label>
        <input id="role" class="input" type="text" name="role" maxlength="120"
               value="{{ old('role', $testimonial->role) }}" placeholder="Business Owner">
    </div>

    <div class="field">
        <label for="company">Company</label>
        <input id="company" class="input" type="text" name="company" maxlength="120"
               value="{{ old('company', $testimonial->company) }}" placeholder="Acme Ltd">
    </div>

    <div class="field">
        <label for="source">Where from</label>
        <select id="source" class="input" name="source">
            <option value="">—</option>
            @foreach (['Fiverr', 'Upwork', 'LinkedIn', 'Direct'] as $src)
                <option value="{{ $src }}" @selected(old('source', $testimonial->source) === $src)>{{ $src }}</option>
            @endforeach
        </select>
    </div>

    <div class="field span-2">
        <label for="quote">What they said *</label>
        <textarea id="quote" class="input" name="quote" rows="4" required maxlength="1000"
                  placeholder="Paste the review exactly as they wrote it.">{{ old('quote', $testimonial->quote) }}</textarea>
        @error('quote') <div class="field-error">{{ $message }}</div> @enderror
    </div>

    <div class="field">
        <label for="rating">Rating *</label>
        <select id="rating" class="input" name="rating" required>
            @for ($i = 5; $i >= 1; $i--)
                <option value="{{ $i }}" @selected((int) old('rating', $testimonial->rating ?: 5) === $i)>
                    {{ str_repeat('★', $i) }} ({{ $i }})
                </option>
            @endfor
        </select>
    </div>

    <div class="field">
        <label for="sort_order">Order</label>
        <input id="sort_order" class="input" type="number" name="sort_order" min="0"
               value="{{ old('sort_order', $testimonial->sort_order ?: 0) }}">
        <div class="field-hint">Lower shows first.</div>
    </div>

    <div class="field span-2">
        <label for="avatar">Photo</label>
        <input id="avatar" class="input" type="file" name="avatar" accept="image/*">
        <div class="field-hint">Optional — without one their initials are shown in a circle.</div>
        @if ($testimonial->avatar_url)
            <img src="{{ $testimonial->avatar_url }}" alt="" class="thumb"
                 style="margin-top:.5rem;width:56px;height:56px;border-radius:50%">
        @endif
    </div>

    <div class="field span-2">
        <label class="check-inline">
            <input type="checkbox" name="is_active" value="1"
                   @checked(old('is_active', $testimonial->exists ? $testimonial->is_active : true))>
            Show on the site
        </label>
    </div>
</div>

<div class="form-actions">
    <a href="{{ route('admin.testimonials.index') }}" class="btn btn-ghost">Cancel</a>
    <button type="submit" class="btn btn-primary">{{ $testimonial->exists ? 'Save changes' : 'Add testimonial' }}</button>
</div>
