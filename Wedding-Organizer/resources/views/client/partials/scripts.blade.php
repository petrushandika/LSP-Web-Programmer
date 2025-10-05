<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Smooth scrolling for navigation links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    const offsetTop = target.offsetTop - 80; // Account for fixed navbar
                    window.scrollTo({
                        top: offsetTop,
                        behavior: 'smooth'
                    });
                }
            });
        });

        // Navbar scroll effect
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('.navbar');
            const scrollTop = document.getElementById('scrollTop');
            
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
            
            // Show/hide scroll to top button
            if (window.scrollY > 300) {
                scrollTop.classList.add('show');
            } else {
                scrollTop.classList.remove('show');
            }
        });

        // Scroll to top functionality
        const scrollTopBtn = document.getElementById('scrollTop');
        if (scrollTopBtn) {
            scrollTopBtn.addEventListener('click', function() {
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            });
        }

        // Contact form submission
        const contactForm = document.getElementById('contactForm');
        if (contactForm) {
            contactForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Get form data
            const name = document.getElementById('name').value;
            const email = document.getElementById('email').value;
            const phone = document.getElementById('phone').value;
            const message = document.getElementById('message').value;
            
            // Create WhatsApp message
            const whatsappMessage = `Halo, saya ${name}%0A%0AEmail: ${email}%0ATelepon: ${phone}%0A%0APesan: ${message}`;
            const whatsappNumber = '{{ str_replace(["+", "-", " "], "", $settings->phone_number ?? "+6281234567890") }}';
            const whatsappUrl = `https://wa.me/${whatsappNumber}?text=${whatsappMessage}`;
            
            // Open WhatsApp
            window.open(whatsappUrl, '_blank');
            
            // Reset form
            this.reset();
            
            // Show success message
            alert('Terima kasih! Anda akan diarahkan ke WhatsApp untuk mengirim pesan.');
            });
        }

        // Add animation on scroll
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver(function(entries) {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, observerOptions);

        // Observe elements for animation
        document.querySelectorAll('.catalogue-card, .contact-info, .contact-form').forEach(el => {
            el.style.opacity = '0';
            el.style.transform = 'translateY(30px)';
            el.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
            observer.observe(el);
        });
    });

    // Authentication check functions
    function checkAuthentication() {
        // Check if user is logged in (you'll need to implement this based on your auth system)
        return {{ auth()->check() ? 'true' : 'false' }};
    }
    
    function redirectToLogin() {
        window.location.href = '{{ url("/login") }}';
    }
    
    // Add to Cart functionality
    function addToCart(catalogueId) {
        if (!checkAuthentication()) {
            alert('Please login to add items to cart');
            redirectToLogin();
            return;
        }
        
        // Add to cart logic here
        alert('Item added to cart! (Feature to be implemented)');
    }
    
    // Buy Now functionality
     function buyNow(catalogueId) {
         if (!checkAuthentication()) {
             alert('Please login to purchase');
             redirectToLogin();
             return;
         }
         
         // Buy now logic here
         alert('Redirecting to checkout... (Feature to be implemented)');
     }
</script>

<!-- Scroll to Top Button -->
<button class="scroll-top" id="scrollTop">
    <i class="fas fa-arrow-up"></i>
</button>