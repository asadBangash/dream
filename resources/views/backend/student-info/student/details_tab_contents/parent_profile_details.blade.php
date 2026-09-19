<div class="p-3">
    <div class="row g-4">

        <div class="form-item p-3">
            <h4 class="title mb-3">{{ ___('student_info.Guardian') }}</h4>
            <hr>

            <div class="row g-4">
                <div class="col-md-4">
                    <h6 class="mb-15 h5">{{ ___('parent.Father Details') }}</h6>
                    <p class="mb-1">{{ ___('parent.Name') }} :  {{ @$data->parent->father_name }} </p>
                    <p class="mb-1">{{ ___('parent.Phone') }} :  {{ @$data->parent->father_mobile }}</p>
                    <p class="mb-1">{{ ___('parent.Email') }} : {{ @$data->parent->guardian_email }}</p>
                    <p class="mb-1">{{ ___('parent.Profession') }} : {{ @$data->parent->father_profession }}</p>
                </div>
                <div class="col-md-4">
                    <h6 class="mb-15 h5">{{ ___('parent.Mother Details') }}</h6>
                    <p class="mb-1">{{ ___('parent.Name') }} :  {{ @$data->parent->mother_name }} </p>
                    <p class="mb-1">{{ ___('parent.Phone') }} :  {{ @$data->parent->mother_mobile }}</p>
                    <p class="mb-1">{{ ___('parent.Email') }} : {{ @$data->parent->mother_name }}</p>
                    <p class="mb-1">{{ ___('parent.Profession') }} : {{ @$data->parent->mother_profession }}</p>
                </div>
                <div class="col-md-4">
                    <h6 class="mb-15 h5">{{ ___('parent.Guardian Details') }}</h6>
                   <p class="mb-1">{{ ___('parent.Name') }} :  {{ @$data->parent->guardian_name }} </p>
                    <p class="mb-1">{{ ___('parent.Phone') }} :  {{ @$data->parent->guardian_mobile }}</p>
                    <p class="mb-1">{{ ___('parent.Relation') }} : {{ @$data->parent->guardian_relation }}</p>
                    <p class="mb-1">{{ ___('parent.Profession') }} : {{ @$data->parent->mother_profession }}</p>
                </div>
            </div>
        </div>

    </div>
</div>
