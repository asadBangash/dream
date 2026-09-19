@if (hasPermission('livechat_read'))
    <li class="sidebar-menu-item {{ set_menu(['admin/live-chat*']) }}">
        <a href="{{ route('livechat.index') }}" class="parent-item-content">
            <i class="lab la-facebook-messenger"></i>
            <span class="on-half-expanded">{{ ___('live_chat.Live_Chat') }}</span>
            @if (env('APP_DEMO'))
                <span class="badge badge-danger text-white">{{ ___('addon.Addon') }}</span>
            @endif
        </a>
    </li>
@endif
