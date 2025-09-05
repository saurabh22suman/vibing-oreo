@extends('layouts.app')

@section('content')
<div class="container" style="max-width:480px;margin:48px auto;">
    <h2>Sign in</h2>
    @if($errors->any())
        <div class="alert alert-danger">{{ $errors->first() }}</div>
    @endif

    <form method="POST" action="{{ route('login.attempt') }}">
        @csrf
        <div class="form-group">
            <label for="email">Email</label>
            <input id="email" name="email" type="email" class="form-control" value="{{ old('email') }}" required />
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input id="password" name="password" type="password" class="form-control" required />
        </div>
        <div style="margin-top:12px;">
            <button class="btn btn-primary" type="submit">Sign in</button>
        </div>
    </form>
</div>
@endsection
