{{-- Shared create/edit form. Expects $post. --}}
@csrf
@if ($post->exists) @method('PUT') @endif

<div class="form-grid">
    <div class="field span-2">
        <label for="title">Title *</label>
        <input id="title" class="input" type="text" name="title" required autofocus
               maxlength="180" placeholder="Building Scalable APIs with Laravel"
               value="{{ old('title', $post->title) }}">
        @error('title') <div class="field-error">{{ $message }}</div> @enderror
    </div>

    <div class="field span-2">
        <label for="slug">URL slug</label>
        <input id="slug" class="input" type="text" name="slug" maxlength="200"
               placeholder="left blank, built from the title"
               value="{{ old('slug', $post->slug) }}">
        <div class="field-hint">{{ url('/blog') }}/<b id="slug-preview">{{ $post->slug ?: 'your-post-title' }}</b></div>
        @error('slug') <div class="field-error">{{ $message }}</div> @enderror
    </div>

    <div class="field">
        <label for="category">Category *</label>
        <select id="category" class="input" name="category" required>
            @foreach (['laravel' => 'Laravel', 'php' => 'PHP', 'javascript' => 'JavaScript', 'wordpress' => 'WordPress', 'database' => 'Database', 'career' => 'Career'] as $v => $label)
                <option value="{{ $v }}" @selected(old('category', $post->category) === $v)>{{ $label }}</option>
            @endforeach
        </select>
    </div>

    <div class="field">
        <label for="read_minutes">Read time (minutes) *</label>
        <input id="read_minutes" class="input" type="number" name="read_minutes" min="1" max="60" required
               value="{{ old('read_minutes', $post->read_minutes ?: 3) }}">
    </div>

    <div class="field span-2">
        <label for="excerpt">Excerpt</label>
        <textarea id="excerpt" class="input" name="excerpt" rows="2" maxlength="500"
                  placeholder="One or two sentences. Shown on the blog card and used as the page's meta description.">{{ old('excerpt', $post->excerpt) }}</textarea>
        @error('excerpt') <div class="field-error">{{ $message }}</div> @enderror
    </div>

    <div class="field span-2">
        <label for="body">Body *</label>
        <textarea id="body" class="input" name="body" rows="16" required
                  placeholder="Write the article…">{{ old('body', $post->body) }}</textarea>
        <div class="field-hint">
            Formatting is saved as HTML and cleaned on save — only headings, lists,
            links, quotes and code survive, so a paste from Word cannot break the page.
        </div>
        @error('body') <div class="field-error">{{ $message }}</div> @enderror
    </div>

    <div class="field">
        <label for="published_at">Publish date</label>
        <input id="published_at" class="input" type="date" name="published_at"
               value="{{ old('published_at', optional($post->published_at)->format('Y-m-d')) }}">
    </div>

    <div class="field">
        <label for="image">Cover image</label>
        <input id="image" class="input" type="file" name="image" accept="image/*">
        @if ($post->image_url)
            <img src="{{ $post->image_url }}" alt="" class="thumb" style="margin-top:.5rem;width:120px;height:70px">
        @endif
        @error('image') <div class="field-error">{{ $message }}</div> @enderror
    </div>

    <div class="field span-2">
        <label class="check-inline">
            <input type="checkbox" name="is_published" value="1"
                   @checked(old('is_published', $post->exists ? $post->is_published : true))>
            Published — visible on the blog
        </label>
    </div>
</div>

<div class="form-actions">
    <a href="{{ route('admin.posts.index') }}" class="btn btn-ghost">Cancel</a>
    <button type="submit" class="btn btn-primary">{{ $post->exists ? 'Save changes' : 'Publish post' }}</button>
</div>

@push('scripts')
@js('js/editor.js')
<script>
// Show what the URL will look like while the title is typed.
(function () {
    const title = document.getElementById('title');
    const slug = document.getElementById('slug');
    const out = document.getElementById('slug-preview');
    const slugify = (s) => s.toLowerCase().trim()
        .replace(/[^a-z0-9\s-]/g, '').replace(/\s+/g, '-').replace(/-+/g, '-');
    const sync = () => { out.textContent = slugify(slug.value || title.value) || 'your-post-title'; };
    title.addEventListener('input', sync);
    slug.addEventListener('input', sync);
})();
</script>
@endpush
