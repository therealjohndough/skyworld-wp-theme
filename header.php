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
        <nav class="skyworld-nav" id="skyworldNav">
            <ul class="skyworld-nav-menu">
                <li><a href="<?php echo home_url('/'); ?>" class="skyworld-nav-link <?php echo is_front_page() ? 'active' : ''; ?>">
                    <i class="fas fa-home"></i> Home
                </a></li>
                <li><a href="<?php echo home_url('/strain-library/'); ?>" class="skyworld-nav-link <?php echo is_post_type_archive('strain') || is_singular('strain') ? 'active' : ''; ?>">
                    <i class="fas fa-seedling"></i> Strain Library
                </a></li>
                <li><a href="<?php echo home_url('/store-locator/'); ?>" class="skyworld-nav-link <?php echo is_page('store-locator') ? 'active' : ''; ?>">
                    <i class="fas fa-map-marker-alt"></i> Find Stores
                </a></li>
                <li><a href="<?php echo home_url('/coa/'); ?>" class="skyworld-nav-link <?php echo is_page('coa') ? 'active' : ''; ?>">
                    <i class="fas fa-certificate"></i> Lab Results
                </a></li>
                <li><a href="<?php echo home_url('/wholesale/'); ?>" class="skyworld-nav-link <?php echo is_page('wholesale') ? 'active' : ''; ?>">
                    <i class="fas fa-handshake"></i> Wholesale
                </a></li>
                <li><a href="<?php echo home_url('/about/'); ?>" class="skyworld-nav-link <?php echo is_page('about') ? 'active' : ''; ?>">
                    <i class="fas fa-info-circle"></i> About
                </a></li>
                <li><a href="<?php echo home_url('/careers/'); ?>" class="skyworld-nav-link <?php echo is_page('careers') ? 'active' : ''; ?>">
                    <i class="fas fa-briefcase"></i> Careers
                </a></li>
            </ul>
            
            <!-- Header Actions -->
            <div class="skyworld-header-actions">
                <!-- Dark Mode Toggle -->
                <button class="skyworld-theme-toggle" id="headerThemeToggle" title="Toggle dark mode">
                    <i class="fas fa-moon"></i>
                </button>
                
                <!-- Search Toggle -->
                <button class="skyworld-search-toggle" id="headerSearchToggle" title="Search strains">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </nav>
    </div>
    
    <!-- Search Overlay -->
    <div class="skyworld-search-overlay" id="searchOverlay">
        <div class="skyworld-search-container">
            <form role="search" method="get" class="skyworld-search-form" action="<?php echo home_url('/'); ?>">
                <input type="search" 
                       class="skyworld-search-input" 
                       placeholder="Search strains, effects, flavors..." 
                       value="<?php echo get_search_query(); ?>" 
                       name="s" 
                       title="Search for:" />
                <input type="hidden" name="post_type" value="strain" />
                <button type="submit" class="skyworld-search-submit">
                    <i class="fas fa-search"></i>
                </button>
            </form>
            <button class="skyworld-search-close" id="searchClose">
                <i class="fas fa-times"></i>
            </button>
        </div>
    </div>
</header>

<script>
// Header functionality
document.addEventListener('DOMContentLoaded', function() {
    // Mobile menu toggle
    const mobileToggle = document.getElementById('mobileMenuToggle');
    const nav = document.getElementById('skyworldNav');
    
    if (mobileToggle && nav) {
        mobileToggle.addEventListener('click', function() {
            nav.classList.toggle('active');
            mobileToggle.classList.toggle('active');
        });
    }
    
    // Search overlay
    const searchToggle = document.getElementById('headerSearchToggle');
    const searchOverlay = document.getElementById('searchOverlay');
    const searchClose = document.getElementById('searchClose');
    
    if (searchToggle && searchOverlay) {
        searchToggle.addEventListener('click', function() {
            searchOverlay.classList.add('active');
            const searchInput = searchOverlay.querySelector('.skyworld-search-input');
            if (searchInput) searchInput.focus();
        });
    }
    
    if (searchClose && searchOverlay) {
        searchClose.addEventListener('click', function() {
            searchOverlay.classList.remove('active');
        });
    }
    
    // Close search on escape
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && searchOverlay) {
            searchOverlay.classList.remove('active');
        }
    });
    
    // Theme toggle
    const themeToggle = document.getElementById('headerThemeToggle');
    const themeIcon = themeToggle ? themeToggle.querySelector('i') : null;
    const body = document.body;
    
    if (themeToggle) {
        // Load saved theme
        const savedTheme = localStorage.getItem('skyworld-theme');
        const prefersDark = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
        
        if (savedTheme === 'dark' || (!savedTheme && prefersDark)) {
            body.classList.add('dark-mode');
            if (themeIcon) themeIcon.className = 'fas fa-sun';
        }
        
        themeToggle.addEventListener('click', function() {
            body.classList.toggle('dark-mode');
            
            if (body.classList.contains('dark-mode')) {
                localStorage.setItem('skyworld-theme', 'dark');
                if (themeIcon) themeIcon.className = 'fas fa-sun';
            } else {
                localStorage.setItem('skyworld-theme', 'light');
                if (themeIcon) themeIcon.className = 'fas fa-moon';
            }
        });
    }
});
</script>