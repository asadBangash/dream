@push('script')
<script type="text/javascript">
    function delete_row(route, row_id, reload = false) {

        // console.log(reload);
        var noteMessage = '';
        var note = $('.note').val();
        if (note) {
            $.ajax({
                type: "GET",
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: `/exam-assign/check-mark-register/${row_id}`,
                success: function (data) {
                    if(data){
                        noteMessage = note;
                    }
                    getEvents();
                },
                error: function (data) {
                    console.log(data);
                }
            });
        }
        else
            getEvents();




        function getEvents(){
        var table_row = '#row_' + row_id;
        var url = "{{url('')}}"+'/'+route+'/'+row_id;
        Swal.fire({
  title: $('#alert_title').val(),
//   text: $('#alert_subtitle').val(),
  html: $('#alert_subtitle').val()+"<br><span class='text-warning'>"+noteMessage+"</span>",
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

                    Swal.fire(
                        response[2],
                            response[0],
                            response[1]
                        );
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
        }

    };
</script>
@endpush
