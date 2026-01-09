@extends('admin.layouts.app')

@push('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
@endpush


@section('content')

<h2>Teachers</h2>

<a href="{{ route('teachers-create') }}" class="btn btn-success mb-3">
    Add New Teacher
</a>

<table class="table table-bordered" id="teachers-table">
    <thead>
        <tr>
            <th>SL</th>
            <th>Image</th>
            <th>Name</th>
            <th>Email</th>
            <th>Subject</th>
            <th>Actions</th>
        </tr>
    </thead>
</table>

@endsection


@push('scripts')

<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<script>
$(document).ready(function () {

    $('#teachers-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('teachers-data') }}",
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'image', name: 'image', orderable: false, searchable: false },
            { data: 'name', name: 'name' },
            { data: 'email', name: 'email' },
            { data: 'subject', name: 'subject' },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ]
    });

});


// Event delegation for Delete button
$(document).on('click', '.delete-btn', function() {
    var id = $(this).data('id');
    
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: '/admin/teachers/' + id,
                type: 'DELETE',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function () {
                    Swal.fire(
                        'Deleted!',
                        'Teacher has been deleted.',
                        'success'
                    );
                    $('#teachers-table').DataTable().ajax.reload();
                },
                error: function () {
                    Swal.fire(
                        'Error!',
                        'Something went wrong.',
                        'error'
                    );
                }
            });
        }
    });
});
</script>

@endpush
