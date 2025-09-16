@extends('layouts.app')

@section('content')
    <div class="mx-auto max-w-7xl px-0 py-12">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-semibold tracking-tight text-white">Featured Work</h2>
            <div class="flex items-center gap-2"><span class="text-xs text-zinc-500">{{ $apps->count() }} apps</span></div>
        </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                        @foreach($apps as $app)
                        @php
                            $__appData = json_encode([
                                'id' => $app->id,
                                'title' => $app->title,
                                'description' => $app->description,
                                'image' => $app->image,
                                'link' => $app->link,
                                'category' => $app->category,
                            ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
                        @endphp
            <div
                                role="button"
                                tabindex="0"
                                data-app="{{ e($__appData) }}"
                                class="group relative rounded-2xl border border-white/10 bg-white/[0.035] hover:bg-white/[0.06] transition-colors overflow-hidden ring-0 hover:ring-1 hover:ring-indigo-500/40 focus:outline-none focus-visible:ring-2 focus-visible:ring-indigo-500/70 cursor-pointer"
                        >
                <div class="p-4">
                    <div class="flex items-start gap-3">
                        <div class="h-12 w-12 overflow-hidden rounded-xl ring-1 ring-inset ring-white/10 bg-gray-800">
                            @php
                                // Determine a safe image URL: prefer a local file under public, allow full external URLs,
                                // otherwise fall back to the bundled placeholder to avoid 404s.
                                $imgSrc = asset('assets/images/placeholder.png');
                                if (!empty($app->image)) {
                                    // if user stored a full URL, trust it
                                    if (filter_var($app->image, FILTER_VALIDATE_URL)) {
                                        $imgSrc = $app->image;
                                    } else {
                                        // normalize path and check for file existence in public
                                        $candidate = ltrim($app->image, '/');
                                        if (file_exists(public_path($candidate))) {
                                            $imgSrc = asset($candidate);
                                        } elseif (file_exists(public_path('assets/images/' . $candidate))) {
                                            $imgSrc = asset('assets/images/' . $candidate);
                                        }
                                    }
                                }
                            @endphp
                            <img src="{{ $imgSrc }}" alt="{{ $app->title }}" class="h-full w-full object-cover" />
                        </div>
                        <div class="min-w-0">
                            <div class="flex items-center gap-2">
                                <h3 class="truncate text-base font-semibold tracking-tight text-white">{{ $app->title }}</h3>
                                @if($app->category)
                                    <span class="inline-flex items-center rounded-full border border-emerald-400/30 text-emerald-300/90 bg-emerald-400/10 px-2 py-0.5 text-[10px]">{{ $app->category }}</span>
                                @endif
                            </div>
                            <p class="mt-1 text-sm text-zinc-400">{{ \Illuminate\Support\Str::limit($app->description, 120) }}</p>
                        </div>
                    </div>
                    <div class="mt-4 flex items-center justify-between border-t border-white/10 pt-4">
                        <div class="flex items-center gap-2 text-xs text-zinc-400"><i data-lucide="globe" class="h-4 w-4 stroke-[1.5]"></i> {{ parse_url($app->link ?? '', PHP_URL_HOST) ?? 'external' }}</div>
                                                <span class="inline-flex items-center gap-1.5 text-sm text-indigo-300 group-hover:text-indigo-200 transition-colors">Details <i data-lucide="eye" class="h-4 w-4 stroke-[1.5]"></i></span>
                    </div>
                </div>
                        </div>
            @endforeach
        </div>
    </div>

<!-- App Details Modal -->
<div id="app-modal" class="fixed inset-0 z-[60]" style="display:none">
    <div id="app-modal-overlay" class="absolute inset-0 bg-black/60 backdrop-blur-sm"></div>
    <div class="relative mx-auto w-[92vw] max-w-2xl mt-24 bg-zinc-900/95 border border-white/10 rounded-2xl shadow-2xl">
    <button id="app-modal-close" type="button" aria-label="Close dialog" title="Close"
        class="absolute top-3 right-3 z-10 h-8 w-8 rounded-full bg-zinc-800 border border-white/10 text-zinc-300 hover:text-white hover:bg-zinc-700 flex items-center justify-center">×</button>
    <div class="modal-header-space"></div>
        <div class="p-6">
            <div class="flex items-start gap-4">
                <div class="h-14 w-14 overflow-hidden rounded-xl ring-1 ring-inset ring-white/10 bg-gray-800" id="app-modal-thumb"></div>
                <div class="min-w-0">
                    <h3 id="app-modal-title" class="text-lg font-semibold tracking-tight text-white"></h3>
                    <p id="app-modal-host" class="text-xs text-zinc-400"></p>
                </div>
            </div>
            <div id="app-modal-body" class="prose prose-invert mt-4 text-sm text-zinc-200 max-h-[48vh] overflow-y-auto"></div>
            <div class="mt-6 flex items-center justify-end gap-3 border-t border-white/10 pt-4">
                <button id="app-modal-cancel" type="button" class="inline-flex items-center gap-1.5 rounded-lg border border-white/10 bg-white/[0.02] px-3.5 py-2 text-sm text-zinc-300 hover:text-white hover:bg-white/[0.06]">Close</button>
                <a id="app-modal-open" href="#" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-1.5 rounded-lg border border-indigo-400/30 bg-indigo-500/10 px-3.5 py-2 text-sm text-indigo-200 hover:text-white hover:bg-indigo-500/20">Open <i data-lucide="arrow-up-right" class="h-4 w-4 stroke-[1.5]"></i></a>
            </div>
        </div>
    </div>
    <style>
    /* Ensure modal header area has room for top-right X */
    #app-modal .modal-header-space { height: 0.25rem; }
        .prose :where(pre, code){ background: rgba(255,255,255,0.05); border-radius: 6px; padding: .15rem .35rem }
        .prose :where(ul){ list-style: disc; padding-left: 1.25rem }
        .prose :where(ol){ list-style: decimal; padding-left: 1.25rem }
        .prose :where(a){ color: #a5b4fc; text-decoration: underline }
    </style>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function(){
    const modal = document.getElementById('app-modal');
    const overlay = document.getElementById('app-modal-overlay');
    const closeBtn = document.getElementById('app-modal-close');
    const cancelBtn = document.getElementById('app-modal-cancel');
    const titleEl = document.getElementById('app-modal-title');
    const hostEl = document.getElementById('app-modal-host');
    const bodyEl = document.getElementById('app-modal-body');
    const thumbEl = document.getElementById('app-modal-thumb');
    const openEl = document.getElementById('app-modal-open');

    function openModal(){ modal.style.display = 'block'; }
    function closeModal(){ modal.style.display = 'none'; }

    function renderMarkdown(md){
        try{
            if (window.marked) {
                const rawHtml = window.marked.parse(md || '');
                return window.DOMPurify ? window.DOMPurify.sanitize(rawHtml) : rawHtml;
            }
        }catch(e){ console.warn('markdown render failed', e); }
        return (md||'').replace(/[<>&]/g, c => ({'<':'&lt;','>':'&gt;','&':'&amp;'}[c]));
    }

    function safeThumb(src){
        if(!src) return `<img src="${@json(asset('assets/images/placeholder.png'))}" class="h-full w-full object-cover"/>`;
        try{
            const url = new URL(src, window.location.origin);
            return `<img src="${url.href}" class="h-full w-full object-cover"/>`;
        }catch{ return `<img src="${@json(asset('assets/images/placeholder.png'))}" class="h-full w-full object-cover"/>`; }
    }

    document.querySelectorAll('[data-app]')?.forEach(card => {
        function handleOpen(){
            let raw = card.getAttribute('data-app');
            // In case any HTML entities slipped in, decode them before parsing
            try {
                const ta = document.createElement('textarea');
                ta.innerHTML = raw;
                raw = ta.value;
            } catch(_) {}
            try {
                const data = JSON.parse(raw);
                titleEl.textContent = data.title || '';
                try{ hostEl.textContent = data.link ? (new URL(data.link)).host : ''; }catch{ hostEl.textContent = ''; }
                bodyEl.innerHTML = renderMarkdown(data.description || '');
                thumbEl.innerHTML = safeThumb(data.image);
                openEl.href = data.link || '#';
                openEl.style.display = data.link ? 'inline-flex' : 'none';
                openModal();
            } catch(e) {
                console.error('Failed to parse app data', { raw, error: e });
            }
        }
        card.addEventListener('click', handleOpen);
        card.addEventListener('keydown', (e)=>{ if(e.key === 'Enter' || e.key === ' ') { e.preventDefault(); handleOpen(); }});
    });

    [overlay, closeBtn, cancelBtn].forEach(el => el && el.addEventListener('click', closeModal));
});
</script>
@endpush

@endsection
