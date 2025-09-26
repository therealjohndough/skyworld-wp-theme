<?php
/**
 * Archive template for sky_product CPT
 */
get_header();
?>

<main id="primary" class="site-main">
    <header class="archive-header">
        <div class="archive-intro" style="text-align:center; padding:2rem 1rem;">
            <h1><?php echo esc_html( get_theme_mod( 'archive_headline', 'Our Products' ) ); ?></h1>
            <p class="hero-lead"><?php echo esc_html( get_theme_mod( 'archive_subhead', 'Discover our selection' ) ); ?></p>
        </div>
    </header>

    <div class="grid-container">
        <div id="product-grid">
            <?php
            $args = array(
                'post_type' => 'sky_product',
                'posts_per_page' => -1,
            );

            $q = new WP_Query( $args );

            if ( $q->have_posts() ) :
                while ( $q->have_posts() ) : $q->the_post();
                    $product_id = get_the_ID();
                    $title = get_the_title();

                    // Get ACF related strain (guarded)
                    $strain_post = null;
                    if ( function_exists( 'get_field' ) ) {
                        $strain_post = get_field( 'related_strain', $product_id );
                    } else {
                        $related = get_post_meta( $product_id, 'related_strain', true );
                        if ( $related ) {
                            $strain_post = get_post( $related );
                        }
                    }

                    // THC and name for data attributes
                    $thc = '';
                    if ( function_exists( 'get_field' ) ) {
                        $thc = get_field( 'thc_percent', $product_id );
                    } else {
                        $thc = get_post_meta( $product_id, 'thc_percent', true );
                    }

                    $batch = function_exists( 'get_field' ) ? get_field( 'batch_number', $product_id ) : get_post_meta( $product_id, 'batch_number', true );
                    $data_name = $title;

                    // Image fallback: product thumbnail then strain thumbnail
                    $thumb_html = '';
                    if ( has_post_thumbnail( $product_id ) ) {
                        $thumb_html = get_the_post_thumbnail( $product_id, 'large' );
                    } elseif ( $strain_post && has_post_thumbnail( $strain_post->ID ) ) {
                        $thumb_html = get_the_post_thumbnail( $strain_post->ID, 'large' );
                    }
                    ?>

                    <article class="product-card <?php echo esc_attr( get_post_meta( $product_id, 'strain_type', true ) ); ?>" data-thc="<?php echo esc_attr( $thc ); ?>" data-name="<?php echo esc_attr( $data_name ); ?>" data-batch="<?php echo esc_attr( $batch ); ?>">
                        <div class="product-image">
                            <?php if ( $thumb_html ) { echo $thumb_html; } else { echo '<i class="fas fa-cannabis"></i>'; } ?>
                        </div>
                        <div class="product-content">
                            <?php
                            $strain_label = '';
                            if ( $strain_post ) {
                                // Try to get strain type from strain post meta or product meta
                                $strain_label = get_post_meta( $product_id, 'strain_type', true );
                            }
                            if ( $strain_label ) {
                                echo '<span class="strain-type ' . esc_attr( strtolower( $strain_label ) . '-type' ) . '">' . esc_html( $strain_label ) . '</span>';
                            }
                            ?>
                            <h3 class="product-title"><?php echo esc_html( $title ); ?></h3>
                            <?php if ( $strain_post ) : ?>
                                <p class="strain-name"><?php echo esc_html( get_the_title( $strain_post ) ); ?></p>
                            <?php endif; ?>

                            <div class="product-details">
                                <div class="detail-item"><span class="detail-label">Product Type</span><span class="detail-value"><?php echo esc_html( get_post_meta( $product_id, 'product_type', true ) ); ?></span></div>
                                <div class="detail-item"><span class="detail-label">Weight</span><span class="detail-value"><?php echo esc_html( get_post_meta( $product_id, 'weight', true ) ); ?></span></div>
                                <div class="detail-item"><span class="detail-label">THC %</span><span class="detail-value thc-percentage"><?php echo esc_html( $thc ); ?></span></div>
                                <?php if ( $batch ) : ?><div class="detail-item"><span class="detail-label">Batch #</span><span class="detail-value"><?php echo esc_html( $batch ); ?></span></div><?php endif; ?>
                                <div class="detail-item"><span class="detail-label">Terpenes</span><span class="detail-value"><?php echo esc_html( get_post_meta( $product_id, 'pert_total', true ) ); ?></span></div>
                            </div>

                            <?php if ( $strain_post ) :
                                // show short strain excerpt or chosen ACF fields
                                $genetics = function_exists( 'get_field' ) ? get_field( 'genetics', $strain_post->ID ) : get_post_meta( $strain_post->ID, 'genetics', true );
                                if ( $genetics ) {
                                    $strain_number = function_exists( 'get_field' ) ? get_field( 'strain_number', $strain_post->ID ) : get_post_meta( $strain_post->ID, 'strain_number', true );
                                    echo '<div class="strain-info"><h4>Strain Information</h4>';
                                    if ( $strain_number ) {
                                        echo '<p><strong>Strain #:</strong> ' . esc_html( $strain_number ) . '</p>';
                                    }
                                    echo '<p><strong>Genetics:</strong> ' . esc_html( $genetics ) . '</p></div>';
                                }
                            endif; ?>
                        </div>
                    </article>

                <?php
                endwhile;
                wp_reset_postdata();
            else :
                echo '<p>No products found.</p>';
            endif;
            ?>
        </div>
    </div>

</main>

<?php get_footer();
