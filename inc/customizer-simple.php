<?php
/**
 * Skyworld Theme Customizer - Simplified Version
 * Basic color controls with live preview (like Astra theme)
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

add_action( 'customize_register', 'skyworld_customize_register' );
function skyworld_customize_register( $wp_customize ) {

    // Add Skyworld Colors section
    $wp_customize->add_section( 'skyworld_colors', array(
        'title' => __('Skyworld Colors', 'skyworld'),
        'priority' => 30,
        'description' => 'Customize your site colors with live preview'
    ));

    // Primary Color
    $wp_customize->add_setting( 'skyworld_primary_color', array(
        'default' => '#2c3e50',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport' => 'refresh',
    ));

    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'skyworld_primary_color', array(
        'label' => __('Primary Color', 'skyworld'),
        'section' => 'skyworld_colors',
        'settings' => 'skyworld_primary_color',
        'description' => 'Used for headings and buttons'
    )));
}

/**
 * Output customizer CSS
 */
function skyworld_customizer_css() {
    $primary_color = get_theme_mod('skyworld_primary_color', '#2c3e50');
    ?>
    <style type="text/css">
        /* Customizer Colors */
        h1, h2, h3, h4, h5, h6 {
            color: <?php echo esc_attr($primary_color); ?> !important;
        }
        .btn, .button, button[type="submit"], input[type="submit"] {
            background-color: <?php echo esc_attr($primary_color); ?> !important;
            border-color: <?php echo esc_attr($primary_color); ?> !important;
        }
    </style>
    <?php
}
add_action('wp_head', 'skyworld_customizer_css', 100);