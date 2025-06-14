$(document).ready(function() {
    // Hero Slider
    let currentSlide = 0;
    const slides = $('.slide');
    const totalSlides = slides.length;

    function showSlide(index) {
        slides.removeClass('active');
        slides.eq(index).addClass('active');
    }

    function nextSlide() {
        currentSlide = (currentSlide + 1) % totalSlides;
        showSlide(currentSlide);
    }

    // Auto slide every 5 seconds
    setInterval(nextSlide, 5000);

    // Smooth scroll for navigation links
    $('nav a').on('click', function(e) {
        if (this.hash !== '') {
            e.preventDefault();
            const hash = this.hash;
            $('html, body').animate({
                scrollTop: $(hash).offset().top - 80
            }, 800);
        }
    });

    // Animate elements on scroll
    $(window).scroll(function() {
        $('.category-card, .product-card').each(function() {
            const elementTop = $(this).offset().top;
            const elementBottom = elementTop + $(this).outerHeight();
            const viewportTop = $(window).scrollTop();
            const viewportBottom = viewportTop + $(window).height();

            if (elementBottom > viewportTop && elementTop < viewportBottom) {
                $(this).addClass('animate__animated animate__fadeInUp');
            }
        });
    });

    // Newsletter form submission
    // $('form').on('submit', function(e) {
    //     e.preventDefault();
    //     const email = $(this).find('input[type="email"]').val();
        
    //     // Add your newsletter subscription logic here
    //     alert('Thank you for subscribing to our newsletter!');
    //     $(this).find('input[type="email"]').val('');
    // });

    // Add to cart animation
    $('.product-card button').on('click', function() {
        const button = $(this);
        button.html('<i class="fas fa-spinner fa-spin"></i> Adding...');
        
        setTimeout(function() {
            button.html('<i class="fas fa-check"></i> Added!');
            setTimeout(function() {
                button.html('Add to Cart');
            }, 2000);
        }, 1000);
    });

    // Mobile menu toggle (you can add this if you implement a mobile menu)
    $('.mobile-menu-toggle').on('click', function() {
        $('.mobile-menu').toggleClass('active');
    });
}); 