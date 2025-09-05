@extends('layouts.app')

@section('content')
<form method="POST" action="{{ route('admin.update', $app->id) }}" enctype="multipart/form-data">
    @csrf
    <label>Title<input type="text" name="title" value="{{ $app->title }}" required></label>
    <label>Description<textarea name="description">{{ $app->description }}</textarea></label>
    <label>Image<input type="file" name="image"></label>
    <label>Link<input type="url" name="link" value="{{ $app->link }}"></label>
    <label>Category<input type="text" name="category" value="{{ $app->category }}"></label>
    <button class="btn" type="submit">Update</button>
</form>
@endsection
