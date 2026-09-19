<tr id="document-file">
    <td>
        <select class="nice-select niceSelect bordered_style wide"
            name="subjects[]" id="subject{{$counter}}" required>
            <option value="">{{ ___('academic.select_subject') }}</option>
            @foreach ($data['subjects'] as $item)
                <option value="{{ $item->subject->id }}">{{ $item->subject->name }}</option>
            @endforeach
        </select> 
    </td>
    <td>
        <select class="nice-select niceSelect bordered_style wide"
            name="time_schedules[]" id="teacher{{$counter}}" required>
            <option value="">{{ ___('academic.select_time_schedule') }}</option>
            @foreach ($data['time_schedules'] as $item)
                <option value="{{ $item->id }}">{{ $item->start_time }} - {{ $item->end_time }}</option>
            @endforeach
        </select> 
    </td>
    <td>
        <select class="nice-select niceSelect bordered_style wide"
            name="class_rooms[]" id="class_room{{$counter}}" required>
            <option value="">{{ ___('academic.select_class_room') }}</option>
            @foreach ($data['class_rooms'] as $item)
                <option value="{{ $item->id }}">{{ $item->room_no }}</option>
            @endforeach
        </select> 
    </td>
    <td>
        <button class="drax_close_icon mark_distribution_close" onclick="removeRow(this)">
            <i class="fa-solid fa-xmark"></i>
        </button>
    </td>
</tr>

