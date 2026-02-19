<li class="menu-header small text-uppercase">
    <span class="menu-header-text">Admin Panel</span>
</li>
<li class="menu-item">
    <a href="{{ route('account.dashboard') }}" class="menu-link">
        <i class="menu-icon tf-icons bx bx-home-circle"></i>
        <div>Dashboard</div>
    </a>
</li>

<!-- Quick Status -->
<li class="menu-item">
    <a href="#" class="menu-link">
        <i class="menu-icon tf-icons bx bx-pulse"></i>
        <div>System Status</div>
    </a>
</li>

<!-- SYSTEM SETTINGS -->
<li class="menu-header small text-uppercase">
    <span class="menu-header-text">System Settings</span>
</li>

<li class="menu-item">
    <a href="javascript:void(0);" class="menu-link menu-toggle">
        <i class="menu-icon tf-icons bx bx-cog"></i>
        <div>Configuration</div>
    </a>
    <ul class="menu-sub">
        <li class="menu-item">
            <a href="{{route('setting.website')}}" class="menu-link">
                <div>General Settings</div>
            </a>
        </li>
        <li class="menu-item">
            <a href="#" class="menu-link">
                <div>Maintenance Mode</div>
            </a>
        </li>
        <li class="menu-item">
            <a href="#" class="menu-link">
                <div>QR Settings</div>
            </a>
        </li>
        <li class="menu-item">
            <a href="#" class="menu-link">
                <div>Default Status Rules</div>
            </a>
        </li>
    </ul>
</li>

<li class="menu-item">
    <a href="javascript:void(0);" class="menu-link menu-toggle">
        <i class="menu-icon tf-icons bx bx-lock-alt"></i>
        <div>Route Permission</div>
    </a>
    <ul class="menu-sub">
        <li class="menu-item">
            <a href="#" class="menu-link">
                <div>Set Route Name</div>
            </a>
        </li>
        <li class="menu-item">
            <a href="#" class="menu-link">
                <div>Assign Role</div>
            </a>
        </li>
        <li class="menu-item">
            <a href="#" class="menu-link">
                <div>Toggle Active / Nonaktif</div>
            </a>
        </li>
    </ul>
</li>

<li class="menu-item">
    <a href="javascript:void(0);" class="menu-link menu-toggle">
        <i class="menu-icon tf-icons bx bx-building-house"></i>
        <div>Estate / Kebun</div>
    </a>
    <ul class="menu-sub">
        <li class="menu-item">
            <a href="#" class="menu-link">
                <div>Tambah Kebun</div>
            </a>
        </li>
        <li class="menu-item">
            <a href="#" class="menu-link">
                <div>Set Kode Kebun</div>
            </a>
        </li>
        <li class="menu-item">
            <a href="#" class="menu-link">
                <div>Set Active Estate</div>
            </a>
        </li>
    </ul>
</li>

<!-- MASTER DATA -->
<li class="menu-header small text-uppercase">
    <span class="menu-header-text">Master Data</span>
</li>

<li class="menu-item">
    <a href="javascript:void(0);" class="menu-link menu-toggle">
        <i class="menu-icon tf-icons bx bx-data"></i>
        <div>Data Management</div>
    </a>
    <ul class="menu-sub">
        <li class="menu-item">
            <a href="{{route('master.data.items')}}" class="menu-link">
                <div>Items</div>
            </a>
        </li>
        <li class="menu-item">
            <a href="{{route('master.data.attributes')}}" class="menu-link">
                <div>Attributes</div>
            </a>
        </li>
        <li class="menu-item">
            <a href="{{route('master.data.itemattributes')}}" class="menu-link">
                <div>Item Attribute Details</div>
            </a>
        </li>
        <li class="menu-item">
            <a href="{{route('master.data.itemattributes.attach')}}" class="menu-link">
                <div>Attach Attribute</div>
            </a>
        </li>
    </ul>
</li>

<li class="menu-item">
    <a href="javascript:void(0);" class="menu-link menu-toggle">
        <i class="menu-icon tf-icons bx bx-user"></i>
        <div>Users</div>
    </a>
    <ul class="menu-sub">
        <li class="menu-item">
            <a href="#" class="menu-link">
                <div>List User</div>
            </a>
        </li>
        <li class="menu-item">
            <a href="#" class="menu-link">
                <div>Create User</div>
            </a>
        </li>
        <li class="menu-item">
            <a href="#" class="menu-link">
                <div>Reset Password</div>
            </a>
        </li>
    </ul>
</li>

<!-- ROUTE PERMISSION -->
<li class="menu-header small text-uppercase">
    <span class="menu-header-text">Access Control</span>
</li>
<li class="menu-item">
    <a href="javascript:void(0);" class="menu-link menu-toggle">
        <i class="menu-icon tf-icons bx bx-devices"></i>
        <div>Session Handler</div>
    </a>

    <ul class="menu-sub">

        <!-- Active Sessions -->
        <li class="menu-item">
            <a href="#" class="menu-link">
                <i class="menu-icon tf-icons bx bx-user-check"></i>
                <div>Active Sessions</div>
            </a>
        </li>

        <!-- Login Logs -->
        <li class="menu-item">
            <a href="#" class="menu-link">
                <i class="menu-icon tf-icons bx bx-history"></i>
                <div>Login History</div>
            </a>
        </li>

        <li class="menu-item">
            <a href="#" class="menu-link">
                <div>Force Logout</div>
            </a>
        </li>
        
        <li class="menu-item">
            <a href="#" class="menu-link">
                <div>Set Role / Hak Akses</div>
            </a>
        </li>

        <!-- Device Tracking -->
        <li class="menu-item">
            <a href="#" class="menu-link">
                <i class="menu-icon tf-icons bx bx-mobile-alt"></i>
                <div>Device Tracking</div>
            </a>
        </li>

        <!-- Session Timeout Config -->
        <li class="menu-item">
            <a href="#" class="menu-link">
                <i class="menu-icon tf-icons bx bx-timer"></i>
                <div>Session Timeout Config</div>
            </a>
        </li>

    </ul>
</li>
