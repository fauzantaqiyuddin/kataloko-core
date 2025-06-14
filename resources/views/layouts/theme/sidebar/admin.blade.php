@if (auth()->user()->role == 'Administrator')
    <li class="pc-item pc-caption">
        <label>Admin Tools</label>
        <i class="ti ti-dashboard"></i>
    </li>

    <li class="pc-item">
        <a href="{{ route('admin.permission.index') }}" class="pc-link">
            <span class="pc-micon">
                <svg class="pc-icon">
                    <use xlink:href="#custom-lock-outline"></use>
                </svg>
            </span>
            <span class="pc-mtext">Permission Access</span>
        </a>
    </li>

    <li class="pc-item">
        <a href="{{ route('admin.menu.index') }}" class="pc-link">
            <span class="pc-micon">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="pc-icon">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M4 4h6v6h-6z" />
                    <path d="M14 4h6v6h-6z" />
                    <path d="M4 14h6v6h-6z" />
                    <path d="M17 17m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0" />
                </svg>
            </span>
            <span class="pc-mtext">Menu Access</span>
        </a>
    </li>

    <li class="pc-item">
        <a href="{{ route('admin.notify.index') }}" class="pc-link">
            <span class="pc-micon">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="pc-icon">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M10 5a2 2 0 1 1 4 0a7 7 0 0 1 4 6v3a4 4 0 0 0 2 3h-16a4 4 0 0 0 2 -3v-3a7 7 0 0 1 4 -6" />
                    <path d="M9 17v1a3 3 0 0 0 6 0v-1" />
                </svg>
            </span>
            <span class="pc-mtext">Notifikasi Users</span>
        </a>
    </li>

    <li class="pc-item">
        <a href="{{ route('admin.banner.index') }}" class="pc-link">
            <span class="pc-micon">
                <svg class="pc-icon">
                    <use xlink:href="#custom-password-check"></use>
                </svg>
            </span>
            <span class="pc-mtext">Banner Settings</span>
        </a>
    </li>

    <li class="pc-item">
        <a href="{{ route('admin.pageSettings.index') }}" class="pc-link">
            <span class="pc-micon">
                <svg class="pc-icon">
                    <use xlink:href="#custom-setting-2"></use>
                </svg>
            </span>
            <span class="pc-mtext">Page Settings</span>
        </a>
    </li>
    
    <li class="pc-item pc-caption">
        <label>Master Data</label>
        <i class="ti ti-dashboard"></i>
    </li>

    <li class="pc-item">
        <a href="{{ route('masterData.masterPackage.index') }}" class="pc-link">
            <span class="pc-micon">
                <svg class="pc-icon">
                    <use xlink:href="#custom-simcard-2"></use>
                </svg>
            </span>
            <span class="pc-mtext">Master Package</span>
        </a>
    </li>
@endif
