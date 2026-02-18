<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="{{ url('/') }}" class="app-brand-link">
            <span class="app-brand-logo demo">
                <i class="fas fa-tractor fa-2x text-green-700"></i>
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

@push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const currentUrl = window.location.href.split(/[?#]/)[0];
            const menuLinks = document.querySelectorAll('.menu-link');

            menuLinks.forEach(link => {
                if (!link.href || link.getAttribute('href').includes('javascript') || link.getAttribute(
                        'href') === '#') {
                    return;
                }

                if (link.href === currentUrl) {
                    const menuItem = link.closest('.menu-item');
                    if (menuItem) {
                        menuItem.classList.add('active');

                        let parent = menuItem.parentElement.closest('.menu-item');
                        while (parent) {
                            parent.classList.add('active', 'open');
                            parent = parent.parentElement.closest('.menu-item');
                        }
                    }
                }
            });
        });
    </script>
@endpush
