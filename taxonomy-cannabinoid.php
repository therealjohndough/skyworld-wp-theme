<?php
/**
 * Archive template for Cannabinoids (CBG, CBN, THCV, etc)
 * URL: /cannabinoids/cbg/
 */

get_header(); ?>

<div class="container">
    <div class="cannabinoid-archive">
        <header class="archive-header">
            <h1 class="archive-title">
                <?php echo strtoupper(single_term_title('', false)); ?> Products
            </h1>
            
            <?php if (term_description()) : ?>
                <div class="archive-description">
                    <?php echo term_description(); ?>
                </div>
            <?php endif; ?>
            
            <div class="cannabinoid-info">
                <p><strong>Products featuring elevated <?php echo strtoupper(single_term_title('', false)); ?> levels:</strong></p>
            </div>
        </header>

        <div class="cannabinoid-products-grid">
            <?php if (have_posts()) : ?>
                <?php while (have_posts()) : the_post(); ?>
                    <div class="cannabinoid-product-card">
                        <?php if (has_post_thumbnail()) : ?>
                            <div class="product-image">
                                <a href="<?php the_permalink(); ?>">
                                    <?php the_post_thumbnail('medium'); ?>
                                </a>
                            </div>
                        <?php endif; ?>
                        
                        <div class="product-content">
                            <h3 class="product-title">
                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                            </h3>
                            
                            <?php 
                            $strain_types = get_the_terms(get_the_ID(), 'strain_type');
                            $product_types = get_the_terms(get_the_ID(), 'product_type');
                            
                            if ($product_types) {
                                echo '<div class="product-type">';
                                foreach ($product_types as $type) {
                                    echo '<span class="product-type-badge">' . esc_html($type->name) . '</span>';
                                }
                                echo '</div>';
                            }
                            
                            if ($strain_types) {
                                echo '<div class="strain-type">';
                                foreach ($strain_types as $type) {
                                    echo '<span class="strain-badge strain-' . esc_attr($type->slug) . '">' . esc_html($type->name) . '</span>';
                                }
                                echo '</div>';
                            }
                            ?>
                            
                            <?php if (get_field('lab_results')) : ?>
                                <div class="lab-results-highlight">
                                    <?php 
                                    $lab_results = get_field('lab_results');
                                    $current_term = get_queried_object();
                                    $cannabinoid = strtoupper($current_term->name);
                                    
                                    // Show the featured cannabinoid prominently
                                    if ($lab_results['thc_percentage']) {
                                        echo '<span class="thc">THC: ' . $lab_results['thc_percentage'] . '%</span>';
                                    }
                                    if ($lab_results['cbd_percentage']) {
                                        echo '<span class="cbd">CBD: ' . $lab_results['cbd_percentage'] . '%</span>';
                                    }
                                    if ($lab_results['cbg_percentage']) {
                                        echo '<span class="cbg">CBG: ' . $lab_results['cbg_percentage'] . '%</span>';
                                    }
                                    ?>
                                </div>
                            <?php endif; ?>
                            
                            <div class="product-excerpt">
                                <?php the_excerpt(); ?>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
                
                <div class="archive-pagination">
                    <?php the_posts_pagination(); ?>
                </div>
                
            <?php else : ?>
                <p>No products currently available featuring elevated <?php echo strtoupper(single_term_title('', false)); ?> levels.</p>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php get_footer(); ?>