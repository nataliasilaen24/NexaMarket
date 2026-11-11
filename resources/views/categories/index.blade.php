<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Kategori - NexaMarket</title>
    <style>
        * { box-sizing: border-box; }
        body { margin: 0; background: #f5f7fb; color: #222; font-family: Arial, sans-serif; }
        header { padding: 18px max(20px, calc((100% - 1100px) / 2)); display: flex; justify-content: space-between; align-items: center; background: white; box-shadow: 0 2px 10px #ddd; }
        .logo { color: #2563eb; font-size: 22px; font-weight: 700; text-decoration: none; }
        nav { display: flex; gap: 20px; }
        nav a { color: #333; font-size: 14px; text-decoration: none; }
        nav a:hover { color: #2563eb; }
        main { max-width: 1100px; margin: 32px auto; padding: 24px; background: white; border-radius: 8px; box-shadow: 0 2px 10px #ddd; }
        .heading { display: flex; align-items: center; justify-content: space-between; gap: 15px; margin-bottom: 20px; }
        h1 { margin: 0; color: #172554; font-size: 24px; }
        .button { padding: 10px 15px; border: 0; border-radius: 5px; background: #2563eb; color: white; font-size: 14px; text-decoration: none; cursor: pointer; }
        .button:hover { background: #1d4ed8; }
        .alert { margin-bottom: 16px; padding: 12px; border-radius: 5px; background: #e8f7ed; color: #17613a; font-size: 14px; }
        .alert.error { background: #fff0ef; color: #a92c20; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 13px 10px; border-bottom: 1px solid #e5e7eb; text-align: left; font-size: 14px; }
        th { background: #f8fafc; color: #475569; }
        .actions { display: flex; align-items: center; gap: 10px; }
        .actions a { color: #2563eb; font-size: 13px; text-decoration: none; }
        .delete { padding: 0; border: 0; background: none; color: #dc2626; font-size: 13px; cursor: pointer; }
        .empty { padding: 35px 10px; color: #64748b; text-align: center; }
        @media (max-width: 650px) {
            header { padding: 14px; align-items: flex-start; gap: 14px; flex-direction: column; }
            nav { gap: 15px; }
            main { margin: 15px 10px; padding: 16px 12px; overflow-x: auto; }
            .heading { align-items: flex-start; flex-direction: column; }
            table { min-width: 580px; }
        }
    </style>
</head>
<body>
    <header>
        <a class="logo" href="{{ url('/') }}">NexaMarket</a>
        <nav><a href="{{ url('/') }}">Home</a><a href="{{ route('products.index') }}">Produk</a><a href="{{ route('cart.index') }}">Keranjang</a></nav>
    </header>
    <main>
        <div class="heading"><h1>Daftar Kategori</h1><a class="button" href="{{ route('categories.create') }}">+ Tambah Kategori</a></div>
        @if(session('success'))<div class="alert" role="status">{{ session('success') }}</div>@endif
        @if(session('error'))<div class="alert error" role="alert">{{ session('error') }}</div>@endif
        @if($categories->isEmpty())
            <div class="empty">Belum ada kategori. Tambahkan kategori agar produk dapat dikelompokkan.</div>
        @else
            <table>
                <thead><tr><th>Nama Kategori</th><th>Slug</th><th>Jumlah Produk</th><th>Aksi</th></tr></thead>
                <tbody>
                    @foreach($categories as $category)
                        <tr>
                            <td>{{ $category->name }}</td>
                            <td>{{ $category->slug }}</td>
                            <td>{{ $category->products_count }}</td>
                            <td><div class="actions">
                                <a href="{{ route('categories.show', $category) }}">Detail</a>
                                <a href="{{ route('categories.edit', $category) }}">Edit</a>
                                <form action="{{ route('categories.destroy', $category) }}" method="POST" onsubmit="return confirm('Hapus kategori ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="delete" type="submit">Hapus</button>
                                </form>
                            </div></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </main>
</body>
</html>
