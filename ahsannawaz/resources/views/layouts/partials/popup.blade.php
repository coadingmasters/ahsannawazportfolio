{{-- ══════════════════════════════════════
     FRONTEND POPUP
     Centered, animated feedback for form results.
     Include once per page, then call Popup.success() / Popup.error().
══════════════════════════════════════ --}}

<div class="pop-backdrop" id="pop" role="alertdialog" aria-modal="true" aria-labelledby="pop-title" hidden>
    <div class="pop">
        <button type="button" class="pop-close" data-pop-dismiss aria-label="Close">✕</button>

        <div class="pop-ico">
            {{-- Success tick (draws itself) --}}
            <svg class="pop-tick" viewBox="0 0 24 24" aria-hidden="true">
                <path d="M4 12.5l5 5L20 6.5"/>
            </svg>
            {{-- Error mark --}}
            <span class="pop-bang" aria-hidden="true">!</span>
        </div>

        <h3 class="pop-title" id="pop-title"></h3>
        <p class="pop-text" id="pop-text"></p>

        {{-- Populated when there are several validation errors --}}
        <ul class="pop-list" id="pop-list" hidden></ul>

        <button type="button" class="pop-btn" data-pop-dismiss id="pop-btn">Got it</button>

        <span class="pop-timer" id="pop-timer"></span>
    </div>
</div>

{{-- Server-side results handed to JS without inlining a script --}}
@if (session('contact_success'))
    <template id="pop-flash-success">{{ session('contact_success') }}</template>
@endif

@if ($errors->any())
    <template id="pop-flash-errors">@json($errors->all())</template>
@endif
