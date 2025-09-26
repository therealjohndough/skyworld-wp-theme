<?php
/**
 * skyworld-wp-child functions and definitions
 */

add_action( 'wp_enqueue_scripts', 'skyworld_child_enqueue_styles' );
function skyworld_child_enqueue_styles() {
    $parent_style = get_template_directory_uri() . '/style.css';

    // Enqueue parent style
    wp_enqueue_style( 'parent-style', $parent_style, array(), wp_get_theme( get_template() )->get('Version') );

    // Enqueue child theme stylesheet
    wp_enqueue_style( 'skyworld-child-style', get_stylesheet_directory_uri() . '/assets/css/skyworld.css', array('parent-style'), '1.0.0' );

    // Enqueue child theme JS
    wp_enqueue_script( 'skyworld-child-js', get_stylesheet_directory_uri() . '/assets/js/skyworld.js', array('jquery'), '1.0.0', true );

    // Load Font Awesome from CDN used by the template
    wp_enqueue_style( 'font-awesome-cdn', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css', array(), '6.4.0' );
}

// Allow SVG uploads (optional convenience)
add_filter( 'upload_mimes', 'skyworld_child_mime_types' );
function skyworld_child_mime_types( $mimes ) {
    $mimes['svg'] = 'image/svg+xml';
    return $mimes;
}


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

    // Taxonomies for strain: effects and terpene
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
        'hierarchical'      => false,
        'labels'            => $effects_labels,
        'show_ui'           => true,
        'show_in_rest'      => true,
        'rewrite'           => array( 'slug' => 'effects' ),
    ) );

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

}

// Load local ACF PHP fallback if present (registers fields programmatically)
if ( file_exists( get_stylesheet_directory() . '/inc/acf-fields.php' ) ) {
    require_once get_stylesheet_directory() . '/inc/acf-fields.php';
}

// Include CSV importer utility if present
if ( file_exists( get_stylesheet_directory() . '/inc/importer.php' ) ) {
    require_once get_stylesheet_directory() . '/inc/importer.php';
}
