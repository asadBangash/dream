@push('script')
<script type="text/javascript">
    function delete_row(route, row_id, reload = false) {

        var table_row = '#row_' + row_id;
        var url = "{{url('')}}"+'/'+route+'/'+row_id;
        Swal.fire({
            title: $('#alert_title').val(),
            text: $('#alert_subtitle').val(),
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: $('#alert_yes_btn').val(),
            cancelButtonText: $('#alert_cancel_btn').val(),
          }).then((confirmed) => {
            if (confirmed.isConfirmed) {
                $.ajax({
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        id: row_id,
                        _method: 'DELETE'
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: url,
                })
                .done(function(response) {

                    Swal.fire({
                        icon: response[1],
                        title: response[2],
                        text: response[0],
                        showCloseButton: true,
                        confirmButtonText: response[3],
                    });
                    $(table_row).fadeOut(2000);

                    if (reload) {
                        // reload

                        setTimeout(function() {
                            location.reload();
                        }, 2000);

                    }

                })
                .fail(function(error) {
                    console.log(error);
                    Swal.fire('{{ ___('common.opps') }}...', '{{ ___('common.something_went_wrong_with_ajax') }}', 'error');
                })
            }
        });

    };
</script>
@endpush
