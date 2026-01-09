@extends('admin.layouts.app')

@section('content')

<div class="container mt-5">

    <h2 class="mb-4 text-center">Add New Teacher</h2>

    <div class="card shadow-sm">
        <div class="card-body">

            <form action="{{ route('teachers-store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                {{-- Name --}}
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input
                        type="text"
                        id="name"
                        name="name"
                        class="form-control @error('name') is-invalid @enderror"
                        value="{{ old('name') }}"
                        placeholder="Enter teacher name"
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
                        value="{{ old('email') }}"
                        placeholder="Enter email address"
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
                        value="{{ old('subject') }}"
                        placeholder="Enter subject"
                    >
                    @error('subject')
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
                </div>

                {{-- Submit --}}
                <div class="text-center">
                    <button type="submit" class="btn btn-primary px-4">
                        Add Teacher
                    </button>
                </div>

            </form>

        </div>
    </div>

</div>

@endsection
