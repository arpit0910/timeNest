@extends('layouts.marketing')

@section('content')
    <x-marketing.header />
    
    <main>
        {{-- Main Hero Section --}}
        <x-marketing.hero />

        {{-- Feature Sections --}}
        <x-marketing.features.workflow />
        <x-marketing.features.attendance />
        
        {{-- Interstitial CTA --}}
        <x-marketing.cta-mini />
        
        <x-marketing.features.shifts />
        <x-marketing.features.leaves />
        <x-marketing.features.chat />
        
        {{-- FAQs --}}
        <x-marketing.faq />

        {{-- Final Newsletter CTA --}}
        <x-marketing.cta-newsletter />

    </main>

    {{-- Footer --}}
    <x-marketing.footer />
@endsection
