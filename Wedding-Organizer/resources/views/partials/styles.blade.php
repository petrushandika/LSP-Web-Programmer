<style>
    :root {
        --primary-color: #e91e63;
        --secondary-color: #f06292;
        --accent-color: #fce4ec;
        --text-dark: #2c2c2c;
        --text-light: #666;
        --love-red: #d32f2f;
        --love-pink: #f8bbd9;
        --love-rose: #ff69b4;
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
        scroll-behavior: smooth;
    }

    .font-playfair {
        font-family: 'Playfair Display', serif;
    }

    /* Navigation Styles */
    .navbar {
        transition: all 0.3s ease;
        padding: 1rem 0;
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
    }

    .navbar.scrolled {
        padding: 0.5rem 0;
        box-shadow: 0 2px 20px rgba(0,0,0,0.1);
    }

    .navbar-brand {
        font-family: 'Playfair Display', serif;
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--primary-color) !important;
    }

    .nav-link {
        font-weight: 500;
        color: var(--text-dark) !important;
        margin: 0 0.5rem;
        transition: color 0.3s ease;
    }

    .nav-link:hover {
        color: var(--primary-color) !important;
    }

    /* Hero Section */
    .hero-section {
        height: 100vh;
        background: linear-gradient(rgba(0,0,0,0.4), rgba(0,0,0,0.4)), url('https://images.unsplash.com/photo-1519741497674-611481863552?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80');
        background-size: cover;
        background-position: center;
        background-attachment: fixed;
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
        color: white;
        position: relative;
    }

    .hero-content h1 {
        font-family: 'Playfair Display', serif;
        font-size: 3.5rem;
        font-weight: 700;
        margin-bottom: 1rem;
        text-shadow: 2px 2px 4px rgba(0,0,0,0.5);
    }

    .hero-content p {
        font-size: 1.2rem;
        margin-bottom: 2rem;
        max-width: 600px;
        margin-left: auto;
        margin-right: auto;
    }

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
    
    /* Uniform button styling with pink color */
    .btn {
        min-width: 150px;
        border-radius: 25px !important;
        border: 2px solid #FF69B4;
        font-weight: 500;
        transition: all 0.3s ease;
        background: #FF69B4 !important;
        color: white !important;
        font-size: 0.75rem !important;
        padding: 8px 16px !important;
    }
    
    .btn:hover {
        background: #FF1493 !important;
        border-color: #FF1493 !important;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(255, 105, 180, 0.4);
    }
    
    .btn-primary {
        background: #FF69B4 !important;
        border-color: #FF69B4 !important;
    }
    
    .btn-outline-primary {
        background: #FF69B4 !important;
        color: white !important;
        border-color: #FF69B4 !important;
    }
    
    .btn-success {
        background: #FF69B4 !important;
        border-color: #FF69B4 !important;
    }
    
    .btn-outline-success {
        background: #FF69B4 !important;
        border-color: #FF69B4 !important;
        color: white !important;
    }

    /* Section Styles */
    .section-padding {
        padding: 80px 0;
    }

    .section-title {
        font-family: 'Playfair Display', serif;
        font-size: 2.5rem;
        font-weight: 700;
        text-align: center;
        margin-bottom: 3rem;
        color: var(--text-dark);
    }

    .section-subtitle {
        text-align: center;
        color: var(--text-light);
        font-size: 1.1rem;
        margin-bottom: 3rem;
        max-width: 600px;
        margin-left: auto;
        margin-right: auto;
    }

    /* Marquee Container - Desktop and Tablet Only */
    .catalogue-marquee-container {
        overflow: hidden;
        position: relative;
        width: 100%;
    }
    
    .catalogue-marquee {
        display: flex;
        gap: 2rem;
    }
    
    .catalogue-card-wrapper {
        flex: 0 0 auto;
        width: 350px;
    }
    
    /* Desktop and Tablet Marquee */
    @media (min-width: 769px) {
        .catalogue-marquee {
            animation: marquee-continuous 30s linear infinite;
        }

        .catalogue-marquee:hover {
            animation-play-state: paused;
        }
    }
    
    @keyframes marquee-continuous {
        0% {
            transform: translateX(0);
        }
        100% {
            transform: translateX(-100%);
        }
    }
    
    /* Catalogue Cards */
    .catalogue-card {
        border: none;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 8px 30px rgba(0,0,0,0.12);
        transition: all 0.4s ease;
        background: white;
        position: relative;
        cursor: pointer;
    }
    
    .catalogue-card:hover {
        transform: translateY(-15px);
        box-shadow: 0 20px 50px rgba(0,0,0,0.2);
    }
    
    .clickable-card {
        cursor: pointer;
    }
    
    .catalogue-image-wrapper {
        position: relative;
        height: 280px;
        overflow: hidden;
    }
    
    .catalogue-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.4s ease;
    }
    
    .catalogue-card:hover .catalogue-image {
        transform: scale(1.1);
    }
    
    .catalogue-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(45deg, rgba(0,0,0,0.3), transparent);
        opacity: 0;
        transition: opacity 0.3s ease;
    }
    
    .catalogue-card:hover .catalogue-overlay {
        opacity: 1;
    }
    
    .overlay-content {
        display: none;
    }
    
    .catalogue-price-badge {
         position: absolute;
         top: 20px;
         right: 20px;
         background: rgba(255,255,255,0.95);
         backdrop-filter: blur(10px);
         padding: 10px 15px;
         border-radius: 25px;
         text-align: center;
         box-shadow: 0 4px 15px rgba(0,0,0,0.1);
     }
     
     .catalogue-price-overlay {
         position: absolute;
         top: 15px;
         right: 15px;
         z-index: 2;
     }
     
     .price-badge {
         background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
         color: white;
         padding: 8px 16px;
         border-radius: 20px;
         font-weight: 700;
         font-size: 0.9rem;
         box-shadow: 0 3px 15px rgba(233, 30, 99, 0.4);
         backdrop-filter: blur(10px);
     }
    
    .catalogue-price-tag {
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        color: white;
        padding: 8px 16px;
        border-radius: 20px;
        text-align: center;
        box-shadow: 0 3px 10px rgba(233, 30, 99, 0.3);
        display: inline-block;
    }
    
    .catalogue-price-tag .price-amount {
        font-weight: 700;
        font-size: 1rem;
    }
    
    .price-label {
        display: block;
        font-size: 0.75rem;
        color: var(--text-light);
        margin-bottom: 2px;
    }
    
    .price-amount {
        display: block;
        font-size: 0.9rem;
        font-weight: 700;
        color: var(--primary-color);
    }
    
    /* Smaller text sizes for catalogue cards */
    .catalogue-title {
        font-size: 1rem !important;
    }
    
    .catalogue-description {
        font-size: 0.85rem !important;
    }
    
    .feature-item span {
        font-size: 0.8rem !important;
    }
    
    .price-badge {
        font-size: 0.8rem !important;
    }
    
    .catalogue-content {
        padding: 25px;
    }
    
    .catalogue-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 15px;
    }
    
    .catalogue-title {
        font-family: 'Playfair Display', serif;
        font-size: 1.4rem;
        font-weight: 600;
        color: var(--text-dark);
        margin: 0;
        flex: 1;
    }
    
    .catalogue-rating {
        display: flex;
        align-items: center;
        gap: 2px;
        margin-left: 10px;
    }
    
    .catalogue-rating .fas.fa-star {
        color: #ffc107;
        font-size: 0.8rem;
    }
    
    .rating-text {
        font-size: 0.8rem;
        color: var(--text-light);
        margin-left: 5px;
    }
    
    .catalogue-description {
        color: var(--text-light);
        line-height: 1.6;
        margin-bottom: 20px;
        font-size: 0.95rem;
    }
    
    .catalogue-features {
        display: flex;
        flex-wrap: wrap;
        gap: 15px;
        margin-bottom: 25px;
    }
    
    .feature-item {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 0.85rem;
        color: var(--text-light);
    }
    
    .feature-item i {
        color: var(--primary-color);
        width: 16px;
    }
    
    .catalogue-actions {
        display: flex;
        flex-direction: column;
        gap: 10px;
        margin-top: auto;
    }
    
    .btn-block {
        width: 100%;
        padding: 12px;
        font-weight: 600;
        border-radius: 10px;
        transition: all 0.3s ease;
    }
    
    .btn-primary.btn-block:hover {
        background: var(--secondary-color);
        border-color: var(--secondary-color);
        transform: translateY(-2px);
    }
    
    .catalogue-content {
        display: flex;
        flex-direction: column;
        height: 100%;
    }
    
    .empty-state {
        padding: 60px 20px;
    }
    
    .empty-state i {
        opacity: 0.5;
    }

    .price-tag {
        color: var(--primary-color);
        font-weight: 700;
        font-size: 1.2rem;
    }

    /* About Section */
    .about-section {
        background: var(--accent-color);
    }

    .about-image {
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    }

    /* Contact Section */
    .contact-info {
        background: white;
        padding: 2rem;
        border-radius: 15px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        margin-bottom: 2rem;
    }

    .contact-info i {
        color: var(--primary-color);
        margin-right: 1rem;
        width: 20px;
    }

    .contact-form {
        background: white;
        padding: 2rem;
        border-radius: 15px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.1);
    }

    .form-control {
        border: 2px solid #eee;
        border-radius: 10px;
        padding: 12px 15px;
        transition: border-color 0.3s ease;
    }

    .form-control:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 0.2rem rgba(212, 175, 55, 0.25);
    }

    /* Social Media */
    .social-links a {
        display: inline-block;
        width: 45px;
        height: 45px;
        line-height: 45px;
        text-align: center;
        border-radius: 50%;
        background: var(--primary-color);
        color: white;
        margin-right: 10px;
        transition: all 0.3s ease;
        text-decoration: none;
    }

    .social-links a:hover {
        background: var(--secondary-color);
        transform: translateY(-3px);
    }

    /* Footer */
    .footer {
        background: var(--text-dark);
        color: white;
        padding: 2rem 0;
        text-align: center;
    }

    /* Responsive */
    @media (max-width: 992px) {
        .catalogue-card-wrapper {
            width: 280px;
        }
        
        .catalogue-features {
            justify-content: center;
        }
        
        .catalogue-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 10px;
        }
        
        .catalogue-rating {
            margin-left: 0;
        }
    }
    
    @media (max-width: 768px) {
         .hero-content h1 {
             font-size: 2.5rem;
         }
         
         .hero-content p {
             font-size: 1.1rem;
         }
         
         .section-title {
             font-size: 2rem;
         }
         
         .navbar-brand {
             font-size: 1.3rem;
         }
         
         /* Mobile - Static Display */
         .catalogue-marquee {
             animation: none;
             flex-wrap: wrap;
             justify-content: center;
         }
         
         .catalogue-marquee-container {
             margin: 0 15px;
         }
         
         .catalogue-card-wrapper {
             width: 100%;
             max-width: 350px;
             margin-bottom: 2rem;
         }
         
         .catalogue-image-wrapper {
             height: 220px;
         }
         
         .catalogue-content {
             padding: 20px;
         }
         
         .catalogue-title {
             font-size: 1.2rem;
         }
         
         .catalogue-features {
             gap: 10px;
         }
         
         .feature-item {
             font-size: 0.8rem;
         }
         
         .catalogue-price-badge {
             top: 15px;
             right: 15px;
             padding: 8px 12px;
         }
         
         .price-amount {
             font-size: 0.8rem;
         }
         
         .section-padding {
             padding: 60px 0;
         }
     }
    
    @media (max-width: 576px) {
        .catalogue-card-wrapper {
            width: 250px;
        }
        
        .catalogue-card {
            margin-bottom: 20px;
        }
        
        .catalogue-image-wrapper {
            height: 200px;
        }
        
        .catalogue-content {
            padding: 15px;
        }
        
        .catalogue-features {
            flex-direction: column;
            gap: 8px;
            align-items: flex-start;
        }
        
        .btn-block {
            padding: 10px;
            font-size: 0.9rem;
        }
    }

    /* Scroll to top button */
    .scroll-top {
        position: fixed;
        bottom: 30px;
        right: 30px;
        width: 50px;
        height: 50px;
        background: var(--primary-color);
        color: white;
        border: none;
        border-radius: 50%;
        display: none;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s ease;
        z-index: 1000;
    }

    .scroll-top:hover {
        background: var(--secondary-color);
        transform: translateY(-3px);
    }

    .scroll-top.show {
        display: flex;
    }
</style>