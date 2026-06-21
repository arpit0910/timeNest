<!DOCTYPE html>
<html lang="en" class="dark bg-black">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    {{-- SEO Meta --}}
    <title>{{ $metaTitle ?? 'TimeNest â€” The Work Operating System' }}</title>
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 32 32'><path d='M28 16 A12 12 0 1 0 16 28' stroke='%236366f1' stroke-width='1.8' fill='none' stroke-linecap='round'/><path d='M23 16 A7 7 0 1 0 16 23' stroke='%2318181b' stroke-width='1.8' fill='none' stroke-linecap='round'/><path d='M19 16 A3 3 0 1 0 16 19' stroke='%2318181b' stroke-width='1.8' fill='none' stroke-linecap='round'/></svg>">
    <meta name="description" content="{{ $metaDescription ?? 'TimeNest is a complete Work Operating System for organizations, freelancers, and collaborative workspaces. Manage employees, attendance, leaves, invoices, and more.' }}">
    <meta name="keywords" content="{{ $metaKeywords ?? 'work os, workforce management, employee management, attendance, freelancer, HR software' }}">
    <link rel="canonical" href="{{ $canonical ?? url()->current() }}">

    {{-- OpenGraph --}}
    <meta property="og:type" content="{{ $ogType ?? 'website' }}">
    <meta property="og:title" content="{{ $metaTitle ?? 'TimeNest â€” The Work Operating System' }}">
    <meta property="og:description" content="{{ $metaDescription ?? 'Complete workforce and operations management platform.' }}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:site_name" content="TimeNest">

    {{-- Twitter Card --}}
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $metaTitle ?? 'TimeNest â€” The Work Operating System' }}">
    <meta name="twitter:description" content="{{ $metaDescription ?? 'Complete workforce and operations management platform.' }}">

    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    {{-- Frontend Assets (production-safe: no npm required on server) --}}
    @if (app()->environment('local') && file_exists(public_path('hot')))
        @vite(['resources/css/frontend.css', 'resources/js/frontend.js'])
    @else
        <link rel="stylesheet" href="{{ asset('assets/frontend.css') }}">
        <script type="module" src="{{ asset('assets/frontend.js') }}"></script>
    @endif

    {{-- Schema.org --}}
    @if(isset($schemaMarkup))
        <script type="application/ld+json">{!! $schemaMarkup !!}</script>
    @endif

    {{-- Analytics --}}
    @if(config('analytics.google_tag'))
        <script async src="https://www.googletagmanager.com/gtag/js?id={{ config('analytics.google_tag') }}"></script>
        <script>window.dataLayer=window.dataLayer||[];function gtag(){dataLayer.push(arguments);}gtag('js',new Date());gtag('config','{{ config('analytics.google_tag') }}');</script>
    @endif

    @if(config('analytics.clarity'))
        <script type="text/javascript">(function(c,l,a,r,i,t,y){c[a]=c[a]||function(){(c[a].q=c[a].q||[]).push(arguments)};t=l.createElement(r);t.async=1;t.src="https://www.clarity.ms/tag/"+i;y=l.getElementsByTagName(r)[0];y.parentNode.insertBefore(t,y)})(window,document,"clarity","script","{{ config('analytics.clarity') }}");</script>
    @endif
</head>
<body class="bg-black text-content-strong font-body antialiased min-h-screen flex flex-col">
    <x-frontend-layout.header />

    <main class="flex-grow bg-surface">
        {{ $slot }}
    </main>

    <x-frontend-layout.footer />

    {{-- Search Overlay --}}
    @include('frontend.partials.search-overlay')
</body>
</html>
