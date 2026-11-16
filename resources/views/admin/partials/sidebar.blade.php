<aside class="admin-sidebar" aria-label="Navigasi admin">
    <a class="admin-sidebar-brand" href="{{ route('admin.dashboard') }}">Nexa<span>Market</span></a>

    <div>
        <p class="admin-sidebar-label">Menu Admin</p>
        <nav class="admin-sidebar-nav">
            <a
                class="admin-sidebar-link {{ request()->routeIs('admin.dashboard') ? 'is-active' : '' }}"
                href="{{ route('admin.dashboard') }}"
                @if(request()->routeIs('admin.dashboard')) aria-current="page" @endif
            >
                <i class="fa-solid fa-chart-pie" aria-hidden="true"></i>
                Dashboard
            </a>
            <a
                class="admin-sidebar-link {{ request()->routeIs('admin.products.*') ? 'is-active' : '' }}"
                href="{{ route('admin.products.index') }}"
                @if(request()->routeIs('admin.products.*')) aria-current="page" @endif
            >
                <i class="fa-solid fa-box" aria-hidden="true"></i>
                Produk
            </a>
            <a
                class="admin-sidebar-link {{ request()->routeIs('admin.orders.*') ? 'is-active' : '' }}"
                href="{{ route('admin.orders.index') }}"
                @if(request()->routeIs('admin.orders.*')) aria-current="page" @endif
            >
                <i class="fa-solid fa-receipt" aria-hidden="true"></i>
                Pesanan
            </a>
            <a
                class="admin-sidebar-link {{ request()->routeIs('admin.contacts.*') ? 'is-active' : '' }}"
                href="{{ route('admin.contacts.index') }}"
                @if(request()->routeIs('admin.contacts.*')) aria-current="page" @endif
            >
                <i class="fa-solid fa-envelope" aria-hidden="true"></i>
                Kontak
            </a>
        </nav>
    </div>

    <div class="admin-sidebar-bottom">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button class="admin-sidebar-logout" type="submit">
                <i class="fa-solid fa-arrow-right-from-bracket" aria-hidden="true"></i>
                Logout
            </button>
        </form>
    </div>
</aside>
