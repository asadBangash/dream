var Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 1500,
    timerProgressBar: true,
    didOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer)
        toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
});
function ajax_error(data) {
    if (data.status === 404) {
        Toast.fire({
            icon: 'error',
            title: 'What you are looking is not found'
        })
        return;
    } else if (data.status === 500) {
        Toast.fire({
            icon: 'error',
            title: 'Something went wrong'
        })
        return;
    } else if (data.status === 200) {
        Toast.fire({
            icon: 'error',
            title: data.message
        })
        return;
    }
    let jsonValue = $.parseJSON(data.responseText);
    let errors = jsonValue.errors;
    if (errors) {
        let i = 0;
        $.each(errors, function(key, value) {
            let first_item = Object.keys(errors)[i];
            let error_el_id = $('#' + first_item);
            if (error_el_id.length > 0) {
                error_el_id.parsley().addError('ajax', {
                    message: value,
                    updateClass: true
                });
            }
            Toast.fire({
                icon: 'error',
                title: value
            })
            i++;
        });
    } else {
        Toast.fire({
            icon: 'error',
            title: jsonValue.message
        })
    }
}

function jsUcfirst(string) {
    "use strict";
    return string.charAt(0).toUpperCase() + string.slice(1);
}


function _formValidation(form_id = 'content_form', modal = false, modal_id = 'content_modal', ajax_table = null) {
   

    const form = $('#' + form_id);

    if (!form.length) {
        return;
    }

    form.parsley().on('field:validated', function() {
        $('.parsley-ajax').remove();
        const ok = $('.parsley-error').length === 0;
        $('.bs-callout-info').toggleClass('hidden', !ok);
        $('.bs-callout-warning').toggleClass('hidden', ok);
    });
    form.on('submit', function(e) {
        e.preventDefault();
        $('.parsley-ajax').remove();
        $('.preloader').fadeIn();
        form.find('.submit').hide();
        form.find('.submitting').show();
        const submit_url = form.attr('action');
        const method = form.attr('method');
        //Start Ajax
     
        const formData = new FormData(form[0]);
        $.ajax({
            url: submit_url,
            type: method,
            data: formData,
            contentType: false, // The content type used when sending data to the server.
            cache: false, // To unable request pages to be cached
            processData: false,
            dataType: 'JSON',
            success: function(data) {
                form.find('input:text').val('');
                form.find("input:text:visible:first").focus();

                Toast.fire({
                    icon: 'success',
                    title: data.message
                })

                setTimeout(function() {
                if (ajax_table) {
                    ajax_table.ajax.reload();
                }

                if (data.goto) {
                    window.location.href = data.goto;
                }

                if (data.reload) {
                    window.location.href = '';
                }
                
            }, 1500);
            
            form.find('.submit').show();
            form.find('.submitting').hide();

            setTimeout(function() {
                $('.preloader').fadeOut()
            }, 800)},

            error: function(data) {
                if(data.status === 504){
                    Toast.fire({
                        icon: 'error',
                        title: 'The 504 (Gateway Timeout)'
                    })
                    let goto_url = $('meta[name="goto_url"]').attr('content');
                    window.location.href =  goto_url;
                } 
                ajax_error(data);
                form.find('.submit').show();
                form.find('.submitting').hide();
                $('.preloader').fadeOut();
            }
        });
    });
}
