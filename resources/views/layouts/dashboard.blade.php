<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dashboard - @yield('title')</title>

    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/favicon/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/favicon/favicon-16x16.png') }}">

    @include('layouts.style')
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
</head>

<body>
    @yield('content')
    <a id="back-to-top" href="#" class="btn btn-dark btn-lg back-to-top" role="button"><span
            class="material-icons">
            expand_less
        </span></a>
    <script>
        $(document).ready(function() {
            $(window).scroll(function() {
                if ($(this).scrollTop() > 100) {
                    $('#back-to-top').fadeIn();
                } else {
                    $('#back-to-top').fadeOut();
                }
            });
            // scroll body to 0px on click
            $('#back-to-top').click(function() {
                $('html, body').animate({
                    scrollTop: 0
                }, 100);
                return false;
            });
        });
    </script>

    <script>
        // Example starter JavaScript for disabling form submissions if there are invalid fields
        (function() {
            'use strict';
            window.addEventListener('load', function() {
                // Fetch all the forms we want to apply custom Bootstrap validation styles to
                var forms = document.getElementsByClassName('needs-validation');
                // Loop over them and prevent submission
                var validation = Array.prototype.filter.call(forms, function(form) {
                    form.addEventListener('submit', function(event) {
                        if (form.checkValidity() === false) {
                            event.preventDefault();
                            event.stopPropagation();
                        }
                        form.classList.add('was-validated');
                    }, false);
                });
            }, false);
        })();
    </script>

    <script>
        var msg = '{{ Session::get('alert') }}';
        var exist = '{{ Session::has('alert') }}';
        if (exist) {
            alert(msg);
        }
    </script>

    @if (auth()->guard('company')->check())
        <script>
            function sendMarkRequest(id = null) {
                return $.ajax("{{ route('company.markNotification') }}", {
                    method: 'POST',
                    data: {
                        _token: "{{ csrf_token() }}",
                        id
                    }
                });
            }
            $(function() {
                $('.mark-as-read').click(function() {
                    let request = sendMarkRequest($(this).data('id'));
                    request.done(() => {
                        $(this).parents('div.alert').remove();
                    });
                });
                $('#mark-all').click(function() {
                    let request = sendMarkRequest();
                    request.done(() => {
                        $('div.alert').remove();
                    })
                });
            });
        </script>
    @else
        @if (auth()->user()->user_type == 1)
            <script>
                function sendMarkRequest(id = null) {
                    return $.ajax("{{ route('admin.markNotification') }}", {
                        method: 'POST',
                        data: {
                            _token: "{{ csrf_token() }}",
                            id
                        }
                    });
                }
                $(function() {
                    $('.mark-as-read').click(function() {
                        let request = sendMarkRequest($(this).data('id'));
                        request.done(() => {
                            $(this).parents('div.alert').remove();
                        });
                    });
                    $('#mark-all').click(function() {
                        let request = sendMarkRequest();
                        request.done(() => {
                            $('div.alert').remove();
                        })
                    });
                });
            </script>
        @endif

        @if (auth()->user()->user_type == 3)
            <script>
                function sendMarkRequest(id = null) {
                    return $.ajax("{{ route('user.markNotification') }}", {
                        method: 'POST',
                        data: {
                            _token: "{{ csrf_token() }}",
                            id
                        }
                    });
                }
                $(function() {
                    $('.mark-as-read').click(function() {
                        let request = sendMarkRequest($(this).data('id'));
                        request.done(() => {
                            $(this).parents('div.alert').remove();
                        });
                    });
                    $('#mark-all').click(function() {
                        let request = sendMarkRequest();
                        request.done(() => {
                            $('div.alert').remove();
                        })
                    });
                });
            </script>
        @endif
    @endif
    @stack('scripts')
</body>

</html>
