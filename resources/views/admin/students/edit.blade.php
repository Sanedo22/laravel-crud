@extends('admin.layouts.app')

@section('content')

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<form action="{{route('students-update', $students->id)}}" method="POST">
    @csrf
    <label for="name">Name:</label>
    <input type="text" id="name" name="name" value="{{$students->name}}">
    @if ($errors->has('name'))
        @error('name')
        {{$message}}
    @enderror
    @endif
    <br><br>

    <label for="email">Email:</label>
    <input type="email" id="email" name="email" value="{{$students->email}}">
    @if ($errors->has('email'))
        @error('email')
        {{$message}}
    @enderror
    @endif<br><br>


    <label for="age">Age:</label>
    <input type="number" id="age" name="age" value="{{$students->age}}">
    @if ($errors->has('age'))
        @error('age')
        {{$message}}
    @enderror
    @endif<br><br>

    <button type="submit">Update Student</button>

 </form>

 @endsection