@extends('layouts.app')

@section('content')
<form method="POST" action="{{ route('admin.store') }}" enctype="multipart/form-data">
    @csrf
    <label>Title<input type="text" name="title" required></label>
    <label>Description<textarea name="description"></textarea></label>
    <label>Image<input type="file" name="image"></label>
    <label>Link<input type="url" name="link"></label>
    <label>Category<input type="text" name="category"></label>
    <button class="btn" type="submit">Create</button>
</form>
@endsection
