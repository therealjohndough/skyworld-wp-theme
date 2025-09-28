<?php
/**
 * Front Page Template for Skyworld WP Child
 * Template Name: Skyworld Catalog Front Page
 */

get_header();
?>

<!-- Age Gate Modal -->
<div id="age-gate-modal" class="age-gate-modal">
    <div class="age-gate-content">
        <div class="age-gate-logo">
            <i class="fas fa-cannabis"></i>
            <h2>Welcome to Skyworld</h2>
        </div>
        <p class="age-gate-message">You must be 21 or older to view this content</p>
        <div class="age-gate-buttons">
            <button id="age-gate-yes" class="age-gate-btn age-gate-yes">I am 21 or older</button>
            <button id="age-gate-no" class="age-gate-btn age-gate-no">I am under 21</button>
        </div>
        <p class="age-gate-disclaimer">
            <i class="fas fa-exclamation-circle"></i>
            This product has not been analyzed or approved by the FDA. 
            Keep out of reach of children and pets.
        </p>
    </div>
</div>

<!-- Main Content Container -->
<main class="skyworld-modern-layout">
    
    <!-- Modern Hero Section with Asymmetrical Design -->
    <section class="section-hero">
            
            <!-- Debug Info -->
            <?php if (current_user_can('administrator')): 
                $debug_query = new WP_Query(array(
                    'post_type' => 'sw-product',
                    'posts_per_page' => 1
                ));
            ?>
            <div class="debug-info">
                <strong>Debug Info:</strong><br>
                SW-Product posts found: <?php echo $debug_query->found_posts; ?><br>
                Post types registered: <?php echo implode(', ', get_post_types()); ?><br>
                Helper functions: <?php echo function_exists('skyworld_get_product_image') ? 'Images ✓' : 'Images ✗'; ?> | 
                <?php echo function_exists('skyworld_get_product_marketing') ? 'Marketing ✓' : 'Marketing ✗'; ?>
            </div>
            <?php wp_reset_postdata(); endif; ?>
            
            <div class="hero-grid">
            <!-- Main Title Block -->
            <div class="hero-title-block">
                <div class="title-pill animate-slide-up">
                    <span class="label">Premium Cannabis</span>
                </div>
                <h1 class="hero-main-title animate-fade-in-up">
                    <span class="title-line">Skyworld</span>
                    <span class="title-accent">Indoor Excellence</span>
                </h1>
                <p class="hero-description animate-fade-in-up delay-1">
                    Born from a passion for the plant. We believe New Yorkers deserve 
                    access to consistent, high-quality cannabis grown with expertise and transparency.
                </p>
                
                <!-- Action Pills -->
                <div class="action-pills animate-fade-in-up delay-2">
                    <a href="#products" class="pill-button primary">
                        <span>Explore Products</span>
                        <i class="ph ph-arrow-right"></i>
                    </a>
                    <a href="/strain-library/" class="pill-button secondary">
                        <span>View Strains</span>
                        <i class="ph ph-plant"></i>
                    </a>
                </div>
            </div>
            
            <!-- Floating Info Cards -->
            <div class="hero-info-cards">
                <div class="info-card lab-tested animate-float-1">
                    <div class="card-icon">
                        <i class="ph ph-test-tube"></i>
                    </div>
                    <div class="card-content">
                        <span class="card-label">Lab Tested</span>
                        <span class="card-value">100% Purity</span>
                    </div>
                </div>
                
                <div class="info-card indoor-grown animate-float-2">
                    <div class="card-icon">
                        <i class="ph ph-house"></i>
                    </div>
                    <div class="card-content">
                        <span class="card-label">Indoor Grown</span>
                        <span class="card-value">Climate Controlled</span>
                    </div>
                </div>
                
                <div class="info-card ny-grown animate-float-3">
                    <div class="card-icon">
                        <i class="ph ph-map-pin"></i>
                    </div>
                    <div class="card-content">
                        <span class="card-label">New York</span>
                        <span class="card-value">Locally Grown</span>
                    </div>
                </div>
            </div>
            
            <!-- Background Decorative Elements -->
            <div class="hero-background-shapes">
                <div class="shape shape-1 animate-rotate-slow"></div>
                <div class="shape shape-2 animate-pulse-slow"></div>
                <div class="shape shape-3 animate-float-vertical"></div>
            </div>
        </div>
    </section>

    <!-- Stats Section with Asymmetrical Layout -->
    <section class="stats-section">
        <div class="stats-grid">
            <div class="stat-block large animate-scale-up">
                <div class="stat-number">15+</div>
                <div class="stat-label">Premium Strains</div>
                <div class="stat-description">Carefully selected genetics</div>
            </div>
            
            <div class="stat-block medium animate-scale-up delay-1">
                <div class="stat-number">100%</div>
                <div class="stat-label">Lab Tested</div>
            </div>
            
            <div class="stat-block small animate-scale-up delay-2">
                <div class="stat-icon">
                    <i class="ph ph-certificate"></i>
                </div>
                <div class="stat-label">Licensed</div>
            </div>
            
            <div class="stat-block wide animate-scale-up delay-3">
                <div class="stat-content">
                    <span class="highlight-text">Rooted in the Empire State</span>
                    <p>Proud to be a New York cannabis brand, committed to serving our local communities with the highest quality products.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Modern Product Showcase -->
    <section class="modern-product-showcase" id="products">
        <div class="section-header">
            <div class="section-pill animate-slide-in">
                <i class="ph ph-package"></i>
                <span>Featured Products</span>
            </div>
            <h2 class="section-title animate-fade-in-up">
                Premium Cannabis Products
            </h2>
        </div>
        
        <div class="product-masonry-grid">
            <?php
            // Query featured products
            $products_query = new WP_Query(array(
                'post_type' => 'sw-product',
                'posts_per_page' => 6,
                'orderby' => 'menu_order',
                'order' => 'ASC'
            ));
            
            $card_layouts = ['large', 'medium', 'small', 'wide', 'tall', 'medium'];
            $animation_delays = [0, 1, 2, 3, 4, 5];
            $counter = 0;
            
            if ($products_query->have_posts()) :
                while ($products_query->have_posts()) : $products_query->the_post();
                    $product_id = get_the_ID();
                    $marketing = function_exists('skyworld_get_product_marketing') ? skyworld_get_product_marketing($product_id) : array();
                    $product_image_data = function_exists('skyworld_get_product_image') ? skyworld_get_product_image($product_id, 'medium') : null;
                    $related_strain = get_field('related_strain');
                    $thc_content = get_field('thc_percentage') ?: get_field('thc_percent');
                    $product_type = get_field('product_type') ?: 'flower';
                    $product_weight = get_field('weight');
                    
                    $layout = $card_layouts[$counter % count($card_layouts)];
                    $delay = $animation_delays[$counter % count($animation_delays)];
                    ?>
                    
                    <article class="product-card-modern <?php echo esc_attr($layout); ?> animate-scale-up delay-<?php echo $delay; ?>">
                        <?php if ($product_image_data && isset($product_image_data['url'])): ?>
                        <div class="card-image">
                            <img src="<?php echo esc_url($product_image_data['url']); ?>" 
                                 alt="<?php echo esc_attr($product_image_data['alt']); ?>" 
                                 loading="lazy">
                            <div class="image-overlay">
                                <div class="product-type-pill">
                                    <i class="ph ph-package"></i>
                                    <span><?php echo esc_html(ucfirst($product_type)); ?></span>
                                </div>
                            </div>
                        </div>
                        <?php else: ?>
                        <div class="card-image">
                            <div class="card-image-placeholder">
                                <i class="ph ph-cannabis"></i>
                            </div>
                            <div class="image-overlay">
                                <div class="product-type-pill">
                                    <i class="ph ph-package"></i>
                                    <span><?php echo esc_html(ucfirst($product_type)); ?></span>
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>
                        
                        <div class="card-content">
                            <div class="card-header">
                                <?php if (isset($marketing['tagline']) && $marketing['tagline']): ?>
                                <div class="tagline-pill">
                                    <?php echo esc_html($marketing['tagline']); ?>
                                </div>
                                <?php endif; ?>
                                
                                <h3 class="card-title">
                                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                </h3>
                                
                                <?php if ($related_strain): ?>
                                <div class="strain-reference">
                                    <i class="ph ph-plant"></i>
                                    <span><?php echo esc_html(get_the_title($related_strain->ID)); ?></span>
                                </div>
                                <?php endif; ?>
                            </div>
                            
                            <?php if ($marketing['flavor_profile']): ?>
                            <div class="flavor-pill">
                                <i class="ph ph-coffee"></i>
                                <span><?php echo esc_html($marketing['flavor_profile']); ?></span>
                            </div>
                            <?php endif; ?>
                            
                            <div class="card-stats">
                                <?php if ($thc_content): ?>
                                <div class="stat-pill thc">
                                    <span class="stat-label">THC</span>
                                    <span class="stat-value"><?php echo esc_html($thc_content); ?>%</span>
                                </div>
                                <?php endif; ?>
                                
                                <?php if ($product_weight): ?>
                                <div class="stat-pill weight">
                                    <span class="stat-label">Weight</span>
                                    <span class="stat-value"><?php echo esc_html($product_weight); ?></span>
                                </div>
                                <?php endif; ?>
                            </div>
                            
                            <div class="card-actions">
                                <a href="<?php the_permalink(); ?>" class="action-pill primary">
                                    <span>Learn More</span>
                                    <i class="ph ph-arrow-right"></i>
                                </a>
                                <button class="action-pill secondary quick-view" data-product="<?php echo $product_id; ?>">
                                    <i class="ph ph-eye"></i>
                                </button>
                            </div>
                        </div>
                        
                        <!-- Decorative Elements -->
                        <div class="card-decoration">
                            <div class="decoration-dot"></div>
                            <div class="decoration-line"></div>
                        </div>
                    </article>
                    
                    <?php
                    $counter++;
                endwhile;
            else :
                // Show sample product cards if no products exist yet
                $sample_products = array(
                    array(
                        'title' => 'Northern Lights',
                        'tagline' => 'Premium Indica',
                        'description' => 'Classic strain known for relaxation and sweet aroma',
                        'thc' => '18%',
                        'type' => 'flower',
                        'weight' => '3.5g',
                        'price' => '$45',
                        'strain' => 'Northern Lights'
                    ),
                    array(
                        'title' => 'Blue Dream',
                        'tagline' => 'Balanced Hybrid',
                        'description' => 'Perfect balance of cerebral stimulation and full-body relaxation',
                        'thc' => '20%',
                        'type' => 'flower',
                        'weight' => '3.5g',
                        'price' => '$50',
                        'strain' => 'Blue Dream'
                    ),
                    array(
                        'title' => 'Green Crack',
                        'tagline' => 'Energizing Sativa',
                        'description' => 'Invigorating mental buzz that keeps you going',
                        'thc' => '22%',
                        'type' => 'flower',
                        'weight' => '3.5g',
                        'price' => '$55',
                        'strain' => 'Green Crack'
                    ),
                    array(
                        'title' => 'Sunset Sherbet',
                        'tagline' => 'Sweet & Potent',
                        'description' => 'Fruity aroma with euphoric and physically relaxing effects',
                        'thc' => '19%',
                        'type' => 'flower',
                        'weight' => '7g',
                        'price' => '$90',
                        'strain' => 'Sunset Sherbet'
                    ),
                    array(
                        'title' => 'Gorilla Glue #4',
                        'tagline' => 'Ultra Premium',
                        'description' => 'Heavy-handed euphoria and relaxation',
                        'thc' => '25%',
                        'type' => 'flower',
                        'weight' => '3.5g',
                        'price' => '$60',
                        'strain' => 'Gorilla Glue #4'
                    ),
                    array(
                        'title' => 'Wedding Cake',
                        'tagline' => 'Dessert Strain',
                        'description' => 'Rich tangy flavor with relaxing and euphoric effects',
                        'thc' => '23%',
                        'type' => 'flower',
                        'weight' => '3.5g',
                        'price' => '$52',
                        'strain' => 'Wedding Cake'
                    )
                );
                
                foreach ($sample_products as $index => $product) :
                    $layout = $card_layouts[$index % count($card_layouts)];
                    $delay = $animation_delays[$index % count($animation_delays)];
                    ?>
                    
                    <article class="product-card-modern <?php echo esc_attr($layout); ?> animate-scale-up delay-<?php echo $delay; ?>">
                        <div class="card-image">
                            <div class="card-image-placeholder">
                                <i class="ph ph-cannabis"></i>
                            </div>
                            <div class="image-overlay">
                                <div class="product-type-pill">
                                    <i class="ph ph-package"></i>
                                    <span><?php echo esc_html(ucfirst($product['type'])); ?></span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="card-content">
                            <div class="card-header">
                                <div class="tagline-pill">
                                    <?php echo esc_html($product['tagline']); ?>
                                </div>
                                
                                <h3 class="card-title">
                                    <?php echo esc_html($product['title']); ?>
                                </h3>
                                
                                <?php if ($product['strain']): ?>
                                <div class="strain-info">
                                    <i class="ph ph-dna"></i>
                                    <span><?php echo esc_html($product['strain']); ?></span>
                                </div>
                                <?php endif; ?>
                            </div>
                            
                            <?php if ($product['description']): ?>
                            <p class="card-description">
                                <?php echo esc_html($product['description']); ?>
                            </p>
                            <?php endif; ?>
                            
                            <div class="card-stats">
                                <?php if ($product['thc']): ?>
                                <div class="stat-pill thc">
                                    <i class="ph ph-leaf"></i>
                                    <span>THC <?php echo esc_html($product['thc']); ?></span>
                                </div>
                                <?php endif; ?>
                                
                                <?php if ($product['weight']): ?>
                                <div class="stat-pill weight">
                                    <i class="ph ph-scales"></i>
                                    <span><?php echo esc_html($product['weight']); ?></span>
                                </div>
                                <?php endif; ?>
                            </div>
                            
                            <div class="card-footer">
                                <div class="price">
                                    <span class="price-label">Price</span>
                                    <span class="price-value"><?php echo esc_html($product['price']); ?></span>
                                </div>
                                <button class="btn-pill primary">
                                    <span>View Details</span>
                                    <i class="ph ph-arrow-right"></i>
                                </button>
                            </div>
                        </div>
                    </article>
                    
                    <?php
                endforeach;
                wp_reset_postdata();
            endif;
            ?>
            
            <!-- Call-to-Action Card -->
            <div class="cta-card-modern animate-scale-up delay-6">
                <div class="cta-content">
                    <div class="cta-icon">
                        <i class="ph ph-storefront"></i>
                    </div>
                    <h3>Find Skyworld Products</h3>
                    <p>Locate authorized dispensaries carrying our premium cannabis products</p>
                    <a href="/store-locator/" class="pill-button primary">
                        <span>Find Stores</span>
                        <i class="ph ph-map-pin"></i>
                    </a>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Call-to-Action Section -->
    <section class="skyworld-cta-section">
        <div class="cta-container">
            <div class="cta-content">
                <h2 class="cta-title">Ready to Experience Skyworld?</h2>
                <p class="cta-subtitle">Find our premium cannabis products at authorized dispensaries near you.</p>
                <div class="cta-actions">
                    <a href="<?php echo home_url('/store-locator/'); ?>" class="cta-button primary">
                        <i class="fas fa-map-marker-alt"></i>
                        Find Stores Near You
                    </a>
                    <a href="<?php echo home_url('/wholesale/'); ?>" class="cta-button secondary">
                        <i class="fas fa-handshake"></i>
                        Wholesale Partnership
                    </a>
                </div>
            </div>
        </div>
    </section>
    
</main>

<style>
/* Age Gate Styles */
.age-gate-modal {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.9);
    z-index: 10000;
    display: flex;
    align-items: center;
    justify-content: center;
    backdrop-filter: blur(10px);
}

.age-gate-modal.hidden {
    display: none;
}

.age-gate-content {
    background: var(--color-card-bg);
    padding: 3rem;
    border-radius: var(--border-radius);
    text-align: center;
    max-width: 500px;
    width: 90%;
    box-shadow: var(--shadow-lg);
}

.age-gate-logo {
    margin-bottom: 2rem;
}

.age-gate-logo i {
    font-size: 3rem;
    color: var(--color-sativa);
    margin-bottom: 1rem;
}

.age-gate-logo h2 {
    font-size: 2rem;
    font-weight: 700;
    color: var(--color-text);
    font-family: 'Playfair Display', serif;
}

.age-gate-message {
    font-size: 1.2rem;
    margin-bottom: 2rem;
    color: var(--color-text);
    font-weight: 500;
}

.age-gate-buttons {
    display: flex;
    gap: 1rem;
    justify-content: center;
    margin-bottom: 2rem;
    flex-wrap: wrap;
}

.age-gate-btn {
    padding: 1rem 2rem;
    border: none;
    border-radius: var(--border-radius);
    font-weight: 600;
    cursor: pointer;
    transition: var(--transition);
    font-size: 1.1rem;
}

.age-gate-yes {
    background: var(--color-sativa);
    color: white;
}

.age-gate-yes:hover {
    background: #1e7e34;
    transform: translateY(-2px);
}

.age-gate-no {
    background: var(--color-indica);
    color: white;
}

.age-gate-no:hover {
    background: #bd2130;
    transform: translateY(-2px);
}

.age-gate-disclaimer {
    font-size: 0.9rem;
    color: var(--color-text-muted);
    display: flex;
    align-items: flex-start;
    gap: 0.5rem;
    text-align: left;
}

/* CTA Section Styles */
.skyworld-cta-section {
    background: linear-gradient(135deg, var(--color-sativa), var(--color-orange-brand));
    color: white;
    padding: 4rem 0;
    text-align: center;
}

.cta-container {
    max-width: 1400px;
    margin: 0 auto;
    padding: 0 2rem;
}

.cta-title {
    font-size: 3rem;
    font-weight: 700;
    margin-bottom: 1rem;
    font-family: 'Playfair Display', serif;
}

.cta-subtitle {
    font-size: 1.3rem;
    margin-bottom: 2.5rem;
    opacity: 0.9;
    max-width: 600px;
    margin-left: auto;
    margin-right: auto;
}

.cta-actions {
    display: flex;
    gap: 1.5rem;
    justify-content: center;
    flex-wrap: wrap;
}

.cta-button {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 1.2rem 2.5rem;
    border-radius: var(--border-radius);
    text-decoration: none;
    font-weight: 600;
    transition: var(--transition);
    font-size: 1.1rem;
    box-shadow: var(--shadow-md);
}

.cta-button.primary {
    background: white;
    color: var(--color-sativa);
}

.cta-button.primary:hover {
    background: #f8f9fa;
    transform: translateY(-3px);
    box-shadow: var(--shadow-lg);
}

.cta-button.secondary {
    background: rgba(255, 255, 255, 0.2);
    color: white;
    border: 2px solid rgba(255, 255, 255, 0.3);
    backdrop-filter: blur(10px);
}

.cta-button.secondary:hover {
    background: rgba(255, 255, 255, 0.3);
    border-color: rgba(255, 255, 255, 0.5);
    transform: translateY(-3px);
}

/* Mobile responsive */
@media (max-width: 768px) {
    .cta-title {
        font-size: 2.2rem;
    }
    
    .cta-subtitle {
        font-size: 1.1rem;
    }
    
    .cta-actions {
        flex-direction: column;
        align-items: center;
    }
    
    .cta-button {
        width: 100%;
        max-width: 300px;
        justify-content: center;
    }
}
</style>

<script>
// Age Gate Functionality
document.addEventListener('DOMContentLoaded', function() {
    const ageGateModal = document.getElementById('age-gate-modal');
    const yesButton = document.getElementById('age-gate-yes');
    const noButton = document.getElementById('age-gate-no');
    
    // Error handling - make sure elements exist
    if (!ageGateModal || !yesButton || !noButton) {
        console.warn('Age gate elements not found');
        return;
    }
    
    // Check if user has already verified age
    const ageVerified = localStorage.getItem('skyworld-age-verified');
    const verificationDate = localStorage.getItem('skyworld-age-verification-date');
    const currentDate = new Date().toDateString();
    
    // Show age gate if not verified or verification is from a different day
    if (!ageVerified || verificationDate !== currentDate) {
        ageGateModal.style.display = 'flex';
        document.body.style.overflow = 'hidden';
    } else {
        ageGateModal.style.display = 'none';
    }
    
    // Handle age verification
    yesButton.addEventListener('click', function() {
        try {
            localStorage.setItem('skyworld-age-verified', 'true');
            localStorage.setItem('skyworld-age-verification-date', currentDate);
            ageGateModal.style.display = 'none';
            document.body.style.overflow = '';
        } catch (e) {
            console.warn('localStorage not available, using session verification');
            // Fallback - just hide for this session
            ageGateModal.style.display = 'none';
            document.body.style.overflow = '';
        }
    });
    
    noButton.addEventListener('click', function() {
        // Redirect to Google as requested
        window.location.href = 'https://www.google.com';
    });
});
</script>

<?php get_footer();
