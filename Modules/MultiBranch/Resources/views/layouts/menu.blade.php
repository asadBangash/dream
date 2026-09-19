<li class="sidebar-menu-item {{ set_menu(['branches*']) }}">
    <a href="{{ route('branch.index') }}" class="parent-item-content">
        <i class="las la-code-branch"></i>
        <span class="on-half-expanded">{{ ___('common.Branch') }}
            @if(env('APP_DEMO'))
                <span class="badge badge-danger text-white">{{ ___('addon.Addon') }}</span>
            @endif
        </span>
    </a>
</li>
