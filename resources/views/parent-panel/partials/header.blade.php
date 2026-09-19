<style>

    .notification_wrapper .notification_items {
      -webkit-transition: 0.3s;
      transition: 0.3s;
      top: 53px;
      position: absolute;
      z-index: 11;
      -webkit-box-shadow: 0 0 10px 3px rgba(0, 0, 0, 0.05);
              box-shadow: 0 0 10px 3px rgba(0, 0, 0, 0.05);
      width: 300px;
      top: 50px;
      right: 0;
      border-radius: 10px;
      z-index: 121;
      background: #f6f8ff;
      -webkit-transform: translateY(10px) translateX(50%);
              transform: translateY(10px) translateX(50%);
      opacity: 0;
      visibility: hidden;
      transition: 0.3s;
    }
    .notification_wrapper .notification_items .notification_header {
      padding: 20px;
      background-color: #2B2D35;
      border-radius: 10px 10px 0 0;
    }
    .notification_wrapper .notification_items .notification_header h3 {
      font-size: 18px;
      font-weight: 700;
      color: #fff;
    }
    .notification_wrapper .notification_items .notification_body {
      padding: 20px 20px 20px 20px;
      overflow: auto;
      max-height: 350px;
      border-radius: 0 0 10px 10px;
    }
    .notification_wrapper .notification_items .notification_body .notification_item {
      grid-gap: 10px;
    }
    .notification_wrapper .notification_items .notification_body .notification_item .icon {
      display: -webkit-box;
      display: -ms-flexbox;
      display: flex;
      -webkit-box-align: center;
          -ms-flex-align: center;
              align-items: center;
      -webkit-box-pack: center;
          -ms-flex-pack: center;
              justify-content: center;
      font-weight: 500;
      color: #fff;
      background-color: #7367f0;
      background-repeat: no-repeat;
      background-position: center center;
      background-size: cover;
      border-radius: 0.475rem;
      -ms-flex-negative: 0;
          flex-shrink: 0;
      width: 35px;
      height: 35px;
      color: #fff;
    }
    .notification_wrapper .notification_items .notification_body .notification_item .notification_item_content h5 {
      font-size: 16px;
      color: #000;
    }
    .notification_wrapper .notification_items .notification_body .notification_item .notification_item_content p {
      font-size: 12px;
      color: #000
    }
    .notification_wrapper .notification_items .notification_body .notification_item .notification_item_content .notification_time {
      background-color: #f9f9f9;
      font-size: 12px;
      padding: 2px 10px;
      border-radius: 4px;
    }
    .notification_wrapper:hover .notification_items {
      opacity: 1;
      visibility: visible;
      -webkit-transform: translateY(0px) translateX(50%);
              transform: translateY(0px) translateX(50%);
    }
    </style>
<header class="header">
    <button class="close-toggle sidebar-toggle p-0">
        <img src="{{ global_asset('backend') }}/assets/images/icons/hammenu-2.svg" alt="" />
    </button>
    <div class="spacing-icon">
        <div class="header-search tab-none">
            <div class="search-icon">
                <i class="las la-search"></i>
            </div>
            <input class="search-field ot_input" id="search_field" type="text"
                placeholder="{{ ___('common.search_page') }}" onkeyup="searchParentMenu()">
            <div id="autoCompleteData" class="d-none">
                <ul class="search_suggestion">

                </ul>
            </div>
        </div>

        <div class="header-controls">


            <div class="header-control-item md-none">

            </div>
            <div class="header-control-item">
                <div class="dropdown theme_dropdown ">
                    <button id="button" class="btn "><i class="lar la-sun"></i></button>
                </div>
            </div>
            <div class="header-control-item">
                <div class="item-content dropdown md-none">
                    <button class="mt-0" onclick="javascript:toggleFullScreen()">
                        <img class="icon" src="{{ global_asset('backend/assets/images/icons/full-screen.svg') }}" alt="check in" />
                    </button>
                </div>
            </div>

            <div class="header-control-item">
                <div class="notification_wrapper position-relative d-none d-xl-flex">
                    <a href="#" class="search-home ">
                        <i class="las la-bell fs_25"></i>
                    </a>
                    <div class="notification_items position-absolute">
                        <div class="notification_header">
                            <h3>Notifications</h3>
                        </div>
                        <div class="notification_body d-flex flex-column gap-2">
                            @foreach ($notifications as $notification)
                                <a href="{{route('viewNotification',$notification->id)}}" class="notification_item d-flex align-items-center">
                                    <div class="icon">
                                        <i class="fas fa-bell"></i>
                                    </div>
                                    <div class="notification_item_content flex-fill d-flex align-items-center">
                                        <div class="notification_item_content_left flex-fill">
                                            <h6>{{$notification->title}}</h6>
                                            <p>{{$notification->message}}</p>
                                        </div>
                                        <span class="notification_time">{{ \Carbon\Carbon::parse($notification->created_at)->format('F j Y') }}</span>
                                    </div>
                                </a>
                            @endforeach


                        </div>
                    </div>
                </div>
            </div>


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
                                <a class="profile-expand-item {{ set_menu(['parent-panel.profile'], 'active') }}"
                                    href="{{ route('parent-panel.profile') }}">
                                    <span>{{ ___('common.profile') }}</span>
                                </a>
                                <a class="profile-expand-item {{ set_menu(['parent-panel.password-update'], 'active') }}"
                                    href="{{ route('parent-panel.password-update') }}">
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


