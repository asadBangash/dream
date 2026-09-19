@if (auth()->user()->role_id == \App\Enums\RoleEnum::ADMIN ||
        auth()->user()->role_id == \App\Enums\RoleEnum::SUPERADMIN ||
        auth()->user()->role_id == \App\Enums\RoleEnum::STAFF)

    @if (auth()->user()->role_id == \App\Enums\RoleEnum::SUPERADMIN || auth()->user()->role_id == \App\Enums\RoleEnum::ADMIN)
        <li
            class="sidebar-menu-item {{ set_menu(['admin/live-chat*', 'admin/conversation-list*', 'admin/conversation*']) }}">
            <a class="parent-item-content has-arrow" aria-expanded="false">
                <i class="lab la-facebook-messenger"></i>
                <span class="on-half-expanded">{{ ___('settings.Live Chat') }}</span>
            </a>
            <ul class="child-menu-list">
                <li class="sidebar-menu-item {{ set_menu(['admin/live-chat*']) }}">
                    <a href="{{ route('admin.live_chat') }}">
                        {{ ___('settings.Messaging') }}
                    </a>
                </li>
                <li class="sidebar-menu-item {{ set_menu(['admin/conversation-list*', 'admin/conversation*']) }}">
                    <a href="{{ route('admin.livechat.conversation_list') }}">
                        {{ ___('settings.All Conversations') }}
                    </a>
                </li>
            </ul>
        </li>
    @else
        <li class="sidebar-menu-item {{ set_menu(['admin/live-chat*']) }}">
            <a href="{{ route('admin.live_chat') }}" class="parent-item-content">
                <i class="lab la-facebook-messenger"></i>
                <span class="on-half-expanded">{{ ___('settings.Live Chat') }}</span>
            </a>
        </li>
    @endif

@endif

@if (auth()->user()->role_id == \App\Enums\RoleEnum::TEACHER)
    <li class="sidebar-menu-item {{ set_menu(['instructor/live-chat*']) }}">
        <a href="{{ route('instructor.live_chat') }}" class="parent-item-content">
            <i class="lab la-facebook-messenger"></i>
            <span class="on-half-expanded">{{ ___('settings.Live Chat') }}</span>
        </a>
    </li>
@endif

@if (auth()->user()->role_id == \App\Enums\RoleEnum::STUDENT)
    <li class="sidebar-menu-item {{ set_menu(['student/live-chat*']) }}">
        <a href="{{ route('student.live_chat') }}" class="parent-item-content">
            <i class="lab la-facebook-messenger"></i>
            <span class="on-half-expanded">{{ ___('settings.LiveChat') }}</span>
        </a>
    </li>
@endif

@if (auth()->user()->role_id == \App\Enums\RoleEnum::GUARDIAN)
    <li class="sidebar-menu-item {{ set_menu(['guardian/live-chat*']) }}">
        <a href="{{ route('guardian.live_chat') }}" class="parent-item-content">
            <i class="lab la-facebook-messenger"></i>
            <span class="on-half-expanded">{{ ___('settings.Live Chat') }}</span>
        </a>
    </li>
@endif
