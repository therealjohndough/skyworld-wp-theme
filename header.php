<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    
    <!-- Professional Cannabis Business Meta -->
    <?php if ( ! function_exists( '_wp_render_title_tag' ) ) : ?>
    <title><?php wp_title( '|', true, 'right' ); ?><?php bloginfo( 'name' ); ?></title>
    <?php endif; ?>
    
    <!-- Professional Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Phosphor Icons CDN -->
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<!-- Professional Cannabis Business Header -->
<header class="site-header" role="banner">
    <div class="skyworld-nav-header">
        <!-- Brand Logo -->
        <div class="skyworld-logo">
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
                <?php if ( has_custom_logo() ) : ?>
                    <?php the_custom_logo(); ?>
                <?php else : ?>
                    <i class="ph ph-leaf" style="color: var(--skyworld-primary); font-size: 1.5rem; margin-right: 0.5rem;"></i>
                    <span class="brand-text"><?php bloginfo( 'name' ); ?></span>
                <?php endif; ?>
            </a>
        </div>

        <!-- Professional Navigation -->
        <nav class="skyworld-nav" role="navigation">
            <?php
            wp_nav_menu( array(
                'theme_location' => 'primary',
                'menu_class'     => 'skyworld-nav-menu',
                'container'      => false,
                'fallback_cb'    => 'skyworld_default_menu',
            ) );
            ?>
        </nav>

        <!-- Mobile Menu Toggle -->
        <button class="mobile-menu-toggle" id="mobileMenuToggle" aria-label="Toggle navigation" aria-expanded="false">
            <span class="hamburger-line"></span>
            <span class="hamburger-line"></span>
            <span class="hamburger-line"></span>
        </button>
    </div>
</header>

<script>
// Mobile menu toggle functionality
document.addEventListener('DOMContentLoaded', function() {
    const mobileToggle = document.getElementById('mobileMenuToggle');
    const nav = document.querySelector('.skyworld-nav');
    
    if (mobileToggle && nav) {
        mobileToggle.addEventListener('click', function() {
            nav.classList.toggle('active');
            mobileToggle.classList.toggle('active');
            
            // Update aria-expanded
            const isExpanded = mobileToggle.classList.contains('active');
            mobileToggle.setAttribute('aria-expanded', isExpanded);
        });
    }
});
</script>

<?php
// Fallback menu if no menu is set
function skyworld_default_menu() {
    echo '<ul class="skyworld-nav-menu">';
    echo '<li><a href="' . esc_url( home_url( '/' ) ) . '"><i class="ph ph-house"></i> Home</a></li>';
    echo '<li><a href="' . esc_url( home_url( '/strains/' ) ) . '"><i class="ph ph-leaf"></i> Strains</a></li>';
    echo '<li><a href="' . esc_url( home_url( '/products/' ) ) . '"><i class="ph ph-package"></i> Products</a></li>';
    echo '<li><a href="' . esc_url( home_url( '/locations/' ) ) . '"><i class="ph ph-map-pin"></i> Locations</a></li>';
    echo '<li><a href="' . esc_url( home_url( '/about/' ) ) . '"><i class="ph ph-info"></i> About</a></li>';
    echo '<li><a href="' . esc_url( home_url( '/contact/' ) ) . '"><i class="ph ph-envelope"></i> Contact</a></li>';
    echo '</ul>';
}
?>