<header class="main-header">

    <!-- Logo -->
    <a href="{{ route('home') }}" class="brand">
        Nexa<span>Market</span>
    </a>

    <!-- Pencarian hanya di Home -->
    @if (request()->routeIs('home'))
        <form action="{{ route('home') }}" method="GET" class="search-form">
            <input
                type="text"
                name="search"
                placeholder="Cari produk yang kamu inginkan..."
                value="{{ request('search') }}"
            >
            <button type="submit">
                <i class="fa-solid fa-magnifying-glass"></i>
                Cari
            </button>
        </form>
    @endif

    <!-- Navigasi -->
    <nav class="main-nav">
        <a href="{{ route('home') }}">Home</a>
        <a href="{{ route('shop') }}">Produk</a>
        <a href="{{ route('categories.index') }}">Kategori</a>
        <a href="{{ route('contact') }}">Kontak</a>

        <!-- Keranjang -->
        <a href="{{ route('cart.index') }}"
           class="cart-link"
           aria-label="Keranjang"
           title="Keranjang">
            <i class="fa-solid fa-cart-shopping"></i>
        </a>
    </nav>

</header>

<style>
/* HEADER */
.main-header {
    width: 100%;
    min-height: 80px;
    padding: 12px 5%;
    background: #ffffff;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 25px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.06);
    box-sizing: border-box;
}

/* LOGO */
.brand {
    font-size: 27px;
    font-weight: 800;
    color: #2563eb;
    text-decoration: none;
    white-space: nowrap;
}

.brand span {
    color: #172554;
}

/* PENCARIAN */
.search-form {
    display: flex;
    flex: 1;
    max-width: 380px;
    border: 1px solid #e2e8f0;
    border-radius: 25px;
    overflow: hidden;
    background: #f8fafc;
}

.search-form input {
    flex: 1;
    min-width: 0;
    padding: 12px 16px;
    border: none;
    outline: none;
    background: transparent;
    font-size: 13px;
}

.search-form button {
    padding: 0 18px;
    border: none;
    background: #2563eb;
    color: white;
    cursor: pointer;
    font-size: 13px;
}

.search-form button:hover {
    background: #1d4ed8;
}

/* NAVIGASI */
.main-nav {
    display: flex;
    align-items: center;
    gap: 22px;
}

.main-nav > a:not(.cart-link) {
    color: #333333;
    text-decoration: none;
    font-size: 14px;
    font-weight: 600;
    white-space: nowrap;
    transition: color 0.2s;
}

.main-nav > a:not(.cart-link):hover {
    color: #2563eb;
}

/* IKON KERANJANG */
.main-nav .cart-link {
    width: 42px;
    height: 42px;
    min-width: 42px;
    display: flex;
    align-items: center;
    justify-content: center;

    background: #f1f5f9;
    color: #64748b;
    border-radius: 50%;

    font-size: 19px;
    text-decoration: none;
    transition: background 0.2s, color 0.2s;
}

.main-nav .cart-link i {
    font-size: 19px;
    color: inherit;
}

.main-nav .cart-link:hover {
    background: #e8edf5;
    color: #334155;
}

/* RESPONSIVE */
@media (max-width: 900px) {
    .main-header {
        flex-wrap: wrap;
        justify-content: space-between;
        gap: 15px;
    }

    .search-form {
        order: 3;
        flex-basis: 100%;
        max-width: 100%;
    }

    .main-nav {
        flex-wrap: wrap;
        justify-content: center;
        gap: 15px;
    }
}

@media (max-width: 500px) {
    .main-header {
        padding: 15px;
    }

    .brand {
        font-size: 23px;
    }

    .main-nav {
        width: 100%;
        gap: 13px;
    }

    .main-nav > a:not(.cart-link) {
        font-size: 12px;
    }

    .main-nav .cart-link {
        width: 42px;
        height: 42px;
        min-width: 42px;
    }
}
</style>