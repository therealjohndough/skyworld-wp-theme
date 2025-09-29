<?php
/**
 * Front Page Template - Skyworld Cannabis
 * Clean, professional cannabis business homepage
 */

get_header();
?>

<div class="front-page-container">
    
    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <div class="hero-content">
                <div class="hero-text">
                    <h1 class="hero-title">Premium Cannabis Products</h1>
                    <p class="hero-subtitle">Quality strains and products from New York's trusted cannabis cultivator</p>
                    <div class="hero-buttons">
                        <a href="#products" class="btn-primary">Shop Products</a>
                        <a href="/strain-library/" class="btn-secondary">View Strains</a>
                    </div>
                </div>
                <div class="hero-image">
                    <div class="hero-placeholder">
                        <i class="ph ph-plant"></i>
                        <span>Premium Cannabis</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features-section">
        <div class="container">
            <div class="features-grid">
                <div class="feature-item">
                    <div class="feature-icon">
                        <i class="ph ph-test-tube"></i>
                    </div>
                    <h3>Lab Tested</h3>
                    <p>All products tested for purity and potency</p>
                </div>
                <div class="feature-item">
                    <div class="feature-icon">
                        <i class="ph ph-house"></i>
                    </div>
                    <h3>Indoor Grown</h3>
                    <p>Climate-controlled cultivation for consistency</p>
                </div>
                <div class="feature-item">
                    <div class="feature-icon">
                        <i class="ph ph-map-pin"></i>
                    </div>
                    <h3>New York Grown</h3>
                    <p>Locally cultivated in New York State</p>
                </div>
                <div class="feature-item">
                    <div class="feature-icon">
                        <i class="ph ph-certificate"></i>
                    </div>
                    <h3>Licensed</h3>
                    <p>Fully licensed and compliant operations</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Products Section -->
    <section class="products-section" id="products">
        <div class="container">
            <div class="section-header">
                <h2>Featured Products</h2>
                <p>Discover our premium selection of cannabis products</p>
            </div>
            
            <div class="products-grid">
                <?php
                $products_query = new WP_Query(array(
                    'post_type' => 'sw-product',
                    'posts_per_page' => 6,
                    'meta_key' => 'featured',
                    'meta_value' => '1',
                    'orderby' => 'menu_order',
                    'order' => 'ASC'
                ));
                
                if ($products_query->have_posts()) :
                    while ($products_query->have_posts()) : $products_query->the_post();
                        $product_id = get_the_ID();
                        $thc_content = get_field('thc_percentage') ?: get_field('thc_percent');
                        $product_type = get_field('product_type') ?: 'flower';
                        $product_weight = get_field('weight');
                        ?>
                        
                        <div class="product-card">
                            <div class="product-image">
                                <?php if (has_post_thumbnail()) : ?>
                                    <?php the_post_thumbnail('medium', array('alt' => get_the_title())); ?>
                                <?php else : ?>
                                    <div class="product-placeholder">
                                        <i class="ph ph-package"></i>
                                    </div>
                                <?php endif; ?>
                            </div>
                            
                            <div class="product-info">
                                <h3 class="product-name"><?php the_title(); ?></h3>
                                <p class="product-type"><?php echo esc_html(ucfirst($product_type)); ?></p>
                                
                                <div class="product-meta">
                                    <?php if ($thc_content) : ?>
                                        <span class="thc-content">THC: <?php echo esc_html($thc_content); ?>%</span>
                                    <?php endif; ?>
                                    <?php if ($product_weight) : ?>
                                        <span class="product-weight"><?php echo esc_html($product_weight); ?></span>
                                    <?php endif; ?>
                                </div>
                                
                                <a href="<?php the_permalink(); ?>" class="product-link">View Details</a>
                            </div>
                        </div>
                        
                    <?php endwhile;
                else : ?>
                    <div class="no-products">
                        <p>No featured products available at this time.</p>
                    </div>
                <?php endif; 
                wp_reset_postdata(); ?>
            </div>
            
            <div class="section-footer">
                <a href="/products/" class="btn-outline">View All Products</a>
            </div>
        </div>
    </section>

    <!-- Strains Section -->
    <section class="strains-section">
        <div class="container">
            <div class="section-header">
                <h2>Premium Strains</h2>
                <p>Explore our carefully curated strain library</p>
            </div>
            
            <div class="strains-grid">
                <?php
                $strains_query = new WP_Query(array(
                    'post_type' => 'strain',
                    'posts_per_page' => 4,
                    'orderby' => 'menu_order',
                    'order' => 'ASC'
                ));
                
                if ($strains_query->have_posts()) :
                    while ($strains_query->have_posts()) : $strains_query->the_post();
                        $strain_id = get_the_ID();
                        $strain_type_terms = get_the_terms($strain_id, 'strain_type');
                        $thc_content = get_field('thc_content');
                        ?>
                        
                        <div class="strain-card">
                            <div class="strain-image">
                                <?php if (has_post_thumbnail()) : ?>
                                    <?php the_post_thumbnail('medium', array('alt' => get_the_title())); ?>
                                <?php else : ?>
                                    <div class="strain-placeholder">
                                        <i class="ph ph-leaf"></i>
                                    </div>
                                <?php endif; ?>
                            </div>
                            
                            <div class="strain-info">
                                <h3 class="strain-name"><?php the_title(); ?></h3>
                                
                                <?php if ($strain_type_terms && !is_wp_error($strain_type_terms)) : ?>
                                    <span class="strain-type <?php echo esc_attr($strain_type_terms[0]->slug); ?>">
                                        <?php echo esc_html($strain_type_terms[0]->name); ?>
                                    </span>
                                <?php endif; ?>
                                
                                <?php if ($thc_content) : ?>
                                    <div class="strain-thc">
                                        <span>THC: <?php echo esc_html($thc_content); ?>%</span>
                                    </div>
                                <?php endif; ?>
                                
                                <a href="<?php the_permalink(); ?>" class="strain-link">Learn More</a>
                            </div>
                        </div>
                        
                    <?php endwhile;
                else : ?>
                    <div class="no-strains">
                        <p>Strain information coming soon.</p>
                    </div>
                <?php endif; 
                wp_reset_postdata(); ?>
            </div>
            
            <div class="section-footer">
                <a href="/strain-library/" class="btn-outline">View All Strains</a>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section class="about-section">
        <div class="container">
            <div class="about-content">
                <div class="about-text">
                    <h2>About Skyworld Cannabis</h2>
                    <p>We're committed to providing New York with premium cannabis products grown with expertise and transparency. Our indoor cultivation facility ensures consistent quality and potency in every product.</p>
                    <p>From seed to sale, we maintain the highest standards of quality control and testing to deliver products you can trust.</p>
                    <a href="/about/" class="btn-secondary">Learn More</a>
                </div>
                <div class="about-stats">
                    <div class="stat-item">
                        <div class="stat-number">15+</div>
                        <div class="stat-label">Premium Strains</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number">100%</div>
                        <div class="stat-label">Lab Tested</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number">NY</div>
                        <div class="stat-label">Grown & Licensed</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

</main>

<style>
/* Hero Section Styles */
.hero-section {
    position: relative;
    min-height: 80vh;
    display: flex;
    align-items: center;
    background: linear-gradient(135deg, rgba(40, 167, 69, 0.1), rgba(255, 193, 7, 0.1));
    overflow: hidden;
}

.hero-section::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grid" width="10" height="10" patternUnits="userSpaceOnUse"><path d="M 10 0 L 0 0 0 10" fill="none" stroke="rgba(40,167,69,0.1)" stroke-width="0.5"/></pattern></defs><rect width="100" height="100" fill="url(%23grid)" /></svg>');
    opacity: 0.5;
}

.hero-content {
    position: relative;
    z-index: 2;
}

.hero-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    background: rgba(40, 167, 69, 0.1);
    color: var(--color-sativa);
    padding: 0.5rem 1rem;
    border-radius: 2rem;
    font-weight: 600;
    margin-bottom: 1.5rem;
    border: 1px solid rgba(40, 167, 69, 0.2);
}

.hero-title {
    font-size: 4rem;
    font-weight: 700;
    line-height: 1.1;
    margin-bottom: 1.5rem;
    color: var(--color-text);
    font-family: 'Playfair Display', serif;
}

.hero-subtitle {
    font-size: 1.3rem;
    color: var(--color-text-muted);
    margin-bottom: 2.5rem;
    max-width: 600px;
}

.hero-actions {
    display: flex;
    gap: 1rem;
    flex-wrap: wrap;
    margin-bottom: 3rem;
}

.btn-primary {
    background: var(--color-sativa);
    color: white;
    padding: 1rem 2rem;
    border-radius: var(--border-radius);
    text-decoration: none;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    transition: var(--transition);
}

.btn-primary:hover {
    background: #1e7e34;
    transform: translateY(-2px);
    box-shadow: var(--shadow-md);
}

.btn-outline {
    background: transparent;
    color: var(--color-text);
    padding: 1rem 2rem;
    border: 2px solid var(--color-border);
    border-radius: var(--border-radius);
    text-decoration: none;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    transition: var(--transition);
}

.btn-outline:hover {
    border-color: var(--color-sativa);
    color: var(--color-sativa);
    transform: translateY(-2px);
}

.hero-features {
    display: flex;
    gap: 2rem;
    flex-wrap: wrap;
}

.feature-item {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    color: var(--color-text-muted);
}

.feature-item i {
    color: var(--color-sativa);
    font-size: 1.2rem;
}

/* Features Section */
.features-section {
    padding: 5rem 0;
    background: var(--color-bg-alt);
}

.features-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 2rem;
    margin-top: 3rem;
}

.feature-card {
    background: var(--color-card-bg);
    padding: 2rem;
    border-radius: var(--border-radius);
    text-align: center;
    transition: var(--transition);
    border: 1px solid var(--color-border);
}

.feature-card:hover {
    transform: translateY(-5px);
    box-shadow: var(--shadow-lg);
}

.feature-icon {
    width: 60px;
    height: 60px;
    background: rgba(40, 167, 69, 0.1);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1.5rem;
    color: var(--color-sativa);
    font-size: 1.5rem;
}

.feature-card h3 {
    font-size: 1.4rem;
    margin-bottom: 1rem;
    color: var(--color-text);
}

.feature-card p {
    color: var(--color-text-muted);
    line-height: 1.6;
}

/* Products Section */
.products-section {
    padding: 5rem 0;
}

.products-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 2rem;
    margin-top: 3rem;
}

.product-card {
    background: var(--color-card-bg);
    border-radius: var(--border-radius);
    overflow: hidden;
    transition: var(--transition);
    border: 1px solid var(--color-border);
}

.product-card:hover {
    transform: translateY(-5px);
    box-shadow: var(--shadow-lg);
}

.product-image {
    aspect-ratio: 4/3;
    background: var(--color-bg-alt);
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--color-text-muted);
    font-size: 2rem;
}

.product-content {
    padding: 1.5rem;
}

.product-title {
    font-size: 1.3rem;
    font-weight: 600;
    margin-bottom: 0.5rem;
    color: var(--color-text);
}

.product-type {
    color: var(--color-sativa);
    font-weight: 600;
    font-size: 0.9rem;
    margin-bottom: 1rem;
}

.product-description {
    color: var(--color-text-muted);
    line-height: 1.6;
    margin-bottom: 1.5rem;
}

.product-meta {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1.5rem;
}

.product-thc {
    background: rgba(40, 167, 69, 0.1);
    color: var(--color-sativa);
    padding: 0.25rem 0.75rem;
    border-radius: 1rem;
    font-weight: 600;
    font-size: 0.9rem;
}

.product-weight {
    color: var(--color-text-muted);
    font-weight: 600;
}

.btn-secondary {
    background: var(--color-bg-alt);
    color: var(--color-text);
    padding: 0.75rem 1.5rem;
    border-radius: var(--border-radius);
    text-decoration: none;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    transition: var(--transition);
    border: 1px solid var(--color-border);
}

.btn-secondary:hover {
    background: var(--color-sativa);
    color: white;
    border-color: var(--color-sativa);
}

/* Strains Section */
.strains-section {
    padding: 5rem 0;
    background: var(--color-bg-alt);
}

.strains-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 2rem;
    margin-top: 3rem;
}

.strain-card {
    background: var(--color-card-bg);
    padding: 2rem;
    border-radius: var(--border-radius);
    transition: var(--transition);
    border: 1px solid var(--color-border);
}

.strain-card:hover {
    transform: translateY(-5px);
    box-shadow: var(--shadow-lg);
}

.strain-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 1rem;
}

.strain-name {
    font-size: 1.4rem;
    font-weight: 700;
    color: var(--color-text);
    margin: 0;
}

.strain-type {
    background: var(--color-indica);
    color: white;
    padding: 0.25rem 0.75rem;
    border-radius: 1rem;
    font-size: 0.8rem;
    font-weight: 600;
}

.strain-type.sativa {
    background: var(--color-sativa);
}

.strain-type.hybrid {
    background: var(--color-hybrid);
}

.strain-genetics {
    color: var(--color-text-muted);
    font-style: italic;
    margin-bottom: 1rem;
}

.strain-description {
    color: var(--color-text-muted);
    line-height: 1.6;
    margin-bottom: 1.5rem;
}

.strain-effects {
    display: flex;
    gap: 0.5rem;
    flex-wrap: wrap;
    margin-bottom: 1.5rem;
}

.effect-tag {
    background: rgba(40, 167, 69, 0.1);
    color: var(--color-sativa);
    padding: 0.25rem 0.75rem;
    border-radius: 1rem;
    font-size: 0.85rem;
    font-weight: 500;
}

/* About Section */
.about-section {
    padding: 5rem 0;
}

.about-content {
    display: grid;
    grid-template-columns: 2fr 1fr;
    gap: 4rem;
    align-items: center;
}

.about-text h2 {
    font-size: 2.5rem;
    font-weight: 700;
    margin-bottom: 1.5rem;
    color: var(--color-text);
    font-family: 'Playfair Display', serif;
}

.about-text p {
    color: var(--color-text-muted);
    line-height: 1.8;
    margin-bottom: 1.5rem;
}

.about-stats {
    display: grid;
    gap: 2rem;
}

.stat-item {
    text-align: center;
    padding: 1.5rem;
    background: var(--color-card-bg);
    border-radius: var(--border-radius);
    border: 1px solid var(--color-border);
}

.stat-number {
    font-size: 2.5rem;
    font-weight: 700;
    color: var(--color-sativa);
    display: block;
    font-family: 'Playfair Display', serif;
}

.stat-label {
    color: var(--color-text-muted);
    font-weight: 600;
    margin-top: 0.5rem;
}

/* Section Headers */
.section-header {
    text-align: center;
    margin-bottom: 3rem;
}

.section-header h2 {
    font-size: 2.8rem;
    font-weight: 700;
    margin-bottom: 1rem;
    color: var(--color-text);
    font-family: 'Playfair Display', serif;
}

.section-header p {
    font-size: 1.2rem;
    color: var(--color-text-muted);
    max-width: 600px;
    margin: 0 auto;
}

.section-footer {
    text-align: center;
    margin-top: 3rem;
}

/* Responsive Design */
@media (max-width: 768px) {
    .hero-title {
        font-size: 2.5rem;
    }
    
    .hero-subtitle {
        font-size: 1.1rem;
    }
    
    .hero-actions {
        flex-direction: column;
        align-items: flex-start;
    }
    
    .hero-features {
        flex-direction: column;
        gap: 1rem;
    }
    
    .section-header h2 {
        font-size: 2rem;
    }
    
    .about-content {
        grid-template-columns: 1fr;
        gap: 2rem;
    }
    
    .about-text h2 {
        font-size: 2rem;
    }
    
    .features-grid,
    .products-grid,
    .strains-grid {
        grid-template-columns: 1fr;
    }
}
<?php get_footer();
