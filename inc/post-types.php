<?php
/**
 * Robust Cannabis Industry Post Types & Taxonomies
 * Clean, scalable architecture for Skyworld
 */

// Register Custom Post Types
add_action( 'init', 'skyworld_register_post_types' );
function skyworld_register_post_types() {
    
    // STRAINS - Genetic library
    register_post_type( 'strain', array(
        'labels' => array(
            'name' => 'Strains',
            'singular_name' => 'Strain',
            'add_new' => 'Add New Strain',
            'add_new_item' => 'Add New Strain',
            'edit_item' => 'Edit Strain',
            'new_item' => 'New Strain',
            'view_item' => 'View Strain',
            'search_items' => 'Search Strains',
        ),
        'public' => true,
        'has_archive' => true,
        'rewrite' => array( 'slug' => 'strain-library' ),
        'supports' => array( 'title', 'editor', 'thumbnail', 'excerpt' ),
        'menu_icon' => 'dashicons-carrot',
        'show_in_rest' => true,
    ));

    // PRODUCTS - Cannabis products (flower, pre-rolls, etc) - Using safe URL slug
    register_post_type( 'sw-product', array(
        'labels' => array(
            'name' => 'Cannabis Products',
            'singular_name' => 'Product',
            'add_new' => 'Add New Product',
            'add_new_item' => 'Add New Product',
            'edit_item' => 'Edit Product',
            'new_item' => 'New Product',
            'view_item' => 'View Product',
            'search_items' => 'Search Products',
            'menu_name' => 'Cannabis Products',
        ),
        'public' => true,
        'has_archive' => true,
        'rewrite' => array( 'slug' => 'cannabis-products' ),
        'supports' => array( 'title', 'editor', 'thumbnail', 'excerpt' ),
        'menu_icon' => 'dashicons-cannabis',
        'show_in_rest' => true,
        'menu_position' => 20,
    ));

    // LOCATIONS - Dispensary/retailer locations
    register_post_type( 'location', array(
        'labels' => array(
            'name' => 'Locations',
            'singular_name' => 'Location',
            'add_new' => 'Add New Location',
            'add_new_item' => 'Add New Location',
            'edit_item' => 'Edit Location',
            'new_item' => 'New Location',
            'view_item' => 'View Location',
            'search_items' => 'Search Locations',
        ),
        'public' => true,
        'has_archive' => true,
        'rewrite' => array( 'slug' => 'locations' ),
        'supports' => array( 'title', 'editor', 'thumbnail' ),
        'menu_icon' => 'dashicons-location-alt',
        'show_in_rest' => true,
    ));
}

// Register Taxonomies
add_action( 'init', 'skyworld_register_taxonomies' );
function skyworld_register_taxonomies() {
    
    // STRAIN TYPE - Indica, Sativa, Hybrid with archives
    register_taxonomy( 'strain_type', array( 'strain', 'sw-product' ), array(
        'labels' => array(
            'name' => 'Strain Types',
            'singular_name' => 'Strain Type',
            'add_new_item' => 'Add New Strain Type',
            'edit_item' => 'Edit Strain Type',
            'all_items' => 'All Strain Types',
            'view_item' => 'View Strain Type',
            'search_items' => 'Search Strain Types',
        ),
        'hierarchical' => false,
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'show_admin_column' => true,
        'show_in_nav_menus' => true,
        'show_tagcloud' => true,
        'has_archive' => true,
        'rewrite' => array( 'slug' => 'strain-types', 'with_front' => false ),
        'show_in_rest' => true,
    ));

    // PRODUCT TYPE - Flower, Pre-rolls, Hash Holes, etc with archives
    register_taxonomy( 'product_type', array( 'sw-product' ), array(
        'labels' => array(
            'name' => 'Product Types',
            'singular_name' => 'Product Type',
            'add_new_item' => 'Add New Product Type',
            'edit_item' => 'Edit Product Type',
            'all_items' => 'All Product Types',
            'view_item' => 'View Product Type',
            'search_items' => 'Search Product Types',
        ),
        'hierarchical' => true,
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'show_admin_column' => true,
        'show_in_nav_menus' => true,
        'has_archive' => true,
        'rewrite' => array( 'slug' => 'product-types', 'with_front' => false ),
        'show_in_rest' => true,
    ));

    // TERPENES - Proper terpene taxonomy with archives
    register_taxonomy( 'terpene', array( 'strain', 'sw-product' ), array(
        'labels' => array(
            'name' => 'Terpenes',
            'singular_name' => 'Terpene',
            'add_new_item' => 'Add New Terpene',
            'edit_item' => 'Edit Terpene',
            'all_items' => 'All Terpenes',
            'view_item' => 'View Terpene',
            'search_items' => 'Search Terpenes',
        ),
        'hierarchical' => false,
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'show_admin_column' => true,
        'show_in_nav_menus' => true,
        'show_tagcloud' => true,
        'has_archive' => true,
        'rewrite' => array( 'slug' => 'terpenes', 'with_front' => false ),
        'show_in_rest' => true,
    ));

    // PACKAGE SIZES/WEIGHTS - Searchable archive
    register_taxonomy( 'package_size', array( 'sw-product' ), array(
        'labels' => array(
            'name' => 'Package Sizes',
            'singular_name' => 'Package Size',
            'add_new_item' => 'Add New Package Size',
            'edit_item' => 'Edit Package Size',
            'all_items' => 'All Package Sizes',
            'view_item' => 'View Package Size',
            'search_items' => 'Search Package Sizes',
        ),
        'hierarchical' => false,
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'show_admin_column' => true,
        'show_in_nav_menus' => true,
        'has_archive' => true,
        'rewrite' => array( 'slug' => 'sizes', 'with_front' => false ),
        'show_in_rest' => true,
    ));

    // CANNABINOIDS - Archive for CBG, CBN, THCV, etc.
    register_taxonomy( 'cannabinoid', array( 'strain', 'sw-product' ), array(
        'labels' => array(
            'name' => 'Cannabinoids',
            'singular_name' => 'Cannabinoid',
            'add_new_item' => 'Add New Cannabinoid',
            'edit_item' => 'Edit Cannabinoid',
            'all_items' => 'All Cannabinoids',
            'view_item' => 'View Cannabinoid',
            'search_items' => 'Search Cannabinoids',
        ),
        'hierarchical' => false,
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'show_admin_column' => true,
        'show_in_nav_menus' => true,
        'has_archive' => true,
        'rewrite' => array( 'slug' => 'cannabinoids', 'with_front' => false ),
        'show_in_rest' => true,
    ));

    // EFFECTS - Cannabis effects with archives
    register_taxonomy( 'effect', array( 'strain', 'sw-product' ), array(
        'labels' => array(
            'name' => 'Effects',
            'singular_name' => 'Effect',
            'add_new_item' => 'Add New Effect',
            'edit_item' => 'Edit Effect',
            'all_items' => 'All Effects',
            'view_item' => 'View Effect',
            'search_items' => 'Search Effects',
        ),
        'hierarchical' => false,
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'show_admin_column' => true,
        'show_in_nav_menus' => true,
        'show_tagcloud' => true,
        'has_archive' => true,
        'rewrite' => array( 'slug' => 'effects', 'with_front' => false ),
        'show_in_rest' => true,
    ));

    // GROWING METHOD - Indoor, Outdoor, Greenhouse
    register_taxonomy( 'growing_method', array( 'strain', 'sw-product' ), array(
        'labels' => array(
            'name' => 'Growing Methods',
            'singular_name' => 'Growing Method',
            'add_new_item' => 'Add New Growing Method',
            'edit_item' => 'Edit Growing Method',
        ),
        'hierarchical' => false,
        'public' => true,
        'show_ui' => true,
        'show_admin_column' => true,
        'rewrite' => array( 'slug' => 'growing-method' ),
        'show_in_rest' => true,
    ));
}

// Add default terms
add_action( 'init', 'skyworld_add_default_terms', 20 );
function skyworld_add_default_terms() {
    // Strain Types
    $strain_types = array( 'Indica', 'Sativa', 'Hybrid' );
    foreach ( $strain_types as $type ) {
        if ( ! term_exists( $type, 'strain_type' ) ) {
            wp_insert_term( $type, 'strain_type' );
        }
    }

    // Product Types
    $product_types = array(
        'Flower' => 'Premium cannabis flower',
        'Pre-rolls' => 'Ready-to-smoke pre-rolled joints',
        'Hash Holes' => 'Premium hash-infused pre-rolls',
        'Concentrates' => 'Cannabis concentrates and extracts',
        'Edibles' => 'Cannabis-infused edibles',
        'Accessories' => 'Cannabis accessories and merchandise'
    );
    foreach ( $product_types as $type => $desc ) {
        if ( ! term_exists( $type, 'product_type' ) ) {
            wp_insert_term( $type, 'product_type', array( 'description' => $desc ) );
        }
    }

    // Common Terpenes
    $terpenes = array(
        'Limonene' => 'Citrusy, uplifting terpene',
        'Myrcene' => 'Relaxing, sedating terpene',
        'Caryophyllene' => 'Spicy, anti-inflammatory terpene',
        'Pinene' => 'Pine-scented, alertness-promoting terpene',
        'Linalool' => 'Floral, calming terpene',
        'Humulene' => 'Woody, appetite-suppressing terpene',
        'Terpinolene' => 'Fresh, herbal terpene',
        'Ocimene' => 'Sweet, herbaceous terpene'
    );
    foreach ( $terpenes as $terpene => $desc ) {
        if ( ! term_exists( $terpene, 'terpene' ) ) {
            wp_insert_term( $terpene, 'terpene', array( 'description' => $desc ) );
        }
    }

    // Effects
    $effects = array( 
        'Relaxed', 'Happy', 'Euphoric', 'Uplifted', 'Focused', 
        'Creative', 'Energetic', 'Sleepy', 'Hungry', 'Giggly',
        'Talkative', 'Aroused', 'Tingly', 'Dry Eyes', 'Dry Mouth'
    );
    foreach ( $effects as $effect ) {
        if ( ! term_exists( $effect, 'effect' ) ) {
            wp_insert_term( $effect, 'effect' );
        }
    }

    // Package Sizes
    $package_sizes = array(
        '0.5g' => 'Half gram',
        '1g' => 'One gram', 
        '3.5g' => 'Eighth ounce (3.5g)',
        '7g' => 'Quarter ounce (7g)',
        '14g' => 'Half ounce (14g)',
        '28g' => 'Full ounce (28g)',
        '2-pack' => 'Two pack pre-rolls',
        '6-pack' => 'Six pack pre-rolls',
        '10-pack' => 'Ten pack pre-rolls',
        '1.5g Hash Hole' => 'Hash hole pre-roll',
        'Variety Pack' => 'Mixed variety pack'
    );
    foreach ( $package_sizes as $size => $desc ) {
        if ( ! term_exists( $size, 'package_size' ) ) {
            wp_insert_term( $size, 'package_size', array( 'description' => $desc ) );
        }
    }

    // Cannabinoids
    $cannabinoids = array(
        'THC' => 'Tetrahydrocannabinol - primary psychoactive compound',
        'CBD' => 'Cannabidiol - non-psychoactive, therapeutic compound',
        'CBG' => 'Cannabigerol - potential antibacterial properties',
        'CBN' => 'Cannabinol - sedating effects, sleep aid',
        'CBC' => 'Cannabichromene - potential anti-inflammatory',
        'THCV' => 'Tetrahydrocannabivarin - appetite suppressant',
        'Delta-8 THC' => 'Delta-8 THC - milder psychoactive effects',
        'CBDA' => 'Cannabidiolic acid - raw CBD precursor',
        'THCA' => 'Tetrahydrocannabinolic acid - raw THC precursor'
    );
    foreach ( $cannabinoids as $cannabinoid => $desc ) {
        if ( ! term_exists( $cannabinoid, 'cannabinoid' ) ) {
            wp_insert_term( $cannabinoid, 'cannabinoid', array( 'description' => $desc ) );
        }
    }
}