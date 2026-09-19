
<tr id="document-file">
    <td>
        <select class="nice-select bordered_style wide @error('subjects') is-invalid @enderror"
            name="subjects[]" id="subject{{$counter}}" required>
            <option value="">{{ ___('academic.select_subject') }}</option>
            @foreach ($data['subjects'] as $item)
                <option value="{{ $item->id }}">{{ $item->name }}</option>
            @endforeach
        </select> 
    </td>
    <td>
        <select class="nice-select bordered_style wide @error('teachers') is-invalid @enderror"
            name="teachers[]" id="teacher{{$counter}}" required>
            <option value="">{{ ___('academic.select_teacher') }}</option>
            @foreach ($data['teachers'] as $item)
                <option value="{{ $item->id }}">{{ $item->first_name }} {{ $item->last_name }}</option>
            @endforeach
        </select> 
    </td>
    <td>
        <button class="drax_close_icon" onclick="removeRow(this)">
            <i class="fa-solid fa-xmark"></i>
        </button>
    </td>
</tr>


