<li class="menu-header small text-uppercase">
    <span class="menu-header-text">Manager Panel</span>
</li>
<li class="menu-item">
    <a href="{{ route('account.operation.dashboard') }}" class="menu-link">
        <i class="menu-icon tf-icons bx bx-home-circle"></i>
        <div>Dashboard</div>
    </a>
</li>

<!-- Quick Status -->
<li class="menu-item">
    <a href="#" class="menu-link">
        <i class="menu-icon tf-icons bx bx-pulse"></i>
        <div>P2H History</div>
    </a>
</li>

<!-- SYSTEM SETTINGS -->
<li class="menu-header small text-uppercase">
    <span class="menu-header-text">P2H Handler</span>
</li>

<li class="menu-item">
    <a href="javascript:void(0);" class="menu-link menu-toggle">
        <i class="menu-icon tf-icons bx bx-cog"></i>
        <div>P2H</div>
    </a>
    <ul class="menu-sub">
        <li class="menu-item">
            <a href="#" class="menu-link">
                <div>Monitoring Unit</div>
            </a>
        </li>
        <li class="menu-item">
            <a href="{{route('operation.p2h.task.index')}}" class="menu-link">
                <div>Monitoring Task</div>
            </a>
        </li>
        <li class="menu-item">
            <a href="#" class="menu-link">
                <div>Tindak Lanjut</div>
            </a>
        </li>
        <li class="menu-item">
            <a href="#" class="menu-link">
                <div>Laporan</div>
            </a>
        </li>
    </ul>
</li>

<li class="menu-item">
    <a href="javascript:void(0);" class="menu-link menu-toggle">
        <i class="menu-icon tf-icons bx bx-data"></i>
        <div>Master Data</div>
    </a>
    <ul class="menu-sub">
        <li class="menu-item">
            <a href="#" class="menu-link">
                <div>Units</div>
            </a>
        </li>
        <li class="menu-item">
            <a href="#" class="menu-link">
                <div>Task</div>
            </a>
        </li>
        <li class="menu-item">
            <a href="#" class="menu-link">
                <div>Operator</div>
            </a>
        </li>
    </ul>
</li>

<!-- Quick Status -->
<li class="menu-item">
    <a href="{{route('auth.logout')}}" class="menu-link">
        <i class="menu-icon tf-icons bx bx-log-out"></i>
        <div>Logout</div>
    </a>
</li>