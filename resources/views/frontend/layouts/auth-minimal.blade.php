<!DOCTYPE html>
<html lang="en" class="dark bg-black">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    {{-- SEO Meta --}}
    <title>{{ $metaTitle ?? 'TimeNest' }}</title>
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 32 32'><path d='M28 16 A12 12 0 1 0 16 28' stroke='%236366f1' stroke-width='1.8' fill='none' stroke-linecap='round'/><path d='M23 16 A7 7 0 1 0 16 23' stroke='%2318181b' stroke-width='1.8' fill='none' stroke-linecap='round'/><path d='M19 16 A3 3 0 1 0 16 19' stroke='%2318181b' stroke-width='1.8' fill='none' stroke-linecap='round'/></svg>">
    <meta name="description" content="{{ $metaDescription ?? 'TimeNest Auth' }}">

    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    {{-- Frontend Assets (Legacy) --}}
    @if (app()->environment('local') && file_exists(public_path('hot')))
        @vite(['resources/css/frontend.css', 'resources/js/frontend.js'])
    @else
        <link rel="stylesheet" href="{{ asset('assets/frontend.css') }}">
        <script type="module" src="{{ asset('assets/frontend.js') }}"></script>
    @endif
</head>
<body class="bg-[#0a0a0f] text-neutral-300 antialiased min-h-screen flex flex-col">
    <main class="flex-grow bg-surface flex flex-col items-center justify-center">
        <div class="mb-8">
            <a href="/" class="flex items-center gap-2" style="text-decoration: none;">
                <svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 32 32' style="width: 32px; height: 32px;">
                    <path d='M28 16 A12 12 0 1 0 16 28' stroke='#6366f1' stroke-width='1.8' fill='none' stroke-linecap='round'/>
                    <path d='M23 16 A7 7 0 1 0 16 23' stroke='#f8fafc' stroke-width='1.8' fill='none' stroke-linecap='round'/>
                    <path d='M19 16 A3 3 0 1 0 16 19' stroke='#f8fafc' stroke-width='1.8' fill='none' stroke-linecap='round'/>
                </svg>
                <span style="font-size: 24px; font-weight: 700; color: #f8fafc;">TimeNest</span>
            </a>
        </div>
        {{ $slot }}
    </main>
</body>
</html>

