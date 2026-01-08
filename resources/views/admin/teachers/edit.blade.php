@extends('admin.layouts.app')

@section('content')

<form action="{{route('teachers-update', $teacher->id)}}" method="POST">
    @csrf
    <label for="name">Name:</label>
    <input type="text" id="name" name="name"  value="{{$teacher->name}}">
    @error('name')
        {{$message}}
    @enderror<br><br>

    <label for="email">Email:</label>
    <input type="email" id="email" name="email"  value="{{$teacher->email}}">
    @error('email')
        {{$message}}
    @enderror<br><br>

    <label for="subject">Subject:</label>
    <input type="text" id="subject" name="subject"  value="{{$teacher->subject}}">
    @error('subject')
        {{$message}}
    @enderror<br><br>

    <button type="submit">Update Teacher</button>
</form>
@endsection