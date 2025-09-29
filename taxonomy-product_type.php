<?php
/**
 * Archive template for Product Types (Flower, Pre-rolls, Hash Holes, etc)
 * URL: /product-types/flower/ or /product-types/pre-rolls/
 */

get_header(); ?>

<div class="container">
    <div class="product-type-archive">
        <header class="archive-header">
            <h1 class="archive-title">
                <?php echo single_term_title('', false); ?>
            </h1>
            
            <?php if (term_description()) : ?>
                <div class="archive-description">
                    <?php echo term_description(); ?>
                </div>
            <?php endif; ?>
            
            <div class="product-type-info">
                <?php 
                $term = get_queried_object();
                $product_type = strtolower($term->name);
                
                switch($product_type) {
                    case 'flower':
                        echo '<p>Premium cannabis flower, hand-trimmed and cured to perfection. Available in various strains and sizes.</p>';
                        break;
                    case 'pre-rolls':
                        echo '<p>Expertly rolled joints using premium flower - no trim, no shake, no shortcuts. Ready to enjoy.</p>';
                        break;
                    case 'hash holes':
                        echo '<p>Premium pre-rolls infused with high-quality hash for an elevated experience.</p>';
                        break;
                    case 'concentrates':
                        echo '<p>High-potency cannabis extracts and concentrates for experienced consumers.</p>';
                        break;
                }
                ?>
            </div>
        </header>

        <div class="product-type-grid">
            <?php if (have_posts()) : ?>
                <?php while (have_posts()) : the_post(); ?>
                    <div class="product-type-card">
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
                                    echo '<a href="' . get_term_link($type) . '" class="strain-badge strain-' . esc_attr($type->slug) . '">' . esc_html($type->name) . '</a>';
                                }
                                echo '</div>';
                            }
                            ?>
                            
                            <?php 
                            $package_sizes = get_the_terms(get_the_ID(), 'package_size');
                            if ($package_sizes) {
                                echo '<div class="package-sizes">';
                                foreach ($package_sizes as $size) {
                                    echo '<span class="size-badge">' . esc_html($size->name) . '</span>';
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
                            
                            <div class="product-meta">
                                <a href="<?php the_permalink(); ?>" class="view-product-btn">
                                    View Details
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
                
                <div class="archive-pagination">
                    <?php the_posts_pagination(); ?>
                </div>
                
            <?php else : ?>
                <p>No <?php echo strtolower(single_term_title('', false)); ?> products available at this time.</p>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php get_footer(); ?>