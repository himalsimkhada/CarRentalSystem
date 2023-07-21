@extends('layouts.dashboard')

@section('title', 'Companies')

@section('content')
    <div class="wrapper">
        @include('layouts.dashboard-sidebar')
        <div class="content">
            <p class="text-center h1 title">Companies</p>
            <div class="card">
                <div class="card-header">Lists of all the companies registered in the system.</div>
                <div class="card-body">
                    {{ $dataTable->table() }}
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).on('click', '#delete', function() {
            var id = $(this).data('id');
            var url = "{{ route('admin.delete.company', ':id') }}";
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
                                    'Company has been deleted.',
                                    'success'
                                )
                                $('#companies-table').DataTable().ajax.reload();
                            } else {
                                console.log(response);
                                Swal.fire(
                                    'Error!',
                                    'Error deleting company.',
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
