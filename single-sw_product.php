<?php
/**
 * Single template for sw_product CPT
 */
get_header();

while ( have_posts() ) : the_post();
    $product_id = get_the_ID();
    $title = get_the_title();

    // Load related strain safely
    $strain_post = null;
    if ( function_exists( 'get_field' ) ) {
        $strain_post = get_field( 'related_strain', $product_id );
    } else {
        $related = get_post_meta( $product_id, 'related_strain', true );
        if ( $related ) {
            $strain_post = get_post( $related );
        }
    }

    $thc = function_exists( 'get_field' ) ? get_field( 'thc_percent', $product_id ) : get_post_meta( $product_id, 'thc_percent', true );

    ?>

    <main id="primary" class="site-main">
        <article class="product-single">
            <header class="entry-header">
                <h1 class="entry-title"><?php echo esc_html( $title ); ?></h1>
            </header>

            <div class="product-single-inner">
                <div class="product-media">
                    <?php if ( has_post_thumbnail( $product_id ) ) { the_post_thumbnail( 'large' ); } elseif ( $strain_post && has_post_thumbnail( $strain_post->ID ) ) { echo get_the_post_thumbnail( $strain_post->ID, 'large' ); } else { echo '<i class="fas fa-cannabis"></i>'; } ?>
                </div>
                <div class="product-summary">
                    <div class="product-meta">
                        <p><strong>THC %:</strong> <?php echo esc_html( $thc ); ?></p>
                        <p><strong>Weight:</strong> <?php echo esc_html( get_post_meta( $product_id, 'weight', true ) ); ?></p>
                    </div>

                    <?php if ( $strain_post ) : ?>
                        <section class="strain-details">
                            <h2>Strain Details</h2>
                            <?php
                                $genetics = function_exists( 'get_field' ) ? get_field( 'genetics', $strain_post->ID ) : get_post_meta( $strain_post->ID, 'genetics', true );
                                if ( $genetics ) echo '<p><strong>Genetics:</strong> ' . esc_html( $genetics ) . '</p>';
                                $nose = function_exists( 'get_field' ) ? get_field( 'nose', $strain_post->ID ) : get_post_meta( $strain_post->ID, 'nose', true );
                                if ( $nose ) echo '<p><strong>Aroma:</strong> ' . esc_html( $nose ) . '</p>';
                            ?>
                        </section>
                    <?php else : ?>
                        <p class="notice">No linked strain information. Please link this product to a Strain post.</p>
                    <?php endif; ?>
                </div>
            </div>
        </article>
    </main>

<?php
endwhile;

get_footer();
