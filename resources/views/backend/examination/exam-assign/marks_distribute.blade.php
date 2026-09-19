
<tr>
    <td>
        <div class="school_primary_fileUplaoder">
            <input type="text" name="marks_distribution[{{ $request->id }}][titles][]" class="redonly_input" placeholder="{{ ___("examination.title") }}" required>
        </div>
    </td>
    <td>
        <div class="school_primary_fileUplaoder">
            <input type="text" name="marks_distribution[{{ $request->id }}][marks][]" class="redonly_input" placeholder="{{ ___("examination.marks") }}" required>
        </div>
    </td>
    <td>
        <button class="drax_close_icon mark_distribution_close" onclick="removeRow(this)">
            <i class="fa-solid fa-xmark"></i>
        </button>
    </td>
</tr>