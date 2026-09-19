<div class="p-3">
    <div class="row g-4">

        <div class="form-item p-3">
            <h4 class="title mb-3">{{ ___('student_info.Profile Info') }}</h4>
            <hr>

            <div class="row g-4">
                <div class="col-md-6">
                    <h6 class="mb-15 h5">{{ ___('student.Personal Details') }} </h6>
                    <p class="mb-1">{{ ___('student.Name') }}: {{ $data->full_name }}</p>
                    <p class="mb-1">{{ ___('student.Admission Number') }}: {{ $data->admission_no }}</p>
                    <p class="mb-1">{{ ___('student.Date of Birth') }} : {{ $data->dob }}</p>
                    <p class="mb-1">{{ ___('student.Gender') }} : {{ @$data->gender->name }}</p>
                </div>
                <div class="col-md-6 ">
                    <h6 class="mb-15 h5">{{ ___('student.Contact Details') }} </h6>
                    <p class="mb-1">{{ ___('student.Mobile') }}: {{ @$data->mobile }}</p>
                    <p class="mb-1">{{ ___('student.Email') }}: {{ @$data->email }}</p>
                    <p class="mb-1">{{ ___('student.Nationality') }}: {{ @$data->nationality }}</p>
                    <p class="mb-1">{{ ___('student.Address') }}: {{ @$data->residance_address }}</p>
                    <p class="mb-1">{{ ___('student.Place Of Birth') }} : {{ @$data->place_of_birth }}</p>
                </div>
            </div>
        </div>

    </div>
</div>
