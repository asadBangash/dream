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
                    <h4 class="bradecrumb-title mb-1">{{ $data['title'] }}</h4>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"> {{ ___('mainapp_common.home') }} </a></li>
                        <li class="breadcrumb-item"><a href="{{ route('sections.index') }}">{{ $data['title'] }}</a></li>
                        <li class="breadcrumb-item">{{ ___('mainapp_common.edit') }}</li>

                    </ol>
                </div>
            </div>
        </div>
        {{-- bradecrumb Area E n d --}}

        <div class="card ot-card">
            <div class="card-title">
                <h4>{{___('website.Key')}}: {{ @$data['sections']->key }}</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('sections.update', @$data['sections']->id) }}" enctype="multipart/form-data" method="post"
                    id="visitForm">
                    @csrf
                    @method('PUT')
                    <div class="row mb-3">
                        <div class="col-lg-12">

                            {{-- @dd($data['sections']) --}}

                            <div class="row">

                                @if (@$data['sections']->name)
                                    <div class="col-md-6">
                                        <label for="exampleDataList" class="form-label ">{{ ___('mainapp_common.name') }}</label>
                                        <input class="form-control ot-input @error('name') is-invalid @enderror" name="name"
                                            value="{{ old('name',@$data['sections']->name) }}" list="datalistOptions" id="exampleDataList"
                                            placeholder="{{ ___('mainapp_common.enter_name') }}">
                                        @error('name')
                                            <div id="validationServer04Feedback" class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                @endif

                                @if (@$data['sections']->upload_id)
                                    <div class="col-md-6">
                                        <label for="exampleDataList" class="form-label ">{{ ___('mainapp_common.background_image') }}</label>
                                        <div class="ot_fileUploader left-side mb-3">
                                            <input class="form-control" type="text"
                                                placeholder="{{ ___('mainapp_common.image') }}" readonly="" id="placeholder">
                                            <button class="primary-btn-small-input" type="button">
                                                <label class="btn btn-lg ot-btn-primary"
                                                    for="fileBrouse">{{ ___('mainapp_common.browse') }}</label>
                                                <input type="file" class="d-none form-control" name="image" accept="image/*"
                                                    id="fileBrouse">
                                            </button>
                                        </div>
                                    </div>
                                @endif

                                @if (@$data['sections']->description)
                                    <div class="col-md-12 mt-3">
                                        <label for="exampleDataList" class="form-label">{{ ___('mainapp_common.Description') }}</label>
                                        <textarea class="form-control ot-textarea @error('description') is-invalid @enderror" name="description"
                                        list="datalistOptions" id="exampleDataList"
                                        placeholder="{{ ___('mainapp_common.Enter description') }}">{{ old('description',@$data['sections']->description) }}</textarea>
                                        @error('description')
                                            <div id="validationServer04Feedback" class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                @endif


                                @if (@$data['sections']->key == 'social_links') {{-- -------------------------------- Social link --------------------------------- --}}
                                    <div class="col-md-12 mt-5">
                                        <div class="text-end">
                                            <button type="button" onclick="addLink()" class="btn ot-btn-primary"><span><i class="fa-solid fa-add"></i> </span>{{ ___('mainapp_common.add') }}</button>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <table class="table" id="social_links">
                                            <thead></thead>
                                            <tbody>
                                                @foreach (@$data['sections']->data as $key=>$item)
                                                    <tr>
                                                        <td>
                                                            <label class="form-label">{{ ___('mainapp_common.name') }}</label>
                                                            <input class="form-control ot-input mb-4" value="{{ $item['name'] }}" name="data[name][]"placeholder="{{ ___('mainapp_common.Enter name') }}">
                                                        </td>
                                                        <td>
                                                            <label class="form-label">{{ ___('mainapp_common.Icon') }}</label>
                                                            <input class="form-control ot-input mb-4" value="{{ $item['icon'] }}" name="data[icon][]"placeholder="{{ ___('mainapp_common.Enter icon') }}">
                                                        </td>
                                                        <td>
                                                            <label class="form-label">{{ ___('mainapp_common.Link') }}</label>
                                                            <div class="d-flex align-items-center mb-4">
                                                                <input class="form-control ot-input mr-2" value="{{ $item['link'] }}" name="data[link][]"placeholder="{{ ___('mainapp_common.Enter link') }}">
                                                                <button class="drax_close_icon mark_distribution_close" onclick="removeRow(this)">
                                                                    <i class="fa-solid fa-xmark"></i>
                                                                </button>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>

                                @elseif (@$data['sections']->key == 'services') {{-- -------------------------------- services --------------------------------- --}}
                                    <h3 class="mt-3">{{___('mainapp_common.Details')}}</h3>
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-6 mb-18">
                                                <div>
                                                    <label class="form-label">{{ ___('mainapp_common.Icon') }} {{ ___('mainapp_common.(70 x 70 px)') }}</label>
                                                    <div class="ot_fileUploader left-side mb-3">
                                                        <input class="form-control" type="text" placeholder="{{ ___('mainapp_common.Select icon') }}" readonly="" id="placeholder">
                                                        <button class="primary-btn-small-input" type="button">
                                                            <label class="btn btn-lg ot-btn-primary" for="fileBrouse">{{ ___('mainapp_common.browse') }}</label>
                                                            <input type="file" class="d-none form-control" name="data[icon][]" accept="image/*" id="fileBrouse">
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="mb-18">
                                                    <label class="form-label">{{ ___('mainapp_common.title') }}</label>
                                                    <input class="form-control ot-input mb-2" value="{{ @$data['sections']->data[0]['title'] }}" name="data[title][]" placeholder="{{ ___('mainapp_common.Enter title') }}">
                                                </div>
                                                <div>
                                                    <label class="form-label">{{ ___('mainapp_common.Description') }}</label>
                                                    <textarea class="form-control ot-textarea mt-0 mb-5" name="data[description][]" placeholder="{{ ___('mainapp_common.Enter description') }}">{{ @$data['sections']->data[0]['description'] }}</textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-18">
                                                <div>
                                                    <label class="form-label">{{ ___('mainapp_common.Icon') }} {{ ___('mainapp_common.(70 x 70 px)') }}</label>
                                                    <div class="ot_fileUploader left-side mb-3">
                                                        <input class="form-control" type="text" placeholder="{{ ___('mainapp_common.Select icon') }}" readonly="" id="placeholder2">
                                                        <button class="primary-btn-small-input" type="button">
                                                            <label class="btn btn-lg ot-btn-primary" for="fileBrouse2">{{ ___('mainapp_common.browse') }}</label>
                                                            <input type="file" class="d-none form-control" name="data[icon][]" accept="image/*" id="fileBrouse2">
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="mb-18">
                                                    <label class="form-label">{{ ___('mainapp_common.title') }}</label>
                                                    <input class="form-control ot-input mb-2" value="{{ @$data['sections']->data[1]['title'] }}" name="data[title][]" placeholder="{{ ___('mainapp_common.Enter title') }}">
                                                </div>
                                                <div>
                                                    <label class="form-label">{{ ___('mainapp_common.Description') }}</label>
                                                    <textarea class="form-control ot-textarea mt-0" name="data[description][]" placeholder="{{ ___('mainapp_common.Enter description') }}">{{ @$data['sections']->data[1]['description'] }}</textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-18">
                                                <div>
                                                    <label class="form-label">{{ ___('mainapp_common.Icon') }} {{ ___('mainapp_common.(70 x 70 px)') }}</label>
                                                    <div class="ot_fileUploader left-side mb-3">
                                                        <input class="form-control" type="text" placeholder="{{ ___('mainapp_common.Select icon') }}" readonly="" id="placeholder3">
                                                        <button class="primary-btn-small-input" type="button">
                                                            <label class="btn btn-lg ot-btn-primary" for="fileBrouse3">{{ ___('mainapp_common.browse') }}</label>
                                                            <input type="file" class="d-none form-control" name="data[icon][]" accept="image/*" id="fileBrouse3">
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="mb-18">
                                                    <label class="form-label">{{ ___('mainapp_common.title') }}</label>
                                                    <input class="form-control ot-input mb-2" value="{{ @$data['sections']->data[2]['title'] }}" name="data[title][]" placeholder="{{ ___('mainapp_common.Enter title') }}">
                                                </div>
                                                <div>
                                                    <label class="form-label">{{ ___('mainapp_common.Description') }}</label>
                                                    <textarea class="form-control ot-textarea mt-0" name="data[description][]" placeholder="{{ ___('mainapp_common.Enter description') }}">{{ @$data['sections']->data[2]['description'] }}</textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-18">
                                                <div>
                                                    <label class="form-label">{{ ___('mainapp_common.Icon') }} {{ ___('mainapp_common.(70 x 70 px)') }}</label>
                                                    <div class="ot_fileUploader left-side mb-3">
                                                        <input class="form-control" type="text" placeholder="{{ ___('mainapp_common.Select icon') }}" readonly="" id="placeholder4">
                                                        <button class="primary-btn-small-input" type="button">
                                                            <label class="btn btn-lg ot-btn-primary" for="fileBrouse4">{{ ___('mainapp_common.browse') }}</label>
                                                            <input type="file" class="d-none form-control" name="data[icon][]" accept="image/*" id="fileBrouse4">
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="mb-18">
                                                    <label class="form-label">{{ ___('mainapp_common.title') }}</label>
                                                    <input class="form-control ot-input mb-2" value="{{ @$data['sections']->data[3]['title'] }}" name="data[title][]" placeholder="{{ ___('mainapp_common.Enter title') }}">
                                                </div>
                                                <div>
                                                    <label class="form-label">{{ ___('mainapp_common.Description') }}</label>
                                                    <textarea class="form-control ot-textarea mt-0" name="data[description][]" placeholder="{{ ___('mainapp_common.Enter description') }}">{{ @$data['sections']->data[3]['description'] }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                @elseif (@$data['sections']->key == 'contact') {{-- -------------------------------- contact --------------------------------- --}}
                                    <h3 class="mt-3">{{___('mainapp_common.Details')}}</h3>
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-4">
                                                <label class="form-label">{{ ___('mainapp_common.email') }}</label>
                                                <input class="form-control ot-input mb-2" value="{{ @$data['sections']->data[0] }}" name="data[]" placeholder="{{ ___('mainapp_common.Enter email') }}" type="email">
                                            </div>
                                            <div class="col-4">
                                                <label class="form-label">{{ ___('mainapp_common.phone') }}</label>
                                                <input class="form-control ot-input mb-2" value="{{ @$data['sections']->data[1] }}" name="data[]" placeholder="{{ ___('mainapp_common.Enter phone') }}">
                                            </div>
                                            <div class="col-4">
                                                <label class="form-label">{{ ___('mainapp_common.address') }}</label>
                                                <input class="form-control ot-input mb-2" value="{{ @$data['sections']->data[2] }}" name="data[]" placeholder="{{ ___('mainapp_common.Enter address') }}">
                                            </div>
                                        </div>
                                    </div>
                                @endif


                                <div class="col-md-12 mt-24">
                                    <div class="text-end">
                                        <button class="btn btn-lg ot-btn-primary"><span><i class="fa-solid fa-save"></i>
                                            </span>{{ ___('mainapp_common.update') }}</button>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
