{{-- resources/views/frontend/index.blade.php --}}
@extends('frontend.master')

@section('main-content')

<style>
    :root {
        --primary-color: #0d6efd;
        --dark-color: #212529;
    }

    .hero {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 120px 0 100px;
        position: relative;
        overflow: hidden;
    }

    .hero::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('https://picsum.photos/id/1015/2000/1200') center/cover no-repeat;
        opacity: 0.15;
        z-index: 0;
    }

    .hero-content {
        position: relative;
        z-index: 1;
    }

    .hero h1 {
        font-size: 3.2rem;
        font-weight: 800;
        line-height: 1.2;
        margin-bottom: 15px;
    }

    .hero p {
        font-size: 1.25rem;
        opacity: 0.95;
        max-width: 600px;
        margin: 0 auto 30px;
    }

    .btn-hero {
        padding: 14px 36px;
        font-size: 1.1rem;
        font-weight: 600;
        border-radius: 50px;
        transition: all 0.4s ease;
    }

    .btn-hero:hover {
        transform: translateY(-4px);
        box-shadow: 0 10px 25px rgba(13, 110, 253, 0.4);
    }

    .section-title {
        font-weight: 700;
        font-size: 2.1rem;
        position: relative;
        display: inline-block;
    }

    .section-title:after {
        content: '';
        position: absolute;
        width: 60px;
        height: 4px;
        background: var(--primary-color);
        bottom: -10px;
        left: 50%;
        transform: translateX(-50%);
        border-radius: 2px;
    }

    .contact-box {
        border-radius: 16px;
        padding: 35px 25px;
        background: #ffffff;
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.08);
        transition: all 0.4s ease;
        height: 100%;
        border: 1px solid #f1f3f5;
    }

    .contact-box:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.12);
    }

    .contact-icon {
        width: 70px;
        height: 70px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2.2rem;
        border-radius: 50%;
        margin: 0 auto 20px;
    }

    .map-container {
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 10px 35px rgba(0, 0, 0, 0.1);
    }

    .map-container iframe {
        width: 100%;
        height: 450px;
        border: none;
    }
</style>

{{-- ================= HERO SECTION ================= --}}
<section class="hero">
    <div class="container">
        <div class="hero-content text-center">
            <h1>Welcome to <span class="fw-bold">Shahzadimart</span></h1>
            <p>Your trusted online shopping destination for quality products at unbeatable prices</p>

            <a href="{{ route('shop') }}" class="btn btn-light btn-hero shadow-sm">
                <i class="fa-solid fa-cart-plus me-2"></i> Shop Now
            </a>
        </div>
    </div>
</section>

{{-- ================= CONTACT INFORMATION ================= --}}
<section class="py-5 bg-light">
    <div class="container">

        <div class="text-center mb-5">
            <h2 class="section-title text-dark">Get In Touch</h2>
            <p class="text-muted mt-3">We're here to help you anytime</p>
        </div>

        <div class="row g-4">

            {{-- Phone --}}
            <div class="col-lg-4 col-md-6">
                <div class="contact-box text-center">
                    <div class="contact-icon bg-primary text-white">
                        <i class="fa-solid fa-phone"></i>
                    </div>
                    <h5 class="mb-2 fw-semibold">Phone</h5>
                    <p class="mb-0 text-muted fs-5">
                        {{ $contact->contact_number ?? 'Not Available' }}
                    </p>
                </div>
            </div>

            {{-- Email --}}
            <div class="col-lg-4 col-md-6">
                <div class="contact-box text-center">
                    <div class="contact-icon bg-success text-white">
                        <i class="fa-solid fa-envelope"></i>
                    </div>
                    <h5 class="mb-2 fw-semibold">Email</h5>
                    <p class="mb-0 text-muted fs-5">
                        {{ $contact->email ?? 'Not Available' }}
                    </p>
                </div>
            </div>

            {{-- Address --}}
            <div class="col-lg-4 col-md-6 mx-auto">
                <div class="contact-box text-center">
                    <div class="contact-icon bg-danger text-white">
                        <i class="fa-solid fa-location-dot"></i>
                    </div>
                    <h5 class="mb-2 fw-semibold">Our Address</h5>
                    <p class="mb-0 text-muted fs-5">
                        {{ $contact->address ?? 'Not Available' }}
                    </p>
                </div>
            </div>

        </div>
    </div>
</section>

{{-- ================= GOOGLE MAP SECTION ================= --}}
<section class="py-5">
    <div class="container">

        <div class="text-center mb-5">
            <h2 class="section-title text-dark">Visit Our Location</h2>
            <p class="text-muted">Find us easily on the map</p>
        </div>

        <div class="map-container">
            @if(!empty($contact->google_map_embed_code))
                {!! $contact->google_map_embed_code !!}
            @else
                <div class="alert alert-warning text-center py-5">
                    <i class="fa-solid fa-map-location-dot fa-3x mb-3 text-warning"></i>
                    <h5>Google Map Not Available</h5>
                    <p class="mb-0">Our location map will be updated soon.</p>
                </div>
            @endif
        </div>

    </div>
</section>

@endsection
