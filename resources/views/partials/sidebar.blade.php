<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="{{ url('/') }}" class="app-brand-link">
            <span class="app-brand-logo demo">
                <svg width="28" height="28" viewBox="0 0 64 64" fill="none" stroke="white" stroke-width="3"
                    stroke-linecap="round" stroke-linejoin="round">

                    <!-- Trunk -->
                    <path d="M32 30 L32 58" />

                    <!-- Leaves -->
                    <path d="M32 30 C20 20, 10 22, 6 16" />
                    <path d="M32 30 C44 20, 54 22, 58 16" />
                    <path d="M32 28 C18 26, 12 18, 10 10" />
                    <path d="M32 28 C46 26, 52 18, 54 10" />
                    <path d="M32 26 C22 14, 22 8, 32 6" />
                    <path d="M32 26 C42 14, 42 8, 32 6" />

                </svg>
            </span>
            <span class="app-brand-text demo menu-text fw-bolder ms-2">{{ $siteName }}</span>
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>
    <ul class="menu-inner py-1">
        {{-- ================= ADMIN ================= --}}
        @if (auth()->user()->role?->name === 'Admin')
            @include('partials.role.adminSidebar')
        @endif
    </ul>
</aside>
