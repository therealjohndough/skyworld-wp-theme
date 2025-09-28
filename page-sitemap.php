<?php
/**
 * Template Name: Sitemap
 * A simple site map for Skyworld Child Theme
 */
get_header();
?>
<main class="site-main site-sitemap">
    <h1>Site Map</h1>
    <ul>
        <li><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Home</a></li>
        <li><a href="<?php echo esc_url( home_url( '/our-flower/' ) ); ?>">Strain Archive</a></li>
        <li><a href="<?php echo esc_url( home_url( '/products/' ) ); ?>">Product Archive</a></li>
        <li><a href="<?php echo esc_url( home_url( '/our-story/' ) ); ?>">Our Story</a></li>
        <li><a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>">Contact</a></li>
        <li><a href="<?php echo esc_url( home_url( '/where-to-find-us/' ) ); ?>">Where to Find Us</a></li>
        <li><a href="<?php echo esc_url( home_url( '/coas/' ) ); ?>">COAs</a></li>
    </ul>

    <h2>Strains</h2>
    <ul>
        <?php $strains = get_posts( array( 'post_type' => 'strain', 'posts_per_page' => -1 ) );
        foreach ( $strains as $strain ) : ?>
            <li><a href="<?php echo esc_url( get_permalink( $strain ) ); ?>"><?php echo esc_html( get_the_title( $strain ) ); ?></a></li>
        <?php endforeach; ?>
    </ul>

    <h2>Products</h2>
    <ul>
        <?php $products = get_posts( array( 'post_type' => 'sw-product', 'posts_per_page' => -1 ) );
        foreach ( $products as $prod ) : ?>
            <li><a href="<?php echo esc_url( get_permalink( $prod ) ); ?>"><?php echo esc_html( get_the_title( $prod ) ); ?></a></li>
        <?php endforeach; ?>
    </ul>

    <h2>Categories</h2>
    <ul>
        <?php foreach ( get_terms( array( 'taxonomy' => 'product_category', 'hide_empty' => false ) ) as $cat ) : ?>
            <li><a href="<?php echo esc_url( get_term_link( $cat ) ); ?>"><?php echo esc_html( $cat->name ); ?></a></li>
        <?php endforeach; ?>
    </ul>

    <h2>Growth Types</h2>
    <ul>
        <?php foreach ( get_terms( array( 'taxonomy' => 'growth_type', 'hide_empty' => false ) ) as $type ) : ?>
            <li><a href="<?php echo esc_url( get_term_link( $type ) ); ?>"><?php echo esc_html( $type->name ); ?></a></li>
        <?php endforeach; ?>
    </ul>

    <hr />
    <h2>Theme Development Highlights</h2>
    <ul>
        <li>Custom templates: <code>archive-strain.php</code>, <code>single-strain.php</code>, <code>archive-product.php</code>, <code>single-product.php</code>, <code>front-page.php</code>, <code>index.php</code></li>
        <li>Partial components: <code>template-parts/cards/strain-card.php</code>, <code>template-parts/cards/product-card.php</code>, <code>template-parts/grids/related-products-grid.php</code></li>
        <li>Custom styles: <code>style.css</code>, <code>css/skyworld-core.css</code></li>
        <li>Tabler Icons system integrated</li>
        <li>Astra Hook Compatibility</li>
        <li>No cart required: catalog with COA + terpene info</li>
    </ul>
</main>
<?php get_footer(); ?>
