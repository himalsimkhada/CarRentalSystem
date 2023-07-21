@extends('layouts.dashboard')

@section('title', 'Users')

@section('content')
    <div class="wrapper">
        @include('layouts.dashboard-sidebar')
        <div class="content">
            <p class="text-center h1 title">Users</p>
            <div class="card">
                <div class="card-header">Manage Users</div>
                <div class="card-body">
                    {{ $dataTable->table() }}
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).on('click', '#delete', function () {
            var id = $(this).data('id');
            var url = "{{ route('admin.delete.user', ':id') }}";
            url = url.replace(':id', id)
            Swal.fire({
                title: 'Are you sure?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Confirm'
            }).then((result)=>{
                if (result.isConfirmed) {
                    $.ajax({
                        method: 'get',
                        url: url,
                        data: {id:id},
                        dataType: "json",
                        success: function (response) {
                            if (response == 1) {
                                Swal.fire(
                                    'Deleted!',
                                    'User has been deleted.',
                                    'success'
                                )
                                $('#users-table').DataTable().ajax.reload();
                            } else {
                                console.log(response);
                                Swal.fire(
                                    'Error!',
                                    'Error deleting user.',
                                    'error'
                                )
                            }
                        },
                        error: function (response) {
                            console.log(response);
                        }
                    })
                }
            })
        });
    </script>

@endsection

@push('scripts')
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
@endpush
