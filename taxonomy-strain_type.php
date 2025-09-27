<?php
/**
 * Archive template for Strain Types (Indica, Sativa, Hybrid)
 * URL: /strain-types/indica/
 */

get_header(); ?>

<div class="container">
    <div class="strain-type-archive">
        <header class="archive-header">
            <h1 class="archive-title">
                <?php echo single_term_title('', false); ?> Strains & Products
            </h1>
            
            <div class="strain-type-description">
                <?php 
                $term = get_queried_object();
                $strain_type = strtolower($term->name);
                
                switch($strain_type) {
                    case 'indica':
                        echo '<p><strong>Indica strains</strong> are known for their relaxing, sedating effects. Perfect for evening use, pain relief, and sleep support.</p>';
                        break;
                    case 'sativa':
                        echo '<p><strong>Sativa strains</strong> provide energizing, uplifting effects. Ideal for daytime use, creativity, and social activities.</p>';
                        break;
                    case 'hybrid':
                        echo '<p><strong>Hybrid strains</strong> combine indica and sativa genetics for balanced effects. Offering the best of both worlds.</p>';
                        break;
                    default:
                        if (term_description()) {
                            echo '<div class="archive-description">' . term_description() . '</div>';
                        }
                }
                ?>
            </div>
        </header>

        <div class="strain-products-grid">
            <?php if (have_posts()) : ?>
                <?php while (have_posts()) : the_post(); ?>
                    <div class="strain-product-card">
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
                            
                            <div class="product-type">
                                <?php 
                                $product_types = get_the_terms(get_the_ID(), 'product_type');
                                if ($product_types) {
                                    foreach ($product_types as $type) {
                                        echo '<span class="product-type-badge">' . esc_html($type->name) . '</span>';
                                    }
                                }
                                ?>
                            </div>
                            
                            <?php if (get_field('lab_results')) : ?>
                                <div class="lab-results-preview">
                                    <?php 
                                    $lab_results = get_field('lab_results');
                                    if ($lab_results['thc_percentage']) {
                                        echo '<span class="thc">THC: ' . $lab_results['thc_percentage'] . '%</span>';
                                    }
                                    if ($lab_results['cbd_percentage']) {
                                        echo '<span class="cbd">CBD: ' . $lab_results['cbd_percentage'] . '%</span>';
                                    }
                                    ?>
                                </div>
                            <?php endif; ?>
                            
                            <?php 
                            $effects = get_the_terms(get_the_ID(), 'effect');
                            if ($effects) {
                                echo '<div class="effects-preview">';
                                $effect_count = 0;
                                foreach ($effects as $effect) {
                                    if ($effect_count < 3) {
                                        echo '<span class="effect-tag">' . esc_html($effect->name) . '</span>';
                                        $effect_count++;
                                    }
                                }
                                echo '</div>';
                            }
                            ?>
                            
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
                <p>No <?php echo strtolower(single_term_title('', false)); ?> products available at this time.</p>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php get_footer(); ?>