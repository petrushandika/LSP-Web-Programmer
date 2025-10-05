<!-- Catalogue Section -->
<section id="catalogue" class="section-padding">
    <div class="container">
        <h2 class="section-title">Our Wedding Packages</h2>
        <p class="section-subtitle">Discover the perfect wedding package tailored to your dreams and budget</p>
        
        <div class="catalogue-marquee-container">
            <div class="catalogue-marquee" id="catalogueMarquee">
                @forelse($catalogues as $catalogue)
                <div class="catalogue-card-wrapper">
                    <div class="card catalogue-card h-100">
                        <div class="catalogue-image-wrapper" onclick="window.location.href='{{ url('catalogue/' . $catalogue->catalogue_id) }}'" style="cursor: pointer;">
                            <img src="{{ $catalogue->image }}" class="card-img-top catalogue-image" alt="{{ $catalogue->name }}">
                            <div class="catalogue-price-overlay">
                                <div class="price-badge">Rp {{ number_format($catalogue->price, 0, ',', '.') }}</div>
                            </div>
                            <div class="catalogue-overlay">
                                <div class="overlay-content">
                                    <i class="fas fa-heart"></i>
                                    <span>View Details</span>
                                </div>
                            </div>
                        </div>
                        <div class="card-body catalogue-content d-flex flex-column">
                            <h5 class="catalogue-title" onclick="window.location.href='{{ url('catalogue/' . $catalogue->catalogue_id) }}'" style="cursor: pointer;">{{ $catalogue->package_name }}</h5>
                            <p class="catalogue-description flex-grow-1">{{ Str::limit($catalogue->description, 50, '...') }}</p>
                            <div class="catalogue-features mb-3">
                                <div class="feature-item">
                                    <span>Up to 200 Guests</span>
                                </div>
                                <div class="feature-item">
                                    <span>Complete Documentation</span>
                                </div>
                                <div class="feature-item">
                                    <span>Premium Catering</span>
                                </div>
                            </div>
                            <div class="catalogue-actions mt-auto">
                                <div class="d-flex gap-2">
                                    <button class="btn btn-primary flex-fill" onclick="event.stopPropagation(); addToCart({{ $catalogue->catalogue_id }})">
                                        Add to Cart
                                    </button>
                                    <button class="btn btn-outline-primary flex-fill" onclick="event.stopPropagation(); buyNow({{ $catalogue->catalogue_id }})">
                                        Buy Now
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12">
                    <div class="empty-state">
                        <i class="fas fa-heart-broken mb-3"></i>
                        <h4>No Wedding Packages Available</h4>
                        <p>We're currently preparing amazing wedding packages for you. Please check back soon!</p>
                    </div>
                </div>
                @endforelse
                
                @if($catalogues->count() > 0)
                <!-- Duplicate cards for seamless loop -->
                @foreach($catalogues as $catalogue)
                <div class="catalogue-card-wrapper">
                    <div class="card catalogue-card h-100">
                        <div class="catalogue-image-wrapper" onclick="window.location.href='{{ url('catalogue/' . $catalogue->catalogue_id) }}'" style="cursor: pointer;">
                            <img src="{{ $catalogue->image }}" class="card-img-top catalogue-image" alt="{{ $catalogue->name }}">
                            <div class="catalogue-price-overlay">
                                <div class="price-badge">Rp {{ number_format($catalogue->price, 0, ',', '.') }}</div>
                            </div>
                            <div class="catalogue-overlay">
                                <div class="overlay-content">
                                    <i class="fas fa-heart"></i>
                                    <span>View Details</span>
                                </div>
                            </div>
                        </div>
                        <div class="card-body catalogue-content d-flex flex-column">
                            <h5 class="catalogue-title" onclick="window.location.href='{{ url('catalogue/' . $catalogue->catalogue_id) }}'" style="cursor: pointer;">{{ $catalogue->package_name }}</h5>
                            <p class="catalogue-description flex-grow-1">{{ Str::limit($catalogue->description, 50, '...') }}</p>
                            <div class="catalogue-features mb-3">
                                <div class="feature-item">
                                    <span>Up to 200 Guests</span>
                                </div>
                                <div class="feature-item">
                                    <span>Complete Documentation</span>
                                </div>
                                <div class="feature-item">
                                    <span>Premium Catering</span>
                                </div>
                            </div>
                            <div class="catalogue-actions mt-auto">
                                <div class="d-flex gap-2">
                                    <button class="btn btn-primary flex-fill" onclick="event.stopPropagation(); addToCart({{ $catalogue->catalogue_id }})">
                                        Add to Cart
                                    </button>
                                    <button class="btn btn-outline-primary flex-fill" onclick="event.stopPropagation(); buyNow({{ $catalogue->catalogue_id }})">
                                        Buy Now
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
                @endif
            </div>
        </div>
    </div>
</section>