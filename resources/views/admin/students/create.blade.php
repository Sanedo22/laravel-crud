@extends('admin.layouts.app')

@section('content')
<h2> Add New Student </h2>
<form action="{{route('students-store')}}" method="POST">
    @csrf
    <label for="name">Name:</label>
    <input type="text" id="name" name="name" >
    @error('name')
        {{$message}}
    @enderror<br><br>

    <label for="email">Email:</label>
    <input type="email" id="email" name="email" >
    @error("email")
        {{$message}}        
    @enderror<br><br>

    <label for="age">Age:</label>
    <input type="number" id="age" name="age" >
    @error('age')
        {{$message}}
    @enderror<br><br>

    <button type="submit">Add Student</button>

 </form>

@endsection