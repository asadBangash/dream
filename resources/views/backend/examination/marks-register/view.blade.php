 <!--Start Customize Width Modal -->


     <div class="modal-content" id="modalWidth">
         <div class="modal-header modal-header-image">
             <h5 class="modal-title" id="modalLabel2">
                 {{ ___('examination.student_and_mark') }}
             </h5>
             <button type="button" onclick="dismissModal()" class="m-0 btn-close d-flex justify-content-center align-items-center"
                 data-bs-dismiss="modal" aria-label="Close"><i class="fa fa-times text-white"
                     aria-hidden="true"></i></button>
         </div>
         <div class="modal-body p-5">
            <div class="table-responsive table_height_450 niceScroll">
                <table class="table ot-table-bg">
                    <thead class="thead">
                        <tr>
                            <th>{{ ___('student_info.student_name') }}</th>
                            <th>{{ ___('examination.total_mark') }}</th>
                            <th>{{ ___('examination.mark_distribution') }}</th>
                        </tr>
                    </thead>
                    <tbody class="tbody">
                        @foreach ($data['students'] as $item)
                        <tr id="document-file">
                            <input type="hidden" name="student_ids[]" value="{{ $item->student_id }}">
                            <td>
                                <p class="mt-3">{{ $item->student->first_name }} {{ $item->student->last_name }}</p>
                            </td>
                            <td>
                                <p class="mt-3">{{ @$data['examAssign']->total_mark }}</p>
                            </td>
                            <td>
                                @foreach (@$data['examAssign']->mark_distribution as $row)
                                    <div class="row mb-1">
                                        <div class="col-md-6">
                                            <p class="mt-3">{{ @$row->title }}</p>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="col-md-6">
                                                @foreach ($data['marks_register']->marksRegisterChilds as $child)
                                                    @if ($child->student_id == $item->student_id && $child->title == $row->title)
                                                        <p class="mt-3">{{ @$child->mark }}</p>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
         </div>
         <div class="modal-footer">
             <button type="button" class="btn btn-outline-secondary py-2 px-4"
                 data-bs-dismiss="modal">{{ ___('ui_element.cancel') }}</button>
             {{-- <button type="button" class="btn ot-btn-primary"
                 data-bs-dismiss="modal">{{ ___('ui_element.confirm') }}</button> --}}
         </div>
     </div>


<!-- End Customize Width  -->