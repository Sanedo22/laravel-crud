@extends('admin.layouts.app')

@section('content')
<h2> Add New teacher </h2>
<form action="{{route('teachers-store')}}" method="POST">
    @csrf
    <label for="name">Name:</label>
    <input type="text" id="name" name="name">
    @error('name')
        {{$message}}
    @enderror<br><br>


    <label for="email">Email:</label>
    <input type="email" id="email" name="email">
    @error('email')
        {{$message}}
    @enderror<br><br>

    <label for="subject">Subject:</label>
    <input type="text" id="subject" name="subject">
    @error('subject')
        {{$message}}
    @enderror<br><br>

    <button type="submit">Add Teacher</button>
</form>

@endsection