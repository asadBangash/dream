@forelse ($items as $item)
<tr>
    <td><input class="form-check-input child" type="checkbox" name="questions_ids[]" value="{{$item->id}}" {{ in_array($item->id, old('questions_ids',[])) ? 'checked' : '' }}></td>
    <td>{{ $item->question }}</td>
    <td>{{ ___(\Config::get('site.question_types')[$item->type]) }}</td>
</tr>
@empty
<tr>
    <td colspan="3 text-center">{{ ___('common.no_data_available') }}</td>
</tr>
@endforelse

