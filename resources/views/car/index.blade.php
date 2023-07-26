@extends('layouts.dashboard')

@section('title', 'Cars')

@section('content')
    <div class="wrapper">
        @include('layouts.dashboard-sidebar')
        <div class="content">
            <p class="text-center h1 title">Cars List</p>
            <div class="card">
                <div class="card-header">Here are all the cars that are on the system.</div>
                <div class="card-body">
                    {{ $dataTable->table() }}
                </div>
            </div>
        </div>
    </div>
    @php
        $url = auth()
            ->guard('company')
            ->check()
            ? route('company.delete.car', ':id')
            : (auth()->check()
                ? route('admin.delete.car', ':id')
                : null);
    @endphp
    <script>
        $(document).on('click', '#delete', function() {
            var id = $(this).data('id');
            var url = "{{ $url }}";
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
                                    'A car has been deleted.',
                                    'success'
                                )
                                $('#cars-table').DataTable().ajax.reload();
                            } else {
                                Swal.fire(
                                    'Error!',
                                    'Error deleting!',
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

        $(document).on('click', '#image', function() {
            var id = $(this).data('id');
            var url = "{{ route('company.car.store.image') }}"
            // url = url.replace(':id', id);
            // url = url.replace(':user_id', user_id);
            Swal.fire({
                title: 'Upload an image for car!',
                input: 'file',
                inputAttributes: {
                    'accept': 'image/*',
                    'aria-label': 'Upload your profile picture'
                },
                showCancelButton: true,
            }).then((result) => {
                if (result.value) {
                    var formData = new FormData();
                    formData.append('image', result.value);
                    formData.append('id', id)

                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        method: 'post',
                        url: url,
                        processData: false,
                        contentType: false,
                        data: formData,
                        beforeSend: function() {
                            Swal.fire({
                                title: 'Uploading image.....',
                                didOpen: () => {
                                    Swal.showLoading();
                                }
                            })
                        },
                        success: function(response) {
                            Swal.fire('Uploading successful.');
                        },
                        error: function(response) {
                            console.log(response);
                            Swal.fire('Process failed. Try again....');
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
