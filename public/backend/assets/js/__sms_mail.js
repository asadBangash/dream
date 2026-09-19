function smsMailSubmit(event) {

  event.preventDefault();

  var attachment   = document.getElementById('fileBrouse');

  var csrfToken   = document.head.querySelector('meta[name="csrf-token"]').content;

  var title            = document.getElementById('title').value;
  var type             = document.getElementById('type').value;
  var template_sms     = document.getElementById('template_sms').value;
  var template_mail    = document.getElementById('template_mail').value;
  var mail_description = document.getElementById('mail_description').value;
  var sms_description  = document.getElementById('sms_description').value;
  var user_type        = document.getElementById('user_type').value;
  
  var role             = document.getElementById('role').value;
  
  var class_id         = document.getElementById('getSections').value;
  


  var role_ids         = $('#role_ids').val();
  var users            = $('#users').val();
  var section_ids      = $('#section_ids').val();

  var attachment     = attachment.files[0];
  var formData = new FormData();

  if (attachment == undefined) {
    attachment = '';
  } 

  formData.append('title', title);
  formData.append('type', type);
  formData.append('template_sms', template_sms);
  formData.append('template_mail', template_mail);
  formData.append('mail_description', mail_description);
  formData.append('sms_description', sms_description);
  formData.append('user_type', user_type);
  formData.append('role_ids', role_ids);
  formData.append('role', role);

  formData.append('users', users);
  formData.append('class_id', class_id);
  formData.append('section_ids', section_ids);

  console.log(formData);


  $.ajax({
      url: '/communication/smsmail/store', // Your server-side script handling the upload
      type: 'POST',
      dataType: 'json',
      headers: {
        'X-CSRF-TOKEN': csrfToken // Include the CSRF token in the headers
      },
      data: formData,
      contentType: false,
      processData: false,
      success: function(response) {
          console.log(response);
          if (response.status) {

            Toast.fire({
                icon: 'success',
                title: response.message
            });

            setTimeout( () => {
              window.location.reload();
            }, 2000);

          } else {

              Toast.fire({
                icon: 'error',
                title: response.message
            });
          }

      },
      error: function(error) {

        console.log(error.responseJSON.errors);

        if( error.status === 422 ) {

            $.each(error.responseJSON.errors, function(field_name,message){
                  $("#" +field_name).addClass('is-invalid');
                  $("#" +field_name).siblings('.invalid-feedback').html(message);
          })
        }
      }
  });
}




$("#template-store .type").on("change", function() {

  if($(this).val() == "sms") {
      $(".__sms").removeClass('d-none');
      $(".__mail").addClass('d-none');
  } else {
      $(".__sms").addClass('d-none');
      $(".__mail").removeClass('d-none');
  }
})

$("#template-store .type").trigger('change');

$("#template-store .user_type").on("change", function() {

  if($(this).val() == "role") {

      $(".__role").removeClass('d-none');

      setTimeout(function() {

          $(".__individual").addClass('d-none');
          $(".__class").addClass('d-none');

      }, 300);

  } else if($(this).val() == "individual") {

      $(".__role").addClass('d-none');
      $(".__individual").removeClass('d-none');
      $(".__class").addClass('d-none');

  } else {

      $(".__role").addClass('d-none');
      $(".__individual").addClass('d-none');
      $(".__class").removeClass('d-none');

  }
})

$("#template-store .user_type").trigger('change');



$("#template-store .__individual .role").on("change", function() {

  var formData = {
      role_id: $(this).val(),
  }

  console.log(formData);

  $.ajax({
      type: "GET",
      dataType: 'json',
      data: formData,
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      url: '/communication/smsmail/users',
      success: function (data) {
          console.log(data);
          var options = '';
          $.each(data, function(index, value) {
              options += `<option value=${value.id}>${value.name}</option>`;
          })


          $(".__individual .users").find('option').not(':first').remove();


          $(".__individual .users").append(options);

      },
      error: function (data) {
          console.log(data);
      }
  });
});


$("#template-store .template").on("change", function() {

  var formData = {
      template_id: $(this).val(),
  }

  console.log(formData);

  $.ajax({
      type: "GET",
      dataType: 'json',
      data: formData,
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      url: '/communication/smsmail/template',
      success: function (data) {
          console.log(data);
          if (data['type'] == 'sms') {

            console.log(data['sms_description']);

              $(".sms_description").html(data['sms_description']);

          } else {

            console.log(data['mail_description']);

              $(".mail_description").summernote("code", data['mail_description']);
              if(data['attachment'] != null) {

                  $("#placeholder").attr("placeholder", data['attachment_file']['path']);
              }

          }

          console.log('hello world');
          
      },
      error: function (data) {
          console.log(data);
      }
  });
});


    $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip();
    });

