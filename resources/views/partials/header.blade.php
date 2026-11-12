<header class="main-header">

    <!-- Logo -->
    <a href="{{ url('/') }}" class="brand">
        Nexa<span>Market</span>
    </a>

    <!-- Pencarian: hanya tampil di Home -->
    @if (request()->is('/'))
        <form action="{{ url('/') }}" method="GET" class="search-form">
            <input
                type="text"
                name="search"
                placeholder="Cari produk yang kamu inginkan..."
                value="{{ request('search') }}"
            >
            <button type="submit">
                Cari
            </button>
        </form>
    @endif

    <!-- Navigasi -->
    <nav class="main-nav">
        <a href="{{ url('/') }}">Home</a>
        <a href="{{ url('/shop') }}">Produk</a>
        <a href="{{ route('categories.index') }}">Kategori</a>
        <a href="{{ url('/profile') }}">Profil</a>
        <a href="{{ url('/contact') }}">Kontak</a>
        <a href="{{ route('cart.index') }}" class="cart-link">
            Keranjang
        </a>
    </nav>

</header>

<style>
.main-header {
    width: 100%;
    min-height: 80px;
    padding: 15px 5%;
    background: white;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 25px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.07);
    box-sizing: border-box;
}

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

.search-form {
    display: flex;
    flex: 1;
    max-width: 380px;
    border: 1px solid #ddd;
    border-radius: 8px;
    overflow: hidden;
}

.search-form input {
    flex: 1;
    min-width: 0;
    padding: 12px;
    border: none;
    outline: none;
}

.search-form button {
    padding: 0 18px;
    border: none;
    background: #2563eb;
    color: white;
    cursor: pointer;
}

.main-nav {
    display: flex;
    align-items: center;
    gap: 20px;
}

.main-nav a {
    color: #333;
    text-decoration: none;
    font-size: 14px;
    font-weight: 600;
    white-space: nowrap;
}

.main-nav a:hover {
    color: #2563eb;
}

.main-nav .cart-link {
    background: #2563eb;
    color: white;
    padding: 11px 15px;
    border-radius: 8px;
}

@media (max-width: 900px) {
    .main-header {
        flex-wrap: wrap;
        justify-content: center;
    }

    .search-form {
        order: 3;
        flex-basis: 100%;
        max-width: 100%;
    }

    .main-nav {
        flex-wrap: wrap;
        justify-content: center;
    }
}
</style>