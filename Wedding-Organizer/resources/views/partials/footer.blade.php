<!-- Footer -->
<footer class="footer" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <h5 class="font-playfair mb-3 text-white">Wedify</h5>
                <p class="mb-3 text-light">Creating unforgettable moments, one wedding at a time. Your dream wedding is our passion.</p>
                <div class="social-links">
                    <a href="#" class="me-3 text-white"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="me-3 text-white"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="me-3 text-white"><i class="fab fa-twitter"></i></a>
                </div>
            </div>
            <div class="col-md-3">
                <h6 class="mb-3 text-white">Quick Links</h6>
                <ul class="list-unstyled">
                    <li><a href="#home" class="text-light">Home</a></li>
                    <li><a href="#catalogue" class="text-light">Packages</a></li>
                    <li><a href="#about-us" class="text-light">About Us</a></li>
                    <li><a href="#contact-us" class="text-light">Contact</a></li>
                </ul>
            </div>
            <div class="col-md-3">
                <h6 class="mb-3 text-white">Contact Info</h6>
                <p class="text-light mb-1"><i class="fas fa-phone me-2"></i>{{ $settings->phone_number ?? '+62 812-345-678' }}</p>
                <p class="text-light mb-1"><i class="fas fa-envelope me-2"></i>{{ $settings->email ?? 'info@wedify.com' }}</p>
                <p class="text-light"><i class="fas fa-map-marker-alt me-2"></i>{{ $settings->address ?? '123 Wedding Lane, Jakarta' }}</p>
            </div>
        </div>
        <hr class="my-4" style="border-color: rgba(255,255,255,0.2);">
        <div class="row align-items-center">
            <div class="col-md-6">
                <p class="mb-0 text-light">&copy; {{ date('Y') }} Wedify. All rights reserved.</p>
            </div>
            <div class="col-md-6 text-md-end">
                <p class="mb-0 text-muted">Made with <i class="fas fa-heart text-danger"></i> for your special day</p>
            </div>
        </div>
    </div>
</footer>