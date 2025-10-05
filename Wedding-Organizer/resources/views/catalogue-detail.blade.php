<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $catalogue->package_name }} - Wedify</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    
    @include('partials.styles')
    <style>
        :root {
            --primary-color: #E91E63;
            --secondary-color: #F06292;
            --accent-color: #FCE4EC;
            --text-dark: #2c2c2c;
            --text-light: #666;
            --love-red: #DC143C;
            --love-pink: #FF69B4;
            --love-rose: #FF1493;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            line-height: 1.6;
            color: var(--text-dark);
            padding-top: 80px;
        }

        .font-playfair {
            font-family: 'Playfair Display', serif;
        }

        /* Navigation styles are included from partials.styles */

        .btn-primary {
            background: var(--primary-color);
            border: none;
            padding: 12px 30px;
            font-weight: 600;
            border-radius: 50px;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background: var(--secondary-color);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }

        .btn-outline-primary {
            color: var(--primary-color);
            border-color: var(--primary-color);
            border-radius: 50px;
            padding: 10px 25px;
            font-weight: 500;
        }

        .btn-outline-primary:hover {
            background: var(--primary-color);
            border-color: var(--primary-color);
        }

        /* Detail Section */
        .detail-section {
            padding: 60px 0;
        }

        .detail-image {
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            width: 100%;
            height: 400px;
            object-fit: cover;
        }

        .detail-content {
            padding-left: 2rem;
        }

        .package-title {
            font-family: 'Playfair Display', serif;
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 1rem;
        }

        .price-display {
            font-size: 2rem;
            font-weight: 700;
            color: var(--primary-color);
            margin-bottom: 1.5rem;
        }

        .description {
            font-size: 1.1rem;
            line-height: 1.8;
            color: var(--text-light);
            margin-bottom: 2rem;
        }

        .package-features {
            background: var(--accent-color);
            padding: 2rem;
            border-radius: 15px;
            margin-bottom: 2rem;
        }

        .feature-item {
            display: flex;
            align-items: center;
            margin-bottom: 1rem;
        }

        .feature-item i {
            color: var(--primary-color);
            margin-right: 1rem;
            width: 20px;
        }

        .organizer-info {
            background: white;
            padding: 1.5rem;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
            margin-top: 2rem;
        }

        .back-button {
            margin-bottom: 2rem;
        }

        /* Contact Section */
        .contact-section {
            background: var(--accent-color);
            padding: 60px 0;
        }

        .contact-card {
            background: white;
            padding: 2rem;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
            text-align: center;
        }

        .contact-icon {
            width: 60px;
            height: 60px;
            background: var(--primary-color);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
            color: white;
            font-size: 1.5rem;
        }

        /* Footer */
        .footer {
            background: var(--text-dark);
            color: white;
            padding: 2rem 0;
            text-align: center;
        }

        /* Recommended Section */
        .recommended-section {
            background: var(--accent-color);
        }
        
        .catalogue-card {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
            display: flex;
            flex-direction: column;
        }
        
        .catalogue-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
        }
        
        .catalogue-image {
            height: 200px;
            overflow: hidden;
        }
        
        .catalogue-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }
        
        .catalogue-card:hover .catalogue-image img {
            transform: scale(1.05);
        }
        
        .catalogue-content {
            padding: 1.5rem;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }
        
        .catalogue-title {
            font-family: 'Playfair Display', serif;
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 0.5rem;
        }
        
        .catalogue-price {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--primary-color);
            margin-bottom: 1rem;
        }
        
        .catalogue-description {
            color: var(--text-light);
            line-height: 1.6;
            margin-bottom: 1rem;
            flex-grow: 1;
        }
        
        .catalogue-features {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
        }
        
        .feature-badge {
            background: var(--accent-color);
            color: var(--primary-color);
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.875rem;
            font-weight: 500;
        }
        
        .feature-badge i {
            margin-right: 0.25rem;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .detail-content {
                padding-left: 0;
                margin-top: 2rem;
            }
            
            .package-title {
                font-size: 2rem;
            }
            
            .price-display {
                font-size: 1.5rem;
            }
            
            .catalogue-image {
                height: 180px;
            }
        }
    </style>
</head>
<body>
    @include('partials.navigation')

    <!-- Detail Section -->
    <section class="detail-section">
        <div class="container">
            <div class="back-button">
                <a href="{{ route('landing') }}#catalogue" class="btn btn-outline-primary">
                    <i class="fas fa-arrow-left me-2"></i>Back to Packages
                </a>
            </div>
            
            <div class="row">
                <div class="col-lg-6 mb-4">
                    @if($catalogue->image)
                        <img src="{{ asset('storage/' . $catalogue->image) }}" class="detail-image" alt="{{ $catalogue->package_name }}">
                    @else
                        <img src="https://images.unsplash.com/photo-1519741497674-611481863552?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" class="detail-image" alt="{{ $catalogue->package_name }}">
                    @endif
                </div>
                
                <div class="col-lg-6">
                    <div class="detail-content">
                        <h1 class="package-title">{{ $catalogue->package_name }}</h1>
                        <div class="price-display">Rp {{ number_format($catalogue->price, 0, ',', '.') }}</div>
                        
                        <div class="description">
                            {{ $catalogue->description }}
                        </div>
                        
                        <div class="package-features">
                            <h4 class="font-playfair mb-3">Package Features:</h4>
                            <div class="feature-item">
                                <i class="fas fa-check-circle"></i>
                                <span>Free wedding consultation</span>
                            </div>
                            <div class="feature-item">
                                <i class="fas fa-check-circle"></i>
                                <span>Themed venue decoration</span>
                            </div>
                            <div class="feature-item">
                                <i class="fas fa-check-circle"></i>
                                <span>Professional wedding coordinator</span>
                            </div>
                            <div class="feature-item">
                                <i class="fas fa-check-circle"></i>
                                <span>Photo & video documentation</span>
                            </div>
                            <div class="feature-item">
                                <i class="fas fa-check-circle"></i>
                                <span>Catering and menu selection</span>
                            </div>
                            <div class="feature-item">
                                <i class="fas fa-check-circle"></i>
                                <span>Entertainment and music</span>
                            </div>
                        </div>
                        
                        <div class="d-grid gap-2 d-md-flex mb-3">
                            <button class="btn btn-primary btn-lg me-md-2" onclick="addToCart({{ $catalogue->catalogue_id }})">
                                Add to Cart
                            </button>
                            <button class="btn btn-outline-primary btn-lg" onclick="buyNow({{ $catalogue->catalogue_id }})">
                                Buy Now
                            </button>
                        </div>
                        
                        <div class="d-grid gap-2 d-md-flex">
                            <button class="btn btn-success btn-lg me-md-2" onclick="contactWhatsApp()">
                                <i class="fas fa-whatsapp me-2"></i>Contact via WhatsApp
                            </button>
                            <button class="btn btn-outline-success btn-lg" onclick="contactPhone()">
                                <i class="fas fa-phone me-2"></i>Call Now
                            </button>
                        </div>
                        
                        @if($catalogue->user)
                        <div class="organizer-info">
                            <h5 class="font-playfair mb-2">Wedding Organizer</h5>
                            <p class="mb-1"><strong>{{ $catalogue->user->name }}</strong></p>
                            <p class="text-muted mb-0">{{ $catalogue->user->email }}</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Recommended Packages Section -->
    <section class="recommended-section py-5">
        <div class="container">
            <div class="row text-center mb-5">
                <div class="col-12">
                    <h2 class="font-playfair mb-3">Recommended Packages</h2>
                    <p class="text-muted">Discover other amazing wedding packages that might interest you</p>
                </div>
            </div>
            
            <div class="row">
                @php
                    $recommendedCatalogues = App\Models\Catalogue::where('catalogue_id', '!=', $catalogue->catalogue_id)->take(3)->get();
                @endphp
                
                @foreach($recommendedCatalogues as $recommended)
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="catalogue-card h-100" onclick="window.location.href='{{ url('catalogue/' . $recommended->id) }}'" style="cursor: pointer;">
                        <div class="catalogue-image">
                            @if($recommended->image)
                                <img src="{{ asset('storage/' . $recommended->image) }}" alt="{{ $recommended->package_name }}">
                            @else
                                <img src="https://images.unsplash.com/photo-1519741497674-611481863552?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="{{ $recommended->package_name }}">
                            @endif
                        </div>
                        <div class="catalogue-content">
                            <h5 class="catalogue-title">{{ $recommended->package_name }}</h5>
                            <p class="catalogue-price">Rp {{ number_format($recommended->price, 0, ',', '.') }}</p>
                            <p class="catalogue-description">{{ Str::limit($recommended->description, 100) }}</p>
                            <div class="catalogue-features">
                                <span class="feature-badge"><i class="fas fa-check"></i> Professional Service</span>
                                <span class="feature-badge"><i class="fas fa-check"></i> Full Package</span>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section class="contact-section">
        <div class="container">
            <div class="row text-center mb-5">
                <div class="col-12">
                    <h2 class="font-playfair mb-3">Interested in This Package?</h2>
                    <p class="text-muted">Contact us now for a free consultation and get the best offer!</p>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-4 mb-4">
                    <div class="contact-card">
                        <div class="contact-icon">
                            <i class="fas fa-whatsapp"></i>
                        </div>
                        <h5 class="font-playfair mb-2">WhatsApp</h5>
                        <p class="text-muted mb-3">{{ $settings->phone_number ?? '+62 812-345-678' }}</p>
                        <button class="btn btn-primary" onclick="contactWhatsApp()">
                            Chat Now
                        </button>
                    </div>
                </div>
                
                <div class="col-md-4 mb-4">
                    <div class="contact-card">
                        <div class="contact-icon">
                            <i class="fas fa-phone"></i>
                        </div>
                        <h5 class="font-playfair mb-2">Phone</h5>
                        <p class="text-muted mb-3">{{ $settings->phone_number ?? '+62 812-345-678' }}</p>
                        <button class="btn btn-outline-primary" onclick="contactPhone()">
                            Call Now
                        </button>
                    </div>
                </div>
                
                <div class="col-md-4 mb-4">
                    <div class="contact-card">
                        <div class="contact-icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <h5 class="font-playfair mb-2">Email</h5>
                        <p class="text-muted mb-3">{{ $settings->email ?? 'info@weddingorganizer.com' }}</p>
                        <a href="mailto:{{ $settings->email ?? 'info@weddingorganizer.com' }}" class="btn btn-outline-primary">
                            Send Email
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <p class="mb-0">&copy; {{ date('Y') }} Wedify. All rights reserved.</p>
        </div>
    </footer>

    @include('partials.scripts')
    <script>
        // Authentication check functions
        function checkAuthentication() {
            @auth
                return true;
            @else
                return false;
            @endauth
        }
        
        function redirectToLogin() {
            alert('Please login first to continue.');
            window.location.href = '{{ route("login") }}';
        }
        
        // Add to Cart function
        function addToCart(catalogueId) {
            if (!checkAuthentication()) {
                redirectToLogin();
                return;
            }
            
            // TODO: Implement add to cart functionality
            alert('Add to Cart functionality will be implemented soon!');
        }
        
        // Buy Now function
        function buyNow(catalogueId) {
            if (!checkAuthentication()) {
                redirectToLogin();
                return;
            }
            
            // TODO: Implement buy now functionality
            alert('Buy Now functionality will be implemented soon!');
        }
        
        function contactWhatsApp() {
            const packageName = '{{ $catalogue->package_name }}';
            const price = 'Rp {{ number_format($catalogue->price, 0, ",", ".") }}';
            const message = `Hello, I'm interested in the wedding package "${packageName}" with price ${price}. Could you please provide more detailed information?`;
            const whatsappNumber = '{{ str_replace(["+", "-", " "], "", $settings->phone_number ?? "+6281234567890") }}';
            const whatsappUrl = `https://wa.me/${whatsappNumber}?text=${encodeURIComponent(message)}`;
            window.open(whatsappUrl, '_blank');
        }
        
        function contactPhone() {
            const phoneNumber = '{{ $settings->phone_number ?? "+62 812-345-678" }}';
            window.location.href = `tel:${phoneNumber}`;
        }
    </script>
</body>
</html>