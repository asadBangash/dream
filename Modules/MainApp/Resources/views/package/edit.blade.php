@extends('mainapp::layouts.backend.master')

@section('title')
    {{ @$data['title'] }}
@endsection
@section('content')
    <div class="page-content">

        {{-- bradecrumb Area S t a r t --}}
        <div class="page-header">
            <div class="row">
                <div class="col-sm-6">
                    <h4 class="bradecrumb-title mb-1">{{ $data['title'] }}</h1>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"> {{ ___('mainapp_common.home') }} </a></li>
                        <li class="breadcrumb-item"><a href="{{ route('package.index') }}">{{ ___('mainapp_package.package') }}</a></li>
                        <li class="breadcrumb-item">{{ ___('mainapp_common.edit') }}</li>

                    </ol>
                </div>
            </div>
        </div>
        {{-- bradecrumb Area E n d --}}
        <div class="card ot-card">
            <div class="card-body">
                <form action="{{ route('package.update', @$data['package']->id) }}" enctype="multipart/form-data" method="post"
                    id="package-form-edit">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="payment_type" value="{{$data['package']->payment_type}}" />
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="payment_type" class="form-label">{{ ___('mainapp_common.Payment Type') }} <span class="fillable">*</span> <i data-toggle="tooltip" data-placement="top" title="{{ ___('mainapp_package. If you select postpaid then will get all features, Unlimited staff create permission.')}}" class="fa-solid fa-circle-exclamation"></i></label>
                            <select class="nice-select niceSelect bordered_style wide @error('payment_type') is-invalid @enderror"
                            name="payment_type" id="payment_type"
                            aria-describedby="validationServer04Feedback" disabled>
                                <option value="">{{ ___('mainapp_common.Select payment type') }}</option>
                                <option value="{{ \Modules\MainApp\Enums\PackagePaymentType::PREPAID }}" {{old('payment_type', $data['package']->payment_type) == \Modules\MainApp\Enums\PackagePaymentType::PREPAID? 'selected':''}}>{{ ___('mainapp_common.Prepaid') }}</option>
                                <option value="{{ \Modules\MainApp\Enums\PackagePaymentType::POSTPAID }}" {{old('payment_type', $data['package']->payment_type) == \Modules\MainApp\Enums\PackagePaymentType::POSTPAID? 'selected':''}}>{{ ___('mainapp_common.Postpaid') }}
                                </option>
                            </select>

                            @error('payment_type')
                                <div id="validationServer04Feedback" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="exampleDataList" class="form-label">{{ ___('mainapp_common.name') }} <span
                                    class="fillable">*</span></label>
                            <input class="form-control ot-input @error('name') is-invalid @enderror" name="name"
                                list="datalistOptions" id="exampleDataList"
                                placeholder="{{ ___('mainapp_common.Enter name') }}" value="{{ old('name', @$data['package']->name) }}">
                            @error('name')
                                <div id="validationServer04Feedback" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="col-md-4 mb-3 _prepaid_main">
                            <label for="exampleDataList" class="form-label">{{ ___('mainapp_common.Price') }} <span
                                    class="fillable">*</span></label>
                            <input class="form-control ot-input @error('price') is-invalid @enderror" name="price" type="number"
                                list="datalistOptions" id="exampleDataList"
                                placeholder="{{ ___('mainapp_common.Enter price') }}" value="{{ old('price', @$data['package']->price) }}">
                            @error('price')
                                <div id="validationServer04Feedback" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="col-md-4 mb-3 _postpaid_main">
                            <label for="exampleDataList" class="form-label">{{ ___('mainapp_common.per_student_price') }} <span
                                    class="fillable">*</span></label>
                            <input class="form-control ot-input @error('per_student_price') is-invalid @enderror" name="per_student_price" type="number" step="any"
                                list="datalistOptions" id="exampleDataList"
                                placeholder="{{ ___('mainapp_common.Enter per student price') }}" value="{{ old('per_student_price', @$data['package']->per_student_price) }}">
                            @error('per_student_price')
                                <div id="validationServer04Feedback" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="col-md-4 mb-3 _prepaid_main">
                            <label for="exampleDataList" class="form-label">{{ ___('mainapp_schools.Student limit') }} <span
                                    class="fillable">*</span></label>
                            <input class="form-control ot-input @error('student_limit') is-invalid @enderror" name="student_limit" type="number"
                                list="datalistOptions" id="exampleDataList"
                                placeholder="{{ ___('mainapp_schools.Enter student limit') }}" value="{{ old('student_limit', @$data['package']->student_limit) }}">
                            @error('student_limit')
                                <div id="validationServer04Feedback" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="col-md-4 mb-3 _prepaid_main">
                            <label for="exampleDataList" class="form-label">{{ ___('mainapp_schools.Staff limit') }} <span
                                    class="fillable">*</span></label>
                            <input class="form-control ot-input @error('staff_limit') is-invalid @enderror" name="staff_limit" type="number"
                                list="datalistOptions" id="exampleDataList"
                                placeholder="{{ ___('mainapp_schools.Enter staff limit') }}" value="{{ old('staff_limit', @$data['package']->staff_limit) }}">
                            @error('staff_limit')
                                <div id="validationServer04Feedback" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="col-md-4 mb-3 _prepaid_main">
                            <label for="validationServer04" class="form-label">{{ ___('mainapp_common.Duration') }} <span class="fillable">*</span></label>
                            <select class="nice-select niceSelect bordered_style wide @error('duration') is-invalid @enderror _duration"
                            name="duration" id="validationServer04"
                            aria-describedby="validationServer04Feedback">
                                <option {{ old('duration', @$data['package']->duration) == \App\Enums\PricingDuration::DAYS ? 'selected' : '' }} value="{{ \App\Enums\PricingDuration::DAYS }}">{{ ___('mainapp_common.days') }}</option>
                                <option {{ old('duration', @$data['package']->duration) == \App\Enums\PricingDuration::MONTHLY ? 'selected' : '' }} value="{{ \App\Enums\PricingDuration::MONTHLY }}">{{ ___('mainapp_common.monthly') }}</option>
                                <option {{ old('duration', @$data['package']->duration) == \App\Enums\PricingDuration::YEARLY ? 'selected' : '' }} value="{{ \App\Enums\PricingDuration::YEARLY }}">{{ ___('mainapp_common.yearly') }}</option>
                                <option {{ old('duration', @$data['package']->duration) == \App\Enums\PricingDuration::LIFETIME ? 'selected' : '' }} value="{{ \App\Enums\PricingDuration::LIFETIME }}">{{ ___('mainapp_common.lifetime') }}</option>
                            </select>

                            @error('duration')
                                <div id="validationServer04Feedback" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="col-md-4 mb-3 _prepaid_main _duration_number_main">
                            <label for="exampleDataList" class="form-label">{{ ___('mainapp_common.Duration number') }} <span
                                    class="fillable">*</span></label>
                            <input class="form-control ot-input @error('duration_number') is-invalid @enderror" name="duration_number" type="number"
                                list="datalistOptions" id="exampleDataList"
                                placeholder="{{ ___('mainapp_common.Enter duration number') }}" value="{{ old('duration_number', @$data['package']->duration_number) }}">
                            @error('duration_number')
                                <div id="validationServer04Feedback" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="exampleDataList" class="form-label">{{ ___('mainapp_common.Short description') }} <span
                                    class="fillable">*</span></label>
                            <input class="form-control ot-input @error('description') is-invalid @enderror" name="description"
                                list="datalistOptions" id="exampleDataList"
                                placeholder="{{ ___('mainapp_common.Enter short description') }}" value="{{ old('description', @$data['package']->description) }}">
                            @error('description')
                                <div id="validationServer04Feedback" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>


                        <div class="col-md-4 mb-3">
                            <label for="validationServer04" class="form-label">{{ ___('mainapp_common.Popular') }} <span class="fillable">*</span></label>
                            <select class="nice-select niceSelect bordered_style wide @error('popular') is-invalid @enderror"
                            name="popular" id="validationServer04"
                            aria-describedby="validationServer04Feedback">
                                <option {{ old('popular', @$data['package']->popular) == 0 ? 'selected':'' }} value="0">{{ ___('mainapp_common.No') }}</option>
                                <option {{ old('popular', @$data['package']->popular) == 1 ? 'selected':'' }} value="1">{{ ___('mainapp_common.Yes') }}
                                </option>
                            </select>

                            @error('popular')
                                <div id="validationServer04Feedback" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="validationServer04" class="form-label">{{ ___('mainapp_common.status') }} <span class="fillable">*</span></label>
                            <select class="nice-select niceSelect bordered_style wide @error('status') is-invalid @enderror"
                            name="status" id="validationServer04"
                            aria-describedby="validationServer04Feedback">
                                <option {{ old('status', @$data['package']->status) == App\Enums\Status::ACTIVE ? 'selected':'' }} value="{{ App\Enums\Status::ACTIVE }}">{{ ___('mainapp_common.active') }}</option>
                                <option {{ old('status', @$data['package']->status) == App\Enums\Status::INACTIVE ? 'selected':'' }} value="{{ App\Enums\Status::INACTIVE }}">{{ ___('mainapp_common.inactive') }}
                                </option>
                            </select>

                            @error('status')
                                <div id="validationServer04Feedback" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="col-12 mb-3 _prepaid_main">
                            <label for="validationServer04" class="form-label">{{ ___('mainapp_feature.Features list') }} <span class="fillable">*</span></label>
                            <div class="table-responsive">
                                <table class="table table-bordered role-table" id="types_table">
                                    <thead class="thead">
                                        <tr>
                                            <th class="purchase mr-4">
                                                <input class="form-check-input all" type="checkbox" {{ $data['features']->count() == @$data['package']->packageChilds->count() ? 'checked' : '' }}> {{ ___('mainapp_common.All') }}
                                            </th>
                                            <th class="purchase">{{ ___('online-examination.Title') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody class="tbody">
                                        @foreach ($data['features'] as $item)
                                        <tr>
                                            <td><input class="form-check-input child" type="checkbox" name="features[]" value="{{$item->id}}" {{ in_array($item->id, old('features',@$data['package']->packageChilds->pluck('feature_id')->toArray())) ? 'checked' : '' }}></td>
                                            <td>{{ $item->title }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                @if ($errors->has('features'))
                                    <span class="text-danger">{{ ___('online-examination.At least select one.') }}</span>
                                @endif
                            </div>
                        </div>

                        <div class="col-md-12 mt-24">
                            <div class="text-end">
                                <button class="btn btn-lg ot-btn-primary"><span><i class="fa-solid fa-save"></i>
                                    </span>{{ ___('mainapp_common.submit') }}</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('script')
<script>
    $(function () {
      $('[data-toggle="tooltip"]').tooltip();
    });
  </script>
@endpush
