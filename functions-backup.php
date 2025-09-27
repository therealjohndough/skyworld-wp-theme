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

// Legacy admin interface for backward compatibility
if ( file_exists( get_stylesheet_directory() . '/inc/admin-interface.php' ) ) {
    require_once get_stylesheet_directory() . '/inc/admin-interface.php';
}

// Enqueue child theme assets
add_action( 'wp_enqueue_scripts', 'skyworld_child_enqueue_assets' );
function skyworld_child_enqueue_assets() {
    // Parent theme styles
    wp_enqueue_style('parent-style', get_template_directory_uri() . '/style.css');
    
    // Child theme styles
    wp_enqueue_style('child-style', get_stylesheet_directory_uri() . '/style.css', array('parent-style'));
    wp_enqueue_style('skyworld-css', get_stylesheet_directory_uri() . '/assets/css/skyworld.css', array('child-style'));
    wp_enqueue_style('template-blocks-css', get_stylesheet_directory_uri() . '/assets/css/template-blocks.css', array('skyworld-css'));
    wp_enqueue_style('color-palette-css', get_stylesheet_directory_uri() . '/assets/css/color-palette.css', array('skyworld-css'));
    
    // Page-specific styles
    if (is_page_template('page-store-locator.php')) {
        wp_enqueue_style('store-locator-css', get_stylesheet_directory_uri() . '/assets/css/store-locator.css');
    }
    
    if (is_page_template('page-coa.php')) {
        wp_enqueue_style('coa-css', get_stylesheet_directory_uri() . '/assets/css/coa.css');
    }
    
    // Strain library styles for archive and single strain pages
    if (is_post_type_archive('strain') || is_singular('strain')) {
        wp_enqueue_style('strain-library-css', get_stylesheet_directory_uri() . '/assets/css/strain-library.css');
    }
    
    // Age gate styles and scripts for all pages
    wp_enqueue_style('age-gate-css', get_stylesheet_directory_uri() . '/assets/css/age-gate.css');
    wp_enqueue_script('age-gate-js', get_stylesheet_directory_uri() . '/assets/js/age-gate.js', array('jquery'), '1.0.0', true);
    
    // Enqueue child theme scripts
    wp_enqueue_script('skyworld-js', get_stylesheet_directory_uri() . '/assets/js/skyworld.js', array('jquery'), '1.0.0', true);
    
    // Google Maps API for store locator
    if (is_page_template('page-store-locator.php')) {
        wp_enqueue_script('google-maps', 'https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places', array(), null, true);
        wp_enqueue_script('store-locator-js', get_stylesheet_directory_uri() . '/assets/js/store-locator.js', array('jquery', 'google-maps'), '1.0.0', true);
        
        wp_localize_script('store-locator-js', 'storeLocator', array(
            'ajaxurl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('store_locator_nonce')
        ));
    }
}

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

// Age gate functionality from customizer
function skyworld_age_gate_script() {
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

add_action( 'wp_enqueue_scripts', 'skyworld_child_enqueue_assets' );
function skyworld_child_enqueue_assets() {
    // Enqueue parent theme styles
    wp_enqueue_style('parent-style', get_template_directory_uri() . '/style.css');
    
    // Enqueue child theme styles
    wp_enqueue_style('child-style', get_stylesheet_directory_uri() . '/style.css', array('parent-style'));
    wp_enqueue_style('skyworld-css', get_stylesheet_directory_uri() . '/assets/css/skyworld.css', array('child-style'));
    wp_enqueue_style('template-blocks-css', get_stylesheet_directory_uri() . '/assets/css/template-blocks.css', array('skyworld-css'));
    wp_enqueue_style('color-palette-css', get_stylesheet_directory_uri() . '/assets/css/color-palette.css', array('skyworld-css'));
    
    // Page-specific styles
    if (is_page_template('page-store-locator.php')) {
        wp_enqueue_style('store-locator-css', get_stylesheet_directory_uri() . '/assets/css/store-locator.css');
    }
    
    if (is_page_template('page-coa.php')) {
        wp_enqueue_style('coa-css', get_stylesheet_directory_uri() . '/assets/css/coa.css');
    }
    
    // Strain library styles for archive and single strain pages
    if (is_post_type_archive('strain') || is_singular('strain')) {
        wp_enqueue_style('strain-library-css', get_stylesheet_directory_uri() . '/assets/css/strain-library.css');
    }
    
    // Age gate styles and scripts for all pages
    wp_enqueue_style('age-gate-css', get_stylesheet_directory_uri() . '/assets/css/age-gate.css');
    wp_enqueue_script('age-gate-js', get_stylesheet_directory_uri() . '/assets/js/age-gate.js', array('jquery'), '1.0.0', true);
    
    // Enqueue child theme scripts
    wp_enqueue_script('skyworld-js', get_stylesheet_directory_uri() . '/assets/js/skyworld.js', array('jquery'), '1.0.0', true);
    
    // Google Maps API for store locator
    if (is_page_template('page-store-locator.php')) {
        wp_enqueue_script('google-maps', 'https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places', array(), null, true);
        wp_enqueue_script('store-locator-js', get_stylesheet_directory_uri() . '/assets/js/store-locator.js', array('jquery', 'google-maps'), '1.0.0', true);
        
        // Localize script for AJAX
        wp_localize_script('store-locator-js', 'storeLocator', array(
            'ajaxurl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('store_locator_nonce')
        ));
    }
    
    // COA page scripts
    if (is_page_template('page-coa.php')) {
        wp_enqueue_script('coa-js', get_stylesheet_directory_uri() . '/assets/js/coa.js', array('jquery'), '1.0.0', true);
        
        wp_localize_script('coa-js', 'coaAjax', array(
            'ajaxurl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('coa_nonce')
        ));
    }
}

// Allow SVG uploads (optional convenience)
add_filter( 'upload_mimes', 'skyworld_child_mime_types' );
function skyworld_child_mime_types( $mimes ) {
    $mimes['svg'] = 'image/svg+xml';
    return $mimes;
}

// Include additional functionality files
require_once get_stylesheet_directory() . '/inc/gravity-forms-integration.php';
require_once get_stylesheet_directory() . '/inc/content-blocks.php';


/**
 * Register custom post types and taxonomies for Skyworld
 * Important: avoid using the slug 'product' for the CPT to prevent conflicts with WooCommerce.
 * We use 'sky_product' as the post type and rewrite slug 'products' (URL: /products/)
 */
add_action( 'init', 'skyworld_register_cpts_and_taxonomies' );
function skyworld_register_cpts_and_taxonomies() {
    // Strain CPT (the hub)
    $strain_labels = array(
        'name'               => 'Strains',
        'singular_name'      => 'Strain',
        'menu_name'          => 'Strain Library',
        'name_admin_bar'     => 'Strain',
        'add_new'            => 'Add Strain',
        'add_new_item'       => 'Add New Strain',
        'new_item'           => 'New Strain',
        'edit_item'          => 'Edit Strain',
        'view_item'          => 'View Strain',
        'all_items'          => 'All Strains',
    );

    $strain_args = array(
        'labels'             => $strain_labels,
        'public'             => true,
        'show_in_rest'       => true,
        'has_archive'        => true,
        'rewrite'            => array( 'slug' => 'strains' ),
        'supports'           => array( 'title', 'editor', 'thumbnail', 'excerpt', 'custom-fields' ),
        'menu_position'      => 20,
        'menu_icon'          => 'dashicons-palmtree',
    );

    register_post_type( 'strain', $strain_args );

    // Sky Product CPT (safe alternative to 'product')
    $product_labels = array(
        'name'               => 'Products',
        'singular_name'      => 'Product',
        'menu_name'          => 'Products',
        'name_admin_bar'     => 'Product',
        'add_new'            => 'Add Product',
        'add_new_item'       => 'Add New Product',
        'new_item'           => 'New Product',
        'edit_item'          => 'Edit Product',
        'view_item'          => 'View Product',
        'all_items'          => 'All Products',
    );

    // If WooCommerce or another plugin has already registered the 'product' post type,
    // avoid using the same rewrite slug. Use 'products' normally, otherwise fall back to 'sky-products'.
    $product_rewrite_slug = post_type_exists( 'product' ) ? 'sky-products' : 'products';

    $product_args = array(
        'labels'             => $product_labels,
        'public'             => true,
        'show_in_rest'       => true,
        'has_archive'        => true,
        // rewrite uses a safe slug for pretty URLs but CPT slug remains 'sky_product' to avoid collisions
        'rewrite'            => array( 'slug' => $product_rewrite_slug ),
        'supports'           => array( 'title', 'editor', 'thumbnail', 'excerpt', 'custom-fields' ),
        'menu_position'      => 21,
        'menu_icon'          => 'dashicons-cart',
    );

    register_post_type( 'sky_product', $product_args );

    // Taxonomies for strain: comprehensive genetics system
    
    // Strain Type (Indica, Sativa, Hybrid)
    $strain_type_labels = array(
        'name'          => 'Strain Types',
        'singular_name' => 'Strain Type',
        'search_items'  => 'Search Strain Types',
        'all_items'     => 'All Strain Types',
        'edit_item'     => 'Edit Strain Type',
        'update_item'   => 'Update Strain Type',
        'add_new_item'  => 'Add New Strain Type',
        'new_item_name' => 'New Strain Type Name',
        'menu_name'     => 'Strain Types',
    );

    register_taxonomy( 'strain_type', array( 'strain' ), array(
        'hierarchical'      => true,
        'labels'            => $strain_type_labels,
        'show_ui'           => true,
        'show_in_rest'      => true,
        'rewrite'           => array( 'slug' => 'strain-type' ),
    ) );

    // Effects - Enhanced categories
    $effects_labels = array(
        'name'          => 'Effects',
        'singular_name' => 'Effect',
        'search_items'  => 'Search Effects',
        'all_items'     => 'All Effects',
        'edit_item'     => 'Edit Effect',
        'update_item'   => 'Update Effect',
        'add_new_item'  => 'Add New Effect',
        'new_item_name' => 'New Effect Name',
        'menu_name'     => 'Effects',
    );

    register_taxonomy( 'effects', array( 'strain' ), array(
        'hierarchical'      => true, // Changed to hierarchical for categorization
        'labels'            => $effects_labels,
        'show_ui'           => true,
        'show_in_rest'      => true,
        'rewrite'           => array( 'slug' => 'effects' ),
    ) );

    // Terpenes - Primary flavor/aroma compounds
    $terpene_labels = array(
        'name'          => 'Terpenes',
        'singular_name' => 'Terpene',
        'search_items'  => 'Search Terpenes',
        'all_items'     => 'All Terpenes',
        'edit_item'     => 'Edit Terpene',
        'update_item'   => 'Update Terpene',
        'add_new_item'  => 'Add New Terpene',
        'new_item_name' => 'New Terpene Name',
        'menu_name'     => 'Terpenes',
    );

    register_taxonomy( 'terpene', array( 'strain' ), array(
        'hierarchical'      => false,
        'labels'            => $terpene_labels,
        'show_ui'           => true,
        'show_in_rest'      => true,
        'rewrite'           => array( 'slug' => 'terpenes' ),
    ) );

    // Flavors - Taste profiles
    $flavor_labels = array(
        'name'          => 'Flavors',
        'singular_name' => 'Flavor',
        'search_items'  => 'Search Flavors',
        'all_items'     => 'All Flavors',
        'edit_item'     => 'Edit Flavor',
        'update_item'   => 'Update Flavor',
        'add_new_item'  => 'Add New Flavor',
        'new_item_name' => 'New Flavor Name',
        'menu_name'     => 'Flavors',
    );

    register_taxonomy( 'flavor', array( 'strain' ), array(
        'hierarchical'      => true,
        'labels'            => $flavor_labels,
        'show_ui'           => true,
        'show_in_rest'      => true,
        'rewrite'           => array( 'slug' => 'flavors' ),
    ) );

    // Growing Difficulty
    $difficulty_labels = array(
        'name'          => 'Growing Difficulty',
        'singular_name' => 'Difficulty Level',
        'search_items'  => 'Search Difficulty Levels',
        'all_items'     => 'All Difficulty Levels',
        'edit_item'     => 'Edit Difficulty Level',
        'update_item'   => 'Update Difficulty Level',
        'add_new_item'  => 'Add New Difficulty Level',
        'new_item_name' => 'New Difficulty Level Name',
        'menu_name'     => 'Growing Difficulty',
    );

    register_taxonomy( 'growing_difficulty', array( 'strain' ), array(
        'hierarchical'      => false,
        'labels'            => $difficulty_labels,
        'show_ui'           => true,
        'show_in_rest'      => true,
        'rewrite'           => array( 'slug' => 'difficulty' ),
    ) );

    // Medical Benefits
    $medical_labels = array(
        'name'          => 'Medical Benefits',
        'singular_name' => 'Medical Benefit',
        'search_items'  => 'Search Medical Benefits',
        'all_items'     => 'All Medical Benefits',
        'edit_item'     => 'Edit Medical Benefit',
        'update_item'   => 'Update Medical Benefit',
        'add_new_item'  => 'Add New Medical Benefit',
        'new_item_name' => 'New Medical Benefit Name',
        'menu_name'     => 'Medical Benefits',
    );

    register_taxonomy( 'medical_benefit', array( 'strain' ), array(
        'hierarchical'      => false,
        'labels'            => $medical_labels,
        'show_ui'           => true,
        'show_in_rest'      => true,
        'rewrite'           => array( 'slug' => 'medical-benefits' ),
    ) );

}

/**
 * Register product-focused taxonomies for better structured querying / AI search.
 * - product_category: hierarchical (flower, pre-roll, concentrate, edibles, etc.)
 * - product_feature: non-hierarchical tags (lab-tested, organic, indoor, limited-edition)
 * - cannabinoid_profile: non-hierarchical tags to classify THC/CBD ranges (High-THC, Low-CBD, Balanced)
 */
add_action( 'init', 'skyworld_register_product_taxonomies', 20 );
function skyworld_register_product_taxonomies() {
    // product_category (hierarchical)
    $pc_labels = array(
        'name' => 'Product Categories',
        'singular_name' => 'Product Category',
        'search_items' => 'Search Product Categories',
        'all_items' => 'All Product Categories',
        'edit_item' => 'Edit Product Category',
        'update_item' => 'Update Product Category',
        'add_new_item' => 'Add New Product Category',
        'new_item_name' => 'New Product Category Name',
        'menu_name' => 'Product Categories',
    );

        // Register custom menu location for Skyworld main navigation
        function skyworld_register_menus() {
            register_nav_menus( array(
                'skyworld_main_menu' => __( 'Skyworld Main Menu', 'skyworld' ),
            ) );
        }
        add_action( 'after_setup_theme', 'skyworld_register_menus' );
    register_taxonomy( 'product_category', array( 'sky_product' ), array(
        'hierarchical' => true,
        'labels' => $pc_labels,
        'show_ui' => true,
        'show_in_rest' => true,
        'rewrite' => array( 'slug' => 'product-category' ),
    ) );

    // product_feature (tags)
    $pf_labels = array(
        'name' => 'Product Features',
        'singular_name' => 'Product Feature',
        'search_items' => 'Search Product Features',
        'all_items' => 'All Product Features',
        'edit_item' => 'Edit Product Feature',
        'update_item' => 'Update Product Feature',
        'add_new_item' => 'Add New Product Feature',
        'new_item_name' => 'New Product Feature Name',
        'menu_name' => 'Product Features',
    );

    register_taxonomy( 'product_feature', array( 'sky_product' ), array(
        'hierarchical' => false,
        'labels' => $pf_labels,
        'show_ui' => true,
        'show_in_rest' => true,
        'rewrite' => array( 'slug' => 'product-feature' ),
    ) );

    // cannabinoid_profile (tags for AI-friendly labeling like High-THC, Balanced, High-CBD)
    $cp_labels = array(
        'name' => 'Cannabinoid Profiles',
        'singular_name' => 'Cannabinoid Profile',
        'search_items' => 'Search Cannabinoid Profiles',
        'all_items' => 'All Cannabinoid Profiles',
        'edit_item' => 'Edit Cannabinoid Profile',
        'update_item' => 'Update Cannabinoid Profile',
        'add_new_item' => 'Add New Cannabinoid Profile',
        'new_item_name' => 'New Cannabinoid Profile Name',
        'menu_name' => 'Cannabinoid Profiles',
    );

    register_taxonomy( 'cannabinoid_profile', array( 'sky_product' ), array(
        'hierarchical' => false,
        'labels' => $cp_labels,
        'show_ui' => true,
        'show_in_rest' => true,
        'rewrite' => array( 'slug' => 'cannabinoid-profile' ),
    ) );
}


/**
 * Output JSON-LD Product schema for sky_product single pages to aid AI and search engines.
 * Uses ACF fields (if present) and post meta as available.
 */
add_action( 'wp_head', 'skyworld_output_product_schema' );
function skyworld_output_product_schema() {
    if ( ! is_singular( 'sky_product' ) ) {
        return;
    }

    global $post;

    // Basic fields
    $name = get_the_title( $post );
    $description = wp_strip_all_tags( get_the_excerpt( $post ) ? get_the_excerpt( $post ) : get_the_content( null, false, $post ) );
    $image = get_the_post_thumbnail_url( $post, 'full' );

    // ACF-friendly getters with fallbacks to post meta
    $get = function( $key ) use ( $post ) {
        if ( function_exists( 'get_field' ) ) {
            $v = get_field( $key, $post->ID );
            if ( $v !== null && $v !== false && $v !== '' ) {
                return $v;
            }
        }
        $meta = get_post_meta( $post->ID, $key, true );
        return $meta !== '' ? $meta : null;
    };

    $batch = $get( 'batch_number' );
    $thc = $get( 'thc_percent' );
    $weight = $get( 'weight' );
    $coa = $get( 'coa_pdf' );

    // Related strain (ACF post_object) -> title if available
    $related_strain = $get( 'related_strain' );
    $strain_name = null;
    if ( $related_strain ) {
        if ( is_array( $related_strain ) && ! empty( $related_strain['ID'] ) ) {
            $strain_name = get_the_title( $related_strain['ID'] );
        } elseif ( is_numeric( $related_strain ) ) {
            $strain_name = get_the_title( intval( $related_strain ) );
        }
    }

    // Taxonomy terms
    $categories = wp_get_post_terms( $post->ID, 'product_category', array( 'fields' => 'names' ) );
    $features = wp_get_post_terms( $post->ID, 'product_feature', array( 'fields' => 'names' ) );
    $profiles = wp_get_post_terms( $post->ID, 'cannabinoid_profile', array( 'fields' => 'names' ) );

    $schema = array(
        '@context' => 'https://schema.org/',
        '@type' => 'Product',
        'name' => $name,
        'description' => $description,
    );

    if ( $image ) {
        $schema['image'] = array( $image );
    }
    if ( $batch ) {
        $schema['sku'] = (string) $batch;
    }
    if ( $strain_name ) {
        $schema['isRelatedTo'] = array( '@type' => 'Product', 'name' => $strain_name );
    }

    // Add additionalProperty entries for structured numeric/text attributes
    $additional = array();
    if ( $thc ) {
        $additional[] = array( '@type' => 'PropertyValue', 'name' => 'THC %', 'value' => (string) $thc );
    }
    if ( $weight ) {
        $additional[] = array( '@type' => 'PropertyValue', 'name' => 'Weight', 'value' => (string) $weight );
    }
    if ( $coa ) {
        $additional[] = array( '@type' => 'PropertyValue', 'name' => 'COA', 'value' => (string) $coa );
    }
    if ( ! empty( $categories ) ) {
        $schema['category'] = $categories;
    }
    if ( ! empty( $features ) ) {
        $schema['keywords'] = implode( ', ', $features );
    }
    if ( ! empty( $profiles ) ) {
        $additional[] = array( '@type' => 'PropertyValue', 'name' => 'Cannabinoid Profile', 'value' => implode( ', ', $profiles ) );
    }
    if ( ! empty( $additional ) ) {
        $schema['additionalProperty'] = $additional;
    }

    // Output JSON-LD
    echo "\n<script type=\"application/ld+json\">" . wp_json_encode( $schema ) . "</script>\n";
}

/**
 * Gravity Forms Integration with Brevo (Sendinblue) Email Service
 */

// Add Brevo integration for Gravity Forms
add_action( 'gform_after_submission', 'skyworld_integrate_brevo', 10, 2 );
function skyworld_integrate_brevo( $entry, $form ) {
    // Only process forms with specific IDs (newsletter, contact, etc.)
    $newsletter_form_ids = array( 1, 2, 3 ); // Replace with actual form IDs
    
    if ( ! in_array( $form['id'], $newsletter_form_ids ) ) {
        return;
    }
    
    // Get email field value
    $email = '';
    $name = '';
    
    foreach ( $form['fields'] as $field ) {
        if ( $field->type === 'email' ) {
            $email = rgar( $entry, $field->id );
        }
        if ( $field->type === 'name' ) {
            $name = rgar( $entry, $field->id );
        } elseif ( $field->type === 'text' && strpos( strtolower( $field->label ), 'name' ) !== false ) {
            $name = rgar( $entry, $field->id );
        }
    }
    
    if ( empty( $email ) ) {
        return;
    }
    
    // Send to Brevo
    skyworld_add_to_brevo( $email, $name );
}

// Function to add contact to Brevo
function skyworld_add_to_brevo( $email, $name = '' ) {
    $api_key = get_option( 'skyworld_brevo_api_key' ); // Store API key in WordPress options
    
    if ( empty( $api_key ) ) {
        error_log( 'Skyworld: Brevo API key not configured' );
        return false;
    }
    
    $url = 'https://api.brevo.com/v3/contacts';
    
    $data = array(
        'email' => $email,
        'attributes' => array(
            'FIRSTNAME' => $name,
        ),
        'listIds' => array( 1 ), // Replace with your Brevo list ID
        'updateEnabled' => true
    );
    
    $args = array(
        'headers' => array(
            'accept' => 'application/json',
            'api-key' => $api_key,
            'content-type' => 'application/json'
        ),
        'body' => wp_json_encode( $data ),
        'timeout' => 30
    );
    
    $response = wp_remote_post( $url, $args );
    
    if ( is_wp_error( $response ) ) {
        error_log( 'Skyworld Brevo Error: ' . $response->get_error_message() );
        return false;
    }
    
    $response_code = wp_remote_retrieve_response_code( $response );
    
    if ( $response_code === 201 || $response_code === 204 ) {
        return true;
    } else {
        $body = wp_remote_retrieve_body( $response );
        error_log( 'Skyworld Brevo API Error: ' . $body );
        return false;
    }
}

// Add admin page for Brevo settings
add_action( 'admin_menu', 'skyworld_brevo_admin_menu' );
function skyworld_brevo_admin_menu() {
    add_options_page(
        'Skyworld Brevo Settings',
        'Brevo Integration',
        'manage_options',
        'skyworld-brevo',
        'skyworld_brevo_settings_page'
    );
}

// Brevo settings page
function skyworld_brevo_settings_page() {
    if ( isset( $_POST['submit'] ) ) {
        update_option( 'skyworld_brevo_api_key', sanitize_text_field( $_POST['brevo_api_key'] ) );
        echo '<div class="notice notice-success"><p>Settings saved!</p></div>';
    }
    
    $api_key = get_option( 'skyworld_brevo_api_key', '' );
    ?>
    <div class="wrap">
        <h1>Skyworld Brevo Integration</h1>
        <form method="post" action="">
            <table class="form-table">
                <tr>
                    <th scope="row">Brevo API Key</th>
                    <td>
                        <input type="text" name="brevo_api_key" value="<?php echo esc_attr( $api_key ); ?>" class="regular-text" />
                        <p class="description">Enter your Brevo (Sendinblue) API key. Get it from your <a href="https://app.brevo.com/settings/keys/api" target="_blank">Brevo dashboard</a>.</p>
                    </td>
                </tr>
            </table>
            <?php submit_button(); ?>
        </form>
        
        <h2>Instructions</h2>
        <ol>
            <li>Sign up for a <a href="https://www.brevo.com/" target="_blank">Brevo account</a></li>
            <li>Get your API key from the Brevo dashboard</li>
            <li>Enter the API key above and save</li>
            <li>Your Gravity Forms will automatically sync with Brevo</li>
        </ol>
    </div>
    <?php
}

/**
 * Custom REST API endpoints for dispensary data
 */
add_action( 'rest_api_init', 'skyworld_register_rest_routes' );
function skyworld_register_rest_routes() {
    register_rest_route( 'skyworld/v1', '/dispensaries', array(
        'methods' => 'GET',
        'callback' => 'skyworld_get_dispensaries',
        'permission_callback' => '__return_true'
    ));
}

// Get dispensaries data (integrate with your data source)
function skyworld_get_dispensaries( $request ) {
    // This is sample data - replace with your actual dispensary data source
    $dispensaries = array(
        array(
            'id' => 1,
            'name' => 'Green Theory',
            'address' => '396 Hancock St, Quincy, MA 02171',
            'phone' => '(617) 328-0420',
            'lat' => 42.2529,
            'lng' => -71.0023,
            'website' => 'https://greentheoryma.com',
            'hours' => array(
                'monday' => '10:00 AM - 9:00 PM',
                'tuesday' => '10:00 AM - 9:00 PM',
                'wednesday' => '10:00 AM - 9:00 PM',
                'thursday' => '10:00 AM - 9:00 PM',
                'friday' => '10:00 AM - 9:00 PM',
                'saturday' => '10:00 AM - 9:00 PM',
                'sunday' => '10:00 AM - 8:00 PM'
            )
        )
        // Add more dispensaries here
    );
    
    return rest_ensure_response( $dispensaries );
}

/**
 * Add custom body classes for age gate and other features
 */
add_filter( 'body_class', 'skyworld_add_body_classes' );
function skyworld_add_body_classes( $classes ) {
    // Add age gate class
    if ( ! isset( $_COOKIE['skyworld_age_verified'] ) ) {
        $classes[] = 'age-gate-required';
    }
    
    // Add page-specific classes
    if ( is_page_template( 'page-store-locator.php' ) ) {
        $classes[] = 'store-locator-page';
    }
    
    if ( is_page_template( 'page-coa.php' ) ) {
        $classes[] = 'coa-page';
    }
    
    return $classes;
}

