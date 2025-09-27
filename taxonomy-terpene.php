<?php
/**
 * Archive template for Terpenes
 * URL: /terpenes/limonene/
 */

get_header(); ?>

<div class="container">
    <div class="terpene-archive">
        <header class="archive-header">
            <h1 class="archive-title">
                <?php echo single_term_title('', false); ?> Terpene
            </h1>
            
            <?php if (term_description()) : ?>
                <div class="archive-description">
                    <?php echo term_description(); ?>
                </div>
            <?php endif; ?>
            
            <div class="terpene-info">
                <p><strong>Products featuring <?php echo single_term_title('', false); ?>:</strong></p>
            </div>
        </header>

        <div class="products-grid">
            <?php if (have_posts()) : ?>
                <?php while (have_posts()) : the_post(); ?>
                    <div class="product-card">
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
                            if ($strain_types) {
                                echo '<div class="strain-type">';
                                foreach ($strain_types as $type) {
                                    echo '<span class="strain-badge strain-' . esc_attr($type->slug) . '">' . esc_html($type->name) . '</span>';
                                }
                                echo '</div>';
                            }
                            ?>
                            
                            <?php if (get_field('lab_results')) : ?>
                                <div class="lab-results-preview">
                                    <?php 
                                    $lab_results = get_field('lab_results');
                                    if ($lab_results['thc_percentage']) {
                                        echo '<span class="thc">THC: ' . $lab_results['thc_percentage'] . '%</span>';
                                    }
                                    if ($lab_results['total_terpenes']) {
                                        echo '<span class="terpenes">Terpenes: ' . $lab_results['total_terpenes'] . '%</span>';
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
                <p>No products found featuring this terpene.</p>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php get_footer(); ?>