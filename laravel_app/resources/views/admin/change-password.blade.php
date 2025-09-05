@extends('layouts.app')

@section('content')
<div class="container" style="max-width:560px">
    <h2>Change Password</h2>

    @if ($errors->any())
        <div class="alert">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if(session('success'))
        <div class="alert success">{{ session('success') }}</div>
    @endif

    <form method="POST" action="{{ route('admin.changePassword') }}">
        @csrf
        <label>Current Password<input type="password" name="current_password" required></label>
        <label>New Password<input type="password" name="password" required></label>
        <label>Confirm New Password<input type="password" name="password_confirmation" required></label>
        <div style="margin-top:12px">
            <button class="btn" type="submit">Update Password</button>
            <a class="btn" href="{{ route('admin.dashboard') }}" style="margin-left:8px">Back</a>
        </div>
    </form>
</div>
@endsection
