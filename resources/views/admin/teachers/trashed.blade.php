@extends('admin.layouts.app')

@push('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
@endpush

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2> Deleted Teachers </h2>
    <a href="{{ route('teachers-index') }}" class="btn btn-primary">
        Back to Teachers
    </a>
</div>

<table class="table table-bordered" id="teachers-trashed-table">
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
    <tbody></tbody>
</table>
@endsection

@push('scripts')
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<script>
$(document).ready(function () {
    $('#teachers-trashed-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('teachers-trashed-data') }}",
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

// Reverts soft-deleted state via POST
$(document).on('click', '.restore-btn', function() {
    var id = $(this).data('id');
    Swal.fire({
        title: 'Restore Teacher?',
        text: "This teacher will be moved back to the main list.",
        icon: 'info',
        showCancelButton: true,
        confirmButtonColor: '#28a745',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, restore it!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: '/admin/teachers/' + id + '/restore',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success) {
                        Swal.fire('Restored!', 'Teacher has been restored.', 'success');
                        $('#teachers-trashed-table').DataTable().ajax.reload();
                    }
                }
            });
        }
    });
});

// Destroys record and image file from storage disk
$(document).on('click', '.force-delete-btn', function() {
    var id = $(this).data('id');
    Swal.fire({
        title: 'Delete Permanently?',
        text: "This action CANNOT be undone! The teacher and their image will be gone forever.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete permanently!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: '/admin/teachers/' + id + '/force-delete',
                type: 'DELETE',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success) {
                        Swal.fire('Deleted!', 'Teacher has been permanently deleted.', 'success');
                        $('#teachers-trashed-table').DataTable().ajax.reload();
                    }
                }
            });
        }
    });
});
</script>
@endpush
