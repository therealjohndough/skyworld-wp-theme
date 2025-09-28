<?php
/**
 * Single Strain Template
 * Template for displaying individual strain details
 */

get_header();

// Get strain data
$strain_id = get_the_ID();
$strain_meta = get_post_meta($strain_id);
?>

<div class="single-strain-page">
    <div class="container">
        <?php if (have_posts()) : ?>
            <?php while (have_posts()) : the_post(); ?>
                
                <div class="strain-hero">
                    <div class="strain-hero-content">
                        <div class="strain-hero-info">
                            <div class="strain-breadcrumbs">
                                <a href="<?php echo get_post_type_archive_link('strain'); ?>">← Back to Strain Library</a>
                            </div>
                            
                            <div class="strain-header">
                                <h1 class="strain-title"><?php the_title(); ?></h1>
                                
                                <?php 
                                $strain_type_terms = get_the_terms($strain_id, 'strain_type');
                                if ($strain_type_terms && !is_wp_error($strain_type_terms)) :
                                    $strain_type = $strain_type_terms[0];
                                ?>
                                    <span class="strain-type-badge <?php echo esc_attr($strain_type->slug); ?>">
                                        <?php echo esc_html($strain_type->name); ?>
                                    </span>
                                <?php endif; ?>
                            </div>
                            
                            <div class="strain-genetics">
                                <?php if (isset($strain_meta['parent_strains'][0]) && !empty($strain_meta['parent_strains'][0])) : ?>
                                    <p class="genetics-info">
                                        <strong>Genetics:</strong> <?php echo esc_html($strain_meta['parent_strains'][0]); ?>
                                    </p>
                                <?php endif; ?>
                            </div>
                            
                            <div class="strain-description">
                                <?php if (get_the_content()) : ?>
                                    <?php the_content(); ?>
                                <?php else : ?>
                                    <p>Explore the unique characteristics and effects of this premium cannabis strain.</p>
                                <?php endif; ?>
                            </div>
                            
                            <div class="strain-quick-stats">
                                <div class="quick-stat">
                                    <span class="stat-label">THC</span>
                                    <span class="stat-value thc-value">
                                        <?php echo isset($strain_meta['thc_content'][0]) ? esc_html($strain_meta['thc_content'][0]) . '%' : 'N/A'; ?>
                                    </span>
                                </div>
                                
                                <div class="quick-stat">
                                    <span class="stat-label">CBD</span>
                                    <span class="stat-value cbd-value">
                                        <?php echo isset($strain_meta['cbd_content'][0]) ? esc_html($strain_meta['cbd_content'][0]) . '%' : 'N/A'; ?>
                                    </span>
                                </div>
                                
                                <div class="quick-stat">
                                    <span class="stat-label">Flowering</span>
                                    <span class="stat-value">
                                        <?php echo isset($strain_meta['flowering_time'][0]) ? esc_html($strain_meta['flowering_time'][0]) . ' weeks' : 'N/A'; ?>
                                    </span>
                                </div>
                                
                                <div class="quick-stat">
                                    <span class="stat-label">Yield</span>
                                    <span class="stat-value">
                                        <?php echo isset($strain_meta['yield_info'][0]) ? esc_html($strain_meta['yield_info'][0]) : 'N/A'; ?>
                                    </span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="strain-hero-image">
                            <?php if (has_post_thumbnail()) : ?>
                                <div class="strain-featured-image">
                                    <?php the_post_thumbnail('large', ['alt' => get_the_title() . ' cannabis flower buds']); ?>
                                    <div class="image-type-overlay">
                                        <span class="image-type-label">Cannabis Flower</span>
                                    </div>
                                </div>
                            <?php else : ?>
                                <div class="strain-placeholder-image">
                                    <div class="placeholder-content">
                                        <span class="placeholder-icon">�</span>
                                        <span class="placeholder-text"><?php the_title(); ?></span>
                                        <span class="placeholder-subtitle">Cannabis Flower</span>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <div class="strain-details-grid">
                    
                    <!-- Effects Section -->
                    <div class="detail-section effects-section">
                        <h3 class="section-title">
                            <span class="section-icon"><i class="ph ph-sparkle"></i></span>
                            Effects & Experience
                        </h3>
                        
                        <div class="effects-content">
                            <?php 
                            $effects = get_the_terms($strain_id, 'effects');
                            if ($effects && !is_wp_error($effects)) : 
                            ?>
                                <div class="effect-tags">
                                    <?php foreach ($effects as $effect) : ?>
                                        <span class="effect-tag"><?php echo esc_html($effect->name); ?></span>
                                    <?php endforeach; ?>
                                </div>
                            <?php else : ?>
                                <p class="no-data">Effects information not available.</p>
                            <?php endif; ?>
                            
                            <?php if (isset($strain_meta['effects_description'][0]) && !empty($strain_meta['effects_description'][0])) : ?>
                                <div class="effects-description">
                                    <p><?php echo esc_html($strain_meta['effects_description'][0]); ?></p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Terpene Profile -->
                    <div class="detail-section terpenes-section">
                        <h3 class="section-title">
                            <span class="section-icon">🧪</span>
                            Terpene Profile
                        </h3>
                        
                        <div class="terpenes-content">
                            <?php 
                            $terpenes = get_the_terms($strain_id, 'terpenes');
                            if ($terpenes && !is_wp_error($terpenes)) : 
                            ?>
                                <div class="terpene-list">
                                    <?php foreach ($terpenes as $terpene) : ?>
                                        <div class="terpene-item">
                                            <span class="terpene-name"><?php echo esc_html($terpene->name); ?></span>
                                            <?php if ($terpene->description) : ?>
                                                <span class="terpene-description"><?php echo esc_html($terpene->description); ?></span>
                                            <?php endif; ?>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php else : ?>
                                <p class="no-data">Terpene profile information not available.</p>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Flavors -->
                    <div class="detail-section flavors-section">
                        <h3 class="section-title">
                            <span class="section-icon">👅</span>
                            Flavor Profile
                        </h3>
                        
                        <div class="flavors-content">
                            <?php 
                            $flavors = get_the_terms($strain_id, 'flavors');
                            if ($flavors && !is_wp_error($flavors)) : 
                            ?>
                                <div class="flavor-tags">
                                    <?php foreach ($flavors as $flavor) : ?>
                                        <span class="flavor-tag"><?php echo esc_html($flavor->name); ?></span>
                                    <?php endforeach; ?>
                                </div>
                            <?php else : ?>
                                <p class="no-data">Flavor information not available.</p>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Growing Information -->
                    <div class="detail-section growing-section">
                        <h3 class="section-title">
                            <span class="section-icon">🌱</span>
                            Growing Information
                        </h3>
                        
                        <div class="growing-content">
                            <div class="growing-stats">
                                <div class="growing-stat">
                                    <label>Difficulty Level:</label>
                                    <span>
                                        <?php 
                                        $difficulty = get_the_terms($strain_id, 'growing_difficulty');
                                        echo ($difficulty && !is_wp_error($difficulty)) ? esc_html($difficulty[0]->name) : 'Not specified';
                                        ?>
                                    </span>
                                </div>
                                
                                <div class="growing-stat">
                                    <label>Flowering Time:</label>
                                    <span><?php echo isset($strain_meta['flowering_time'][0]) ? esc_html($strain_meta['flowering_time'][0]) . ' weeks' : 'Not specified'; ?></span>
                                </div>
                                
                                <div class="growing-stat">
                                    <label>Expected Yield:</label>
                                    <span><?php echo isset($strain_meta['yield_info'][0]) ? esc_html($strain_meta['yield_info'][0]) : 'Not specified'; ?></span>
                                </div>
                                
                                <div class="growing-stat">
                                    <label>Plant Height:</label>
                                    <span><?php echo isset($strain_meta['plant_height'][0]) ? esc_html($strain_meta['plant_height'][0]) : 'Not specified'; ?></span>
                                </div>
                            </div>
                            
                            <?php if (isset($strain_meta['growing_notes'][0]) && !empty($strain_meta['growing_notes'][0])) : ?>
                                <div class="growing-notes">
                                    <h4>Growing Notes:</h4>
                                    <p><?php echo esc_html($strain_meta['growing_notes'][0]); ?></p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Medical Benefits -->
                    <div class="detail-section medical-section">
                        <h3 class="section-title">
                            <span class="section-icon">🏥</span>
                            Potential Medical Benefits
                        </h3>
                        
                        <div class="medical-content">
                            <?php 
                            $medical_benefits = get_the_terms($strain_id, 'medical_benefit');
                            if ($medical_benefits && !is_wp_error($medical_benefits)) : 
                            ?>
                                <div class="medical-benefits-list">
                                    <?php foreach ($medical_benefits as $benefit) : ?>
                                        <div class="medical-benefit-item">
                                            <span class="benefit-name"><?php echo esc_html($benefit->name); ?></span>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php else : ?>
                                <p class="no-data">Medical benefit information not available.</p>
                            <?php endif; ?>
                            
                            <div class="medical-disclaimer">
                                <p><em>* This information is for educational purposes only and is not intended as medical advice. Consult with a healthcare provider before using cannabis for medical purposes.</em></p>
                            </div>
                        </div>
                    </div>

                    <!-- Lab Results / COA -->
                    <div class="detail-section lab-results-section">
                        <h3 class="section-title">
                            <span class="section-icon">🔬</span>
                            Lab Results & Quality
                        </h3>
                        
                        <div class="lab-results-content">
                            <div class="cannabinoid-profile">
                                <h4>Cannabinoid Profile</h4>
                                <div class="cannabinoid-chart">
                                    <div class="cannabinoid-item">
                                        <span class="cannabinoid-label">THC</span>
                                        <div class="cannabinoid-bar">
                                            <div class="cannabinoid-fill thc-fill" style="width: <?php echo isset($strain_meta['thc_content'][0]) ? min(100, intval($strain_meta['thc_content'][0]) * 3.33) : 0; ?>%"></div>
                                        </div>
                                        <span class="cannabinoid-value"><?php echo isset($strain_meta['thc_content'][0]) ? esc_html($strain_meta['thc_content'][0]) . '%' : '0%'; ?></span>
                                    </div>
                                    
                                    <div class="cannabinoid-item">
                                        <span class="cannabinoid-label">CBD</span>
                                        <div class="cannabinoid-bar">
                                            <div class="cannabinoid-fill cbd-fill" style="width: <?php echo isset($strain_meta['cbd_content'][0]) ? min(100, intval($strain_meta['cbd_content'][0]) * 10) : 0; ?>%"></div>
                                        </div>
                                        <span class="cannabinoid-value"><?php echo isset($strain_meta['cbd_content'][0]) ? esc_html($strain_meta['cbd_content'][0]) . '%' : '0%'; ?></span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="quality-assurance">
                                <h4>Quality Assurance</h4>
                                <div class="qa-badges">
                                    <span class="qa-badge">Lab Tested</span>
                                    <span class="qa-badge">Pesticide Free</span>
                                    <span class="qa-badge">Heavy Metal Free</span>
                                    <span class="qa-badge">Microbial Safe</span>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Related Products -->
                <div class="related-products-section">
                    <h3 class="section-title">Available Products</h3>
                    
                    <div class="products-grid">
                        <?php
                        // Query for products related to this strain
                        $related_products = new WP_Query([
                            'post_type' => 'sky_product',
                            'meta_query' => [
                                [
                                    'key' => 'strain_reference',
                                    'value' => $strain_id,
                                    'compare' => '='
                                ]
                            ],
                            'posts_per_page' => 6
                        ]);
                        
                        if ($related_products->have_posts()) :
                            while ($related_products->have_posts()) : $related_products->the_post();
                                $product_meta = get_post_meta(get_the_ID());
                        ?>
                            <div class="product-card">
                                <div class="product-image">
                                    <?php if (has_post_thumbnail()) : ?>
                                        <?php the_post_thumbnail('medium', ['alt' => get_the_title() . ' product packaging']); ?>
                                        <div class="product-image-overlay">
                                            <span class="product-type-badge">Packaging</span>
                                        </div>
                                    <?php else : ?>
                                        <div class="product-placeholder">
                                            <span class="placeholder-icon"><i class="ph ph-package"></i></span>
                                            <span class="placeholder-label">Product Packaging</span>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                
                                <div class="product-info">
                                    <h4 class="product-name"><?php the_title(); ?></h4>
                                    <p class="product-type"><?php echo isset($product_meta['product_type'][0]) ? esc_html($product_meta['product_type'][0]) : 'Cannabis Product'; ?></p>
                                    
                                    <?php if (isset($product_meta['thc_percentage'][0])) : ?>
                                        <div class="product-potency">
                                            THC: <?php echo esc_html($product_meta['thc_percentage'][0]); ?>%
                                        </div>
                                    <?php endif; ?>
                                    
                                    <a href="<?php the_permalink(); ?>" class="product-link">View Product Details</a>
                                </div>
                            </div>
                        <?php
                            endwhile;
                            wp_reset_postdata();
                        else :
                        ?>
                            <p class="no-products">No products currently available for this strain. Check back soon!</p>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Related Strains -->
                <div class="related-strains-section">
                    <h3 class="section-title">Similar Strains</h3>
                    
                    <div class="related-strains-grid">
                        <?php
                        // Get similar strains based on type and effects
                        $current_strain_type = wp_get_post_terms($strain_id, 'strain_type', ['fields' => 'ids']);
                        $current_effects = wp_get_post_terms($strain_id, 'effects', ['fields' => 'ids']);
                        
                        $similar_strains = new WP_Query([
                            'post_type' => 'strain',
                            'post__not_in' => [$strain_id],
                            'tax_query' => [
                                'relation' => 'OR',
                                [
                                    'taxonomy' => 'strain_type',
                                    'field' => 'term_id',
                                    'terms' => $current_strain_type
                                ],
                                [
                                    'taxonomy' => 'effects',
                                    'field' => 'term_id',
                                    'terms' => $current_effects
                                ]
                            ],
                            'posts_per_page' => 3
                        ]);
                        
                        if ($similar_strains->have_posts()) :
                            while ($similar_strains->have_posts()) : $similar_strains->the_post();
                                $similar_meta = get_post_meta(get_the_ID());
                                $similar_type = get_the_terms(get_the_ID(), 'strain_type');
                        ?>
                            <div class="related-strain-card">
                                <div class="strain-image">
                                    <?php if (has_post_thumbnail()) : ?>
                                        <?php the_post_thumbnail('medium'); ?>
                                    <?php else : ?>
                                        <div class="strain-placeholder"><i class="ph ph-leaf"></i></div>
                                    <?php endif; ?>
                                </div>
                                
                                <div class="strain-info">
                                    <h4 class="strain-name"><?php the_title(); ?></h4>
                                    
                                    <?php if ($similar_type && !is_wp_error($similar_type)) : ?>
                                        <span class="strain-type <?php echo esc_attr($similar_type[0]->slug); ?>">
                                            <?php echo esc_html($similar_type[0]->name); ?>
                                        </span>
                                    <?php endif; ?>
                                    
                                    <div class="strain-stats">
                                        <span class="thc-stat">
                                            THC: <?php echo isset($similar_meta['thc_content'][0]) ? esc_html($similar_meta['thc_content'][0]) . '%' : 'N/A'; ?>
                                        </span>
                                    </div>
                                    
                                    <a href="<?php the_permalink(); ?>" class="strain-link">Learn More</a>
                                </div>
                            </div>
                        <?php
                            endwhile;
                            wp_reset_postdata();
                        else :
                        ?>
                            <p class="no-related">No similar strains found at this time.</p>
                        <?php endif; ?>
                    </div>
                </div>

            <?php endwhile; ?>
        <?php endif; ?>
    </div>
</div>

<?php get_footer(); ?>

<style>
/* Single Strain Page Styles */
.single-strain-page {
    background: #f8f9fa;
    min-height: 100vh;
    padding: 40px 0;
}

.container {
    max-width: 1400px;
    margin: 0 auto;
    padding: 0 20px;
}

/* Hero Section */
.strain-hero {
    background: white;
    border-radius: 16px;
    padding: 60px;
    margin-bottom: 40px;
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
}

.strain-hero-content {
    display: grid;
    grid-template-columns: 2fr 1fr;
    gap: 60px;
    align-items: start;
}

.strain-breadcrumbs {
    margin-bottom: 20px;
}

.strain-breadcrumbs a {
    color: #6c757d;
    text-decoration: none;
    font-size: 14px;
    transition: color 0.3s ease;
}

.strain-breadcrumbs a:hover {
    color: #27ae60;
}

.strain-header {
    display: flex;
    align-items: center;
    gap: 20px;
    margin-bottom: 20px;
    flex-wrap: wrap;
}

.strain-title {
    font-size: 48px;
    font-weight: 800;
    color: #2c3e50;
    margin: 0;
    letter-spacing: 1px;
}

.strain-type-badge {
    padding: 8px 16px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.strain-type-badge.indica {
    background: rgba(142, 68, 173, 0.9);
    color: white;
}

.strain-type-badge.sativa {
    background: rgba(230, 126, 34, 0.9);
    color: white;
}

.strain-type-badge.hybrid {
    background: rgba(39, 174, 96, 0.9);
    color: white;
}

.genetics-info {
    color: #6c757d;
    font-size: 16px;
    font-style: italic;
    margin-bottom: 25px;
}

.strain-description {
    color: #495057;
    font-size: 18px;
    line-height: 1.7;
    margin-bottom: 40px;
}

.strain-quick-stats {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 30px;
}

.quick-stat {
    text-align: center;
    background: #f8f9fa;
    padding: 20px;
    border-radius: 12px;
    border: 1px solid #e9ecef;
}

.stat-label {
    display: block;
    color: #6c757d;
    font-size: 12px;
    font-weight: 500;
    margin-bottom: 8px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.stat-value {
    display: block;
    color: #2c3e50;
    font-size: 24px;
    font-weight: 700;
}

.thc-value {
    color: #27ae60 !important;
}

.cbd-value {
    color: #3498db !important;
}

/* Hero Image */
.strain-hero-image {
    position: relative;
}

.strain-featured-image {
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.15);
}

.strain-featured-image {
    position: relative;
}

.strain-featured-image img {
    width: 100%;
    height: 400px;
    object-fit: cover;
}

.strain-featured-image::after {
    content: 'Cannabis Flower';
    position: absolute;
    bottom: 15px;
    left: 15px;
    background: rgba(0, 0, 0, 0.7);
    color: white;
    padding: 8px 12px;
    border-radius: 6px;
    font-size: 12px;
    font-weight: 500;
}

.strain-placeholder-image {
    background: linear-gradient(135deg, #27ae60, #2ecc71);
    border-radius: 12px;
    height: 400px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    text-align: center;
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.15);
    position: relative;
}

.placeholder-content {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 15px;
}

.placeholder-icon {
    font-size: 64px;
}

.placeholder-text {
    font-size: 20px;
    font-weight: 600;
}

.placeholder-subtitle {
    font-size: 14px;
    opacity: 0.8;
    font-weight: 400;
}

/* Details Grid */
.strain-details-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
    gap: 30px;
    margin-bottom: 60px;
}

.detail-section {
    background: white;
    border-radius: 16px;
    padding: 40px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    border: 1px solid #e9ecef;
}

.section-title {
    color: #2c3e50;
    font-size: 24px;
    font-weight: 700;
    margin-bottom: 25px;
    display: flex;
    align-items: center;
    gap: 12px;
    padding-bottom: 15px;
    border-bottom: 2px solid #27ae60;
}

.section-icon {
    font-size: 28px;
}

/* Effects */
.effect-tags {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
    margin-bottom: 20px;
}

.effect-tag {
    background: #d4edda;
    color: #155724;
    padding: 8px 16px;
    border-radius: 20px;
    font-size: 14px;
    font-weight: 500;
}

.effects-description p {
    color: #6c757d;
    line-height: 1.6;
    font-style: italic;
}

/* Terpenes */
.terpene-list {
    display: flex;
    flex-direction: column;
    gap: 15px;
}

.terpene-item {
    background: #f8f9fa;
    padding: 15px;
    border-radius: 8px;
    border-left: 4px solid #17a2b8;
}

.terpene-name {
    color: #2c3e50;
    font-weight: 600;
    display: block;
    margin-bottom: 5px;
}

.terpene-description {
    color: #6c757d;
    font-size: 14px;
}

/* Flavors */
.flavor-tags {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
}

.flavor-tag {
    background: #fff3cd;
    color: #856404;
    padding: 8px 16px;
    border-radius: 20px;
    font-size: 14px;
    font-weight: 500;
}

/* Growing Info */
.growing-stats {
    display: grid;
    gap: 15px;
    margin-bottom: 25px;
}

.growing-stat {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 12px 0;
    border-bottom: 1px solid #e9ecef;
}

.growing-stat:last-child {
    border-bottom: none;
}

.growing-stat label {
    color: #6c757d;
    font-weight: 500;
}

.growing-stat span {
    color: #2c3e50;
    font-weight: 600;
}

.growing-notes {
    background: #f8f9fa;
    padding: 20px;
    border-radius: 8px;
    border-left: 4px solid #28a745;
}

.growing-notes h4 {
    color: #2c3e50;
    margin-bottom: 10px;
}

.growing-notes p {
    color: #6c757d;
    line-height: 1.6;
    margin: 0;
}

/* Medical Benefits */
.medical-benefits-list {
    display: grid;
    gap: 10px;
    margin-bottom: 20px;
}

.medical-benefit-item {
    background: #e7f3ff;
    color: #0056b3;
    padding: 12px 16px;
    border-radius: 8px;
    border-left: 4px solid #007bff;
}

.medical-disclaimer {
    background: #fff3cd;
    padding: 15px;
    border-radius: 6px;
    border-left: 4px solid #ffc107;
}

.medical-disclaimer p {
    margin: 0;
    font-size: 14px;
    color: #856404;
}

/* Lab Results */
.cannabinoid-profile {
    margin-bottom: 30px;
}

.cannabinoid-profile h4 {
    color: #2c3e50;
    margin-bottom: 20px;
}

.cannabinoid-chart {
    display: grid;
    gap: 15px;
}

.cannabinoid-item {
    display: grid;
    grid-template-columns: 60px 1fr 60px;
    align-items: center;
    gap: 15px;
}

.cannabinoid-label {
    font-weight: 600;
    color: #2c3e50;
}

.cannabinoid-bar {
    height: 20px;
    background: #e9ecef;
    border-radius: 10px;
    overflow: hidden;
    position: relative;
}

.cannabinoid-fill {
    height: 100%;
    border-radius: 10px;
    transition: width 0.3s ease;
}

.thc-fill {
    background: linear-gradient(90deg, #27ae60, #2ecc71);
}

.cbd-fill {
    background: linear-gradient(90deg, #3498db, #74b9ff);
}

.cannabinoid-value {
    text-align: right;
    font-weight: 600;
    color: #2c3e50;
}

.qa-badges {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
}

.qa-badge {
    background: #d4edda;
    color: #155724;
    padding: 6px 12px;
    border-radius: 15px;
    font-size: 12px;
    font-weight: 500;
    border: 1px solid #c3e6cb;
}

/* Related Sections */
.related-products-section,
.related-strains-section {
    background: white;
    border-radius: 16px;
    padding: 40px;
    margin-bottom: 40px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
}

.products-grid,
.related-strains-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 30px;
    margin-top: 30px;
}

.product-card,
.related-strain-card {
    background: #f8f9fa;
    border-radius: 12px;
    overflow: hidden;
    border: 1px solid #e9ecef;
    transition: all 0.3s ease;
}

.product-card:hover,
.related-strain-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
}

.product-image,
.strain-image {
    height: 200px;
    overflow: hidden;
}

.product-image img,
.strain-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.product-placeholder,
.strain-placeholder {
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #e9ecef;
    font-size: 48px;
}

.product-info,
.strain-info {
    padding: 20px;
}

.product-name,
.strain-name {
    color: #2c3e50;
    font-size: 18px;
    font-weight: 600;
    margin-bottom: 8px;
}

.product-type {
    color: #6c757d;
    font-size: 14px;
    margin-bottom: 10px;
}

.product-potency {
    background: #d4edda;
    color: #155724;
    padding: 4px 8px;
    border-radius: 12px;
    font-size: 12px;
    font-weight: 500;
    display: inline-block;
    margin-bottom: 15px;
}

.product-link,
.strain-link {
    color: #27ae60;
    text-decoration: none;
    font-weight: 500;
    font-size: 14px;
}

.product-link:hover,
.strain-link:hover {
    color: #219a52;
}

.strain-type {
    font-size: 12px;
    padding: 4px 8px;
    border-radius: 12px;
    display: inline-block;
    margin-bottom: 10px;
    font-weight: 500;
}

.strain-type.indica {
    background: rgba(142, 68, 173, 0.1);
    color: #8e44ad;
}

.strain-type.sativa {
    background: rgba(230, 126, 34, 0.1);
    color: #e67e22;
}

.strain-type.hybrid {
    background: rgba(39, 174, 96, 0.1);
    color: #27ae60;
}

.strain-stats {
    margin-bottom: 15px;
}

.thc-stat {
    background: #d4edda;
    color: #155724;
    padding: 4px 8px;
    border-radius: 12px;
    font-size: 12px;
    font-weight: 500;
}

.no-data,
.no-products,
.no-related {
    color: #6c757d;
    font-style: italic;
    text-align: center;
    padding: 40px;
}

/* Responsive Design */
@media (max-width: 1200px) {
    .strain-details-grid {
        grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
    }
}

@media (max-width: 768px) {
    .single-strain-page {
        padding: 20px 0;
    }
    
    .container {
        padding: 0 15px;
    }
    
    .strain-hero {
        padding: 30px;
    }
    
    .strain-hero-content {
        grid-template-columns: 1fr;
        gap: 30px;
    }
    
    .strain-title {
        font-size: 32px;
    }
    
    .strain-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 15px;
    }
    
    .strain-quick-stats {
        grid-template-columns: repeat(2, 1fr);
        gap: 15px;
    }
    
    .detail-section {
        padding: 25px;
    }
    
    .strain-details-grid {
        grid-template-columns: 1fr;
        gap: 20px;
    }
    
    .products-grid,
    .related-strains-grid {
        grid-template-columns: 1fr;
        gap: 20px;
    }
    
    .cannabinoid-item {
        grid-template-columns: 1fr;
        gap: 10px;
        text-align: center;
    }
    
    .related-products-section,
    .related-strains-section {
        padding: 25px;
    }
}

/* Dark Mode Support */
body.dark-mode .single-strain-page {
    background: #1a1a1a;
}

body.dark-mode .strain-hero,
body.dark-mode .detail-section,
body.dark-mode .related-products-section,
body.dark-mode .related-strains-section {
    background: #2c3e50;
    border-color: #555;
}

body.dark-mode .strain-title,
body.dark-mode .section-title,
body.dark-mode .cannabinoid-profile h4,
body.dark-mode .growing-notes h4,
body.dark-mode .product-name,
body.dark-mode .strain-name {
    color: #ecf0f1;
}

body.dark-mode .quick-stat,
body.dark-mode .growing-notes,
body.dark-mode .terpene-item,
body.dark-mode .product-card,
body.dark-mode .related-strain-card {
    background: #34495e;
    border-color: #555;
}

body.dark-mode .genetics-info,
body.dark-mode .strain-description,
body.dark-mode .growing-notes p,
body.dark-mode .terpene-description {
    color: #bdc3c7;
}
</style>