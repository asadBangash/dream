@foreach ($students as $item)
<tr id="document-file">
    <td><input class="form-check-input student" type="checkbox" name="student_ids[]" value="{{$item->id}}"></td>
    <td>{{ @$item->student->admission_no }}</td>
    <td>{{ @$item->student->first_name }} {{ @$item->student->last_name }}</td>
    <td>{{ @$item->class->name }} ({{ @$item->section->name }})</td>
    <td>{{ @$item->student->parent->guardian_name }}</td>
    <td>{{ @$item->student->mobile }}</td>
</tr>
@endforeach

