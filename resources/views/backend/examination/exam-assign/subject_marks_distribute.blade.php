@foreach ($request->ids as $key=>$item)

<tr id="row-{{$item}}">
    <td>
        <p class="mark_distribution_p">{{ $subjectArr[$item] }}</p>
        <input type="hidden" name="selected_subjects[]" value="{{$item}}" />
    </td>
    <td class="pr-0">
        <div class="d-flex align-items-center justify-content-between mt-0">
            <div></div>
            <button type="button" class="btn btn-lg ot-btn-primary radius_30px small_add_btn"
            onclick="marksDistribution({{$item}})">
            <span><i class="fa-solid fa-plus"></i> </span>
            {{ ___('common.add') }}</button>
        </div>
        <table class="table table_border_hide" id="marks-distribution{{$item}}">
            <tr>
                <td>
                    <div class="school_primary_fileUplaoder">
                        <input type="text" name="marks_distribution[{{ $item }}][titles][]" value="{{___('examination.written')}}" class="redonly_input" placeholder="{{ ___("examination.title") }}" required>
                    </div>
                </td>
                <td>
                    <div class="school_primary_fileUplaoder">
                        <input type="number" step="any" name="marks_distribution[{{ $item }}][marks][]" class="redonly_input" placeholder="{{ ___("examination.marks") }}" required>
                    </div>
                </td>
                <td>
                    <button class="drax_close_icon mark_distribution_close" onclick="removeRow(this)">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </td>
            </tr>
        </table>
    </td>
</tr>
@endforeach