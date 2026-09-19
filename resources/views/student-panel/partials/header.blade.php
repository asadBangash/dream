<header class="header">
    <button class="close-toggle sidebar-toggle p-0">
        <img src="{{ asset('backend') }}/assets/images/icons/hammenu-2.svg" alt="" />
    </button>
    <div class="spacing-icon">
        <div class="header-search tab-none">
            <div class="search-icon">
                <i class="las la-search"></i>
            </div>
            <input class="search-field ot_input" id="search_field" type="text"
                placeholder="{{ ___('common.search_page') }}" onkeyup="searchStudentMenu()">
            <div id="autoCompleteData" class="d-none">
                <ul class="search_suggestion">

                </ul>
            </div>
        </div>

        <div class="header-controls">

            <div class="header-control-item">
                <div class="dropdown theme_dropdown ">
                    <button id="button" class="btn "><i class="lar la-sun"></i></button>
                </div>
            </div>
            <div class="header-control-item">
                <div class="item-content dropdown md-none">
                    <button class="mt-0" onclick="javascript:toggleFullScreen()">
                        <img class="icon" src="{{ asset('backend/assets/images/icons/full-screen.svg') }}" alt="check in" />
                    </button>
                </div>
            </div>







            {{-- Start attendance --}}
            <div class="header-control-item">
                <button class="mt-0 attendance_btn p-0" data-bs-toggle="modal" data-bs-target="#lead-modal">
                    <span><i class="las la-sign-in-alt"></i> </span>
                </button>
            </div>

            <div class="modal fade lead-modal" id="lead-modal"  aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content data">
                        <div class="modal-header modal-header-image mb-3">
                            <h5 class="modal-title text-white">{{ ___('common.Attendance') }}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                <i class="las la-times" aria-hidden="true"></i>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="row pb-4 text-align-center">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <div class="timer-field pt-2 pb-2">
                                            <h1 class="text-center">
                                            <div class="clock company_name_clock fs-16 clock" id="clock"
                                                onload="currentTime()">{{ ___('common.00:00:00') }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group w-100 mx-auto mb-3">
                                        <label class="form-label float-left">{{ ___('common.Message / Reason') }}</label>
                                        <textarea type="text" name="reason" id="reason" rows="3" class="form-control mt-0 ot_input">{{ old('reason') }}</textarea>
                                        <small class="error_show_reason text-left text-danger">

                                        </small>
                                    </div>
                                    <div class="form-group button-hold-container">
                                        <button class="button-hold" id="button-hold">
                                            <div>
                                                <svg class="progress" viewBox="0 0 32 32">
                                                    <circle r="8" cx="16" cy="16" />
                                                </svg>
                                                <svg class="tick" viewBox="0 0 32 32">
                                                    <polyline points="18,7 11,16 6,12" />
                                                </svg>
                                            </div>
                                        </button>
                                    </div>
                                    <input type="hidden" id="form_url" value="{{ route('student-panel-attendance.attendance') }}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- End attendance --}}

            <div class="header-control-item">
                <div class="item-content">
                    <button class="profile-navigate mt-0 p-0" type="button" id="profile_expand" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        <div class="profile-photo user-card">
                            <img src="{{ @globalAsset(Auth::user()->upload->path, '40X40.webp') }}" alt="{{ Auth::user()->name }}">
                        </div>
                        <div class="profile-info md-none">
                            <h6>{{ Auth::user()->name }}</h6>
                            <p>{{ @Auth::user()->role->name }}</p>
                        </div>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end profile-expand-dropdown top-navbar-dropdown-menu ot-card"
                        aria-labelledby="profile_expand">
                        <div class="profile-expand-container">
                            <div class="profile-expand-list d-flex flex-column">
                                <a class="profile-expand-item {{ set_menu(['student-panel.profile'], 'active') }}"
                                    href="{{ route('student-panel.profile') }}">
                                    <span>{{ ___('common.profile') }}</span>
                                </a>
                                <a class="profile-expand-item {{ set_menu(['student-panel.password-update'], 'active') }}"
                                    href="{{ route('student-panel.password-update') }}">
                                    <span>{{ ___('common.update_password') }}</span>
                                </a>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="profile-expand-item">
                                        <span>
                                            {{ ___('common.logout') }}</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</header>


