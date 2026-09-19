<li class="sidebar-menu-item {{ set_menu(['forums*']) }}">
    <a class="parent-item-content has-arrow">
        <i class="las la-rss"></i>
        <span class="on-half-expanded">{{ ___('setting.Forums') }}</span>
    </a>
    <ul class="child-menu-list">
        <li class="sidebar-menu-item {{ set_menu(['forum/*']) }}">
            <a
                href="{{ route('student-panel-forum.index', ['publisher' => auth()->user()->role_id]) }}">{{ ___('setting.My Forums') }}</a>
        </li>
        <li class="sidebar-menu-item {{ set_menu(['forum/feeds*']) }}">
            <a href="{{ route('student-panel-forum.feeds') }}">{{ ___('setting.Forum Feeds') }}</a>
        </li>
    </ul>
</li>

<li class="sidebar-menu-item {{ set_menu(['memories*']) }}">
    <a class="parent-item-content has-arrow">
        <i class="las la-photo-video"></i>
        <span class="on-half-expanded">{{ ___('setting.Memories') }}</span>
    </a>
    <ul class="child-menu-list">
        <li class="sidebar-menu-item">
            <a
                href="{{ route('student-panel-memory.index') }}">{{ ___('setting.My Memories') }}</a>
        </li>
        {{-- <li class="sidebar-menu-item">
            <a href="{{ route('student-panel-memory.index') }}">{{ ___('setting.Memories') }}</a>
        </li> --}}
    </ul>
</li>
