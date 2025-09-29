<?php
/**
 * Template Part: Genetic Library Block
 * Displays strain genetics in an interactive grid layout
 */
?>

<section class="skyworld-genetic-library" id="geneticLibrary">
    <div class="genetic-library-container">
        <div class="section-header">
            <div class="section-badge">
                <i class="fas fa-dna"></i>
                <span>Genetic Library</span>
            </div>
            <h2 class="section-title">Explore Our Genetics</h2>
            <p class="section-subtitle">Discover premium strains crafted with intention, each with its own unique character and effects.</p>
        </div>
        
        <div class="genetic-filter-tabs">
            <button class="filter-tab active" data-filter="all">
                <i class="fas fa-th-large"></i>
                All Strains
            </button>
            <button class="filter-tab" data-filter="sativa">
                <i class="fas fa-leaf"></i>
                Sativa
            </button>
            <button class="filter-tab" data-filter="indica">
                <i class="fas fa-seedling"></i>
                Indica
            </button>
            <button class="filter-tab" data-filter="hybrid">
                <i class="fas fa-balance-scale"></i>
                Hybrid
            </button>
            <button class="filter-tab" data-filter="featured">
                <i class="fas fa-star"></i>
                Featured
            </button>
        </div>
        
        <div class="genetic-library-grid" id="geneticGrid">
            <?php
            // Query strains for genetic library
            $genetics_query = new WP_Query(array(
                'post_type' => 'strain',
                'posts_per_page' => 12,
                'meta_key' => 'strain_popularity_score',
                'orderby' => 'meta_value_num',
                'order' => 'DESC'
            ));
            
            if ($genetics_query->have_posts()) :
                while ($genetics_query->have_posts()) : $genetics_query->the_post();
                    $strain_type = get_field('strain_type') ?: 'hybrid';
                    $thc_level = get_field('thc_level');
                    $cbd_level = get_field('cbd_level');
                    $effects = get_field('primary_effects');
                    $is_featured = get_field('featured_strain');
                    $strain_image = get_the_post_thumbnail_url(get_the_ID(), 'medium');
                    $dominant_terpenes = get_field('dominant_terpenes');
                    ?>
                    
                    <div class="genetic-card" 
                         data-strain-type="<?php echo $strain_type; ?>" 
                         data-featured="<?php echo $is_featured ? 'true' : 'false'; ?>">
                        
                        <div class="genetic-card-image">
                            <?php if ($strain_image): ?>
                                <img src="<?php echo $strain_image; ?>" 
                                     alt="<?php the_title(); ?> Cannabis Flower"
                                     loading="lazy">
                            <?php else: ?>
                                <div class="genetic-card-placeholder">
                                    <i class="fas fa-cannabis"></i>
                                    <span>🌸</span>
                                </div>
                            <?php endif; ?>
                            
                            <div class="genetic-card-overlay">
                                <div class="strain-type-badge <?php echo $strain_type; ?>">
                                    <?php echo ucfirst($strain_type); ?>
                                </div>
                                <?php if ($is_featured): ?>
                                <div class="featured-badge">
                                    <i class="fas fa-star"></i>
                                    Featured
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        
                        <div class="genetic-card-content">
                            <h3 class="genetic-card-title">
                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                            </h3>
                            
                            <div class="genetic-card-stats">
                                <?php if ($thc_level): ?>
                                <div class="stat">
                                    <span class="stat-label">THC</span>
                                    <span class="stat-value"><?php echo $thc_level; ?>%</span>
                                </div>
                                <?php endif; ?>
                                
                                <?php if ($cbd_level): ?>
                                <div class="stat">
                                    <span class="stat-label">CBD</span>
                                    <span class="stat-value"><?php echo $cbd_level; ?>%</span>
                                </div>
                                <?php endif; ?>
                            </div>
                            
                            <?php if ($effects): ?>
                            <div class="genetic-card-effects">
                                <?php 
                                $effects_array = is_array($effects) ? $effects : explode(',', $effects);
                                foreach (array_slice($effects_array, 0, 3) as $effect): 
                                ?>
                                <span class="effect-tag"><?php echo trim($effect); ?></span>
                                <?php endforeach; ?>
                            </div>
                            <?php endif; ?>
                            
                            <?php if ($dominant_terpenes): ?>
                            <div class="genetic-card-terpenes">
                                <span class="terpene-label">
                                    <i class="fas fa-flask"></i>
                                    Dominant Terpenes:
                                </span>
                                <span class="terpene-list"><?php echo $dominant_terpenes; ?></span>
                            </div>
                            <?php endif; ?>
                            
                            <div class="genetic-card-actions">
                                <a href="<?php the_permalink(); ?>" class="genetic-card-button primary">
                                    <i class="fas fa-info-circle"></i>
                                    Learn More
                                </a>
                                <a href="<?php echo home_url('/store-locator/'); ?>?strain=<?php echo get_the_ID(); ?>" 
                                   class="genetic-card-button secondary">
                                    <i class="fas fa-map-marker-alt"></i>
                                    Find Stores
                                </a>
                            </div>
                        </div>
                    </div>
                    
                <?php endwhile;
                wp_reset_postdata();
            else: ?>
                
                <div class="no-genetics-message">
                    <div class="no-genetics-icon">
                        <i class="fas fa-seedling"></i>
                    </div>
                    <h3>Coming Soon</h3>
                    <p>Our genetic library is being curated. Check back soon for our premium strain collection.</p>
                </div>
                
            <?php endif; ?>
        </div>
        
        <div class="genetic-library-footer">
            <a href="<?php echo home_url('/strain-library/'); ?>" class="view-all-button">
                <span>View Complete Library</span>
                <i class="fas fa-arrow-right"></i>
            </a>
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const filterTabs = document.querySelectorAll('.filter-tab');
    const geneticCards = document.querySelectorAll('.genetic-card');
    
    filterTabs.forEach(tab => {
        tab.addEventListener('click', function() {
            const filter = this.dataset.filter;
            
            // Update active tab
            filterTabs.forEach(t => t.classList.remove('active'));
            this.classList.add('active');
            
            // Filter cards
            geneticCards.forEach(card => {
                if (filter === 'all') {
                    card.style.display = 'block';
                } else if (filter === 'featured') {
                    card.style.display = card.dataset.featured === 'true' ? 'block' : 'none';
                } else {
                    card.style.display = card.dataset.strainType === filter ? 'block' : 'none';
                }
            });
        });
    });
});
</script>