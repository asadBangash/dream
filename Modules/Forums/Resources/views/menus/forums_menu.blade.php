@if (hasPermission('forum_list'))
    <li class="sidebar-menu-item {{ set_menu(['forums*']) }}">
        <a class="parent-item-content has-arrow">
            <i class="las la-rss"></i>
            <span class="on-half-expanded">{{ ___('setting.Forums') }}</span>
        </a>
        <ul class="child-menu-list">
            @if (hasPermission('forum_list'))
                <li class="sidebar-menu-item {{ set_menu(['forum/*']) }}">
                    <a href="{{ route('my-forum.index') }}">{{ ___('setting.My Forums') }}</a>
                </li>
            @endif
            @if (hasPermission('forum_list'))
                <li class="sidebar-menu-item {{ set_menu(['forum/*']) }}">
                    <a href="{{ route('forum.index') }}">{{ ___('setting.Forums') }}</a>
                </li>
            @endif


            @if (hasPermission('forum_feeds'))
                <li class="sidebar-menu-item {{ set_menu(['forum/feeds*']) }}">
                    <a href="{{ route('forum.feeds') }}">{{ ___('setting.Forum Feeds') }}</a>
                </li>
            @endif
        </ul>
    </li>

    <li class="sidebar-menu-item {{ set_menu(['memories*']) }}">
        <a class="parent-item-content has-arrow">
            <i class="las la-photo-video"></i>
            <span class="on-half-expanded">{{ ___('setting.Memories') }}</span>
        </a>
        <ul class="child-menu-list">
            @if (hasPermission('memory_list'))
                <li class="sidebar-menu-item">
                    <a href="{{ route('memory.myIndex') }}">{{ ___('setting.My Memories') }}</a>
                </li>
            @endif

            @if (hasPermission('memory_list'))
                <li class="sidebar-menu-item">
                    <a href="{{ route('memory.index') }}">{{ ___('setting.Memories') }}</a>
                </li>
            @endif
        </ul>
    </li>
@endif
