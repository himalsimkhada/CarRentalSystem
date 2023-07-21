@extends('layouts.dashboard')

@section('title', 'Messages')

@section('content')
    <div class="wrapper">
        @include('layouts.dashboard-sidebar')
        <div class="content">
            <p class="text-center h1 title">Messages</p>
            <div class="card">
                <div class="card-header">List of messages from customers</div>
                <div class="card-body">
                    {{ $dataTable->table() }}
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).on('click', '#email', function() {
            var id = $(this).data('id');
            var user_id = $(this).data('user_id');
            var url = "{{ route('company.support.customer', ['user_id' => ':user_id', 'id' => ':id']) }}"
            url = url.replace(':id', id);
            url = url.replace(':user_id', user_id);
            Swal.fire({
                title: 'Are you sure?',
                input: 'textarea',
                inputLabel: 'Message:',
                showCancelButton: true,
                inputPlaceholder: "Write your message here.....",
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        method: 'post',
                        url: url,
                        data: {
                            id: id,
                            user_id: user_id,
                            result: result.value
                        },
                        dataType: "json",
                        beforeSend: function () {
                            Swal.fire({
                                title: 'Sending email.....',
                                didOpen: () => {
                                    Swal.showLoading();
                                }
                            })
                        },
                        success: function(response) {
                            console.log(response);
                            Swal.fire('Emailed successfully.');
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
