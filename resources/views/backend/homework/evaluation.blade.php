<div class="table-responsive">
    <table class="table table-bordered role-table">
        <thead class="thead">
            <tr>
                <th class="serial">{{ ___('common.sr_no') }}</th>
                <th class="purchase">{{ ___('academic.student_name') }} </th>
                <th class="purchase">{{ ___('academic.admission_no') }} </th>
                <th class="purchase">{{ ___('academic.roll_no') }} </th>
                <th class="purchase">{{ ___('academic.homework') }}</th>
                <th class="purchase">{{ ___('academic.marks') }}</th>
            </tr>
        </thead>
        <tbody class="tbody">
            @forelse ($data['students'] as $key => $row)
            <tr id="row_{{ @$row->student->id }}">
                <td class="serial">{{ ++$key }}</td>
                <td class="serial">{{ @$row->student->first_name }} {{ @$row->student->last_name }}</td>
                <td class="serial">{{ @$row->student->admission_no }}</td>
                <td class="serial">{{ @$row->roll }}</td>
                <td>
                    @if($row->homeworkStudent)

                    {{ ___('academic.date') }} : {{$row->homeworkStudent?->date}}<br>
                    {{ ___('academic.homework') }} : <a class="btn btn-lg ot-btn-primary radius_30px small_add_btn" href="{{ @globalAsset($row->homeworkStudent->homeworkUpload->path, '100X100.webp') }}" target="_blank">
                        <i class="fa-solid fa-eye"></i>
                    </a><br>


                    @else 
                    <span class="badge-basic-danger-text">{{ ___('online-examination.Not Submitted Yest') }}</span>
                    @endif
                </td>
                <td>
                    @if($row->homeworkStudent)
                    <input type="number" class="form-control ot-input" step="any" name="marks[]" value="{{ $row->homeworkStudent?->marks }}" required />
                    <input type="hidden" step="any" name="students[]" value="{{$row->student_id}}" />
                    @endif
                </td>
            </tr>
                @empty
                <tr>
                    <td colspan="100%" class="text-center gray-color">
                        <img src="{{ asset('images/no_data.svg') }}" alt="" class="mb-primary" width="100">
                        <p class="mb-0 text-center">{{ ___('common.no_data_available') }}</p>
                        <p class="mb-0 text-center text-secondary font-size-90">
                            {{ ___('common.please_add_new_entity_regarding_this_table') }}</p>
                    </td>
                </tr>
                @endforelse
        </tbody>
    </table>
</div>