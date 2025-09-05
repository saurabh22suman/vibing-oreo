@extends('layouts.app')

@section('content')
<main>
    <div class="mx-auto max-w-7xl px-0 py-12">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-semibold tracking-tight text-white">Featured Apps</h2>
            <div class="flex items-center gap-2"><span class="text-xs text-zinc-500">{{ $apps->count() }} apps</span></div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach($apps as $app)
            <a href="{{ $app->link ?: route('apps.show', $app->id) }}" target="_blank" rel="noopener noreferrer" class="group relative rounded-2xl border border-white/10 bg-white/[0.035] hover:bg-white/[0.06] transition-colors overflow-hidden ring-0 hover:ring-1 hover:ring-indigo-500/40 focus:outline-none focus-visible:ring-2 focus-visible:ring-indigo-500/70">
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
                        <span class="inline-flex items-center gap-1.5 text-sm text-indigo-300 group-hover:text-indigo-200 transition-colors">Open <i data-lucide="arrow-up-right" class="h-4 w-4 stroke-[1.5]"></i></span>
                    </div>
                </div>
            </a>
            @endforeach
        </div>
    </div>
</main>

@endsection
