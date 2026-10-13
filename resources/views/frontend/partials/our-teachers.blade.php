@php
    $teachersPageUrl = $teachersPageUrl ?? route('frontend.teachers');
    $showViewAll = $showViewAll ?? false;
@endphp
<!-- instractors_wrapper::start  -->
<div class="instractors_wrapper gray_bg section_padding">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section__title mb_76 text-center">
                    @if ($showViewAll)
                        <a href="{{ $teachersPageUrl }}" class="d-inline-block text-decoration-none">
                            <h3 class="text-capitalize mb-0">{{ @$sections['our_teachers']->defaultTranslate->name }}</h3>
                        </a>
                    @else
                        <h3 class="text-capitalize">{{ @$sections['our_teachers']->defaultTranslate->name }}</h3>
                    @endif
                </div>
            </div>
        </div>
        <div class="row">
            @foreach ($teachers as $item)
                <div class="col-md-6 col-lg-4 col-xl-3">
                    <div class="single_instractor mb_30 position-relative">
                        @if ($showViewAll)
                            <a href="{{ $teachersPageUrl }}" class="thumb d-block">
                                <img src="{{ @globalAsset(@$item->upload->path, '340X340.webp') }}" alt="{{ @$item->first_name }} {{ @$item->last_name }}">
                            </a>
                        @else
                            <a href="#" class="thumb">
                                <img src="{{ @globalAsset(@$item->upload->path, '340X340.webp') }}" alt="{{ @$item->first_name }} {{ @$item->last_name }}">
                            </a>
                        @endif
                        <div class="instractor_info text-center">
                            <div class="instractor_info_content">
                                @if ($showViewAll)
                                    <a href="{{ $teachersPageUrl }}" class="text-decoration-none">
                                        <h4>{{ @$item->first_name }} {{ @$item->last_name }}</h4>
                                    </a>
                                @else
                                    <h4>{{ @$item->first_name }} {{ @$item->last_name }}</h4>
                                @endif
                                <div class="teacher_card_meta">
                                    @if (@$item->designation?->name)
                                        <p class="teacher_designation">
                                            <span>{{ ___('common.designation') }}:</span>
                                            {{ $item->designation->name }}
                                        </p>
                                    @endif
                                    @if (filled($item->qualification))
                                        <p class="teacher_qualification">
                                            <span>{{ ___('staff.qualification') }}:</span>
                                            {{ $item->qualification }}
                                        </p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        @if ($showViewAll && $teachers->isNotEmpty())
            <div class="row">
                <div class="col-12 text-center mt_20">
                    <a href="{{ $teachersPageUrl }}" class="theme_btn min_windth_200">{{ ___('frontend.view_all_teachers') }}</a>
                </div>
            </div>
        @endif
    </div>
</div>
<!-- instractors_wrapper::end  -->
