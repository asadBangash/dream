function homeworkSubmit(event) {

  event.preventDefault();

  var fileInput   = document.getElementById('fileBrouse');
  var homework_id = document.getElementById('homework_id').value;
  var csrfToken   = document.head.querySelector('meta[name="csrf-token"]').content;


  var file     = fileInput.files[0];
  var formData = new FormData();


  if (file == undefined) {
    file = '';
  } 


  formData.append('homework', file);
  formData.append('homework_id', homework_id);

  console.log(formData);


  $.ajax({
      url: '/stundet/panel/homework/submit', // Your server-side script handling the upload
      type: 'POST',
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

        if( error.status === 422 ) {

            $.each(error.responseJSON.errors,function(field_name,message){
                  $("#" + field_name + "_error").text(message);
          })
        }
      }
  });
}


function openHomeworkModal(id) {

    $("#homework_id").val(id);

}