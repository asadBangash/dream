@extends('backend.master')

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
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"> {{ ___('common.home') }} </a></li>
                        <li class="breadcrumb-item"><a href="{{ route('sections.index') }}">{{ $data['title'] }}</a></li>
                        <li class="breadcrumb-item">{{ ___('common.edit') }}</li>

                    </ol>
                </div>
            </div>
        </div>
        {{-- bradecrumb Area E n d --}}

        <div class="card ot-card">
            <div class="card-body">
                <form action="{{ route('sections.translate.update', @$data['sections']->id) }}" enctype="multipart/form-data" method="post"
                    id="visitForm">
                    @csrf
                    @method('PUT')
                    <div class="row mb-3">
                        <div class="col-lg-12">

                            @foreach ($data['languages'] as $language)
                                    @php
                                        $encoded = json_decode(@$data['translates'][$language->code][0]->data);  
                                    @endphp
                                <div class="row mb-3">
                                    @if (@$data['sections']->name)
                                    <div class="col-md-12">
                                        <label for="exampleDataList" class="form-label ">{{ ___('common.name') }}- ({{$language->name}})<span
                                                class="fillable">*</span></label>
                                        <input class="form-control ot-input @error('name') is-invalid @enderror" name="name[{{$language->code}}]"
                                            value="{{isset($data['translates'][$language->code][0]) ? $data['translates'][$language->code][0]->name :  @$data['sections']->name}}" list="datalistOptions" id="exampleDataList"
                                            placeholder="{{ ___('common.enter_name') }}">
                                        @error('name')
                                            <div id="validationServer04Feedback" class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    @endif
                                    @if (@$data['sections']->description)
                                    <div class="col-md-12 mt-3">
                                        <label for="exampleDataList" class="form-label">{{ ___('common.Description') }}- ({{$language->name}})</label>
                                        <textarea class="form-control ot-textarea @error('description') is-invalid @enderror" name="description[{{$language->code}}]"
                                        list="datalistOptions" id="exampleDataList"
                                        placeholder="{{ ___('common.Enter description') }}">{{isset($data['translates'][$language->code][0]) ? $data['translates'][$language->code][0]->description :  @$data['sections']->description}}</textarea>
                                        @error('description')
                                            <div id="validationServer04Feedback" class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    @endif
                                </div>

                                {{-- dynamic sections --}}

                                @if (@$data['sections']->key == 'social_links') {{-- -------------------------------- Social link --------------------------------- --}}

                                <div class="col-md-12">
                                    <table class="table" id="social_links">
                                        <thead>{{$language->name}}</thead>
                                        <input type="hidden" name="lang[]" value="{{ $language->code }}">
                                        <tbody>
                                            @foreach (@json_decode($data['translates'][$language->code][0]->data)??[] as $key=>$item)
                                                <tr>
                                                    <td>
                                                        <label class="form-label">{{ ___('common.name') }}</label>
                                                            {{-- <input class="form-control ot-input mr-2" value="{{ $item }}" name="data[{{$language->code}}][]"placeholder="{{ ___('common.Enter name') }}"> --}}

                                                        <input class="form-control ot-input mb-4" value="{{@$item->name}}" name="data[{{$language->code}}][name][]" placeholder="{{ ___('common.Enter name') }}">
                                                    </td>
                                                    <td>
                                                        <label class="form-label">{{ ___('common.Icon') }}</label>
                                                        <input class="form-control ot-input mb-4" value="{{ @$item->icon }}" name="data[{{$language->code}}][icon][]" placeholder="{{ ___('common.Enter icon') }}">
                                                    </td>
                                                    <td>
                                                        <label class="form-label">{{ ___('common.Link') }}</label>
                                                        <div class="d-flex align-items-center mb-4">
                                                            <input class="form-control ot-input mr-2" value="{{ @$item->link }}" name="data[{{$language->code}}][link][]" placeholder="{{ ___('common.Enter link') }}">
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @endif

                            @if (@$data['sections']->key == 'statement') {{-- -------------------------------- Statement --------------------------------- --}}
                                <h3 class="mt-3">{{___('common.Details')}}</h3>
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-6 mb-18">
                                            <div class="mb-18">
                                                <label class="form-label">{{ ___('common.title') }} - ({{$language->name}})</label>
                                                <input class="form-control ot-input mb-2" value="{{isset($data['translates'][$language->code][0]) ? $encoded[0]->title :  @$data['sections']->data[0]['title']}}" name="data[{{$language->code}}][title][]" placeholder="{{ ___('common.Enter title') }}">
                                            </div>
                                            <div>
                                                <label class="form-label">{{ ___('common.Description') }} - ({{$language->name}})</label>
                                                <textarea class="form-control ot-textarea mt-0 mb-5" name="data[{{$language->code}}][description][]" placeholder="{{ ___('common.Enter description') }}">{{isset($data['translates'][$language->code][0]) ? $encoded[0]->description :  @$data['sections']->data[0]['description']}}</textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-18">
                                            <div class="mb-18">
                                                <label class="form-label">{{ ___('common.title') }} - ({{$language->name}})</label>
                                                <input class="form-control ot-input mb-2" value="{{isset($data['translates'][$language->code][0]) ? $encoded[1]->title :  @$data['sections']->data[1]['title']}}" name="data[{{$language->code}}][title][]" placeholder="{{ ___('common.Enter title') }}">
                                            </div>
                                            <div>
                                                <label class="form-label">{{ ___('common.Description') }} - ({{$language->name}})</label>
                                                <textarea class="form-control ot-textarea mt-0" name="data[{{$language->code}}][description][]" placeholder="{{ ___('common.Enter description') }}">{{isset($data['translates'][$language->code][0]) ? $encoded[1]->description :  @$data['sections']->data[1]['description']}}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            @if (@$data['sections']->key == 'study_at') {{-- -------------------------------- study_at --------------------------------- --}}
                                <h3 class="mt-3">{{___('common.Details')}}</h3>
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-6">
                                            <div>

                                        @php
                                        $study_at = json_decode(@$data['translates'][$language->code][0]->data);  
                                        @endphp
                                        <input type="hidden" class="form-control"  name="data[{{$language->code}}][icon][0]" value="{{ @$study_at[0]->icon }}" accept="image/*" id="fileBrouse2">

                                            </div>
                                            <div>
                                                <label class="form-label">{{ ___('common.title') }} ({{$language->name}})</label>
                                                <input class="form-control ot-input mb-2" value="{{isset($data['translates'][$language->code][0]) ? $study_at[0]->title :  @$data['sections']->data[0]['title']}}" name="data[{{$language->code}}][title][]" placeholder="{{ ___('common.Enter title') }}">
                                            </div>
                                            <div>
                                                <label class="form-label">{{ ___('common.Description') }} ({{$language->name}})</label>
                                                <textarea class="form-control ot-textarea mt-0 mb-5" name="data[{{$language->code}}][description][]" placeholder="{{ ___('common.Enter description') }}">{{isset($data['translates'][$language->code][0]) ? $study_at[0]->description :  @$data['sections']->data[0]['description']}}</textarea>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div>

                                                <input type="hidden" class="form-control"  name="data[{{$language->code}}][icon][1]" value="{{ @$study_at[1]->icon }}" accept="image/*" id="fileBrouse2">

                                            </div>
                                            <div>
                                                <label class="form-label">{{ ___('common.title') }} ({{$language->name}})</label>
                                                <input class="form-control ot-input mb-2" value="{{isset($data['translates'][$language->code][0]) ? @$study_at[1]->title :  @$data['sections']->data[1]['title']}}" name="data[{{$language->code}}][title][]" placeholder="{{ ___('common.Enter title') }}">
                                            </div>
                                            <div>
                                                <label class="form-label">{{ ___('common.Description') }} ({{$language->name}})</label>
                                                <textarea class="form-control ot-textarea mt-0" name="data[{{$language->code}}][description][]" placeholder="{{ ___('common.Enter description') }}">{{isset($data['translates'][$language->code][0]) ? $study_at[1]->description :  @$data['sections']->data[1]['description']}}</textarea>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div>
                                                <input type="hidden" class="form-control"  name="data[{{$language->code}}][icon][2]" value="{{ @$study_at[2]->icon }}" accept="image/*" id="fileBrouse2">
                                            </div>
                                            <div>
                                                <label class="form-label">{{ ___('common.title') }} ({{$language->name}})</label>
                                                <input class="form-control ot-input mb-2" value="{{isset($data['translates'][$language->code][0]) ? $study_at[2]->title :  @$data['sections']->data[2]['title']}}" name="data[{{$language->code}}][title][]" placeholder="{{ ___('common.Enter title') }}">
                                            </div>
                                            <div>
                                                <label class="form-label">{{ ___('common.Description') }} ({{$language->name}})</label>
                                                <textarea class="form-control ot-textarea mt-0" name="data[{{$language->code}}][description][]" placeholder="{{ ___('common.Enter description') }}"> {{isset($data['translates'][$language->code][0]) ? $study_at[2]->description :  @$data['sections']->data[2]['description']}}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            @if (@$data['sections']->key == 'explore') {{-- -------------------------------- explore --------------------------------- --}}
                                <h3 class="mt-3">{{___('common.Details')}}</h3>
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-6">
                                            <div>
                                                <label class="form-label">{{ ___('common.Tab') }} - ({{$language->name}})</label>
                                                <input class="form-control ot-input mb-2" value="{{isset($data['translates'][$language->code][0]) ? $encoded[0]->tab :  @$data['sections']->data[0]['tab']}}" name="data[{{$language->code}}][tab][]" placeholder="{{ ___('common.Enter tab') }}">
                                            </div>
                                            <div>
                                                <label class="form-label">{{ ___('common.title') }} - ({{$language->name}})</label>
                                                <input class="form-control ot-input mb-2" value="{{isset($data['translates'][$language->code][0]) ? $encoded[0]->title :  @$data['sections']->data[0]['title']}}" name="data[{{$language->code}}][title][]" placeholder="{{ ___('common.Enter title') }}">
                                            </div>
                                            <div>
                                                <label class="form-label">{{ ___('common.Description') }} - ({{$language->name}})</label>
                                                <textarea class="form-control ot-textarea mt-0 mb-5" name="data[{{$language->code}}][description][]" placeholder="{{ ___('common.Enter description') }}">{{isset($data['translates'][$language->code][0]) ? $encoded[0]->description :  @$data['sections']->data[0]['description']}}</textarea>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div>
                                                <label class="form-label">{{ ___('common.Tab') }} - ({{$language->name}})</label>
                                                <input class="form-control ot-input mb-2" value="{{isset($data['translates'][$language->code][0]) ? $encoded[1]->tab :  @$data['sections']->data[1]['tab']}}" name="data[{{$language->code}}][tab][]" placeholder="{{ ___('common.Enter tab') }}">
                                            </div>
                                            <div>
                                                <label class="form-label">{{ ___('common.title') }} - ({{$language->name}})</label>
                                                <input class="form-control ot-input mb-2" value="{{isset($data['translates'][$language->code][0]) ? $encoded[1]->title :  @$data['sections']->data[1]['title']}}" name="data[{{$language->code}}][title][]" placeholder="{{ ___('common.Enter title') }}">
                                            </div>
                                            <div>
                                                <label class="form-label">{{ ___('common.Description') }} - ({{$language->name}})</label>
                                                <textarea class="form-control ot-textarea mt-0" name="data[{{$language->code}}][description][]" placeholder="{{ ___('common.Enter description') }}">{{isset($data['translates'][$language->code][0]) ? $encoded[1]->description :  @$data['sections']->data[1]['description']}} </textarea>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div>
                                                <label class="form-label">{{ ___('common.Tab') }} - ({{$language->name}})</label>
                                                <input class="form-control ot-input mb-2" value="{{isset($data['translates'][$language->code][0]) ? $encoded[2]->tab :  @$data['sections']->data[2]['tab']}}" name="data[{{$language->code}}][tab][]" placeholder="{{ ___('common.Enter tab') }}">
                                            </div>
                                            <div>
                                                <label class="form-label">{{ ___('common.title') }} - ({{$language->name}})</label>
                                                <input class="form-control ot-input mb-2" value="{{isset($data['translates'][$language->code][0]) ? $encoded[2]->title :  @$data['sections']->data[2]['title']}}" name="data[{{$language->code}}][title][]" placeholder="{{ ___('common.Enter title') }}">
                                            </div>
                                            <div>
                                                <label class="form-label">{{ ___('common.Description') }} - ({{$language->name}})</label>
                                                <textarea class="form-control ot-textarea mt-0" name="data[{{$language->code}}][description][]" placeholder="{{ ___('common.Enter description') }}">{{isset($data['translates'][$language->code][0]) ? $encoded[2]->description :  @$data['sections']->data[2]['description']}}</textarea>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div>
                                                <label class="form-label">{{ ___('common.Tab') }} - ({{$language->name}})</label>
                                                <input class="form-control ot-input mb-2" value="{{isset($data['translates'][$language->code][0]) ? $encoded[2]->tab :  @$data['sections']->data[2]['tab']}}" name="data[{{$language->code}}][tab][]" placeholder="{{ ___('common.Enter tab') }}">
                                            </div>
                                            <div>
                                                <label class="form-label">{{ ___('common.title') }} - ({{$language->name}})</label>
                                                <input class="form-control ot-input mb-2" value="{{isset($data['translates'][$language->code][0]) ? $encoded[2]->title :  @$data['sections']->data[2]['title']}}" name="data[{{$language->code}}][title][]" placeholder="{{ ___('common.Enter title') }}">
                                            </div>
                                            <div>
                                                <label class="form-label">{{ ___('common.Description') }} - ({{$language->name}})</label>
                                                <textarea class="form-control ot-textarea mt-0" name="data[{{$language->code}}][description][]" placeholder="{{ ___('common.Enter description') }}">{{isset($data['translates'][$language->code][0]) ? $encoded[2]->description :  @$data['sections']->data[2]['description']}}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            @if (@$data['sections']->key == 'why_choose_us') {{-- -------------------------------- why_choose_us --------------------------------- --}}
                                <h3 class="mt-3">{{___('common.Details')}}</h3>
                                

                                <div class="col-md-12">
                                    <table class="table" id="why_choose_us">
                                        <thead></thead>
                                        <tbody>
                                            @foreach (json_decode(@$data['translates'][$language->code][0]->data) as $key=>$item)
                                                <tr>
                                                    <td>
                                                        <label class="form-label">{{ ___('common.name') }} - ({{$language->name}})</label>
                                                        <div class="d-flex align-items-center mb-2">
                                                            <input class="form-control ot-input mr-2" value="{{ $item }}" name="data[{{$language->code}}][]"placeholder="{{ ___('common.Enter name') }}">
                                                            
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @endif
                            @if (@$data['sections']->key == 'academic_curriculum') {{-- -------------------------------- academic_curriculum --------------------------------- --}}
                                <h3 class="mt-3">{{___('common.Details')}}</h3>                                

                                <div class="col-md-12">
                                    <table class="table" id="academic_curriculum">
                                        <thead></thead>
                                        <tbody>
                                            @foreach (@json_decode(@$data['translates'][$language->code][0]->data) as $key=>$item)
                                                <tr>
                                                    <td>
                                                        <label class="form-label">{{ ___('common.name') }} - ({{$language->name}})</label>
                                                        <div class="d-flex align-items-center mb-2">
                                                            <input class="form-control ot-input mr-2" value="{{ $item }}" name="data[{{$language->code}}][]"placeholder="{{ ___('common.Enter name') }}">
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @endif
                                {{-- dynamic sections  --}}
                            @endforeach


                                <div class="col-md-12 mt-24">
                                    <div class="text-end">
                                        <button class="btn btn-lg ot-btn-primary"><span><i class="fa-solid fa-save"></i>
                                            </span>{{ ___('common.update') }}</button>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
            </div>
        </div>
    </div>
@endsection
