@foreach ($students as $item)
<tr id="document-file">
    <input type="hidden" name="student_ids[]" value="{{ $item->student_id }}">
    <td>
        <p class="mt-3">{{ $item->student->first_name }} {{ $item->student->last_name }}</p>
    </td>
    <td>
        <p class="mt-3">{{ @$examAssign->total_mark }}</p>
    </td>
    <td>
        @foreach (@$examAssign->mark_distribution as $row)
            <div class="row mb-1">
                <div class="col-md-6">
                    <p class="mt-3">{{ @$row->title }}</p>
                </div>
                <div class="col-md-6">
                    <input type="number" name="marks[{{ $item->student_id }}][{{ @$row->title }}]" class="form-control ot-input min_width_200" placeholder="{{ ___('examination.Enter mark out of') }} {{ @$row->mark }}" required>
                </div>
            </div>
        @endforeach
    </td>
</tr>
@endforeach

