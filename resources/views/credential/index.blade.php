@extends('layouts.dashboard')

@section('title', 'Credentials')

@section('content')
    <div class="wrapper">
        @include('layouts.dashboard-sidebar')
        <div class="content">
            <p class="text-center h1 title">Credentials</p>
            <div class="card">
                <div class="card-header">All the list of added credentials</div>
                <div class="card-body">
                    {{ $dataTable->table() }}
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).on('click', '#delete', function() {
            var id = $(this).data('id');
            var url = "{{ Route::is('company.index.credential') ? route('company.delete.credential', ':id') : route('user.delete.credential', ':id') }}";
            url = url.replace(':id', id)
            Swal.fire({
                title: 'Are you sure?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Confirm'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        method: 'get',
                        url: url,
                        data: {
                            id: id
                        },
                        dataType: "json",
                        success: function(response) {
                            if (response == 1) {
                                Swal.fire(
                                    'Deleted!',
                                    'Credentials has been deleted.',
                                    'success'
                                )
                                $('#companycredentials-table').DataTable().ajax.reload();
                                $('#usercredentials-table').DataTable().ajax.reload();
                            } else {
                                Swal.fire(
                                    'Error!',
                                    'Error deleting....',
                                    'error'
                                )
                            }
                        },
                        error: function(response) {
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
