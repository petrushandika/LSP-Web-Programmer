<!-- Contact Us Section -->
<section id="contact-us" class="section-padding">
    <div class="container">
        <h2 class="section-title">Contact Us</h2>
        <p class="section-subtitle">Ready to help make your dream wedding come true. Contact us now!</p>
        
        <div class="row">
            <div class="col-lg-6 mb-4">
                <div class="contact-info">
                    <h4 class="font-playfair mb-4">Contact Information</h4>
                    <div class="mb-3">
                        <i class="fas fa-map-marker-alt"></i>
                        <span>{{ $settings->address ?? '123 Wedding Lane, Jakarta' }}</span>
                    </div>
                    <div class="mb-3">
                        <i class="fas fa-phone"></i>
                        <span>{{ $settings->phone_number ?? '+62 812-345-678' }}</span>
                    </div>
                    <div class="mb-3">
                        <i class="fas fa-envelope"></i>
                        <span>{{ $settings->email ?? 'info@wedify.com' }}</span>
                    </div>
                    <div class="mb-4">
                        <i class="fas fa-clock"></i>
                        <span>{{ $settings->time_business_hour ?? 'Monday - Friday: 09:00 - 17:00' }}</span>
                    </div>
                    
                    <h5 class="mb-3">Follow Us</h5>
                    <div class="social-links">
                        @if($settings->facebook_url ?? false)
                            <a href="{{ $settings->facebook_url }}" target="_blank"><i class="fab fa-facebook-f"></i></a>
                        @endif
                        @if($settings->instagram_url ?? false)
                            <a href="{{ $settings->instagram_url }}" target="_blank"><i class="fab fa-instagram"></i></a>
                        @endif
                        @if($settings->youtube_url ?? false)
                            <a href="{{ $settings->youtube_url }}" target="_blank"><i class="fab fa-youtube"></i></a>
                        @endif
                    </div>
                </div>
            </div>
            
            <div class="col-lg-6">
                <div class="contact-form">
                    <h4 class="font-playfair mb-4">Send Message</h4>
                    <form id="contactForm">
                        <div class="mb-3">
                            <label for="name" class="form-label">Full Name</label>
                            <input type="text" class="form-control" id="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label">Phone Number</label>
                            <input type="tel" class="form-control" id="phone" required>
                        </div>
                        <div class="mb-3">
                            <label for="message" class="form-label">Message</label>
                            <textarea class="form-control" id="message" rows="4" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-paper-plane me-2"></i>Send Message
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>