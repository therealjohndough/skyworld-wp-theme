<?php
/**
 * Template Part: Product Slider Block
 * Displays featured products in a horizontal slider
 */
?>

<section class="skyworld-product-slider" id="productSlider">
    <div class="product-slider-container">
        <div class="section-header">
            <div class="section-badge">
                <i class="fas fa-box-open"></i>
                <span>Featured Products</span>
            </div>
            <h2 class="section-title">Premium Cannabis Products</h2>
            <p class="section-subtitle">Explore our carefully curated selection of premium flower, concentrates, and accessories.</p>
        </div>
        
        <div class="product-slider-wrapper">
            <div class="product-slider-track" id="productSliderTrack">
                <?php
                // Query featured products
                $products_query = new WP_Query(array(
                    'post_type' => 'sw_product',
                    'posts_per_page' => 8,
                    'meta_query' => array(
                        array(
                            'key' => 'featured_product',
                            'value' => '1',
                            'compare' => '='
                        )
                    ),
                    'orderby' => 'menu_order',
                    'order' => 'ASC'
                ));
                
                if ($products_query->have_posts()) :
                    while ($products_query->have_posts()) : $products_query->the_post();
                        $product_type = get_field('product_type') ?: 'flower';
                        $product_price = get_field('product_price');
                        $product_weight = get_field('product_weight');
                        $thc_content = get_field('thc_content');
                        $cbd_content = get_field('cbd_content');
                        $strain_genetics = get_field('strain_genetics');
                        $product_image = get_the_post_thumbnail_url(get_the_ID(), 'medium');
                        $availability = get_field('product_availability') ?: 'In Stock';
                        ?>
                        
                        <div class="product-slide">
                            <div class="product-card">
                                <div class="product-card-image">
                                    <?php if ($product_image): ?>
                                        <img src="<?php echo $product_image; ?>" 
                                             alt="<?php the_title(); ?> Product Packaging"
                                             loading="lazy">
                                    <?php else: ?>
                                        <div class="product-card-placeholder">
                                            <i class="fas fa-cannabis"></i>
                                            <span><i class="ph ph-package"></i></span>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <div class="product-card-overlay">
                                        <div class="product-type-badge <?php echo $product_type; ?>">
                                            <?php echo ucfirst(str_replace('_', ' ', $product_type)); ?>
                                        </div>
                                        
                                        <div class="product-image-type-overlay">
                                            <i class="fas fa-box"></i>
                                            <span>Product Packaging</span>
                                        </div>
                                        
                                        <div class="product-quick-actions">
                                            <button class="quick-action-btn" title="Quick View">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button class="quick-action-btn" title="Find Stores">
                                                <i class="fas fa-map-marker-alt"></i>
                                            </button>
                                        </div>
                                    </div>
                                    
                                    <div class="availability-badge <?php echo strtolower(str_replace(' ', '-', $availability)); ?>">
                                        <?php echo $availability; ?>
                                    </div>
                                </div>
                                
                                <div class="product-card-content">
                                    <h3 class="product-card-title">
                                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                    </h3>
                                    
                                    <?php if ($strain_genetics): ?>
                                    <div class="product-genetics">
                                        <i class="fas fa-dna"></i>
                                        <span><?php echo $strain_genetics; ?></span>
                                    </div>
                                    <?php endif; ?>
                                    
                                    <div class="product-card-details">
                                        <?php if ($product_weight): ?>
                                        <div class="product-detail">
                                            <span class="detail-label">Weight:</span>
                                            <span class="detail-value"><?php echo $product_weight; ?></span>
                                        </div>
                                        <?php endif; ?>
                                        
                                        <div class="product-potency">
                                            <?php if ($thc_content): ?>
                                            <div class="potency-stat">
                                                <span class="stat-label">THC</span>
                                                <span class="stat-value"><?php echo $thc_content; ?>%</span>
                                            </div>
                                            <?php endif; ?>
                                            
                                            <?php if ($cbd_content): ?>
                                            <div class="potency-stat">
                                                <span class="stat-label">CBD</span>
                                                <span class="stat-value"><?php echo $cbd_content; ?>%</span>
                                            </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    
                                    <?php if ($product_price): ?>
                                    <div class="product-card-price">
                                        <span class="price-label">Price:</span>
                                        <span class="price-value">$<?php echo $product_price; ?></span>
                                    </div>
                                    <?php endif; ?>
                                    
                                    <div class="product-card-actions">
                                        <a href="<?php the_permalink(); ?>" class="product-card-button primary">
                                            <i class="fas fa-info-circle"></i>
                                            Learn More
                                        </a>
                                        <a href="<?php echo home_url('/store-locator/'); ?>?product=<?php echo get_the_ID(); ?>" 
                                           class="product-card-button secondary">
                                            <i class="fas fa-shopping-bag"></i>
                                            Find Stores
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    <?php endwhile;
                    wp_reset_postdata();
                else: ?>
                    
                    <!-- Fallback products -->
                    <?php for ($i = 1; $i <= 4; $i++): ?>
                    <div class="product-slide">
                        <div class="product-card placeholder">
                            <div class="product-card-image">
                                <div class="product-card-placeholder">
                                    <i class="fas fa-cannabis"></i>
                                    <span><i class="ph ph-package"></i></span>
                                </div>
                                <div class="product-card-overlay">
                                    <div class="product-type-badge flower">Premium Flower</div>
                                </div>
                            </div>
                            <div class="product-card-content">
                                <h3 class="product-card-title">Coming Soon</h3>
                                <p>Premium product launching soon</p>
                                <div class="product-card-actions">
                                    <button class="product-card-button primary disabled">
                                        <i class="fas fa-clock"></i>
                                        Coming Soon
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endfor; ?>
                    
                <?php endif; ?>
            </div>
            
            <button class="slider-nav-arrow slider-nav-prev" id="productSliderPrev">
                <i class="fas fa-chevron-left"></i>
            </button>
            <button class="slider-nav-arrow slider-nav-next" id="productSliderNext">
                <i class="fas fa-chevron-right"></i>
            </button>
        </div>
        
        <div class="product-slider-dots" id="productSliderDots">
            <!-- Dots will be generated by JavaScript -->
        </div>
        
        <div class="product-slider-footer">
            <a href="<?php echo home_url('/products/'); ?>" class="view-all-button">
                <span>View All Products</span>
                <i class="fas fa-arrow-right"></i>
            </a>
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const sliderTrack = document.getElementById('productSliderTrack');
    const slides = sliderTrack.querySelectorAll('.product-slide');
    const prevBtn = document.getElementById('productSliderPrev');
    const nextBtn = document.getElementById('productSliderNext');
    const dotsContainer = document.getElementById('productSliderDots');
    
    let currentSlide = 0;
    const slidesToShow = window.innerWidth <= 768 ? 1 : window.innerWidth <= 1024 ? 2 : 3;
    const totalSlides = slides.length;
    const maxSlide = Math.ceil(totalSlides / slidesToShow) - 1;
    
    // Generate dots
    for (let i = 0; i <= maxSlide; i++) {
        const dot = document.createElement('button');
        dot.classList.add('slider-dot');
        if (i === 0) dot.classList.add('active');
        dot.dataset.slide = i;
        dotsContainer.appendChild(dot);
    }
    
    const dots = dotsContainer.querySelectorAll('.slider-dot');
    
    function updateSlider() {
        const translateX = -(currentSlide * (100 / slidesToShow));
        sliderTrack.style.transform = `translateX(${translateX}%)`;
        
        // Update dots
        dots.forEach(dot => dot.classList.remove('active'));
        if (dots[currentSlide]) {
            dots[currentSlide].classList.add('active');
        }
        
        // Update nav buttons
        prevBtn.disabled = currentSlide === 0;
        nextBtn.disabled = currentSlide === maxSlide;
    }
    
    function nextSlide() {
        if (currentSlide < maxSlide) {
            currentSlide++;
            updateSlider();
        }
    }
    
    function prevSlide() {
        if (currentSlide > 0) {
            currentSlide--;
            updateSlider();
        }
    }
    
    // Event listeners
    nextBtn.addEventListener('click', nextSlide);
    prevBtn.addEventListener('click', prevSlide);
    
    dots.forEach(dot => {
        dot.addEventListener('click', () => {
            currentSlide = parseInt(dot.dataset.slide);
            updateSlider();
        });
    });
    
    // Auto-slide
    let autoSlideInterval = setInterval(nextSlide, 5000);
    
    // Pause on hover
    sliderTrack.addEventListener('mouseenter', () => clearInterval(autoSlideInterval));
    sliderTrack.addEventListener('mouseleave', () => {
        autoSlideInterval = setInterval(nextSlide, 5000);
    });
    
    // Initial update
    updateSlider();
    
    // Responsive handling
    window.addEventListener('resize', () => {
        location.reload(); // Simple solution for responsive changes
    });
});
</script>