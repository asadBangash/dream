@if (hasPermission('parent_create'))
    <div class="modal fade" id="addParentModal" tabindex="-1" aria-labelledby="addParentModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header modal-header-image">
                    <h5 class="modal-title text-white" id="addParentModalLabel">{{ ___('student_info.parent_create') }}</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="quickParentFormErrors" class="alert alert-danger d-none"></div>
                    <form id="quickParentForm" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="password_type" value="default">
                        @if (hasModule('MultiBranch') && isSuperAdmin())
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label for="quickParentBranchSelect" class="form-label">{{ ___('branch.branch') }}
                                        <span class="fillable">*</span></label>
                                    <select name="branch_id" id="quickParentBranchSelect"
                                        class="nice-select niceSelect bordered_style wide">
                                        <option value="">{{ ___('branch.select_branch') }}</option>
                                        @foreach (\Modules\MultiBranch\Entities\Branch::query()->where('status', \App\Enums\Status::ACTIVE)->orderBy('name')->pluck('name', 'id') as $id => $name)
                                            <option value="{{ $id }}">{{ $name }}</option>
                                        @endforeach
                                    </select>
                                    <small class="text-muted">{{ ___('branch.select_branch') }} (required for parent login)</small>
                                </div>
                            </div>
                        @else
                            <input type="hidden" name="branch_id" id="quickParentBranchId"
                                value="{{ auth()->user()->branch_id ?? 1 }}">
                        @endif
                        @include('backend.student-info.parent.partials.form-fields', ['fieldPrefix' => 'modal_parent_'])
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ ___('common.cancel') }}</button>
                    <button type="button" class="btn ot-btn-primary" id="saveQuickParentBtn">
                        <i class="fa-solid fa-save"></i> {{ ___('common.save') }}
                    </button>
                </div>
            </div>
        </div>
    </div>

    @push('script')
        <script>
            (function() {
                const parentSelectSelector = 'select.parent[name="parent"]';

                function studentFormBranchId() {
                    const $studentBranch = $('#visitForm select[name="branch_id"]').first();
                    const val = $studentBranch.val() || $('#visitForm input[name="branch_id"]').val() || '';
                    return val === 'all' ? '' : val;
                }

                $('#addParentModal').on('show.bs.modal', function() {
                    $('#quickParentFormErrors').addClass('d-none').empty();
                    const fromStudent = studentFormBranchId();
                    const $modalBranch = $('#quickParentBranchSelect');
                    if ($modalBranch.length && fromStudent) {
                        $modalBranch.val(fromStudent);
                    }
                    $('#quickParentForm select.nice-select').each(function() {
                        if (!$(this).next('.nice-select').length && typeof $(this).niceSelect === 'function') {
                            $(this).niceSelect();
                        } else if ($(this).next('.nice-select').length && typeof $(this).niceSelect === 'function') {
                            $(this).niceSelect('update');
                        }
                    });
                });

                $('#saveQuickParentBtn').on('click', function() {
                    const form = document.getElementById('quickParentForm');
                    const $form = $(form);

                    if (!$form.find('[name=guardian_name]').val() && $form.find('[name=father_name]').val()) {
                        $form.find('[name=guardian_name]').val($form.find('[name=father_name]').val());
                    }
                    if (!$form.find('[name=guardian_mobile]').val() && $form.find('[name=father_mobile]').val()) {
                        $form.find('[name=guardian_mobile]').val($form.find('[name=father_mobile]').val());
                    }

                    const fd = new FormData(form);
                    let branchVal = $form.find('[name=branch_id]').val();
                    if ((!branchVal || branchVal === 'all') && studentFormBranchId()) {
                        branchVal = studentFormBranchId();
                        fd.set('branch_id', branchVal);
                    }
                    if (!branchVal || branchVal === 'all') {
                        $('#quickParentFormErrors').removeClass('d-none').html(
                            '<div>{{ ___('branch.select_branch') }}</div>');
                        return;
                    }

                    const $btn = $(this);
                    $btn.prop('disabled', true);

                    $.ajax({
                        url: '{{ route('parent.store') }}',
                        method: 'POST',
                        data: fd,
                        processData: false,
                        contentType: false,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json',
                        },
                        success: function(res) {
                            if (res.status && res.data && res.data.id) {
                                const $sel = $(parentSelectSelector);
                                $sel.append(
                                    $('<option>', {
                                        value: res.data.id,
                                        text: res.data.guardian_name,
                                        selected: true,
                                    })
                                );
                                if (typeof $sel.niceSelect === 'function') {
                                    try {
                                        $sel.niceSelect('update');
                                    } catch (e) {
                                        $sel.niceSelect('destroy');
                                        $sel.niceSelect();
                                    }
                                }
                                $sel.trigger('change');
                                $('#addParentModal').modal('hide');
                                form.reset();
                                if (typeof toastr !== 'undefined') {
                                    toastr.success(res.message);
                                }
                            }
                        },
                        error: function(xhr) {
                            let html = '';
                            if (xhr.status === 422 && xhr.responseJSON && xhr.responseJSON.errors) {
                                $.each(xhr.responseJSON.errors, function(field, messages) {
                                    html += '<div>' + messages.join('<br>') + '</div>';
                                });
                            } else if (xhr.responseJSON && xhr.responseJSON.message) {
                                html = xhr.responseJSON.message;
                            } else {
                                html = '{{ ___('alert.something_went_wrong_please_try_again') }}';
                            }
                            $('#quickParentFormErrors').removeClass('d-none').html(html);
                        },
                        complete: function() {
                            $btn.prop('disabled', false);
                        },
                    });
                });
            })();
        </script>
    @endpush
@endif
