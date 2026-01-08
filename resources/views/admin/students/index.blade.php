@extends('admin.layouts.app')

@push('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
@endpush

@section('content')
<h2> Students </h2>

<a href="{{ route('students-create') }}" class="btn btn-success mb-3">
    Add New Student
</a>

<table class="table table-bordered" id="students-table">
    <thead>
        <tr>
            <th>SL</th>
            <th>Name</th>
            <th>Email</th>
            <th>Age</th>
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

    $('#students-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('students-data') }}",
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'name', name: 'name' },
            { data: 'email', name: 'email' },
            { data: 'age', name: 'age' },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ]
    });

});

// Event delegation for Delete button
$(document).on('click', '.delete-btn', function() {
    var id = $(this).data('id');
    if (confirm('Are you sure you want to delete this student?')) {
        $.ajax({
            url: '/admin/students/' + id,
            type: 'DELETE',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                if (response.success) {
                    $('#students-table').DataTable().ajax.reload();
                    alert('Student deleted successfully');
                }
            },
            error: function() {
                alert('An error occurred while deleting the student');
            }
        });
    }
});
</script>
@endpush