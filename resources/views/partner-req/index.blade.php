@extends('layouts.dashboard')

@section('title', 'Requests')

@section('content')
    <div class="wrapper">
        @include('layouts.dashboard-sidebar')
        <div class="content">
            <p class="text-center h1 title">Partnering Requests</p>
            <div class="card">
                <div class="card-header">List of requests</div>
                <div class="card-body">
                    {{ $dataTable->table() }}
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).on('click', '#deny', function() {
            var id = $(this).data('id');
            var url = "{{ route('admin.deny.partner', ':id') }}";
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
                                    'Denied!',
                                    'A request has been denied.',
                                    'success'
                                )
                                $('#partnerreqs-table').DataTable().ajax.reload();
                            } else {
                                Swal.fire(
                                    'Error!',
                                    'Error denieing!',
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
