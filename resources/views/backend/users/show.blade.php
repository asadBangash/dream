@extends('backend.master')

@section('title')
    {{ @$data['title'] }}
@endsection
@section('content')
    <div class="page-content">
        <!-- profile content start -->
        <div class="profile-content">
            <div class="d-flex flex-column flex-lg-row gap-4 gap-lg-0">

                <div class="profile-menu">
                    <!-- profile menu head start -->
                    <div class="profile-menu-head">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <img class="img-fluid rounded-circle" src="{{ @globalAsset(@$data->upload->path) }}"
                                    alt="{{ @$data->name }}">
                            </div>
                            <div class="flex-grow-1">
                                <div class="body">
                                    <h2 class="title">{{ @$data->first_name }} {{ @$data->last_name }}</h2>
                                    <p class="paragraph">{{ @$data->role->name }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- profile menu head end -->

                    <!-- profile menu body start -->
                    <div class="profile-menu-body">
                        <nav>
                            <ul class="nav flex-column">
                                <li class="nav-item">
                                    <a class="nav-link active" aria-current="page"
                                        href="#">{{ ___('common.Profile') }}</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                    <!-- profile menu body end -->
                </div>

                <!-- profile menu end -->

                <div class="profile-body">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h2 class="title">{{ ___('common.Staff Details') }}</h2>
                        <a href="{{ route('users.edit',@$data->id) }}" class="btn btn-lg ot-btn-primary mb-5">
                            <span class="icon"><i class="fa-solid fa-pen-to-square"></i></span>
                            <span class="">{{ ___('common.edit') }}</span>
                        </a>
                    </div>

                    <!-- profile body form start -->
                    <div class="profile-body-form">
                        <div class="form-item">
                            <div class="d-flex justify-content-between align-content-center">
                                <div class="align-self-center">
                                    <h2 class="title">{{ ___('staff.staff_id') }}</h2>
                                    <p class="paragraph">{{ @$data->staff_id }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="form-item">
                            <div class="d-flex justify-content-between align-content-center">
                                <div class="align-self-center">
                                    <h2 class="title">{{ ___('common.roles') }}</h2>
                                    <p class="paragraph">{{ @$data->role->name }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="form-item">
                            <div class="d-flex justify-content-between align-content-center">
                                <div class="align-self-center">
                                    <h2 class="title">{{ ___('staff.select_designation') }}</h2>
                                    <p class="paragraph">{{ @$data->designation->name }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="form-item">
                            <div class="d-flex justify-content-between align-content-center">
                                <div class="align-self-center">
                                    <h2 class="title">{{ ___('staff.departments') }}</h2>
                                    <p class="paragraph">{{ @$data->department->name }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="form-item">
                            <div class="d-flex justify-content-between align-content-center">
                                <div class="align-self-center">
                                    <h2 class="title">{{ ___('staff.first_name') }}</h2>
                                    <p class="paragraph">{{ @$data->first_name }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="form-item">
                            <div class="d-flex justify-content-between align-content-center">
                                <div class="align-self-center">
                                    <h2 class="title">{{ ___('staff.last_name') }}</h2>
                                    <p class="paragraph">{{ @$data->last_name }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="form-item">
                            <div class="d-flex justify-content-between align-content-center">
                                <div class="align-self-center">
                                    <h2 class="title">{{ ___('staff.father_name') }}</h2>
                                    <p class="paragraph">{{ @$data->father_name }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="form-item">
                            <div class="d-flex justify-content-between align-content-center">
                                <div class="align-self-center">
                                    <h2 class="title">{{ ___('staff.mother_name') }}</h2>
                                    <p class="paragraph">{{ @$data->mother_name }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="form-item">
                            <div class="d-flex justify-content-between align-content-center">
                                <div class="align-self-center">
                                    <h2 class="title">{{ ___('common.email') }}</h2>
                                    <p class="paragraph">{{ @$data->email }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="form-item">
                            <div class="d-flex justify-content-between align-content-center">
                                <div class="align-self-center">
                                    <h2 class="title">{{ ___('staff.genders') }}</h2>
                                    <p class="paragraph">{{ @$data->gender->name }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="form-item">
                            <div class="d-flex justify-content-between align-content-center">
                                <div class="align-self-center">
                                    <h2 class="title">{{ ___('staff.date_of_birth') }}</h2>
                                    <p class="paragraph">{{ dateFormat(@$data->dob) }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="form-item">
                            <div class="d-flex justify-content-between align-content-center">
                                <div class="align-self-center">
                                    <h2 class="title">{{ ___('staff.joining_date') }}</h2>
                                    <p class="paragraph">{{ dateFormat(@$data->joining_date) }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="form-item">
                            <div class="d-flex justify-content-between align-content-center">
                                <div class="align-self-center">
                                    <h2 class="title">{{ ___('staff.phone') }}</h2>
                                    <p class="paragraph">{{ @$data->phone }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="form-item">
                            <div class="d-flex justify-content-between align-content-center">
                                <div class="align-self-center">
                                    <h2 class="title">{{ ___('staff.emergency_contact') }}</h2>
                                    <p class="paragraph">{{ @$data->emergency_contact }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="form-item">
                            <div class="d-flex justify-content-between align-content-center">
                                <div class="align-self-center">
                                    <h2 class="title">{{ ___('staff.marital_status') }}</h2>
                                    <p class="paragraph">
                                        @if (@$data->marital_status == App\Enums\MaritalStatus::MARRIED)
                                            {{ ___('staff.married') }}
                                        @else
                                            {{ ___('staff.unmarried') }}
                                        @endif  
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="form-item">
                            <div class="d-flex justify-content-between align-content-center">
                                <div class="align-self-center">
                                    <h2 class="title">{{ ___('common.status') }}</h2>
                                    <p class="paragraph">
                                        @if (@$data->status == App\Enums\Status::ACTIVE)
                                            {{ ___('common.active') }}
                                        @else
                                            {{ ___('common.inactive') }}
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="form-item">
                            <div class="d-flex justify-content-between align-content-center">
                                <div class="align-self-center">
                                    <h2 class="title">{{ ___('staff.current_address') }}</h2>
                                    <p class="paragraph">{{ @$data->current_address }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="form-item">
                            <div class="d-flex justify-content-between align-content-center">
                                <div class="align-self-center">
                                    <h2 class="title">{{ ___('staff.permanent_address') }}</h2>
                                    <p class="paragraph">{{ @$data->permanent_address }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="form-item">
                            <div class="d-flex justify-content-between align-content-center">
                                <div class="align-self-center">
                                    <h2 class="title">{{ ___('staff.basic_salary') }}</h2>
                                    <p class="paragraph">{{ @$data->basic_salary }}</p>
                                </div>
                            </div>
                        </div>
                        
                        <h3>{{ ___('staff.Documents') }}</h3>
                        @if (@$data->upload_documents)
                            @foreach (@$data->upload_documents as $key=>$item)
                                <div class="form-item">
                                    <div class="d-flex justify-content-between align-content-center">
                                        <div class="align-self-center">
                                            <h2 class="title">{{ $item['title'] }}</h2>
                                            <p class="paragraph"><a href="{{ @globalAsset($item['file']->upload->path) }}" download>Download</a></p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif

                    </div>
                </div>
                <!-- profile body form end -->
            </div>
            <!-- profile body end -->
        </div>
    </div>
@endsection

