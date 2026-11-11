<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#3157e7">
    <title>NexaMarket | Belanja pilihanmu</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Manrope:wght@500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --ink: #151a2e;
            --muted: #7d8290;
            --paper: #f5f6fa;
            --white: #fff;
            --line: #e8eaf0;
            --brand: #3157e7;
            --brand-dark: #2546cc;
            --green: #3157e7;
            --lime: #ffcb62;
            --shadow: 0 12px 32px rgba(35, 54, 132, .09);
        }
        * { box-sizing: border-box; }
        html { scroll-behavior: smooth; }
        body { margin: 0; color: var(--ink); background: var(--paper); font-family: 'DM Sans', sans-serif; }
        a { color: inherit; text-decoration: none; }
        button, input { font: inherit; }
        .announcement { padding: 9px 5vw; background: var(--green); color: white; font-size: 12px; text-align: center; }
        .announcement strong { color: var(--lime); }
        .site-header { position: sticky; top: 0; z-index: 20; background: rgba(255,255,255,.96); border-bottom: 1px solid var(--line); backdrop-filter: blur(14px); }
        .header-inner { max-width: 1280px; min-height: 78px; margin: auto; padding: 12px 28px; display: grid; grid-template-columns: auto minmax(240px, 1fr) auto; gap: 38px; align-items: center; }
        .brand { display: inline-flex; align-items: center; gap: 10px; white-space: nowrap; font: 800 21px 'Manrope', sans-serif; letter-spacing: 0; }
        .brand-mark { width: 37px; height: 37px; display: grid; place-items: center; color: white; background: var(--brand); border-radius: 12px 12px 12px 4px; font-size: 17px; }
        .search-form { height: 44px; display: flex; border: 1px solid #dfe3da; background: #f8f9f5; border-radius: 7px; overflow: hidden; }
        .search-form:focus-within { border-color: var(--green); box-shadow: 0 0 0 3px rgba(46,101,83,.09); }
        .search-form input { width: 100%; min-width: 0; padding: 0 14px; color: var(--ink); border: 0; outline: 0; background: transparent; }
        .search-form button { min-width: 48px; border: 0; color: white; background: var(--brand); cursor: pointer; font-size: 19px; }
        .search-form button:hover { background: var(--brand-dark); }
        .header-actions { display: flex; align-items: center; gap: 24px; }
        .header-link { color: #53605a; font-size: 13px; font-weight: 600; }
        .header-link:hover { color: var(--brand); }
        .cart-link { position: relative; width: 42px; height: 42px; display: grid; place-items: center; border: 1px solid var(--line); border-radius: 50%; font-size: 20px; }
        .cart-count { position: absolute; top: -5px; right: -5px; min-width: 19px; height: 19px; padding: 0 5px; display: grid; place-items: center; border: 2px solid white; border-radius: 20px; background: var(--brand); color: white; font-size: 10px; font-weight: 700; }
        .page { width: min(1280px, calc(100% - 48px)); margin: 28px auto 64px; }
        .hero { min-height: 350px; position: relative; display: grid; grid-template-columns: 1fr .9fr; overflow: hidden; background: #dce8df; border-radius: 10px; }
        .hero-copy { position: relative; z-index: 1; padding: 52px 0 48px 6%; align-self: center; }
        .eyebrow { margin: 0 0 15px; color: var(--green); font-size: 11px; font-weight: 700; letter-spacing: 1.4px; text-transform: uppercase; }
        .hero h1 { max-width: 540px; margin: 0; font: 800 clamp(34px, 4vw, 54px)/1.08 'Manrope', sans-serif; letter-spacing: 0; }
        .hero-copy > p:not(.eyebrow) { max-width: 410px; margin: 16px 0 25px; color: #53645b; font-size: 15px; line-height: 1.7; }
        .button { min-height: 45px; padding: 0 19px; display: inline-flex; align-items: center; justify-content: center; gap: 9px; border: 0; border-radius: 5px; background: var(--brand); color: white; font-size: 13px; font-weight: 700; cursor: pointer; transition: background .2s, transform .2s; }
        .button:hover { background: var(--brand-dark); transform: translateY(-1px); }
        .hero-photo { position: absolute; inset: 0 0 0 47%; background: linear-gradient(90deg, #dce8df 0%, rgba(220,232,223,.15) 31%, transparent 58%), url('https://images.unsplash.com/photo-1607082349566-187342175e2f?auto=format&fit=crop&w=1400&q=85') center 48% / cover; }
        .hero-stamp { position: absolute; right: 7%; bottom: 24px; padding: 13px 17px; background: var(--lime); color: var(--ink); transform: rotate(-4deg); font: 800 12px 'Manrope', sans-serif; }
        .perks { margin: 18px 0 35px; display: grid; grid-template-columns: repeat(3, 1fr); background: white; border: 1px solid var(--line); border-radius: 7px; }
        .perk { min-height: 74px; padding: 14px 20px; display: flex; align-items: center; justify-content: center; gap: 12px; color: #56625b; font-size: 12px; }
        .perk + .perk { border-left: 1px solid var(--line); }
        .perk-icon { width: 34px; height: 34px; display: grid; place-items: center; border-radius: 50%; color: var(--green); background: #eef4ed; font-size: 17px; }
        .perk strong { display: block; margin-bottom: 3px; color: var(--ink); font-size: 13px; }
        .section { margin-top: 37px; }
        .section-heading { margin-bottom: 17px; display: flex; align-items: end; justify-content: space-between; gap: 16px; }
        .section-heading h2 { margin: 0; font: 800 22px 'Manrope', sans-serif; letter-spacing: 0; }
        .section-heading p { margin: 5px 0 0; color: var(--muted); font-size: 13px; }
        .text-link { color: var(--green); font-size: 13px; font-weight: 700; }
        .category-list { display: grid; grid-template-columns: repeat(6, minmax(0, 1fr)); gap: 11px; }
        .category-item { min-height: 98px; padding: 15px 10px; display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 10px; border: 1px solid var(--line); border-radius: 6px; background: white; text-align: center; transition: border-color .2s, transform .2s, background .2s; }
        .category-item:hover, .category-item.active { border-color: var(--green); background: #f0f5ef; transform: translateY(-2px); }
        .category-symbol { width: 34px; height: 34px; display: grid; place-items: center; border-radius: 50%; background: #f3eadb; color: var(--green); font: 700 14px 'Manrope', sans-serif; }
        .category-item span:last-child { overflow-wrap: anywhere; font-size: 12px; font-weight: 600; }
        .catalog { margin-top: 43px; }
        .catalog-tools { display: flex; align-items: center; gap: 10px; }
        .catalog-tools label { color: var(--muted); font-size: 12px; }
        .catalog-tools select { height: 36px; padding: 0 28px 0 10px; border: 1px solid var(--line); border-radius: 4px; background: white; color: var(--ink); font-size: 12px; }
        .product-grid { display: grid; grid-template-columns: repeat(5, minmax(0, 1fr)); gap: 15px; }
        .product-card { min-width: 0; overflow: hidden; border: 1px solid var(--line); border-radius: 6px; background: white; transition: transform .2s, box-shadow .2s, border-color .2s; }
        .product-card:hover { transform: translateY(-3px); border-color: #cbd6cc; box-shadow: var(--shadow); }
        .product-image-wrap { position: relative; aspect-ratio: 1 / .92; overflow: hidden; background: #f0f1ec; }
        .product-image { width: 100%; height: 100%; display: block; object-fit: cover; transition: transform .35s; }
        .product-card:hover .product-image { transform: scale(1.035); }
        .image-placeholder { width: 100%; height: 100%; display: grid; place-items: center; color: #89918a; font-size: 12px; }
        .stock-tag { position: absolute; left: 9px; top: 9px; padding: 5px 7px; background: var(--lime); color: var(--ink); font-size: 10px; font-weight: 700; }
        .product-info { padding: 12px 12px 5px; }
        .product-category { margin: 0 0 6px; color: var(--muted); font-size: 10px; }
        .product-name { min-height: 38px; margin: 0; display: -webkit-box; overflow: hidden; color: var(--ink); font-size: 13px; font-weight: 600; line-height: 1.45; -webkit-box-orient: vertical; -webkit-line-clamp: 2; }
        .product-price { margin-top: 9px; color: var(--brand-dark); font: 800 16px 'Manrope', sans-serif; }
        .product-stock { margin-top: 5px; color: var(--muted); font-size: 11px; }
        .product-action { padding: 10px 12px 12px; }
        .add-button { width: 100%; min-height: 36px; border: 1px solid var(--brand); border-radius: 4px; background: white; color: var(--brand-dark); font-size: 12px; font-weight: 700; cursor: pointer; transition: color .2s, background .2s; }
        .add-button:hover:not(:disabled) { background: var(--brand); color: white; }
        .add-button:disabled { border-color: #d4d8d0; color: #9da49c; cursor: not-allowed; }
        .empty-state { grid-column: 1 / -1; padding: 56px 20px; border: 1px dashed #cfd5cc; background: white; text-align: center; }
        .empty-state strong { display: block; margin-bottom: 7px; font: 700 17px 'Manrope', sans-serif; }
        .empty-state p { margin: 0 0 18px; color: var(--muted); font-size: 13px; }
        .notice { margin: 0 0 20px; padding: 13px 15px; border: 1px solid #bbdfc8; background: #edf8ef; color: #286344; font-size: 13px; }
        .footer { margin-top: 55px; padding: 34px 0 22px; border-top: 1px solid var(--line); display: flex; align-items: center; justify-content: space-between; gap: 20px; color: var(--muted); font-size: 12px; }
        .footer .brand { color: var(--ink); font-size: 17px; }
        .mobile-nav { display: none; }
        .hero { min-height: 330px; grid-template-columns: minmax(0, 2fr) minmax(230px, .92fr); gap: 12px; overflow: visible; background: transparent; }
        .hero-copy { min-height: 330px; padding: 38px 7%; overflow: hidden; border-radius: 8px; background: #3157e7; color: white; }
        .hero-copy::after { position: absolute; right: 4%; bottom: -34px; width: 230px; height: 230px; content: ''; border: 1px solid rgba(255,255,255,.25); border-radius: 50%; box-shadow: 0 0 0 28px rgba(255,255,255,.06), 0 0 0 58px rgba(255,255,255,.04); }
        .hero-copy .eyebrow { color: #dce5ff; }
        .hero h1 { max-width: 430px; font-size: clamp(32px, 3.5vw, 46px); }
        .hero-copy > p:not(.eyebrow) { max-width: 350px; color: #e1e7ff; }
        .hero-copy .button { background: white; color: var(--brand); }
        .hero-copy .button:hover { background: #edf1ff; }
        .hero-photo { inset: 0 0 0 49%; opacity: .4; border-radius: 8px; background-image: linear-gradient(90deg, #3157e7 0%, rgba(49,87,231,.12) 65%, transparent), url('https://images.unsplash.com/photo-1607082349566-187342175e2f?auto=format&fit=crop&w=1200&q=85'); }
        .hero-stamp { display: none; }
        .hero-side { position: relative; z-index: 2; display: grid; grid-template-rows: 1fr 1fr; gap: 12px; }
        .hero-promo { position: relative; min-height: 155px; padding: 22px; overflow: hidden; border-radius: 8px; color: white; background: #12182b; }
        .hero-promo::after { position: absolute; right: -17px; bottom: -35px; width: 130px; height: 130px; content: ''; border: 1px solid rgba(255,255,255,.27); border-radius: 30px; transform: rotate(25deg); }
        .hero-promo.warm { color: #27231b; background: #ffdf96; }
        .hero-promo.warm::after { border-color: rgba(67,49,10,.2); }
        .hero-promo small { display: block; margin-bottom: 9px; color: #ffcb62; font-size: 10px; font-weight: 700; letter-spacing: 1px; text-transform: uppercase; }
        .hero-promo.warm small { color: #815619; }
        .hero-promo strong { position: relative; z-index: 1; display: block; max-width: 190px; font: 800 17px/1.3 'Manrope', sans-serif; }
        .hero-promo span { display: block; margin-top: 7px; color: rgba(255,255,255,.72); font-size: 11px; }
        .hero-promo.warm span { color: #66573e; }
        .shortcut-menu { margin: 15px 0 30px; padding: 16px 10px; display: grid; grid-template-columns: repeat(6, minmax(0, 1fr)); gap: 8px; border: 1px solid var(--line); border-radius: 7px; background: white; }
        .shortcut-item { min-height: 71px; display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 7px; color: #51586b; font-size: 11px; font-weight: 600; text-align: center; }
        .shortcut-item:hover { color: var(--brand); }
        .shortcut-icon { width: 34px; height: 34px; display: grid; place-items: center; border-radius: 50%; background: #eef1ff; color: var(--brand); font-size: 16px; }
        .market-section { margin: 0 0 33px; }
        .market-heading { margin-bottom: 14px; display: flex; align-items: center; justify-content: space-between; gap: 14px; }
        .market-heading h2 { margin: 0; font: 800 19px 'Manrope', sans-serif; letter-spacing: 0; }
        .market-heading p { margin: 4px 0 0; color: var(--muted); font-size: 11px; }
        .sale-mark { color: #ed4e54; }
        .mini-grid { display: grid; grid-template-columns: repeat(4, minmax(0, 1fr)); gap: 12px; }
        .mini-product { min-width: 0; overflow: hidden; border: 1px solid var(--line); border-radius: 6px; background: white; }
        .mini-product > a { display: block; }
        .mini-image { position: relative; aspect-ratio: 1.15 / 1; overflow: hidden; background: #f0f2f7; }
        .mini-image img { width: 100%; height: 100%; display: block; object-fit: cover; }
        .mini-placeholder { width: 100%; height: 100%; display: grid; place-items: center; color: #9da2af; font-size: 11px; }
        .mini-tag { position: absolute; top: 8px; left: 8px; padding: 4px 6px; background: #ff5b61; color: white; font-size: 9px; font-weight: 700; }
        .mini-info { padding: 9px 10px 10px; }
        .mini-name { min-height: 30px; margin: 0; overflow: hidden; font-size: 11px; font-weight: 600; line-height: 1.4; }
        .mini-price { margin-top: 6px; color: var(--brand); font: 800 13px 'Manrope', sans-serif; }
        .mini-stock { margin-top: 5px; height: 4px; background: #f0f1f5; }
        .mini-stock span { width: 62%; height: 100%; display: block; background: #ff6768; }
        .category-item { min-height: 100px; }
        .category-symbol { border-radius: 8px; background: #f1f3ff; color: var(--brand); }
        .product-grid { grid-template-columns: repeat(5, minmax(0, 1fr)); gap: 12px; }
        .product-card { border-radius: 5px; }
        .product-image-wrap { aspect-ratio: 1 / .85; }
        .product-price { color: var(--brand); }
        .stock-tag { background: #ff6268; color: white; }
        .add-button { border-color: var(--brand); color: var(--brand); }
        .add-button:hover:not(:disabled) { background: var(--brand); }
        .promo-banner-bottom { position: relative; min-height: 185px; margin: 35px 0 0; padding: 34px 5%; overflow: hidden; display: flex; align-items: center; justify-content: space-between; gap: 20px; border-radius: 8px; background: linear-gradient(110deg, #11172c 0 55%, #3157e7 55% 100%); color: white; }
        .promo-banner-bottom::after { position: absolute; right: 12%; bottom: -60px; width: 180px; height: 180px; content: 'N'; display: grid; place-items: center; border: 1px solid rgba(255,255,255,.35); border-radius: 50%; color: rgba(255,255,255,.16); font: 800 100px 'Manrope', sans-serif; }
        .promo-banner-bottom h2 { max-width: 430px; margin: 0 0 8px; font: 800 25px/1.2 'Manrope', sans-serif; }
        .promo-banner-bottom p { margin: 0; color: rgba(255,255,255,.72); font-size: 12px; }
        .promo-banner-bottom .button { position: relative; z-index: 1; background: white; color: var(--brand); }
        .trust-row { margin: 25px 0 0; padding: 18px 0; display: grid; grid-template-columns: repeat(4, 1fr); gap: 12px; border-bottom: 1px solid var(--line); }
        .trust-item { display: flex; align-items: center; gap: 9px; color: #6b7180; font-size: 10px; }
        .trust-item strong { display: block; margin-bottom: 3px; color: var(--ink); font-size: 11px; }
        .trust-icon { width: 30px; height: 30px; display: grid; flex: 0 0 auto; place-items: center; border-radius: 50%; background: #eef1ff; color: var(--brand); font-size: 14px; }
        .footer { width: 100vw; margin-top: 0; margin-left: calc((100% - 100vw) / 2); padding: 34px 5% 22px; align-items: start; background: #11172c; color: #aab0c0; }
        .footer .brand { color: white; }
        .footer-groups { display: grid; grid-template-columns: repeat(3, minmax(100px, 1fr)); gap: 35px; }
        .footer-group strong { display: block; margin-bottom: 10px; color: white; font-size: 11px; }
        .footer-group a { display: block; margin: 7px 0; color: #aab0c0; font-size: 10px; }
        .footer-group a:hover { color: white; }
        @media (max-width: 1000px) {
            .header-inner { grid-template-columns: auto minmax(180px, 1fr) auto; gap: 20px; }
            .header-link { display: none; }
            .product-grid { grid-template-columns: repeat(4, minmax(0, 1fr)); }
            .category-list { grid-template-columns: repeat(4, minmax(0, 1fr)); }
            .hero { grid-template-columns: minmax(0, 1.5fr) minmax(205px, .9fr); }
        }
        @media (max-width: 680px) {
            .announcement { font-size: 10px; }
            .header-inner { min-height: 64px; padding: 9px 16px; grid-template-columns: auto 1fr auto; gap: 12px; }
            .brand { gap: 7px; font-size: 17px; }
            .brand-mark { width: 32px; height: 32px; border-radius: 10px 10px 10px 4px; }
            .search-form { height: 39px; }
            .search-form input { padding: 0 9px; font-size: 12px; }
            .search-form button { min-width: 38px; }
            .cart-link { width: 38px; height: 38px; font-size: 18px; }
            .page { width: min(100% - 28px, 560px); margin-top: 14px; margin-bottom: 85px; }
            .hero { min-height: auto; grid-template-columns: 1fr; gap: 9px; }
            .hero-copy { min-height: 290px; padding: 28px 22px; align-self: stretch; }
            .hero h1 { max-width: 330px; font-size: 35px; }
            .hero-copy > p:not(.eyebrow) { max-width: 300px; margin: 10px 0 17px; font-size: 13px; }
            .hero-photo { inset: 0 0 0 28%; background-image: linear-gradient(90deg, #3157e7 0%, rgba(49,87,231,.48) 45%, rgba(49,87,231,.08)), url('https://images.unsplash.com/photo-1607082349566-187342175e2f?auto=format&fit=crop&w=900&q=80'); background-position: center; }
            .hero-copy::after { right: -50px; bottom: -80px; width: 190px; height: 190px; }
            .hero-side { grid-template-columns: 1fr 1fr; grid-template-rows: 1fr; gap: 9px; }
            .hero-promo { min-height: 132px; padding: 15px; }
            .hero-promo strong { font-size: 14px; }
            .hero-promo span { font-size: 10px; }
            .shortcut-menu { margin: 10px 0 24px; padding: 9px 5px; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 4px; }
            .shortcut-item { min-height: 62px; font-size: 10px; }
            .shortcut-icon { width: 30px; height: 30px; font-size: 14px; }
            .market-section { margin-bottom: 26px; }
            .market-heading h2 { font-size: 17px; }
            .mini-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 8px; }
            .mini-product:nth-child(n+3) { display: none; }
            .mini-image { aspect-ratio: 1.3 / 1; }
            .section { margin-top: 30px; }
            .section-heading h2 { font-size: 19px; }
            .section-heading p { font-size: 11px; }
            .category-list { grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 8px; }
            .category-item { min-height: 84px; padding: 10px 7px; gap: 7px; }
            .category-symbol { width: 30px; height: 30px; }
            .category-item span:last-child { font-size: 11px; }
            .catalog { margin-top: 34px; }
            .catalog .section-heading { align-items: center; }
            .catalog-tools label { display: none; }
            .catalog-tools select { height: 33px; max-width: 130px; font-size: 11px; }
            .product-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 9px; }
            .product-info { padding: 10px 9px 4px; }
            .product-name { min-height: 36px; font-size: 12px; }
            .product-price { font-size: 14px; }
            .product-stock { font-size: 10px; }
            .product-action { padding: 8px 9px 10px; }
            .add-button { min-height: 34px; font-size: 11px; }
            .promo-banner-bottom { min-height: 180px; margin-top: 27px; padding: 24px 20px; align-items: flex-start; flex-direction: column; background: #11172c; }
            .promo-banner-bottom::after { right: -28px; bottom: -75px; }
            .promo-banner-bottom h2 { max-width: 270px; font-size: 22px; }
            .trust-row { grid-template-columns: repeat(2, 1fr); }
            .footer { margin-top: 0; padding: 25px 20px; flex-direction: column; align-items: flex-start; }
            .footer-groups { width: 100%; grid-template-columns: repeat(2, 1fr); gap: 18px; }
            .mobile-nav { position: fixed; z-index: 30; right: 0; bottom: 0; left: 0; min-height: 62px; padding: 7px 12px calc(7px + env(safe-area-inset-bottom)); display: grid; grid-template-columns: repeat(3, 1fr); border-top: 1px solid var(--line); background: rgba(255,255,255,.97); }
            .mobile-nav a { display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 3px; color: #68736c; font-size: 10px; font-weight: 600; }
            .mobile-nav a span:first-child { font-size: 18px; }
        }
        @media (prefers-reduced-motion: reduce) { *, *::before, *::after { scroll-behavior: auto !important; transition-duration: .01ms !important; } }
    </style>
</head>
<body>
    <div class="announcement">Belanja lebih mudah, pilihan produk untuk setiap kebutuhan <strong>NexaMarket</strong></div>
    <header class="site-header">
        <div class="header-inner">
            <a href="{{ url('/') }}" class="brand" aria-label="NexaMarket, halaman utama"><span class="brand-mark">N</span><span>NexaMarket</span></a>
            <form action="{{ url('/shop') }}" method="GET" class="search-form" role="search">
                @if(request('category'))<input type="hidden" name="category" value="{{ request('category') }}">@endif
                <input type="search" name="search" placeholder="Cari produk yang kamu butuhkan" value="{{ request('search') }}" aria-label="Cari produk">
                <button type="submit" aria-label="Cari">⌕</button>
            </form>
            <div class="header-actions">
                <a class="header-link" href="#kategori">Kategori</a>
                <a class="header-link" href="#produk">Jelajahi produk</a>
                <a class="cart-link" href="{{ route('cart.index') }}" aria-label="Keranjang belanja">♧<span class="cart-count">{{ collect(session('cart', []))->sum('quantity') }}</span></a>
            </div>
        </div>
    </header>

    <main class="page">
        @if(session('success'))<div class="notice" role="status">{{ session('success') }}</div>@endif
        <section class="hero" aria-labelledby="hero-title">
            <div class="hero-copy">
                <p class="eyebrow">Selamat datang di NexaMarket</p>
                <h1 id="hero-title">Upgrade harimu, temukan pilihan terbaik.</h1>
                <p>Jelajahi produk pilihan untuk kebutuhan harian, hobi, dan hadiah spesial.</p>
                <a class="button" href="#produk">Mulai belanja <span aria-hidden="true">→</span></a>
            </div>
            <div class="hero-photo" role="img" aria-label="Suasana berbelanja dan pilihan produk"></div>
            <div class="hero-side">
                <div class="hero-promo"><small>Temukan favoritmu</small><strong>Produk pilihan, semua dalam satu tempat.</strong><span>Jelajahi koleksi terbaru</span></div>
                <div class="hero-promo warm"><small>Belanja lebih mudah</small><strong>Barang incaranmu tinggal beberapa klik.</strong><span>Pilih, masukkan keranjang, selesai.</span></div>
            </div>
        </section>

        <nav class="shortcut-menu" aria-label="Jelajahi NexaMarket">
            <a class="shortcut-item" href="#produk"><span class="shortcut-icon">⚡</span><span>Pilihan hari ini</span></a>
            <a class="shortcut-item" href="#kategori"><span class="shortcut-icon">⌕</span><span>Jelajahi kategori</span></a>
            <a class="shortcut-item" href="#produk"><span class="shortcut-icon">✦</span><span>Produk terbaru</span></a>
            <a class="shortcut-item" href="#produk"><span class="shortcut-icon">▣</span><span>Kebutuhan harian</span></a>
            <a class="shortcut-item" href="#produk"><span class="shortcut-icon">♡</span><span>Rekomendasi</span></a>
            <a class="shortcut-item" href="{{ route('cart.index') }}"><span class="shortcut-icon">♧</span><span>Keranjang</span></a>
        </nav>

        <section class="market-section" aria-labelledby="daily-title">
            <div class="market-heading">
                <div><h2 id="daily-title"><span class="sale-mark">✦</span> Pilihan hari ini</h2><p>Produk yang bisa langsung kamu jelajahi</p></div>
                <a class="text-link" href="#produk">Lihat semua →</a>
            </div>
            <div class="mini-grid">
                @forelse($products->take(4) as $product)
                    <article class="mini-product">
                        <a href="{{ route('products.show', $product->id) }}">
                            <div class="mini-image">
                                @if($product->image)<img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" loading="lazy">@else<div class="mini-placeholder">Foto produk</div>@endif
                                <span class="mini-tag">{{ $product->stock > 0 ? 'TERSEDIA' : 'HABIS' }}</span>
                            </div>
                            <div class="mini-info"><h3 class="mini-name">{{ $product->name }}</h3><div class="mini-price">Rp {{ number_format($product->price, 0, ',', '.') }}</div></div>
                        </a>
                    </article>
                @empty
                    <div class="empty-state"><strong>Produk segera hadir</strong><p>Produk pilihan akan tampil di bagian ini.</p></div>
                @endforelse
            </div>
        </section>

        <section class="section" id="kategori">
            <div class="section-heading">
                <div><h2>Belanja berdasarkan kategori</h2><p>Pilih kategori untuk menyaring produk</p></div>
                @if(request('category'))<a class="text-link" href="{{ url('/shop') }}">Hapus filter</a>@endif
            </div>
            <div class="category-list">
                <a class="category-item {{ request('category') ? '' : 'active' }}" href="{{ url('/shop') }}"><span class="category-symbol">✳</span><span>Semua</span></a>
                @forelse($categories as $category)
                    <a class="category-item {{ (string) request('category') === (string) $category->id ? 'active' : '' }}" href="{{ url('/shop?' . http_build_query(array_filter(['category' => $category->id, 'search' => request('search')]))) }}"><span class="category-symbol">{{ mb_strtoupper(mb_substr($category->name, 0, 1)) }}</span><span>{{ $category->name }}</span></a>
                @empty
                    <div class="empty-state"><strong>Belum ada kategori</strong><p>Kategori produk akan tampil di sini.</p></div>
                @endforelse
            </div>
        </section>

        <section class="catalog" id="produk">
            <div class="section-heading">
                <div>
                    <h2>{{ request('search') ? 'Hasil pencarian' : (request('category') ? 'Produk dalam kategori' : 'Baru datang, layak dilirik') }}</h2>
                    <p>{{ $products->count() }} produk tersedia{{ request('search') ? ' untuk “' . request('search') . '”' : '' }}</p>
                </div>
                <div class="catalog-tools"><label for="sort-products">Urutkan</label><select id="sort-products"><option value="latest">Terbaru</option><option value="price-low">Harga terendah</option><option value="price-high">Harga tertinggi</option><option value="name">Nama A-Z</option></select></div>
            </div>
            <div class="product-grid" id="product-grid">
                @forelse($products as $product)
                    <article class="product-card" data-price="{{ $product->price }}" data-name="{{ strtolower($product->name) }}">
                        <a href="{{ route('products.show', $product->id) }}" aria-label="Lihat {{ $product->name }}">
                            <div class="product-image-wrap">
                                @if($product->image)
                                    <img class="product-image" src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" loading="lazy">
                                @else
                                    <div class="image-placeholder">Foto produk belum tersedia</div>
                                @endif
                                @if($product->stock > 0 && $product->stock <= 5)<span class="stock-tag">Stok terbatas</span>@endif
                            </div>
                            <div class="product-info">
                                <p class="product-category">{{ $product->category->name ?? 'Produk pilihan' }}</p>
                                <h3 class="product-name">{{ $product->name }}</h3>
                                <div class="product-price">Rp {{ number_format($product->price, 0, ',', '.') }}</div>
                                <div class="product-stock">{{ $product->stock > 0 ? 'Stok ' . $product->stock : 'Stok habis' }}</div>
                            </div>
                        </a>
                        <form class="product-action" action="{{ route('cart.add', $product->id) }}" method="POST">
                            @csrf
                            <button class="add-button" type="submit" {{ $product->stock < 1 ? 'disabled' : '' }}>{{ $product->stock > 0 ? '+ Tambah ke keranjang' : 'Stok habis' }}</button>
                        </form>
                    </article>
                @empty
                    <div class="empty-state"><strong>Produk belum ditemukan</strong><p>Coba kata kunci lain atau lihat semua produk yang tersedia.</p><a class="button" href="{{ url('/shop') }}">Lihat semua produk</a></div>
                @endforelse
            </div>
        </section>

        @if($products->count() > 4)
            <section class="market-section" aria-labelledby="recommend-title" style="margin-top: 37px;">
                <div class="market-heading"><div><h2 id="recommend-title">Mungkin kamu suka</h2><p>Temukan produk lain dari katalog NexaMarket</p></div></div>
                <div class="mini-grid">
                    @foreach($products->slice(4, 4) as $product)
                        <article class="mini-product">
                            <a href="{{ route('products.show', $product->id) }}">
                                <div class="mini-image">
                                    @if($product->image)<img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" loading="lazy">@else<div class="mini-placeholder">Foto produk</div>@endif
                                    <span class="mini-tag">{{ $product->stock > 0 ? 'TERSEDIA' : 'HABIS' }}</span>
                                </div>
                                <div class="mini-info"><h3 class="mini-name">{{ $product->name }}</h3><div class="mini-price">Rp {{ number_format($product->price, 0, ',', '.') }}</div></div>
                            </a>
                        </article>
                    @endforeach
                </div>
            </section>
        @endif

        <section class="promo-banner-bottom">
            <div><h2>Belanja jadi lebih praktis.</h2><p>Produk pilihanmu, tersusun rapi dalam satu keranjang.</p></div>
            <a class="button" href="#produk">Jelajahi produk →</a>
        </section>
        <section class="trust-row" aria-label="Fitur NexaMarket">
            <div class="trust-item"><span class="trust-icon">⌕</span><span><strong>Pencarian mudah</strong>Temukan barang incaran</span></div>
            <div class="trust-item"><span class="trust-icon">▦</span><span><strong>Kategori rapi</strong>Jelajahi sesuai kebutuhan</span></div>
            <div class="trust-item"><span class="trust-icon">♧</span><span><strong>Keranjang praktis</strong>Atur pilihan belanja</span></div>
            <div class="trust-item"><span class="trust-icon">♡</span><span><strong>Produk pilihan</strong>Beragam koleksi tersedia</span></div>
        </section>
        <footer class="footer">
            <a href="{{ url('/') }}" class="brand"><span class="brand-mark">N</span><span>NexaMarket</span></a>
            <div class="footer-groups">
                <div class="footer-group"><strong>NexaMarket</strong><a href="{{ url('/') }}">Beranda</a><a href="#kategori">Kategori</a></div>
                <div class="footer-group"><strong>Belanja</strong><a href="#produk">Produk terbaru</a><a href="{{ route('cart.index') }}">Keranjang</a></div>
                <div class="footer-group"><strong>Akun toko</strong><a href="{{ route('products.index') }}">Kelola produk</a><a href="{{ route('categories.index') }}">Kelola kategori</a></div>
            </div>
            <span>© {{ date('Y') }} NexaMarket</span>
        </footer>
    </main>

    <nav class="mobile-nav" aria-label="Navigasi utama"><a href="{{ url('/') }}"><span>⌂</span><span>Beranda</span></a><a href="#kategori"><span>▦</span><span>Kategori</span></a><a href="{{ route('cart.index') }}"><span>♧</span><span>Keranjang</span></a></nav>
    <script>
        const productGrid = document.querySelector('#product-grid');
        const sortProducts = document.querySelector('#sort-products');
        sortProducts.addEventListener('change', () => {
            const cards = [...productGrid.querySelectorAll('.product-card')];
            const sorters = {
                latest: () => 0,
                'price-low': (a, b) => Number(a.dataset.price) - Number(b.dataset.price),
                'price-high': (a, b) => Number(b.dataset.price) - Number(a.dataset.price),
                name: (a, b) => a.dataset.name.localeCompare(b.dataset.name, 'id')
            };
            cards.sort(sorters[sortProducts.value]);
            cards.forEach((card) => productGrid.append(card));
        });
    </script>
</body>
</html>
