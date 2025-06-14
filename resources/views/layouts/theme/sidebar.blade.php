<ul class="pc-navbar">
    <li class="pc-item pc-caption">
        <label>Navigation</label>
        <i class="ti ti-dashboard"></i>
    </li>
    <li class="pc-item">
        <a href="{{ route('v1.dashboard') }}" class="pc-link">
            <span class="pc-micon">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="pc-icon">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M5 12l-2 0l9 -9l9 9l-2 0" />
                    <path d="M5 12v7a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-7" />
                    <path d="M9 21v-6a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v6" />
                </svg>
            </span>
            <span class="pc-mtext">Dashboard</span>
        </a>
    </li>

    @include('layouts.theme.sidebar.admin')

    @foreach (auth()->user()->layout() as $menu)
        <!-- Judul Menu -->
        <li class="pc-item pc-caption">
            <label>{{ $menu->label }}</label>
            @if ($menu->icon)
                <i class="ti ti-dashboard"></i>
            @endif
        </li>

        <!-- Sub-Menu -->
        @foreach ($menu->children->sortBy('order') as $child)
            <li class="pc-item {{ request()->is(str_replace('.', '/', $child->route) . '*') ? 'active' : '' }}">
                <a href="{{ route($child->route) }}" class="pc-link">
                    <span class="pc-micon">
                        <svg class="pc-icon">
                            <use xlink:href="#{{ $child->icon }}"></use>
                        </svg>
                    </span>
                    <span class="pc-mtext">{{ $child->label }}</span>
                </a>
            </li>
        @endforeach
    @endforeach

    <li class="pc-item pc-caption">
        <label>Kelola Toko</label>
        <i class="ti ti-dashboard"></i>
    </li>

    <li class="pc-item">
        <a href="{{ route('v1.product.index') }}" class="pc-link">
            <span class="pc-micon">
                <svg class="pc-icon">
                    <use xlink:href="#custom-bag"></use>
                </svg>
            </span>
            <span class="pc-mtext">Product Saya</span>
        </a>
    </li>

    <li class="pc-item">
        <a href="{{ route('v1.master.manualBook') }}" class="pc-link">
            <span class="pc-micon">
                <svg class="pc-icon">
                    <use xlink:href="#custom-refresh-2"></use>
                </svg>
            </span>
            <span class="pc-mtext">Otomasi Product</span>
        </a>
    </li>

    <li class="pc-item">
        <a href="{{ route('v1.master.manualBook') }}" class="pc-link">
            <span class="pc-micon">
                <svg class="pc-icon">
                    <use xlink:href="#custom-text-block"></use>
                </svg>
            </span>
            <span class="pc-mtext">Ai Generate Desc</span>
        </a>
    </li>

    <li class="pc-item">
        <a href="{{ route('v1.master.manualBook') }}" class="pc-link">
            <span class="pc-micon">
                <svg class="pc-icon">
                    <use xlink:href="#custom-image"></use>
                </svg>
            </span>
            <span class="pc-mtext">Ai Foto Product</span>
        </a>
    </li>

    <li class="pc-item">
        <a href="{{ route('v1.master.manualBook') }}" class="pc-link">
            <span class="pc-micon">
                <svg class="pc-icon">
                    <use xlink:href="#custom-graph"></use>
                </svg>
            </span>
            <span class="pc-mtext">Ai Riset Harga</span>
        </a>
    </li>

    <li class="pc-item">
        <a href="{{ route('v1.master.manualBook') }}" class="pc-link">
            <span class="pc-micon">
                <svg class="pc-icon">
                    <use xlink:href="#custom-message-2"></use>
                </svg>
            </span>
            <span class="pc-mtext">Whatsapp Blast</span>
        </a>
    </li>

    <li class="pc-item">
        <a href="{{ route('v1.master.manualBook') }}" class="pc-link">
            <span class="pc-micon">
                <svg class="pc-icon">
                    <use xlink:href="#custom-dollar-square"></use>
                </svg>
            </span>
            <span class="pc-mtext">Kalkulator HPP</span>
        </a>
    </li>

    <li class="pc-item pc-caption">
        <label>Other</label>
        <i class="ti ti-brand-chrome"></i>
    </li>
    <li class="pc-item">
        <a href="{{ route('v1.master.manualBook') }}" class="pc-link">
            <span class="pc-micon">
                <svg class="pc-icon">
                    <use xlink:href="#custom-keyboard"></use>
                </svg>
            </span>
            <span class="pc-mtext">Manual Book</span>
        </a>
    </li>
    <li class="pc-item {{ request()->is('v1/contactUs*') ? 'active' : '' }}">
        <a href="{{ route('v1.contactUs') }}" class="pc-link">
            <span class="pc-micon">
                <svg class="pc-icon">
                    <use xlink:href="#custom-call-calling"></use>
                </svg>
            </span>
            <span class="pc-mtext">Open Ticket</span>
        </a>
    </li>

    <li class="pc-item {{ request()->is('v1/contactUs*') ? 'active' : '' }}">
        <a href="{{ route('v1.contactUs') }}" class="pc-link">
            <span class="pc-micon">
                <svg class="pc-icon">
                    <use xlink:href="#custom-shopping-bag"></use>
                </svg>
            </span>
            <span class="pc-mtext">Langganan</span>
        </a>
    </li>

</ul>

<div class="card pc-user-card mt-3">
    <div class="card-body text-center">
        <img src="../assets/images/application/img-coupon.png" alt="img" class="img-fluid w-50">
        <h5 class="mb-0 mt-1">Upgrade</h5>
        <p>Checkout Packages</p>
        <a href="https://themeforest.net/item/able-pro-bootstrap-admin-dashboard-template/50170229" target="_blank"
            class="btn btn-warning">
            <svg class="pc-icon me-2">
                <use xlink:href="#custom-logout-1-outline"></use>
            </svg>
            Upgrade Langganan
        </a>
    </div>
</div>
