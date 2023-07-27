@extends('layouts.dashboard')

@section('title', 'Booking')

@section('content')
    <div class="wrapper">
        @include('layouts.dashboard-sidebar')
        <div class="content">
            <p class="text-center h1 title">Bookings</p>
            <div class="card">
                <div class="card-header">List of bookings.</div>
                <div class="card-body">
                    {{ $dataTable->table() }}
                </div>
            </div>
        </div>
    </div>

    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <div>{{ $error }}</div>
        @endforeach
    @endif

    {{-- <script type="module">
        $(document).on('click', '#delete', function() {
            var id = $(this).data('id');
            var url = "{{ route('admin.delete.type', ':id') }}";
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
                                    'A type has been deleted.',
                                    'success'
                                )
                                $('#bookings-table').DataTable().ajax.reload();
                            } else {
                                console.log(response);
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
    </script> --}}

    <script type="module">
        $(document).on('click', '#paymentLink', function() {
            var id = $(this).data('id');
            var route = "{{ route('paypal.make.payment') }}";

            var paypalForm = document.createElement("form");
            paypalForm.action = route;
            paypalForm.method = 'get';
            paypalForm.hidden = true;
            document.body.appendChild(paypalForm);

            var booking_id = document.createElement("input");
            booking_id.setAttribute('type', 'text');
            booking_id.setAttribute('name', 'id');
            booking_id.setAttribute('value', id);
            booking_id.hidden = true;
            paypalForm.appendChild(booking_id);

            paypalForm.submit();
        })
    </script>

    <script type="module">
        $(document).on('click', '#delete', function() {
            var id = $(this).data('id');
            var url = "{{ route('user.delete.booking', ':id') }}";
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
                                    'A booking has been deleted.',
                                    'success'
                                )
                                $('#bookings-table').DataTable().ajax.reload();
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
    </script>

@endsection

@push('scripts')
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
@endpush
