
<tr id="document-file">
    <td>
        <input type="text" name="document_names[{{$counter}}]"
            class="form-control ot-input min_width_200 " placeholder="{{___('student_info.enter_name')}}" required>
            <input type="hidden" name="document_rows[]" value="{{$counter}}">
            
    </td>
    <td>
            <div class="school_primary_fileUplaoder mb-3">
                <label for="awesomefile{{$counter}}" class="filelabel">{{ ___('common.browse') }}</label>
                <input type="file" name="document_files[{{$counter}}]" id="awesomefile{{$counter}}" >
                <input type="text" class="redonly_input" readonly placeholder="{{ ___('student_info.upload_documents') }}">
            </div>
    </td>
    <td>
        <button class="drax_close_icon" onclick="removeRow(this)">
            <i class="fa-solid fa-xmark"></i>
        </button>
    </td>
</tr>

<script src="{{ asset('backend') }}/assets/js/jquery-3.6.0.min.js"></script>
<script>
      $('input[type="file"]').change( function() {
    //construct a selector for the label that belongs to the changed input field
    var label = 'label[for="' + $(this).attr('id') + '"]';
    // Get the filename
    var fn = $(this).val().split("\\")[2];
  
    // set the filename as the text for the label
    $(this).parent().children('input[type="text"]').attr("placeholder", fn);
  //   $(label).text("File: "+fn);
  }).hide();
</script>

