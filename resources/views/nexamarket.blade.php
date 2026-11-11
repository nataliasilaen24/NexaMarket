<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NexaMarket - Upgrade Harimu, Hemat Hingga 40%</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts: Plus Jakarta Sans -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-gray-50 text-slate-800 antialiased">

    <!-- Top Announcement Bar -->
    <div class="bg-slate-900 text-white text-xs py-2 px-4 text-center">
        Gratis Ongkir Seluruh Indonesia Untuk Pengguna Baru! • <a href="#" class="underline font-semibold">Klaim Voucher</a>
    </div>

    <!-- Header Navigation -->
    <header class="sticky top-0 z-50 bg-white border-b border-gray-100 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16 gap-4">
                <!-- Logo -->
                <div class="flex items-center gap-2">
                    <div class="w-9 h-9 bg-blue-600 rounded-lg flex items-center justify-center text-white font-bold text-xl shadow-md">
                        N
                    </div>
                    <span class="font-extrabold text-xl tracking-tight text-slate-900">Nexa<span class="text-blue-600">Market</span></span>
                </div>

                <!-- Search Bar -->
                <div class="flex-1 max-w-2xl mx-4">
                    <div class="relative">
                        <input type="text" placeholder="Cari di NexaMarket..." class="w-full bg-gray-100 border border-transparent rounded-full py-2.5 pl-10 pr-24 text-sm focus:outline-none focus:bg-white focus:border-blue-600 focus:ring-2 focus:ring-blue-100 transition-all">
                        <i class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                        <button class="absolute right-1.5 top-1/2 -translate-y-1/2 bg-blue-600 hover:bg-blue-700 text-white px-4 py-1.5 rounded-full text-xs font-semibold transition-colors">
                            Cari
                        </button>
                    </div>
                </div>

                <!-- Right Actions -->
                <div class="flex items-center gap-5">
                    <div class="relative cursor-pointer">
                        <i class="fa-solid fa-cart-shopping text-gray-700 text-lg hover:text-blue-600 transition-colors"></i>
                        <span id="cart-count" class="absolute -top-2 -right-2 bg-blue-600 text-white text-[10px] font-bold w-4 h-4 rounded-full flex items-center justify-center">0</span>
                    </div>
                    <a href="#" class="text-sm font-semibold text-gray-700 hover:text-blue-600">Masuk</a>
                    <a href="#" class="bg-slate-900 hover:bg-slate-800 text-white text-sm font-medium px-4 py-2 rounded-lg transition-colors">Daftar</a>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content Container -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 space-y-10">

        <!-- Hero Banners Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Hero Banner -->
            <div class="lg:col-span-2 bg-gradient-to-br from-blue-50 to-indigo-100 rounded-3xl p-8 relative overflow-hidden min-h-[320px] flex flex-col justify-between shadow-sm border border-blue-100">
                <div class="max-w-md z-10">
                    <span class="inline-block bg-blue-600 text-white text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wider mb-4">Mesa Electronics Sale</span>
                    <h1 class="text-3xl sm:text-4xl font-extrabold text-slate-900 leading-tight mb-3">
                        Upgrade harimu, <span class="text-blue-600">hemat hingga 40%.</span>
                    </h1>
                    <p class="text-gray-600 text-sm mb-6">Produk original, harga terbaik khusus untuk meningkatkan produktivitasmu.</p>
                    <button class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-3 rounded-xl shadow-lg shadow-blue-500/30 transition-all flex items-center gap-2">
                        Belanja Sekarang <i class="fa-solid fa-arrow-right text-sm"></i>
                    </button>
                </div>
                <div class="absolute right-4 bottom-4 bg-white/80 backdrop-blur-md p-3 rounded-2xl border border-white shadow-lg text-xs font-semibold text-slate-800">
                    Mulai dari <span class="text-blue-600 font-bold">Rp 190.000</span>
                </div>
            </div>

            <!-- Right Small Banners -->
            <div class="flex flex-col gap-6">
                <div class="bg-slate-900 rounded-3xl p-6 text-white flex-1 flex flex-col justify-between relative overflow-hidden shadow-sm">
                    <div>
                        <span class="text-xs text-blue-400 font-semibold uppercase tracking-wider">Voucher Pengguna Baru</span>
                        <h3 class="text-xl font-bold mt-1">Diskon 25% pesanan pertama</h3>
                    </div>
                    <a href="#" class="text-xs text-gray-300 font-medium hover:text-white flex items-center gap-1 mt-4">Klaim Promo <i class="fa-solid fa-chevron-right text-[10px]"></i></a>
                </div>
                <div class="bg-amber-100 rounded-3xl p-6 flex-1 flex flex-col justify-between border border-amber-200/60 shadow-sm">
                    <div>
                        <span class="text-xs text-amber-700 font-semibold uppercase tracking-wider">Gratis Ongkir</span>
                        <h3 class="text-xl font-bold text-amber-950 mt-1">Belanja tanpa beban jarak</h3>
                    </div>
                    <a href="#" class="text-xs text-amber-900 font-medium hover:underline flex items-center gap-1 mt-4">Cek Ketentuan <i class="fa-solid fa-chevron-right text-[10px]"></i></a>
                </div>
            </div>
        </div>

        <!-- Quick Access Icon Menu -->
        <div class="grid grid-cols-4 sm:grid-cols-8 gap-4 bg-white p-6 rounded-2xl shadow-sm border border-gray-100 text-center">
            <div class="flex flex-col items-center gap-2 cursor-pointer group">
                <div class="w-12 h-12 bg-red-50 text-red-500 rounded-2xl flex items-center justify-center group-hover:bg-red-500 group-hover:text-white transition-all"><i class="fa-solid fa-bolt text-lg"></i></div>
                <span class="text-xs font-medium text-gray-700">Flash Sale</span>
            </div>
            <div class="flex flex-col items-center gap-2 cursor-pointer group">
                <div class="w-12 h-12 bg-blue-50 text-blue-500 rounded-2xl flex items-center justify-center group-hover:bg-blue-600 group-hover:text-white transition-all"><i class="fa-solid fa-mobile-screen text-lg"></i></div>
                <span class="text-xs font-medium text-gray-700">Electronics</span>
            </div>
            <div class="flex flex-col items-center gap-2 cursor-pointer group">
                <div class="w-12 h-12 bg-indigo-50 text-indigo-500 rounded-2xl flex items-center justify-center group-hover:bg-indigo-600 group-hover:text-white transition-all"><i class="fa-solid fa-laptop text-lg"></i></div>
                <span class="text-xs font-medium text-gray-700">Gadget</span>
            </div>
            <div class="flex flex-col items-center gap-2 cursor-pointer group">
                <div class="w-12 h-12 bg-pink-50 text-pink-500 rounded-2xl flex items-center justify-center group-hover:bg-pink-500 group-hover:text-white transition-all"><i class="fa-solid fa-shirt text-lg"></i></div>
                <span class="text-xs font-medium text-gray-700">Fashion</span>
            </div>
            <div class="flex flex-col items-center gap-2 cursor-pointer group">
                <div class="w-12 h-12 bg-purple-50 text-purple-500 rounded-2xl flex items-center justify-center group-hover:bg-purple-600 group-hover:text-white transition-all"><i class="fa-solid fa-glasses text-lg"></i></div>
                <span class="text-xs font-medium text-gray-700">Aksesori</span>
            </div>
            <div class="flex flex-col items-center gap-2 cursor-pointer group">
                <div class="w-12 h-12 bg-emerald-50 text-emerald-500 rounded-2xl flex items-center justify-center group-hover:bg-emerald-600 group-hover:text-white transition-all"><i class="fa-solid fa-couch text-lg"></i></div>
                <span class="text-xs font-medium text-gray-700">Kecantikan</span>
            </div>
            <div class="flex flex-col items-center gap-2 cursor-pointer group">
                <div class="w-12 h-12 bg-amber-50 text-amber-500 rounded-2xl flex items-center justify-center group-hover:bg-amber-500 group-hover:text-white transition-all"><i class="fa-solid fa-house text-lg"></i></div>
                <span class="text-xs font-medium text-gray-700">Rumah</span>
            </div>
            <div class="flex flex-col items-center gap-2 cursor-pointer group">
                <div class="w-12 h-12 bg-gray-100 text-gray-600 rounded-2xl flex items-center justify-center group-hover:bg-slate-800 group-hover:text-white transition-all"><i class="fa-solid fa-grid-2 text-lg"></i></div>
                <span class="text-xs font-medium text-gray-700">Semua</span>
            </div>
        </div>

        <!-- Flash Sale Section -->
        <section>
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center gap-3">
                    <span class="text-red-500 font-extrabold text-xs tracking-wider uppercase flex items-center gap-1"><i class="fa-solid fa-bolt"></i> Promo Spesial Hari Ini</span>
                    <h2 class="text-xl font-bold text-slate-900">Flash Sale</h2>
                    <div class="flex items-center gap-1 ml-4 bg-red-50 text-red-600 px-3 py-1 rounded-full text-xs font-bold">
                        <span id="timer-h">02</span>:<span id="timer-m">45</span>:<span id="timer-s">18</span>
                    </div>
                </div>
                <a href="#" class="text-xs font-semibold text-blue-600 hover:underline">Lihat semua <i class="fa-solid fa-chevron-right text-[10px]"></i></a>
            </div>

            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                <!-- Product Card 1 -->
                <div class="bg-white rounded-2xl p-4 border border-gray-100 shadow-sm hover:shadow-md transition-shadow relative">
                    <span class="absolute top-3 left-3 bg-red-500 text-white text-[10px] font-bold px-2 py-0.5 rounded-full">-30%</span>
                    <div class="h-36 bg-gray-100 rounded-xl mb-3 flex items-center justify-center">
                        <i class="fa-solid fa-headphones text-4xl text-gray-400"></i>
                    </div>
                    <h4 class="text-sm font-semibold text-slate-800 truncate">Audio Pro Wireless</h4>
                    <p class="text-xs text-blue-600 font-bold mt-1">Rp 1.240.000</p>
                    <div class="w-full bg-gray-100 rounded-full h-1.5 mt-3 overflow-hidden">
                        <div class="bg-red-500 h-full w-3/4"></div>
                    </div>
                    <span class="text-[10px] text-gray-400 mt-1 block">Terjual 75%</span>
                </div>
                <!-- Product Card 2 -->
                <div class="bg-white rounded-2xl p-4 border border-gray-100 shadow-sm hover:shadow-md transition-shadow relative">
                    <span class="absolute top-3 left-3 bg-red-500 text-white text-[10px] font-bold px-2 py-0.5 rounded-full">-15%</span>
                    <div class="h-36 bg-gray-100 rounded-xl mb-3 flex items-center justify-center">
                        <i class="fa-solid fa-mobile-button text-4xl text-gray-400"></i>
                    </div>
                    <h4 class="text-sm font-semibold text-slate-800 truncate">Nexa Phone X1</h4>
                    <p class="text-xs text-blue-600 font-bold mt-1">Rp 3.100.000</p>
                    <div class="w-full bg-gray-100 rounded-full h-1.5 mt-3 overflow-hidden">
                        <div class="bg-red-500 h-full w-1/2"></div>
                    </div>
                    <span class="text-[10px] text-gray-400 mt-1 block">Terjual 50%</span>
                </div>
                <!-- Product Card 3 -->
                <div class="bg-white rounded-2xl p-4 border border-gray-100 shadow-sm hover:shadow-md transition-shadow relative">
                    <span class="absolute top-3 left-3 bg-red-500 text-white text-[10px] font-bold px-2 py-0.5 rounded-full">-20%</span>
                    <div class="h-36 bg-gray-100 rounded-xl mb-3 flex items-center justify-center">
                        <i class="fa-solid fa-clock text-4xl text-gray-400"></i>
                    </div>
                    <h4 class="text-sm font-semibold text-slate-800 truncate">Smartwatch Modern</h4>
                    <p class="text-xs text-blue-600 font-bold mt-1">Rp 750.000</p>
                    <div class="w-full bg-gray-100 rounded-full h-1.5 mt-3 overflow-hidden">
                        <div class="bg-red-500 h-full w-4/5"></div>
                    </div>
                    <span class="text-[10px] text-gray-400 mt-1 block">Terjual 80%</span>
                </div>
                <!-- Product Card 4 -->
                <div class="bg-white rounded-2xl p-4 border border-gray-100 shadow-sm hover:shadow-md transition-shadow relative">
                    <span class="absolute top-3 left-3 bg-red-500 text-white text-[10px] font-bold px-2 py-0.5 rounded-full">-40%</span>
                    <div class="h-36 bg-gray-100 rounded-xl mb-3 flex items-center justify-center">
                        <i class="fa-solid fa-gamepad text-4xl text-gray-400"></i>
                    </div>
                    <h4 class="text-sm font-semibold text-slate-800 truncate">Stick Game Wireless</h4>
                    <p class="text-xs text-blue-600 font-bold mt-1">Rp 290.000</p>
                    <div class="w-full bg-gray-100 rounded-full h-1.5 mt-3 overflow-hidden">
                        <div class="bg-red-500 h-full w-1/4"></div>
                    </div>
                    <span class="text-[10px] text-gray-400 mt-1 block">Terjual 25%</span>
                </div>
            </div>
        </section>

        <!-- Product Grid (Baru Datang) -->
        <section>
            <div class="flex items-center justify-between mb-4">
                <div>
                    <span class="text-blue-600 font-bold text-xs uppercase tracking-wider">Baru Diunggah</span>
                    <h2 class="text-xl font-bold text-slate-900">Baru datang, layak dilirik</h2>
                </div>
                <a href="#" class="text-xs font-semibold text-blue-600 hover:underline">Lihat semua produk <i class="fa-solid fa-chevron-right text-[10px]"></i></a>
            </div>

            <div class="grid grid-cols-2 sm:grid-cols-4 gap-6">
                <!-- Card Item -->
                <div class="bg-white rounded-2xl p-4 border border-gray-100 shadow-sm hover:shadow-lg transition-all flex flex-col justify-between group">
                    <div>
                        <div class="h-44 bg-gray-100 rounded-xl mb-3 flex items-center justify-center relative overflow-hidden">
                            <i class="fa-solid fa-laptop text-5xl text-gray-400 group-hover:scale-110 transition-transform"></i>
                            <span class="absolute top-2 left-2 bg-slate-900 text-white text-[10px] px-2 py-0.5 rounded">Terbaru</span>
                        </div>
                        <span class="text-[10px] text-gray-400 uppercase font-semibold">Elektronik</span>
                        <h3 class="text-sm font-semibold text-slate-800 mt-1">Audio Pro Headset Studio</h3>
                        <p class="text-xs text-gray-400 mt-1"><i class="fa-solid fa-star text-amber-400"></i> 4.8 | Terjual 120+</p>
                    </div>
                    <div class="flex items-center justify-between mt-4">
                        <span class="text-sm font-bold text-slate-900">Rp 1.240.000</span>
                        <button onclick="addToCart()" class="w-8 h-8 rounded-full bg-blue-50 text-blue-600 hover:bg-blue-600 hover:text-white flex items-center justify-center transition-colors">
                            <i class="fa-solid fa-plus text-xs"></i>
                        </button>
                    </div>
                </div>

                <!-- Card Item -->
                <div class="bg-white rounded-2xl p-4 border border-gray-100 shadow-sm hover:shadow-lg transition-all flex flex-col justify-between group">
                    <div>
                        <div class="h-44 bg-gray-100 rounded-xl mb-3 flex items-center justify-center relative overflow-hidden">
                            <i class="fa-solid fa-tablet-screen-button text-5xl text-gray-400 group-hover:scale-110 transition-transform"></i>
                            <span class="absolute top-2 left-2 bg-slate-900 text-white text-[10px] px-2 py-0.5 rounded">Terbaru</span>
                        </div>
                        <span class="text-[10px] text-gray-400 uppercase font-semibold">Gadget</span>
                        <h3 class="text-sm font-semibold text-slate-800 mt-1">Nexa Phone 13 Pro</h3>
                        <p class="text-xs text-gray-400 mt-1"><i class="fa-solid fa-star text-amber-400"></i> 4.9 | Terjual 85+</p>
                    </div>
                    <div class="flex items-center justify-between mt-4">
                        <span class="text-sm font-bold text-slate-900">Rp 7.450.000</span>
                        <button onclick="addToCart()" class="w-8 h-8 rounded-full bg-blue-50 text-blue-600 hover:bg-blue-600 hover:text-white flex items-center justify-center transition-colors">
                            <i class="fa-solid fa-plus text-xs"></i>
                        </button>
                    </div>
                </div>

                <!-- Card Item -->
                <div class="bg-white rounded-2xl p-4 border border-gray-100 shadow-sm hover:shadow-lg transition-all flex flex-col justify-between group">
                    <div>
                        <div class="h-44 bg-gray-100 rounded-xl mb-3 flex items-center justify-center relative overflow-hidden">
                            <i class="fa-solid fa-keyboard text-5xl text-gray-400 group-hover:scale-110 transition-transform"></i>
                            <span class="absolute top-2 left-2 bg-red-500 text-white text-[10px] px-2 py-0.5 rounded">-10%</span>
                        </div>
                        <span class="text-[10px] text-gray-400 uppercase font-semibold">Aksesori</span>
                        <h3 class="text-sm font-semibold text-slate-800 mt-1">Keyboard Mekanikal RGB</h3>
                        <p class="text-xs text-gray-400 mt-1"><i class="fa-solid fa-star text-amber-400"></i> 4.7 | Terjual 300+</p>
                    </div>
                    <div class="flex items-center justify-between mt-4">
                        <span class="text-sm font-bold text-slate-900">Rp 570.000</span>
                        <button onclick="addToCart()" class="w-8 h-8 rounded-full bg-blue-50 text-blue-600 hover:bg-blue-600 hover:text-white flex items-center justify-center transition-colors">
                            <i class="fa-solid fa-plus text-xs"></i>
                        </button>
                    </div>
                </div>

                <!-- Card Item -->
                <div class="bg-white rounded-2xl p-4 border border-gray-100 shadow-sm hover:shadow-lg transition-all flex flex-col justify-between group">
                    <div>
                        <div class="h-44 bg-gray-100 rounded-xl mb-3 flex items-center justify-center relative overflow-hidden">
                            <i class="fa-solid fa-camera text-5xl text-gray-400 group-hover:scale-110 transition-transform"></i>
                        </div>
                        <span class="text-[10px] text-gray-400 uppercase font-semibold">Fotografi</span>
                        <h3 class="text-sm font-semibold text-slate-800 mt-1">Lensa Kamera Mirrorless</h3>
                        <p class="text-xs text-gray-400 mt-1"><i class="fa-solid fa-star text-amber-400"></i> 5.0 | Terjual 40+</p>
                    </div>
                    <div class="flex items-center justify-between mt-4">
                        <span class="text-sm font-bold text-slate-900">Rp 1.650.000</span>
                        <button onclick="addToCart()" class="w-8 h-8 rounded-full bg-blue-50 text-blue-600 hover:bg-blue-600 hover:text-white flex items-center justify-center transition-colors">
                            <i class="fa-solid fa-plus text-xs"></i>
                        </button>
                    </div>
                </div>
            </div>
        </section>

        <!-- Bottom Banner Promo -->
        <div class="bg-slate-900 rounded-3xl p-8 sm:p-12 text-white relative overflow-hidden flex flex-col sm:flex-row justify-between items-center gap-6">
            <div class="max-w-md z-10">
                <span class="text-blue-400 text-xs font-bold uppercase tracking-widest">Nexa Best Value</span>
                <h2 class="text-3xl font-extrabold mt-2 leading-tight">Harga turun. Standar tetap tinggi.</h2>
                <p class="text-gray-400 text-sm mt-2">Dapatkan diskon hingga 40% untuk produk-produk pilihan minggu ini.</p>
                <button class="mt-6 bg-white text-slate-900 font-bold px-6 py-3 rounded-xl hover:bg-gray-100 transition-colors">
                    Jelajahi Promo
                </button>
            </div>
            <div class="w-32 h-32 sm:w-48 sm:h-48 bg-blue-600 rounded-3xl flex items-center justify-center opacity-80 rotate-12 shadow-2xl">
                <i class="fa-solid fa-bag-shopping text-6xl sm:text-8xl text-white"></i>
            </div>
        </div>

    </main>

    <!-- Footer -->
    <footer class="bg-slate-950 text-gray-400 py-12 border-t border-slate-900 mt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 sm:grid-cols-4 gap-8 text-sm">
            <div>
                <div class="flex items-center gap-2 mb-4">
                    <div class="w-7 h-7 bg-blue-600 rounded-md flex items-center justify-center text-white font-bold text-sm">N</div>
                    <span class="font-bold text-white text-lg">NexaMarket</span>
                </div>
                <p class="text-xs text-gray-500 leading-relaxed">Tempat berbelanja kebutuhan teknologi dan gaya hidup digital terbaik Anda.</p>
            </div>
            <div>
                <h4 class="text-white font-semibold mb-3">NexaMarket</h4>
                <ul class="space-y-2 text-xs">
                    <li><a href="#" class="hover:text-white">Tentang Kami</a></li>
                    <li><a href="#" class="hover:text-white">Karir</a></li>
                    <li><a href="#" class="hover:text-white">Mitra Seller</a></li>
                </ul>
            </div>
            <div>
                <h4 class="text-white font-semibold mb-3">Bantuan</h4>
                <ul class="space-y-2 text-xs">
                    <li><a href="#" class="hover:text-white">Pusat Bantuan</a></li>
                    <li><a href="#" class="hover:text-white">Cara Belanja</a></li>
                    <li><a href="#" class="hover:text-white">Pengembalian</a></li>
                </ul>
            </div>
            <div>
                <h4 class="text-white font-semibold mb-3">Hubungi Kami</h4>
                <p class="text-xs leading-relaxed">support@nexamarket.id<br>Jakarta, Indonesia</p>
            </div>
        </div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-xs text-gray-600 border-t border-slate-900 mt-8 pt-6">
            &copy; 2026 NexaMarket. All rights reserved.
        </div>
    </footer>

    <!-- JavaScript Interaktif -->
    <script>
        let cartCount = 0;
        function addToCart() {
            cartCount++;
            document.getElementById('cart-count').innerText = cartCount;
        }

        let seconds = 10000;
        setInterval(() => {
            seconds--;
            let h = Math.floor(seconds / 3600).toString().padStart(2, '0');
            let m = Math.floor((seconds % 3600) / 60).toString().padStart(2, '0');
            let s = Math.floor(seconds % 60).toString().padStart(2, '0');
            document.getElementById('timer-h').innerText = h;
            document.getElementById('timer-m').innerText = m;
            document.getElementById('timer-s').innerText = s;
        }, 1000);
    </script>
</body>
</html>