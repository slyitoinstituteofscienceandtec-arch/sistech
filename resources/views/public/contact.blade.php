@extends('layouts.public')

@section('content')
<div class="page-hero">
    <div class="container">
        <h1>Contact Us</h1>
        <p>We'd love to hear from you</p>
        <div class="breadcrumb">
            <a href="{{ route('public.home') }}">Home</a>
            <span>/</span>
            <span>Contact</span>
        </div>
    </div>
</div>

<section class="section">
    <div class="container">
        <div style="display: grid; grid-template-columns: 3fr 2fr; gap: 2.5rem; align-items: start;">

            <div>
                @if(session('contact_success'))
                <div class="alert alert-success" style="display: flex; align-items: start; gap: 1rem; padding: 1.5rem; border-radius: 12px; background: #f0fdf4; border: 1px solid #bbf7d0; color: #166534; margin-bottom: 2rem;">
                    <i class="fas fa-check-circle" style="font-size: 1.5rem; margin-top: 0.15rem; color: #22c55e;"></i>
                    <div>
                        <strong style="display: block; margin-bottom: 0.35rem;">Message Sent Successfully!</strong>
                        <span style="opacity: 0.9;">{{ session('contact_success') }}</span>
                    </div>
                </div>
                @endif

                <div class="card" style="overflow: hidden;">
                    <div style="padding: 1.5rem 2rem; border-bottom: 1px solid #e8ecf1;">
                        <h3 style="margin: 0; color: #1a1a2e; display: flex; align-items: center; gap: 0.75rem;">
                            <div class="feature-icon blue" style="width: 36px; height: 36px; min-width: 36px; display: flex; align-items: center; justify-content: center; border-radius: 10px; background: linear-gradient(135deg, #0066CC, #004999); color: #fff; font-size: 0.85rem;">
                                <i class="fas fa-envelope"></i>
                            </div>
                            Send Us a Message
                        </h3>
                    </div>
                    <div class="card-body" style="padding: 2rem;">
                        <form action="{{ route('public.contact.store') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label class="form-label">Your Name <span style="color: #dc2626;">*</span></label>
                                <input type="text" name="name" class="form-control" value="{{ old('name') }}" placeholder="Enter your full name" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Email Address <span style="color: #dc2626;">*</span></label>
                                <input type="email" name="email" class="form-control" value="{{ old('email') }}" placeholder="you@example.com" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Subject <span style="color: #dc2626;">*</span></label>
                                <input type="text" name="subject" class="form-control" value="{{ old('subject') }}" placeholder="What is this about?" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Message <span style="color: #dc2626;">*</span></label>
                                <textarea name="message" class="form-control" rows="6" placeholder="Write your message here..." required>{{ old('message') }}</textarea>
                            </div>
                            <button type="submit" class="btn btn-primary btn-lg" style="width: 100%; padding: 1rem; font-size: 1.1rem; border-radius: 12px; display: flex; align-items: center; justify-content: center; gap: 0.5rem;">
                                Send Message <i class="fas fa-paper-plane"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <aside>
                <div class="card" style="margin-bottom: 1.5rem; overflow: hidden;">
                    <div style="padding: 1.25rem 1.5rem; border-bottom: 1px solid #e8ecf1;">
                        <h4 style="margin: 0; color: #1a1a2e; display: flex; align-items: center; gap: 0.5rem;">
                            <i class="fas fa-map-marker-alt" style="color: #0066CC;"></i>
                            Get in Touch
                        </h4>
                    </div>
                    <div class="card-body">
                        <div style="display: flex; flex-direction: column; gap: 1.25rem;">
                            <div style="display: flex; align-items: start; gap: 1rem;">
                                <div style="width: 40px; height: 40px; min-width: 40px; border-radius: 10px; background: linear-gradient(135deg, #0066CC, #004999); color: #fff; display: flex; align-items: center; justify-content: center;">
                                    <i class="fas fa-map-marker-alt" style="font-size: 0.9rem;"></i>
                                </div>
                                <div>
                                    <strong style="display: block; color: #1a1a2e; margin-bottom: 0.2rem; font-size: 0.9rem;">Address</strong>
                                    <span style="color: #666; font-size: 0.85rem;">{{ $settings['institution_address'] ?? 'SISTECH College, Freetown, Sierra Leone' }}</span>
                                </div>
                            </div>
                            <div style="display: flex; align-items: start; gap: 1rem;">
                                <div style="width: 40px; height: 40px; min-width: 40px; border-radius: 10px; background: linear-gradient(135deg, #0066CC, #004999); color: #fff; display: flex; align-items: center; justify-content: center;">
                                    <i class="fas fa-phone-alt" style="font-size: 0.9rem;"></i>
                                </div>
                                <div>
                                    <strong style="display: block; color: #1a1a2e; margin-bottom: 0.2rem; font-size: 0.9rem;">Phone</strong>
                                    <span style="color: #666; font-size: 0.85rem;">{{ $settings['institution_phone'] ?? '+232 77 893 327' }}</span><br>
                                    <span style="color: #666; font-size: 0.85rem;">{{ $settings['institution_phone2'] ?? '+232 34 145 006' }}</span>
                                </div>
                            </div>
                            <div style="display: flex; align-items: start; gap: 1rem;">
                                <div style="width: 40px; height: 40px; min-width: 40px; border-radius: 10px; background: linear-gradient(135deg, #9333ea, #7e22ce); color: #fff; display: flex; align-items: center; justify-content: center;">
                                    <i class="fas fa-envelope" style="font-size: 0.9rem;"></i>
                                </div>
                                <div>
                                    <strong style="display: block; color: #1a1a2e; margin-bottom: 0.2rem; font-size: 0.9rem;">Email</strong>
                                    <span style="color: #666; font-size: 0.85rem;">{{ $settings['institution_email'] ?? 'sistech2025@gmail.com' }}</span>
                                </div>
                            </div>
                            <div style="display: flex; align-items: start; gap: 1rem;">
                                <div style="width: 40px; height: 40px; min-width: 40px; border-radius: 10px; background: linear-gradient(135deg, #ea580c, #c2410c); color: #fff; display: flex; align-items: center; justify-content: center;">
                                    <i class="fas fa-globe" style="font-size: 0.9rem;"></i>
                                </div>
                                <div>
                                    <strong style="display: block; color: #1a1a2e; margin-bottom: 0.2rem; font-size: 0.9rem;">Website</strong>
                                    <span style="color: #666; font-size: 0.85rem;">{{ $settings['institution_website'] ?? 'https://sistech.website' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card" style="margin-bottom: 1.5rem; overflow: hidden;">
                    <div style="padding: 1.25rem 1.5rem; border-bottom: 1px solid #e8ecf1;">
                        <h4 style="margin: 0; color: #1a1a2e; display: flex; align-items: center; gap: 0.5rem;">
                            <i class="fas fa-clock" style="color: #0066CC;"></i>
                            Office Hours
                        </h4>
                    </div>
                    <div class="card-body">
                        <div style="display: flex; flex-direction: column; gap: 0.75rem;">
                            <div style="display: flex; justify-content: space-between; align-items: center; padding-bottom: 0.75rem; border-bottom: 1px solid #f1f5f9;">
                                <span style="color: #555; font-size: 0.9rem;">Monday – Friday</span>
                                <span style="color: #1a1a2e; font-weight: 600; font-size: 0.9rem;">8:00 AM – 5:00 PM</span>
                            </div>
                            <div style="display: flex; justify-content: space-between; align-items: center;">
                                <span style="color: #555; font-size: 0.9rem;">Saturday</span>
                                <span style="color: #1a1a2e; font-weight: 600; font-size: 0.9rem;">9:00 AM – 1:00 PM</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div style="border-radius: 16px; overflow: hidden; background: #e2e8f0; height: 300px;">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3947.757660592525!2d-13.0797462!3d8.3268622!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xf04e12802634259%3A0x4e4804aa96b5f9b5!2sSlyito%20Institute%20of%20Science%20and%20Technology%20(SISTECH)!5e0!3m2!1sen!2ssl!4v1784125766411!5m2!1sen!2ssl" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="strict-origin-when-cross-origin"></iframe>
                </div>
            </aside>

        </div>
    </div>
</section>
@endsection
