<!-- Start Basic Modal -->
<div class="modal fade" id="basicModal" tabindex="-1" aria-labelledby="basicModalLabel"
aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header modal-header-image">
                <h5 class="modal-title" id="basicModalLabel">{{ ___('ui_element.Subject & Teacher') }}
                </h5>
                <button type="button" class="m-0 btn-close d-flex justify-content-center align-items-center"
                    data-bs-dismiss="modal" aria-label="Close"><i class="fa fa-times text-white"
                        aria-hidden="true"></i></button>
            </div>
            <div class="modal-body p-5">
                <div class="table-responsive table_height_450 niceScroll">
                    <table class="table ot-table-bg">
                        <thead class="thead">
                            <tr>
                                <th class="serial">{{ ___('academic.subject') }}</th>
                                <th class="purchase">{{ ___('academic.teacher') }}</th>
                            </tr>
                        </thead>
                        <tbody class="tbody">
                            @foreach ($data['subject_assign_children'] as $key => $row)
                            <tr>
                                <td> 
                                    
                                    {{ $row->subject->name }}<br>
                                 
                                </td>
                                <td> 
                                    
                                    {{ $row->teacher->first_name }} {{ $row->teacher->last_name }}<br>
                                    
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary py-2 px-4"
                    data-bs-dismiss="modal">{{ ___('ui_element.close') }}</button>
            </div>
        </div>
    </div>
</div>
<!-- End Basic Modal -->