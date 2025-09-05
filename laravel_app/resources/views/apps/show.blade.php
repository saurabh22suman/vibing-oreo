@extends('layouts.app')

@section('content')
<article class="app-detail">
    <div class="app-media">
        <img src="{{ $app->image ?? '/assets/images/placeholder.png' }}" alt="{{ $app->title }}">
    </div>
    <div class="app-meta">
        <h2>{{ $app->title }}</h2>
        <p>{{ $app->description }}</p>
        @if($app->link)
            <p><a href="{{ $app->link }}" target="_blank" rel="noopener">Open App</a></p>
        @endif
    </div>
</article>
@endsection
