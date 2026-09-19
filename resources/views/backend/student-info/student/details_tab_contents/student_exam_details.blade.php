<div class="p-3">
    <div class="row g-4">
        <!-- Overview Section -->
        <!-- Table Section -->
        <div class="col-12">
            <div class="card border shadow-sm">
                <div class="card-header bg-light d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">{{ ___('student.Examination Details') }}</h5>
                </div>
                <div class="card-body table-responsive">
                    @forelse ($examAssigns as $examType => $examAssign)

                        <div class="card border shadow-sm mb-3">
                            <div class="card-header bg-light d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">{{ strtoupper($examType) }}</h5>
                            </div>
                            <div class="card-body table-responsive">
                                <div class="table-responsive">
                                    <table class="table table-bordered role-table">
                                        <thead class="thead">
                                            <tr>

                                                <th class="purchase">{{ ___('examination.exam_title') }}</th>
                                                <th class="purchase">{{ ___('examination.class') }}
                                                    ({{ ___('examination.section') }})
                                                </th>
                                                <th class="purchase">{{ ___('examination.subjects') }}</th>
                                                <th class="purchase">{{ ___('examination.total_mark') }}</th>
                                                <th class="purchase">{{ ___('examination.mark_distribution') }}</th>

                                            </tr>
                                        </thead>
                                        <tbody class="tbody">
                                            @forelse ($examAssign as  $row)
                                                <td>{{ @$row->exam_type->name }}</td>
                                                <td>{{ @$row->class->name }} ({{ @$row->section->name }})</td>
                                                <td>{{ @$row->subject->name }}</td>
                                                <td>{{ @$row->total_mark }}</td>
                                                <td>
                                                    @foreach (@$row->mark_distribution as $item)
                                                        <div
                                                            class="d-flex align-items-center justify-content-between mt-0">
                                                            <p>{{ $item->title }}</p>
                                                            <p>{{ $item->mark }}</p>
                                                        </div>
                                                    @endforeach
                                                </td>

                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="100%" class="text-center gray-color">
                                                        <img src="{{ asset('images/no_data.svg') }}" alt=""
                                                            class="mb-primary" width="100">
                                                        <p class="mb-0 text-center">
                                                            {{ ___('common.no_data_available') }}</p>
                                                        <p class="mb-0 text-center text-secondary font-size-90">
                                                            {{ ___('common.please_add_new_entity_regarding_this_table') }}
                                                        </p>
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>



                    @empty

                    @endforelse
                </div>
            </div>
        </div>

        <!-- Modal Placeholder -->

    </div>
</div>
