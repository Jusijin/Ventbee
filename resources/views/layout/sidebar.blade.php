<link rel="stylesheet" href="{{ asset('css/sidebar.css') }}">

<div class="sidebar position-fixed p-3">
    <div class="text-center mb-4">
        <img src="{{ asset('img/logo_ventbee_baru.png') }}" width="200" alt="Logo">
    </div>

    {{-- User Box --}}
    <div class="sidebar-user-box">
        <div class="user-avatar">
            <i class="bi bi-person-circle"></i>
        </div>
        <div class="user-info">
            <small>{{ __('sidebar.hello') }}</small>
            <h6 class="mb-0">{{ auth()->user()->name }}</h6>
            <span class="badge {{ auth()->user()->role == 'admin' ? 'bg-danger' : 'bg-primary' }} text-white" style="font-size: 10px;">
                {{ ucfirst(auth()->user()->role) }}
            </span>
        </div>
    </div>

    <ul class="nav flex-column gap-3 mt-3">

        {{-- ============ MENU KHUSUS ADMIN ============ --}}
        @if(auth()->user()->role === 'admin')
            
            {{-- HANYA TAMPILKAN DASHBOARD --}}
            <li class="nav-item">
                <a href="{{ route('admin.dashboard') }}" 
                   class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <div class="sb-nav-link-icon"><i class="bi bi-speedometer2"></i></div>
                    {{ __('sidebar.dashboard_admin')}}
                </a>
            </li>

        {{-- ============ MENU KHUSUS USER ============ --}}
        @else
            <li class="nav-item">
                <a href="{{ route('user.dashboard') }}" 
                   class="nav-link {{ request()->routeIs('user.dashboard') ? 'active' : '' }}">
                    {{ __('sidebar.dashboard') }}
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('user.events.index') }}" 
                   class="nav-link {{ request()->routeIs('user.events.index') ? 'active' : '' }}">
                    {{ __('sidebar.event') }}
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('history.index') }}" 
                   class="nav-link {{ request()->routeIs('history.index') ? 'active' : '' }}">
                    {{ __('sidebar.history') }}
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('user.profile') }}" 
                   class="nav-link {{ request()->routeIs('user.profile') ? 'active' : '' }}">
                    {{ __('sidebar.profile') }}
                </a>
            </li>
        @endif
    </ul>
</div>