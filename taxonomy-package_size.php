<?php
/**
 * Archive template for Package Sizes/Weights
 * URL: /sizes/3-5g/ or /sizes/6-pack/
 */

get_header(); ?>

<div class="container">
    <div class="package-size-archive">
        <header class="archive-header">
            <h1 class="archive-title">
                <?php echo single_term_title('', false); ?> Products
            </h1>
            
            <?php if (term_description()) : ?>
                <div class="archive-description">
                    <?php echo term_description(); ?>
                </div>
            <?php endif; ?>
        </header>

        <div class="size-products-grid">
            <?php if (have_posts()) : ?>
                <?php while (have_posts()) : the_post(); ?>
                    <div class="size-product-card">
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
                            
                            <div class="product-meta">
                                <?php 
                                $product_types = get_the_terms(get_the_ID(), 'product_type');
                                $strain_types = get_the_terms(get_the_ID(), 'strain_type');
                                
                                if ($product_types) {
                                    echo '<span class="product-type">' . esc_html($product_types[0]->name) . '</span>';
                                }
                                
                                if ($strain_types) {
                                    echo '<span class="strain-type strain-' . esc_attr($strain_types[0]->slug) . '">' . esc_html($strain_types[0]->name) . '</span>';
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
                <p>No products available in this size.</p>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php get_footer(); ?>