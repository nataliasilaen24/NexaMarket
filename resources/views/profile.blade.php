@extends('layouts.app')

@section('title', 'Profil Kami - NexaMarket')

@push('styles')
<style>
    .profile-page {
        color: #1e293b;
    }

    .profile-hero {
        background: linear-gradient(120deg, #1e40af, #3b82f6);
        color: white;
        text-align: center;
        padding: 90px 20px;
    }

    .profile-hero span {
        background: rgba(255,255,255,.2);
        padding: 9px 20px;
        border-radius: 30px;
        font-size: 13px;
    }

    .profile-hero h1 {
        font-size: 42px;
        margin: 28px 0 15px;
    }

    .profile-hero p {
        max-width: 650px;
        margin: auto;
        line-height: 1.8;
        color: #eff6ff;
    }

    .profile-container {
        max-width: 1150px;
        margin: auto;
        padding: 65px 22px;
    }

    .about-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 45px;
        align-items: center;
    }

    .profile-title {
        color: #1d4ed8;
        font-size: 29px;
        margin-bottom: 18px;
    }

    .about-text p {
        color: #64748b;
        font-size: 15px;
        line-height: 1.9;
        margin-bottom: 15px;
    }

    .about-illustration {
        background: linear-gradient(135deg, #dbeafe, #eff6ff);
        border-radius: 18px;
        min-height: 290px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        text-align: center;
        padding: 25px;
    }

    .about-illustration .icon {
        font-size: 75px;
        margin-bottom: 15px;
    }

    .about-illustration h3 {
        font-size: 25px;
        color: #1e40af;
    }

    .about-illustration p {
        color: #64748b;
        margin-top: 10px;
    }

    .vision-section {
        background: #f8fafc;
    }

    .section-heading {
        text-align: center;
        margin-bottom: 35px;
    }

    .section-heading p {
        color: #64748b;
        margin-top: 10px;
        line-height: 1.7;
    }

    .vision-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 25px;
    }

    .vision-card {
        background: white;
        border: 1px solid #e2e8f0;
        padding: 30px;
        border-radius: 14px;
    }

    .vision-card .icon {
        font-size: 35px;
        margin-bottom: 15px;
    }

    .vision-card h3 {
        color: #1d4ed8;
        font-size: 21px;
        margin-bottom: 12px;
    }

    .vision-card p,
    .vision-card li {
        color: #64748b;
        font-size: 14px;
        line-height: 1.9;
    }

    .vision-card ul {
        padding-left: 20px;
    }

    .advantages-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 20px;
    }

    .advantage-card {
        border: 1px solid #e2e8f0;
        border-radius: 13px;
        padding: 25px 15px;
        text-align: center;
        transition: .2s;
    }

    .advantage-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(0,0,0,.06);
    }

    .advantage-card .icon {
        font-size: 35px;
        margin-bottom: 15px;
    }

    .advantage-card h3 {
        color: #1d4ed8;
        font-size: 16px;
        margin-bottom: 10px;
    }

    .advantage-card p {
        color: #64748b;
        font-size: 13px;
        line-height: 1.7;
    }

    .profile-cta {
        background: #eff6ff;
        text-align: center;
        padding: 60px 20px;
    }

    .profile-cta h2 {
        color: #1e40af;
        font-size: 28px;
        margin-bottom: 13px;
    }

    .profile-cta p {
        color: #64748b;
        margin-bottom: 23px;
    }

    .contact-button {
        display: inline-block;
        background: #2563eb;
        color: white;
        text-decoration: none;
        padding: 13px 25px;
        border-radius: 7px;
        font-weight: bold;
    }

    .contact-button:hover {
        background: #1d4ed8;
    }

    @media(max-width: 800px) {
        .about-grid {
            grid-template-columns: 1fr;
        }

        .advantages-grid {
            grid-template-columns: repeat(2, 1fr);
        }

        .profile-hero h1 {
            font-size: 32px;
        }
    }

    @media(max-width: 550px) {
        .vision-grid {
            grid-template-columns: 1fr;
        }

        .profile-container {
            padding: 45px 18px;
        }
    }
</style>
@endpush

@section('content')

<div class="profile-page">

    <!-- BAGIAN PEMBUKA -->
    <section class="profile-hero">
        <span>SELAMAT DATANG DI NEXAMARKET</span>

        <h1>Kenali NexaMarket Lebih Dekat</h1>

        <p>
            NexaMarket hadir sebagai platform belanja online
            yang memberikan pengalaman berbelanja lebih mudah,
            praktis, dan nyaman untuk semua pelanggan.
        </p>
    </section>

    <!-- TENTANG KAMI -->
    <section class="profile-container">
        <div class="about-grid">

            <div class="about-text">
                <h2 class="profile-title">Tentang NexaMarket</h2>

                <p>
                    NexaMarket merupakan platform e-commerce
                    yang menyediakan berbagai pilihan produk
                    untuk memenuhi kebutuhan pelanggan.
                </p>

                <p>
                    Melalui NexaMarket, pelanggan dapat melihat
                    berbagai produk, mencari barang yang diinginkan,
                    mengetahui informasi harga, dan mengelola
                    keranjang belanja dengan mudah.
                </p>

                <p>
                    Kami berkomitmen untuk terus mengembangkan
                    layanan agar memberikan pengalaman belanja
                    online yang lebih baik.
                </p>
            </div>

            <div class="about-illustration">
                <div class="icon">🛍️</div>
                <h3>NexaMarket</h3>
                <p>Belanja mudah, nyaman, dan praktis.</p>
            </div>

        </div>
    </section>

    <!-- VISI MISI -->
    <section class="vision-section">
        <div class="profile-container">

            <div class="section-heading">
                <h2 class="profile-title">Visi dan Misi Kami</h2>
                <p>
                    Tujuan dan komitmen NexaMarket dalam
                    memberikan layanan belanja online.
                </p>
            </div>

            <div class="vision-grid">

                <div class="vision-card">
                    <div class="icon">🎯</div>
                    <h3>Visi</h3>
                    <p>
                        Menjadi platform belanja online yang
                        mudah diakses, nyaman digunakan, dan
                        mampu memenuhi kebutuhan pelanggan
                        melalui layanan digital.
                    </p>
                </div>

                <div class="vision-card">
                    <div class="icon">🚀</div>
                    <h3>Misi</h3>
                    <ul>
                        <li>Menyediakan pilihan produk yang beragam.</li>
                        <li>Memberikan informasi produk yang jelas.</li>
                        <li>Menghadirkan proses belanja yang praktis.</li>
                        <li>Meningkatkan kualitas pelayanan pelanggan.</li>
                    </ul>
                </div>

            </div>
        </div>
    </section>

    <!-- KEUNGGULAN -->
    <section class="profile-container">

        <div class="section-heading">
            <h2 class="profile-title">Mengapa Memilih NexaMarket?</h2>
            <p>
                Kami ingin membuat pengalaman belanja
                online menjadi lebih mudah dan menyenangkan.
            </p>
        </div>

        <div class="advantages-grid">

            <div class="advantage-card">
                <div class="icon">🛒</div>
                <h3>Produk Beragam</h3>
                <p>Berbagai pilihan produk tersedia dalam satu platform.</p>
            </div>

            <div class="advantage-card">
                <div class="icon">🔍</div>
                <h3>Mudah Dicari</h3>
                <p>Fitur pencarian membantu pelanggan menemukan produk.</p>
            </div>

            <div class="advantage-card">
                <div class="icon">💳</div>
                <h3>Belanja Praktis</h3>
                <p>Pelanggan dapat melihat produk dan mengelola keranjang.</p>
            </div>

            <div class="advantage-card">
                <div class="icon">🤝</div>
                <h3>Pelayanan</h3>
                <p>Kami berupaya memberikan informasi dan bantuan pelanggan.</p>
            </div>

        </div>
    </section>

    <!-- HUBUNGI KAMI -->
    <section class="profile-container" id="kontak">
        <div class="section-heading">
            <h2 class="profile-title">Hubungi Kami</h2>
            <p>
                Kami siap membantu Anda untuk informasi produk,
                layanan, dan kebutuhan belanja online lainnya.
            </p>
        </div>

        <div class="vision-grid">
            <div class="vision-card">
                <div class="icon">📧</div>
                <h3>Email</h3>
                <p>support@nexamarket.id</p>
            </div>

            <div class="vision-card">
                <div class="icon">📞</div>
                <h3>Telepon</h3>
                <p>+62 812 3456 7890</p>
            </div>
        </div>
    </section>

    <section class="profile-cta">
        <h2>Ada Pertanyaan Tentang NexaMarket?</h2>

        <p>
            Jangan ragu menghubungi kami untuk informasi lebih lanjut.
        </p>

        <a href="#kontak" class="contact-button">
            Hubungi Kami
        </a>
    </section>

</div>

@endsection