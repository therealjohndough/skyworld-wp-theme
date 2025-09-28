<?php
/**
 * Template Part: Hero Slider
 * Displays top 3 stories/products of the month in a rotating hero section
 */
?>

<section class="skyworld-hero-slider" id="heroSlider">
    <div class="hero-slider-container">
        <?php
        // Query for featured posts or products (top 3 stories of the month)
        $hero_query = new WP_Query(array(
            'post_type' => array('post', 'strain', 'sw_product'),
            'posts_per_page' => 3,
            'meta_query' => array(
                array(
                    'key' => 'featured_in_hero',
                    'value' => '1',
                    'compare' => '='
                )
            ),
            'orderby' => 'menu_order',
            'order' => 'ASC'
        ));
        
        if ($hero_query->have_posts()) :
            $slide_count = 0;
            while ($hero_query->have_posts()) : $hero_query->the_post();
                $slide_count++;
                $post_type = get_post_type();
                $hero_image = get_the_post_thumbnail_url(get_the_ID(), 'full');
                $hero_subtitle = get_field('hero_subtitle') ?: get_the_excerpt();
                $hero_button_text = get_field('hero_button_text') ?: 'Learn More';
                $hero_button_link = get_field('hero_button_link') ?: get_permalink();
                ?>
                
                <div class="hero-slide <?php echo $slide_count === 1 ? 'active' : ''; ?>" 
                     data-slide="<?php echo $slide_count; ?>"
                     style="background-image: url('<?php echo $hero_image; ?>')">
                    
                    <div class="hero-slide-overlay"></div>
                    
                    <div class="hero-slide-content">
                        <div class="hero-slide-content-inner">
                            <div class="hero-slide-badge">
                                <?php if ($post_type === 'strain'): ?>
                                    <i class="fas fa-seedling"></i>
                                    <span>Featured Strain</span>
                                <?php elseif ($post_type === 'sw_product'): ?>
                                    <i class="fas fa-star"></i>
                                    <span>Featured Product</span>
                                <?php else: ?>
                                    <i class="fas fa-fire"></i>
                                    <span>Story of the Month</span>
                                <?php endif; ?>
                            </div>
                            
                            <h1 class="hero-slide-title"><?php the_title(); ?></h1>
                            
                            <p class="hero-slide-subtitle"><?php echo $hero_subtitle; ?></p>
                            
                            <div class="hero-slide-actions">
                                <a href="<?php echo $hero_button_link; ?>" 
                                   class="hero-slide-button primary">
                                    <?php echo $hero_button_text; ?>
                                    <i class="fas fa-arrow-right"></i>
                                </a>
                                
                                <?php if ($post_type === 'strain' || $post_type === 'sw_product'): ?>
                                <a href="<?php echo home_url('/store-locator/'); ?>" 
                                   class="hero-slide-button secondary">
                                    <i class="fas fa-map-marker-alt"></i>
                                    Find In Stores
                                </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Slide Indicators -->
                    <?php if ($slide_count === 1): ?>
                    <div class="hero-slide-indicators">
                        <?php for ($i = 1; $i <= $hero_query->found_posts; $i++): ?>
                        <button class="hero-indicator <?php echo $i === 1 ? 'active' : ''; ?>" 
                                data-slide="<?php echo $i; ?>">
                            <span><?php echo $i; ?></span>
                        </button>
                        <?php endfor; ?>
                    </div>
                    <?php endif; ?>
                </div>
                
            <?php endwhile;
            wp_reset_postdata();
        else: ?>
            
            <!-- Fallback hero slide -->
            <div class="hero-slide active fallback-hero">
                <div class="hero-slide-overlay"></div>
                <div class="hero-slide-content">
                    <div class="hero-slide-content-inner">
                        <div class="hero-slide-badge">
                            <i class="fas fa-cannabis"></i>
                            <span>Welcome to Skyworld</span>
                        </div>
                        <h1 class="hero-slide-title">Premium Cannabis.<br>Proven Excellence.</h1>
                        <p class="hero-slide-subtitle">Discover our exclusive collection of premium flower, crafted with intention and respect for both plant and people.</p>
                        <div class="hero-slide-actions">
                            <a href="<?php echo home_url('/strain-library/'); ?>" class="hero-slide-button primary">
                                Explore Strains
                                <i class="fas fa-arrow-right"></i>
                            </a>
                            <a href="<?php echo home_url('/store-locator/'); ?>" class="hero-slide-button secondary">
                                <i class="fas fa-map-marker-alt"></i>
                                Find Stores
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            
        <?php endif; ?>
        
        <!-- Navigation arrows -->
        <button class="hero-nav-arrow hero-nav-prev" id="heroPrev">
            <i class="fas fa-chevron-left"></i>
        </button>
        <button class="hero-nav-arrow hero-nav-next" id="heroNext">
            <i class="fas fa-chevron-right"></i>
        </button>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const heroSlider = document.getElementById('heroSlider');
    const slides = heroSlider.querySelectorAll('.hero-slide');
    const indicators = heroSlider.querySelectorAll('.hero-indicator');
    const prevBtn = document.getElementById('heroPrev');
    const nextBtn = document.getElementById('heroNext');
    let currentSlide = 0;
    let slideInterval;
    
    function showSlide(index) {
        slides.forEach(slide => slide.classList.remove('active'));
        indicators.forEach(indicator => indicator.classList.remove('active'));
        
        if (slides[index]) {
            slides[index].classList.add('active');
            if (indicators[index]) {
                indicators[index].classList.add('active');
            }
        }
        currentSlide = index;
    }
    
    function nextSlide() {
        const nextIndex = (currentSlide + 1) % slides.length;
        showSlide(nextIndex);
    }
    
    function prevSlide() {
        const prevIndex = (currentSlide - 1 + slides.length) % slides.length;
        showSlide(prevIndex);
    }
    
    function startSlideshow() {
        if (slides.length > 1) {
            slideInterval = setInterval(nextSlide, 6000); // Change slide every 6 seconds
        }
    }
    
    function stopSlideshow() {
        clearInterval(slideInterval);
    }
    
    // Event listeners
    if (nextBtn) nextBtn.addEventListener('click', () => { stopSlideshow(); nextSlide(); startSlideshow(); });
    if (prevBtn) prevBtn.addEventListener('click', () => { stopSlideshow(); prevSlide(); startSlideshow(); });
    
    indicators.forEach((indicator, index) => {
        indicator.addEventListener('click', () => {
            stopSlideshow();
            showSlide(index);
            startSlideshow();
        });
    });
    
    // Pause on hover
    heroSlider.addEventListener('mouseenter', stopSlideshow);
    heroSlider.addEventListener('mouseleave', startSlideshow);
    
    // Start slideshow
    startSlideshow();
});
</script>