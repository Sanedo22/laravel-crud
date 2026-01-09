@extends('admin.layouts.app')

@section('content')

<div class="container mt-5">

    <h2 class="mb-4 text-center">Edit Student</h2>

    <div class="card shadow-sm">
        <div class="card-body">

            <form action="{{ route('students-update', $students->id) }}" method="POST" enctype="multipart/form-data">
                @csrf

                {{-- Name --}}
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input
                        type="text"
                        id="name"
                        name="name"
                        class="form-control @error('name') is-invalid @enderror"
                        value="{{ old('name', $students->name) }}"
                    >
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Email --}}
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        class="form-control @error('email') is-invalid @enderror"
                        value="{{ old('email', $students->email) }}"
                    >
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Age --}}
                <div class="mb-3">
                    <label for="age" class="form-label">Age</label>
                    <input
                        type="number"
                        id="age"
                        name="age"
                        class="form-control @error('age') is-invalid @enderror"
                        value="{{ old('age', $students->age) }}"
                    >
                    @error('age')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Image --}}
                <div class="mb-3">
                    <label for="image" class="form-label">Profile Image</label>
                    <input
                        type="file"
                        id="image"
                        name="image"
                        class="form-control @error('image') is-invalid @enderror"
                    >
                    @error('image')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror

                    @if($students->image)
                        <div class="mt-2">
                            <p>Current Image:</p>
                            <img src="{{ asset('storage/' . $students->image) }}" width="100" class="img-thumbnail" alt="Student Image">
                        </div>
                    @endif
                </div>

                {{-- Buttons --}}
                <div class="d-flex justify-content-between">
                    <a href="{{ route('students-index') }}" class="btn btn-secondary">
                        Back
                    </a>

                    <button type="submit" class="btn btn-primary px-4">
                        Update Student
                    </button>
                </div>

            </form>

        </div>
    </div>

</div>

@endsection
