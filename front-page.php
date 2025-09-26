<?php
/**
 * Front Page Template for Skyworld WP Child
 * Template Name: Skyworld Catalog Front Page
 */
get_header();
?>

<div id="skyworld-catalog" class="site-main">
    <header>
        <div class="header-content">
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="logo">Skyworld</a>
            <button class="theme-toggle" id="themeToggle">
                <i class="fas fa-moon"></i>
            </button>
        </div>
    </header>

    <section class="hero">
        <h1>Premium Indoor Cultivation</h1>
        <p class="hero-sub">born from a passion for the plant</p>
        <p class="hero-lead">We believe New Yorkers deserve access to consistent, high-quality cannabis grown with expertise and transparency. Our mission is simple: to elevate your cannabis experience through uncompromising quality, rooted right here in NY.</p>
    </section>

    <section class="intro site-intro">
        <div class="coas-link">
            <a href="#" class="filter-btn">COAs</a>
        </div>

        <p class="rooted">ROOTED IN THE EMPIRE STATE</p>
        <p class="rooted-lead">We are proud to be a New York cannabis brand, committed to serving our local communities.</p>
    </section>

    <!-- News / Updates -->
    <section class="news-list">
        <h2 class="section-heading">News</h2>
        <div class="news-grid">
            <?php
            // Show latest 3 blog posts
            $news_q = new WP_Query( array( 'post_type' => 'post', 'posts_per_page' => 3 ) );
            if ( $news_q->have_posts() ) :
                while ( $news_q->have_posts() ) : $news_q->the_post(); ?>
                    <article class="news-card">
                        <h3><?php the_title(); ?></h3>
                        <p class="news-excerpt"><?php echo wp_trim_words( get_the_excerpt(), 30 ); ?></p>
                        <p class="news-meta"><?php echo esc_html( get_the_author() ); ?> / <?php echo get_the_date(); ?></p>
                        <p><a class="learn-more" href="<?php the_permalink(); ?>">Learn More</a></p>
                    </article>
                <?php endwhile;
                wp_reset_postdata();
            else : ?>
                <p>No news yet. Check back soon.</p>
            <?php endif; ?>
        </div>
    </section>

    <!-- About section -->
    <section class="about site-about">
        <h2 class="section-heading">About Skyworld</h2>
        <p class="about-lead">Our name, Skyworld, draws from the Tuscarora tradition, symbolizing a place of origin and return. Just as Skyworld represents a sacred beginning, our flower is cultivated with intention.</p>

        <div class="about-list">
            <div class="about-card">
                <h4>Thoughtful Genetic Selections</h4>
                <p class="muted">We focus on cultivating exclusive genetics that you won’t find anywhere else.</p>
            </div>
            <div class="about-card">
                <h4>Indoor Cultivation</h4>
                <p class="muted">True indoor for maximum trichome development and terpene expression.</p>
            </div>
            <div class="about-card">
                <h4>Lab-Tested Purity &amp; Potency</h4>
                <p class="muted">Every batch is lab-tested, confirming what true connoisseurs already know—this is top-shelf, next-level cannabis.</p>
            </div>
        </div>
    </section>

    <div class="controls">
        <div class="filter-buttons">
            <button class="filter-btn active" data-filter="*">All Products</button>
            <button class="filter-btn sativa" data-filter=".sativa">Sativa</button>
            <button class="filter-btn indica" data-filter=".indica">Indica</button>
            <button class="filter-btn hybrid" data-filter=".hybrid">Hybrid</button>
        </div>
        <div class="sort-controls">
            <label for="sort-by-select">Sort by:</label>
            <select id="sort-by-select">
                <option value="name">Name</option>
                <option value="thc">THC %</option>
            </select>
        </div>
    </div>

    <div class="grid-container">
        <div id="product-grid">
            <?php
            // Query sky_product CPT. Show all for now; you can change posts_per_page as needed.
            $prod_q = new WP_Query( array( 'post_type' => 'sky_product', 'posts_per_page' => -1 ) );
            if ( $prod_q->have_posts() ) :
                while ( $prod_q->have_posts() ) : $prod_q->the_post();
                    $pid = get_the_ID();
                    $title = get_the_title();

                    // Guarded ACF lookups with postmeta fallbacks
                    $related_strain = function_exists( 'get_field' ) ? get_field( 'related_strain', $pid ) : get_post_meta( $pid, 'related_strain', true );
                    if ( is_numeric( $related_strain ) ) {
                        $strain_post = get_post( $related_strain );
                    } elseif ( is_object( $related_strain ) ) {
                        $strain_post = $related_strain;
                    } else {
                        $strain_post = null;
                    }

                    $thc = function_exists( 'get_field' ) ? get_field( 'thc_percent', $pid ) : get_post_meta( $pid, 'thc_percent', true );
                    $weight = function_exists( 'get_field' ) ? get_field( 'weight', $pid ) : get_post_meta( $pid, 'weight', true );
                    $coa = function_exists( 'get_field' ) ? get_field( 'coa_pdf', $pid ) : get_post_meta( $pid, 'coa_pdf', true );
                    $batch = function_exists( 'get_field' ) ? get_field( 'batch_number', $pid ) : get_post_meta( $pid, 'batch_number', true );

                    // Attempt to determine a simple product class (sativa/indica/hybrid) from product meta or strain meta
                    $ptype = function_exists( 'get_field' ) ? get_field( 'type', $pid ) : get_post_meta( $pid, 'type', true );
                    if ( empty( $ptype ) && $strain_post ) {
                        $ptype = get_post_meta( $strain_post->ID, 'type', true );
                    }
                    $ptype_class = $ptype ? esc_attr( strtolower( preg_replace('/[^a-z0-9]+/','-', $ptype ) ) ) : '';

                    // Prepare image: prefer product thumbnail, then strain thumbnail
                    ob_start();
                    if ( has_post_thumbnail( $pid ) ) {
                        echo get_the_post_thumbnail( $pid, 'medium' );
                    } elseif ( $strain_post && has_post_thumbnail( $strain_post->ID ) ) {
                        echo get_the_post_thumbnail( $strain_post->ID, 'medium' );
                    } else {
                        echo '<i class="fas fa-cannabis"></i>';
                    }
                    $img_html = ob_get_clean();
                    ?>

                    <div class="product-card <?php echo $ptype_class; ?>" data-thc="<?php echo esc_attr( $thc ); ?>" data-name="<?php echo esc_attr( $title ); ?>" data-batch="<?php echo esc_attr( $batch ); ?>">
                        <div class="product-image"><?php echo $img_html; ?></div>
                        <div class="product-content">
                            <?php if ( $ptype ) : ?><span class="strain-type"><?php echo esc_html( $ptype ); ?></span><?php endif; ?>
                            <h3 class="product-title"><?php echo esc_html( $title ); ?></h3>
                            <?php if ( $strain_post ) : ?><p class="strain-name"><?php echo esc_html( get_the_title( $strain_post ) ); ?></p><?php endif; ?>

                            <div class="product-details">
                                <div class="detail-item"><span class="detail-label">Product Type</span><span class="detail-value"><?php echo esc_html( get_post_meta( $pid, 'product_type', true ) ); ?></span></div>
                                <div class="detail-item"><span class="detail-label">Weight</span><span class="detail-value"><?php echo esc_html( $weight ); ?></span></div>
                                <div class="detail-item"><span class="detail-label">THC %</span><span class="detail-value thc-percentage"><?php echo esc_html( $thc ); ?>%</span></div>
                                <div class="detail-item"><span class="detail-label">Terpenes</span><span class="detail-value">
                                    <?php
                                        if ( $strain_post ) {
                                            $terps = get_the_terms( $strain_post->ID, 'terpene' );
                                            if ( $terps && ! is_wp_error( $terps ) ) {
                                                $names = wp_list_pluck( $terps, 'name' );
                                                echo esc_html( implode( ', ', $names ) );
                                            }
                                        }
                                    ?>
                                </span></div>
                            </div>

                            <?php if ( $strain_post ) : ?>
                                <div class="strain-info">
                                    <h4>Strain Information</h4>
                                    <?php
                                        $genetics = function_exists( 'get_field' ) ? get_field( 'genetics', $strain_post->ID ) : get_post_meta( $strain_post->ID, 'genetics', true );
                                        $nose = function_exists( 'get_field' ) ? get_field( 'nose', $strain_post->ID ) : get_post_meta( $strain_post->ID, 'nose', true );
                                        $strain_number = function_exists( 'get_field' ) ? get_field( 'strain_number', $strain_post->ID ) : get_post_meta( $strain_post->ID, 'strain_number', true );
                                        if ( $strain_number ) echo '<p><strong>Strain #:</strong> ' . esc_html( $strain_number ) . '</p>';
                                        if ( $genetics ) echo '<p><strong>Genetics:</strong> ' . esc_html( $genetics ) . '</p>';
                                        if ( $nose ) echo '<p><strong>Aroma:</strong> ' . esc_html( $nose ) . '</p>';
                                    ?>
                                    <div class="terpenes">
                                        <?php
                                            if ( $terps && ! is_wp_error( $terps ) ) {
                                                foreach ( $terps as $t ) {
                                                    echo '<span class="terpene-tag">' . esc_html( $t->name ) . '</span>';
                                                }
                                            }
                                        ?>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <div class="product-actions">
                                <?php
                                // COA: product-level COA preferred, otherwise strain-level COA
                                $coa_url = $coa;
                                if ( empty( $coa_url ) && $strain_post ) {
                                    $coa_url = function_exists( 'get_field' ) ? get_field( 'coa_link', $strain_post->ID ) : get_post_meta( $strain_post->ID, 'coa_link', true );
                                }
                                if ( $coa_url ) : ?>
                                    <a class="coa-link" href="<?php echo esc_url( $coa_url ); ?>" target="_blank" rel="noopener noreferrer">View COA</a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                <?php endwhile;
                wp_reset_postdata();
            else : ?>
                <p>No products found.</p>
            <?php endif; ?>

        </div>
    </div>

    <footer>
        <p>&copy; <?php echo date('Y'); ?> Skyworld Cannabis. All rights reserved.</p>
    </footer>
</div>

<?php get_footer();
