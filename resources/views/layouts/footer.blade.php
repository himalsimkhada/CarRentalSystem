<script type="module">
    function showAlert(message, type) {
        switch (type) {
            case 'success':
                alertify.success(message);
                break;
            case 'error':
                alertify.error(message);
                break;
            case 'warning':
                alertify.warning(message);
                break;
            // Add more cases for other types if needed
            default:
                break;
        }
    }

    var msg = '{{ Session::get('message') }}';
    var type = '{{ Session::get('type') }}';
    var exist = '{{ Session::has('message') }}';

    if (exist) {
        showAlert(msg, type);
    }
</script>
@if (auth()->check() ||
        auth()->guard('company')->check())
    <script type="module">
        $(".dropdown-menu-right").click(function(e) {
            e.stopPropagation();
        })

        function sendMarkRequest(id = null) {
            return $.ajax("{{ route('notification.mark-as-read') }}", {
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
                let notificationDiv = $(this).parents('div.alert');
                request.done(() => {
                    notificationDiv.removeClass('alert-info').addClass('alert-danger');
                    notificationDiv.fadeOut('slow', function() {
                        notificationDiv.remove();
                        updateNotificationBadgeFromServer();
                    });
                });
            });
            $('#mark-all').click(function() {
                let request = sendMarkRequest();
                let notificationDivs = $('div.alert');
                request.done(() => {
                    notificationDivs.removeClass('alert-info').addClass('alert-danger');
                    notificationDivs.fadeOut('slow', function() {
                        notificationDiv.remove();
                        updateNotificationBadgeFromServer();
                    });
                })
            });
        });

        function updateNotificationBadgeFromServer() {
            $.ajax({
                url: "{{ route('notification.count.unread') }}",
                method: 'GET',
                dataType: 'json',
                success: function(response) {
                    if (response && response.count) {
                        $(".notification-badge").html(response.count);
                    }
                },
                error: function(error) {
                    console.log(error);
                }
            });
        }
    </script>
@endif
