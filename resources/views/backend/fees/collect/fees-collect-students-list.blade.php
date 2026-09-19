@foreach ($students as $item)
<tr id="document-file">
    <td>{{ @$item->student->admission_no }}</td>
    <td>{{ @$item->student->first_name }} {{ @$item->student->last_name }}</td>
    <td>{{ @$item->class->name }}</td>
    <td>{{ @$item->section->name }}</td>
    <td>{{ @$item->student->parent->guardian_name }}</td>
    <td>{{ @$item->student->mobile }}</td>
    <td>
        <a href="{{ route('fees-collect.collect',$item) }}" class="btn btn-sm ot-btn-primary">{{ ___('common.Collect')}}</a>
    </td>
</tr>
@endforeach

