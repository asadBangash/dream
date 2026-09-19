@extends('backend.master')
@section('title', ___('multibranch.Branches'))
@section('content')
    <div class="page-content">
        <div class="page-header">
            <div class="row">
                <div class="col-sm-6">
                    <h4 class="bradecrumb-title mb-1">{{ $title }}</h4>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ ___('common.home') }}</a></li>
                        <li class="breadcrumb-item">{{ $title }}</li>
                    </ol>
                </div>
            </div>
        </div>
        <div class="card ot-card">
            <div class="card-body">
                <form action="{{ route('branch.update', $branch->id) }}" enctype="multipart/form-data" method="post" id="visitForm">
                    @csrf
                    @method('put')
                    <div class="row mb-3">
                        <!-- Name -->
                        <div class="col-lg-4 col-md-6 mb-3">
                            <label for="name" class="form-label">{{ ___('branch.Branch Name') }} <span
                                    class="fillable">*</span></label>
                            <input class="form-control ot-input @error('name') is-invalid @enderror" name="name"
                                   value="{{ old('name', $branch->name) }}" id="name" type="text"
                                   placeholder="{{ ___('branch.Enter name') }}">
                            @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Phone -->
                        <div class="col-lg-4 col-md-6 mb-3">
                            <label for="phone" class="form-label">{{ ___('branch.Phone') }}</label>
                            <input class="form-control ot-input @error('phone') is-invalid @enderror" name="phone"
                                   value="{{ old('phone', $branch->phone) }}" id="phone" type="text"
                                   placeholder="{{ ___('branch.Enter phone') }}">
                            @error('phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div class="col-lg-4 col-md-6 mb-3">
                            <label for="email" class="form-label">{{ ___('branch.Email') }}</label>
                            <input class="form-control ot-input @error('email') is-invalid @enderror" name="email"
                                   value="{{ old('email', $branch->email) }}" id="email" type="email"
                                   placeholder="{{ ___('branch.Enter email') }}">
                            @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Country -->
{{--                        <div class="col-lg-3 col-md-6 mb-3">--}}
{{--                            <label for="country_id" class="form-label">{{ ___('branch.Country') }}</label>--}}
{{--                            <select class="form-control ot-input @error('country_id') is-invalid @enderror"--}}
{{--                                    name="country_id" id="country_id">--}}
{{--                                <option value="">{{ ___('branch.Select country') }}</option>--}}
{{--                                @foreach ($countries as $id => $name)--}}
{{--                                    <option--}}
{{--                                        value="{{ $id }}" {{ old('country_id') == $id ? 'selected' : '' }}>{{ $name }}</option>--}}
{{--                                @endforeach--}}
{{--                            </select>--}}
{{--                            @error('country_id')--}}
{{--                            <div class="invalid-feedback">{{ $message }}</div>--}}
{{--                            @enderror--}}
{{--                        </div>--}}

                        <!-- Latitude -->
                        <div class="col-lg-3 col-md-6 mb-3">
                            <label for="lat" class="form-label">{{ ___('branch.Latitude') }}</label>
                            <input class="form-control ot-input @error('lat') is-invalid @enderror" name="lat"
                                   value="{{ old('lat', $branch->lat) }}" id="lat" type="text"
                                   placeholder="{{ ___('branch.Enter latitude') }}">
                            @error('lat')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Longitude -->
                        <div class="col-lg-3 col-md-6 mb-3">
                            <label for="long" class="form-label">{{ ___('branch.Longitude') }}</label>
                            <input class="form-control ot-input @error('long') is-invalid @enderror" name="long"
                                   value="{{ old('long', $branch->long) }}" id="long" type="text"
                                   placeholder="{{ ___('branch.Enter longitude') }}">
                            @error('long')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Status -->
                        <div class="col-lg-3 col-md-6 mb-3">
                            <label for="status" class="form-label">{{ ___('branch.Status') }}</label>
                            <select class="form-control ot-input @error('status') is-invalid @enderror" name="status"
                                    id="status">
                                <option
                                    value="{{ App\Enums\Status::ACTIVE }}" {{ old('status', $branch->status) == App\Enums\Status::ACTIVE ? 'selected' : '' }}>{{ ___('branch.Active') }}</option>
                                <option
                                    value="{{ App\Enums\Status::INACTIVE }}" {{ old('status', $branch->status) == App\Enums\Status::INACTIVE ? 'selected' : '' }}>{{ ___('branch.Inactive') }}</option>
                            </select>
                            @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Address -->
                        <div class="col-lg-12 col-md-12 mb-3">
                            <label for="address" class="form-label">{{ ___('branch.Address') }}</label>
                            <textarea class="form-control ot-input @error('address') is-invalid @enderror"
                                      name="address" id="address" rows="1"
                                      placeholder="{{ ___('branch.Enter address') }}">{{ old('address', $branch->address) }}</textarea>
                            @error('address')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-12 mt-24">
                            <div class="text-end">
                                <button class="btn btn-lg ot-btn-primary"><span><i class="fa-solid fa-save"></i>
                            </span>Submit</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
