@extends('admin.layouts.app')

@section('content')

<div class="container mt-5">

    <h2 class="mb-4 text-center">Edit Teacher</h2>

    <div class="card shadow-sm">
        <div class="card-body">

            <form action="{{ route('teachers-update', $teacher->id) }}" method="POST">
                @csrf

                {{-- Name --}}
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input
                        type="text"
                        id="name"
                        name="name"
                        class="form-control @error('name') is-invalid @enderror"
                        value="{{ old('name', $teacher->name) }}"
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
                        value="{{ old('email', $teacher->email) }}"
                    >
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Subject --}}
                <div class="mb-3">
                    <label for="subject" class="form-label">Subject</label>
                    <input
                        type="text"
                        id="subject"
                        name="subject"
                        class="form-control @error('subject') is-invalid @enderror"
                        value="{{ old('subject', $teacher->subject) }}"
                    >
                    @error('subject')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Buttons --}}
                <div class="d-flex justify-content-between">
                    <a href="{{ route('teachers-index') }}" class="btn btn-secondary">
                        Back
                    </a>

                    <button type="submit" class="btn btn-primary px-4">
                        Update Teacher
                    </button>
                </div>

            </form>

        </div>
    </div>

</div>

@endsection
