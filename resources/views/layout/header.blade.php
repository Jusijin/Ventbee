<div class="header">
    <nav class="navbar navbar-expand bg-white shadow-sm px-4"
    style="height: 65px">

    <div class="container-fluid">
        <h5 class="name-title">{{ __('header.event')}}</h5>

        <div class="d-flex align-items-center gap-4">
            {{-- Ubah Bahasa --}}
            <div class="dropdown">
                <button class="btn dropdown-toggle" data-bs-toggle="dropdown">
                    <i class="bi bi-globe fs-6"></i>
                    {{ strtoupper(app()->getLocale()) }}
                </button>
                
                <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                        <a class="dropdown-item" href="{{ route('lang.switch', 'id') }}">
                            🇮🇩 Bahasa Indonesia
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="{{ route('lang.switch', 'en') }}">
                            🇺🇸 English
                        </a>
                    </li>
                </ul>
            </div>

            {{-- Notifikasi --}}
            <div class="dropdown">
                <button class="btn position-relative" data-bs-toggle="dropdown">
                    <i class="bi bi-bell fs-5"></i>
                    
                    {{-- Hitung Total Notifikasi (DB + Event Hari Ini) --}}
                    @php
                        $totalNotif = 0;
                        if(auth()->check()){
                            $totalNotif = (isset($notif_db) ? $notif_db->count() : 0) + 
                                          (isset($notif_today) ? $notif_today->count() : 0);
                        }
                    @endphp

                    @if($totalNotif > 0)
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                            {{ $totalNotif }}
                        </span>
                    @endif
                </button>

                <ul class="dropdown-menu dropdown-menu-end" style="width: 300px; max-height: 400px; overflow-y: auto;">
                    <li class="dropdown-header">{{ __('header.notification')}}</li>
                    
                    @if($totalNotif == 0)
                        <li><a class="dropdown-item text-muted text-center" href="#">{{ __('header.new_notification')}}</a></li>
                    @else
                        
                        {{-- 1. Tampilkan Event Hari Ini --}}
                        @if(isset($notif_today))
                            @foreach($notif_today as $event)
                            <li>
                                <a class="dropdown-item border-bottom bg-light" href="#">
                                    <small class="text-primary fw-bold">📅 Event Dimulai Hari Ini!</small><br>
                                    <span class="fw-bold">{{ $event->event_name }}</span><br>
                                    <small class="text-muted">{{ $event->date->format('H:i') }} WIB</small>
                                </a>
                            </li>
                            @endforeach
                        @endif

                        {{-- 2. Tampilkan Notifikasi Pendaftaran (Database) --}}
                        @if(isset($notif_db))
                            @foreach($notif_db as $notif)
                            <li>
                                {{-- Saat diklik, notifikasi ditandai sudah dibaca --}}
                                <a class="dropdown-item border-bottom" href="{{ route('notifications.read', $notif->id) }}">
                                    @if($notif->data['type'] == 'registration')
                                        <small class="text-success fw-bold">✅ Pendaftaran Berhasil</small><br>
                                    @endif
                                    <span>{{ $notif->data['message'] }}</span>
                                </a>
                            </li>
                            @endforeach
                        @endif

                    @endif
                </ul>
            </div>

            {{-- Akun User --}}
            <div class="dropdown">
                <button class="btn btn-light dropdown-toggle"
                    type="button"
                    data-bs-toggle="dropdown"
                    aria-expanded="false">
                    {{ auth()->user()->name }}
                </button>

                <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                        <a class="dropdown-item d-flex align-items-center gap-2" href="#">
                            <i class="bi bi-person-fill"></i>
                            {{ __('header.profile') }}
                        </a>
                    </li>
                    <li>
                        <form method="POST" action="logout">
                            @csrf
                            <button class="dropdown-item d-flex align-items-center gap-2 text-danger">
                                <i class="bi bi-box-arrow-right"></i>
                                {{ __('header.logout')}}
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    </nav>

    <script src="{{ asset('js/header.js') }}"></script>
</div>