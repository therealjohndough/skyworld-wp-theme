<?php
/**
 * Skyworld Child Theme Functions
 * Clean, client-friendly cannabis business management
 * NO GUTENBERG - Everything controlled via ACF & Customizer
 */

// DISABLE GUTENBERG COMPLETELY - Client safety first!
add_filter( 'use_block_editor_for_post', '__return_false', 10 );
add_filter( 'use_block_editor_for_post_type', '__return_false', 10 );
remove_theme_support( 'widgets-block-editor' );

// Remove Gutenberg CSS
add_action( 'wp_enqueue_scripts', 'remove_gutenberg_css' );
function remove_gutenberg_css() {
    wp_dequeue_style( 'wp-block-library' );
    wp_dequeue_style( 'wp-block-library-theme' );
    wp_dequeue_style( 'wc-block-style' );
}

// Include all our custom functionality - ORDER MATTERS!
require_once get_stylesheet_directory() . '/inc/post-types.php';
require_once get_stylesheet_directory() . '/inc/acf-fields.php';
require_once get_stylesheet_directory() . '/inc/customizer.php';
require_once get_stylesheet_directory() . '/inc/admin-dashboard.php';
require_once get_stylesheet_directory() . '/inc/seo-manager.php';
require_once get_stylesheet_directory() . '/inc/cannabis-importer.php';
require_once get_stylesheet_directory() . '/inc/asset-manager.php';
require_once get_stylesheet_directory() . '/inc/coa-viewer.php';
require_once get_stylesheet_directory() . '/inc/product-uploader.php';

// Legacy admin interface for backward compatibility
if ( file_exists( get_stylesheet_directory() . '/inc/admin-interface.php' ) ) {
    require_once get_stylesheet_directory() . '/inc/admin-interface.php';
}

// Add WordPress theme support - Professional cannabis theme
add_action( 'after_setup_theme', 'skyworld_cannabis_setup' );
function skyworld_cannabis_setup() {
    // Theme support for professional features
    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'custom-logo' );
    add_theme_support( 'custom-background' );
    add_theme_support( 'customize-selective-refresh-widgets' );
    add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption' ) );
    
    // Navigation menus
    register_nav_menus( array(
        'primary' => 'Primary Navigation',
        'footer' => 'Footer Navigation',
    ) );
    
    // Image sizes for cannabis products
    add_image_size( 'product-thumbnail', 300, 300, true );
    add_image_size( 'strain-hero', 800, 400, true );
}

// Enqueue theme assets with cache busting
add_action( 'wp_enqueue_scripts', 'skyworld_cannabis_assets' );
function skyworld_cannabis_assets() {
    // Main theme stylesheet
    wp_enqueue_style( 'skyworld-style', get_stylesheet_uri(), array(), filemtime( get_stylesheet_directory() . '/style.css' ) );
    
    // Custom cannabis business styles
    wp_enqueue_style( 'skyworld-cannabis', get_stylesheet_directory_uri() . '/assets/css/skyworld.css', array(), filemtime( get_stylesheet_directory() . '/assets/css/skyworld.css' ) );
    
    // COA Viewer styles
    wp_enqueue_style( 'skyworld-coa', get_stylesheet_directory_uri() . '/assets/css/coa-viewer.css', array(), filemtime( get_stylesheet_directory() . '/assets/css/coa-viewer.css' ) );
    
    // Video CTA fallback styles (until you have actual video files)
    wp_enqueue_style( 'skyworld-video-cta', get_stylesheet_directory_uri() . '/assets/css/video-cta-fallback.css', array(), filemtime( get_stylesheet_directory() . '/assets/css/video-cta-fallback.css' ) );
    
    // Custom JavaScript
    wp_enqueue_script( 'skyworld-js', get_stylesheet_directory_uri() . '/assets/js/skyworld.js', array( 'jquery' ), filemtime( get_stylesheet_directory() . '/assets/js/skyworld.js' ), true );
    
    // Phosphor Icons (professional icon system)
    wp_enqueue_style( 'phosphor-icons', 'https://unpkg.com/@phosphor-icons/web@2.0.3/src/regular/style.css', array(), '2.0.3' );
}

// PROFESSIONAL SECURITY FEATURES
// Remove WordPress version from head and feeds for security
remove_action('wp_head', 'wp_generator');
add_filter('the_generator', '__return_empty_string');

// Remove RSD link from head for security
remove_action('wp_head', 'rsd_link');

// Remove wlwmanifest.xml from head
remove_action('wp_head', 'wlwmanifest_link');

// Disable XML-RPC for security
add_filter('xmlrpc_enabled', '__return_false');

// Remove shortlink from head
remove_action('wp_head', 'wp_shortlink_wp_head');

// Hide login errors for security
add_filter('login_errors', function() { return 'Invalid credentials.'; });

// Disable file editing in WordPress admin for security
define('DISALLOW_FILE_EDIT', true);

// Add security headers
add_action('send_headers', 'skyworld_security_headers');
function skyworld_security_headers() {
    header('X-Content-Type-Options: nosniff');
    header('X-Frame-Options: SAMEORIGIN');
    header('X-XSS-Protection: 1; mode=block');
    header('Referrer-Policy: strict-origin-when-cross-origin');
}

// PROFESSIONAL PERFORMANCE FEATURES
// Remove emoji scripts for performance
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');
remove_action('admin_print_scripts', 'print_emoji_detection_script');
remove_action('admin_print_styles', 'print_emoji_styles');

// Disable embeds for performance
remove_action('wp_head', 'wp_oembed_add_discovery_links');
remove_action('wp_head', 'wp_oembed_add_host_js');

// Clean up wp_head
remove_action('wp_head', 'feed_links_extra', 3);
remove_action('wp_head', 'feed_links', 2);
remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);

// Add theme support for features
add_theme_support( 'post-thumbnails' );
add_theme_support( 'title-tag' );
add_theme_support( 'custom-logo' );
add_theme_support( 'html5', array( 'comment-list', 'comment-form', 'search-form', 'gallery', 'caption' ) );

// Set up image sizes for cannabis products
add_image_size( 'product-thumb', 300, 300, true );
add_image_size( 'product-large', 600, 600, true );
add_image_size( 'strain-card', 400, 250, true );

// Clean up WordPress head
remove_action( 'wp_head', 'wp_generator' );
remove_action( 'wp_head', 'wlwmanifest_link' );
remove_action( 'wp_head', 'rsd_link' );

// Custom login logo
function skyworld_login_logo() {
    $logo = get_theme_mod( 'custom_logo' );
    if ( $logo ) {
        $image = wp_get_attachment_image_src( $logo, 'full' );
        echo '<style type="text/css">
            #login h1 a, .login h1 a {
                background-image: url(' . $image[0] . ');
                background-size: contain;
                width: 320px;
                height: 80px;
            }
        </style>';
    }
}
add_action( 'login_enqueue_scripts', 'skyworld_login_logo' );

// Custom login URL
function skyworld_login_url() {
    return home_url();
}
add_filter( 'login_headerurl', 'skyworld_login_url' );

// Age gate functionality from customizer - DISABLED (using front-page.php implementation)
function skyworld_age_gate_script() {
    // This function is disabled in favor of the more sophisticated 
    // age gate implementation in front-page.php
    return;
    
    if ( ! get_theme_mod( 'skyworld_enable_age_gate', true ) ) {
        return;
    }
    
    if ( ! isset( $_COOKIE['skyworld_age_verified'] ) ) {
        ?>
        <div id="age-gate-overlay" style="
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.9);
            z-index: 999999;
            display: flex;
            align-items: center;
            justify-content: center;
        ">
            <div style="
                background: white;
                padding: 40px;
                border-radius: 10px;
                text-align: center;
                max-width: 400px;
                margin: 20px;
            ">
                <h2 style="color: #333; margin-bottom: 20px;"><?php echo esc_html( get_theme_mod( 'skyworld_age_gate_headline', 'Age Verification Required' ) ); ?></h2>
                <p style="color: #666; margin-bottom: 30px;"><?php echo esc_html( get_theme_mod( 'skyworld_age_gate_message', 'You must be 21 years or older to view this website.' ) ); ?></p>
                <button onclick="verifyAge()" style="
                    background: <?php echo get_theme_mod( 'skyworld_primary_color', '#ff793f' ); ?>;
                    color: white;
                    border: none;
                    padding: 12px 30px;
                    border-radius: 5px;
                    font-size: 16px;
                    cursor: pointer;
                    margin-right: 10px;
                ">I'm 21+</button>
                <button onclick="window.location='https://google.com'" style="
                    background: #666;
                    color: white;
                    border: none;
                    padding: 12px 30px;
                    border-radius: 5px;
                    font-size: 16px;
                    cursor: pointer;
                ">Under 21</button>
            </div>
        </div>
        <script>
        function verifyAge() {
            document.cookie = "skyworld_age_verified=true; path=/; max-age=" + (60*60*24*30);
            document.getElementById('age-gate-overlay').style.display = 'none';
        }
        </script>
        <?php
    }
}
add_action( 'wp_footer', 'skyworld_age_gate_script' );

// Add Google Analytics tracking from customizer
add_action( 'wp_head', 'skyworld_google_analytics' );
function skyworld_google_analytics() {
    $ga_id = get_theme_mod( 'skyworld_ga_tracking_id' );
    if ( $ga_id ) {
        ?>
        <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=<?php echo esc_attr( $ga_id ); ?>"></script>
        <script>
          window.dataLayer = window.dataLayer || [];
          function gtag(){dataLayer.push(arguments);}
          gtag('js', new Date());
          gtag('config', '<?php echo esc_js( $ga_id ); ?>');
        </script>
        <?php
    }
}

// Add Google Search Console verification
add_action( 'wp_head', 'skyworld_search_console_verification' );
function skyworld_search_console_verification() {
    $verification_code = get_theme_mod( 'skyworld_search_console_code' );
    if ( $verification_code ) {
        echo '<meta name="google-site-verification" content="' . esc_attr( $verification_code ) . '" />' . "\n";
    }
}

// Add custom meta descriptions
add_action( 'wp_head', 'skyworld_custom_meta_description' );
function skyworld_custom_meta_description() {
    if ( is_home() || is_front_page() ) {
        $description = get_theme_mod( 'skyworld_default_meta_description', 'Premium indoor cannabis cultivation in New York.' );
        echo '<meta name="description" content="' . esc_attr( $description ) . '" />' . "\n";
    }
}

// Add structured data (Schema.org) for cannabis business
add_action( 'wp_head', 'skyworld_structured_data' );
function skyworld_structured_data() {
    if ( ! get_theme_mod( 'skyworld_enable_schema', true ) ) {
        return;
    }
    
    $company_name = get_theme_mod( 'skyworld_company_name', 'Skyworld Cannabis' );
    $phone = get_theme_mod( 'skyworld_phone', '' );
    $email = get_theme_mod( 'skyworld_email', '' );
    
    if ( is_home() || is_front_page() ) {
        ?>
        <script type="application/ld+json">
        {
          "@context": "https://schema.org",
          "@type": "Organization",
          "name": "<?php echo esc_js( $company_name ); ?>",
          "url": "<?php echo esc_js( home_url() ); ?>",
          <?php if ( $phone ) : ?>
          "telephone": "<?php echo esc_js( $phone ); ?>",
          <?php endif; ?>
          <?php if ( $email ) : ?>
          "email": "<?php echo esc_js( $email ); ?>",
          <?php endif; ?>
          "industry": "Cannabis Cultivation",
          "description": "<?php echo esc_js( get_theme_mod( 'skyworld_default_meta_description', 'Premium cannabis cultivation' ) ); ?>"
        }
        </script>
        <?php
    }
    
    // Product schema for individual cannabis products
    if ( is_singular( 'sw_product' ) ) {
        global $post;
        $strain = get_field( 'product_strain', $post->ID );
        $thc = get_field( 'product_thc_percentage', $post->ID );
        $price = get_field( 'product_price', $post->ID );
        $image = get_the_post_thumbnail_url( $post->ID, 'large' );
        
        ?>
        <script type="application/ld+json">
        {
          "@context": "https://schema.org",
          "@type": "Product",
          "name": "<?php echo esc_js( $post->post_title ); ?>",
          "description": "<?php echo esc_js( wp_strip_all_tags( $post->post_content ) ); ?>",
          <?php if ( $image ) : ?>
          "image": "<?php echo esc_js( $image ); ?>",
          <?php endif; ?>
          "category": "Cannabis Product",
          <?php if ( $strain ) : ?>
          "additionalProperty": {
            "@type": "PropertyValue",
            "name": "Strain",
            "value": "<?php echo esc_js( $strain->post_title ); ?>"
          },
          <?php endif; ?>
          <?php if ( $price ) : ?>
          "offers": {
            "@type": "Offer",
            "price": "<?php echo esc_js( $price ); ?>",
            "priceCurrency": "USD"
          },
          <?php endif; ?>
          "brand": {
            "@type": "Brand",
            "name": "<?php echo esc_js( $company_name ); ?>"
          }
        }
        </script>
        <?php
    }
}

// Custom title tags for better SEO
add_filter( 'pre_get_document_title', 'skyworld_custom_title' );
function skyworld_custom_title( $title ) {
    if ( is_home() || is_front_page() ) {
        $custom_title = get_theme_mod( 'skyworld_homepage_title' );
        if ( $custom_title ) {
            return $custom_title;
        }
    }
    
    return $title;
}

// AJAX handlers for store locator
add_action( 'wp_ajax_get_nearby_stores', 'skyworld_get_nearby_stores' );
add_action( 'wp_ajax_nopriv_get_nearby_stores', 'skyworld_get_nearby_stores' );

function skyworld_get_nearby_stores() {
    // Verify nonce for security
    if ( ! wp_verify_nonce( $_POST['nonce'], 'store_locator_nonce' ) ) {
        wp_die( 'Security check failed' );
    }
    
    $lat = floatval( $_POST['lat'] );
    $lng = floatval( $_POST['lng'] );
    $radius = intval( $_POST['radius'] ) ?: 25; // Default 25 miles
    
    // Get all locations
    $locations = get_posts( array(
        'post_type' => 'location',
        'posts_per_page' => -1,
        'post_status' => 'publish'
    ));
    
    $nearby_stores = array();
    
    foreach ( $locations as $location ) {
        $store_lat = get_field( 'location_latitude', $location->ID );
        $store_lng = get_field( 'location_longitude', $location->ID );
        
        if ( $store_lat && $store_lng ) {
            $distance = skyworld_calculate_distance( $lat, $lng, $store_lat, $store_lng );
            
            if ( $distance <= $radius ) {
                $nearby_stores[] = array(
                    'id' => $location->ID,
                    'title' => $location->post_title,
                    'address' => get_field( 'location_address', $location->ID ),
                    'phone' => get_field( 'location_phone', $location->ID ),
                    'hours' => get_field( 'location_hours', $location->ID ),
                    'website' => get_field( 'location_website', $location->ID ),
                    'lat' => $store_lat,
                    'lng' => $store_lng,
                    'distance' => round( $distance, 1 )
                );
            }
        }
    }
    
    // Sort by distance
    usort( $nearby_stores, function( $a, $b ) {
        return $a['distance'] <=> $b['distance'];
    });
    
    wp_send_json_success( $nearby_stores );
}

// Calculate distance between two coordinates
function skyworld_calculate_distance( $lat1, $lng1, $lat2, $lng2 ) {
    $earth_radius = 3959; // miles
    
    $delta_lat = deg2rad( $lat2 - $lat1 );
    $delta_lng = deg2rad( $lng2 - $lng1 );
    
    $a = sin( $delta_lat / 2 ) * sin( $delta_lat / 2 ) +
         cos( deg2rad( $lat1 ) ) * cos( deg2rad( $lat2 ) ) *
         sin( $delta_lng / 2 ) * sin( $delta_lng / 2 );
    
    $c = 2 * atan2( sqrt( $a ), sqrt( 1 - $a ) );
    
    return $earth_radius * $c;
}

// Add admin notice if ACF is not active
add_action( 'admin_notices', 'skyworld_acf_admin_notice' );
function skyworld_acf_admin_notice() {
    if ( ! function_exists( 'get_field' ) ) {
        echo '<div class="notice notice-error">
            <p><strong>Skyworld Theme:</strong> This theme requires Advanced Custom Fields (ACF) plugin to function properly. Please install and activate ACF.</p>
        </div>';
    }
}

// Custom body classes for easier styling
add_filter( 'body_class', 'skyworld_custom_body_classes' );
function skyworld_custom_body_classes( $classes ) {
    // Add cannabis-specific classes
    if ( is_post_type_archive( 'strain' ) || is_singular( 'strain' ) ) {
        $classes[] = 'cannabis-strains';
    }
    
    if ( is_post_type_archive( 'sw_product' ) || is_singular( 'sw_product' ) ) {
        $classes[] = 'cannabis-products';
    }
    
    if ( is_post_type_archive( 'location' ) || is_singular( 'location' ) ) {
        $classes[] = 'cannabis-locations';
    }
    
    return $classes;
}