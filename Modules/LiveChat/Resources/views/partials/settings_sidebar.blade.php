@if (hasPermission('livechat_settings'))
    <li class="sidebar-menu-item {{ set_menu(['livechat.setting']) }}">
        <a href="{{ route('livechat.setting') }}">
            {{ ___('live_chat.live_chat') }}
            @if(env('APP_DEMO'))
                <span class="badge badge-danger text-white">{{ ___('addon.Addon') }}</span>
            @endif
        </a>
    </li>
@endif
