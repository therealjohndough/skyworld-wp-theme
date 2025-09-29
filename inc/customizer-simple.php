<?php
/**
 * Advanced Skyworld Customizer with Live Preview
 * Astra-style customization system with real-time updates
 */

// Add customizer settings and controls
function skyworld_customize_register($wp_customize) {
    
    // Add Skyworld Panel
    $wp_customize->add_panel('skyworld_options', array(
        'title'       => __('Skyworld Design', 'skyworld'),
        'description' => __('Customize your Skyworld Cannabis site design', 'skyworld'),
        'priority'    => 30,
    ));
    
    // === COLORS SECTION ===
    $wp_customize->add_section('skyworld_colors', array(
        'title'    => __('Colors & Branding', 'skyworld'),
        'panel'    => 'skyworld_options',
        'priority' => 10,
    ));
    
    // Primary Color
    $wp_customize->add_setting('skyworld_primary_color', array(
        'default'           => '#27ae60',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'skyworld_primary_color', array(
        'label'       => __('Primary Brand Color', 'skyworld'),
        'description' => __('Main brand color for buttons, links, and accents', 'skyworld'),
        'section'     => 'skyworld_colors',
        'settings'    => 'skyworld_primary_color',
    )));
    
    // Secondary Color
    $wp_customize->add_setting('skyworld_secondary_color', array(
        'default'           => '#2c3e50',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'skyworld_secondary_color', array(
        'label'       => __('Secondary Color', 'skyworld'),
        'description' => __('Secondary color for headings and emphasis', 'skyworld'),
        'section'     => 'skyworld_colors',
        'settings'    => 'skyworld_secondary_color',
    )));
    
    // Background Color
    $wp_customize->add_setting('skyworld_bg_color', array(
        'default'           => '#f8f9fa',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'skyworld_bg_color', array(
        'label'       => __('Background Color', 'skyworld'),
        'description' => __('Main page background color', 'skyworld'),
        'section'     => 'skyworld_colors',
        'settings'    => 'skyworld_bg_color',
    )));
    
    // Text Color
    $wp_customize->add_setting('skyworld_text_color', array(
        'default'           => '#495057',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'skyworld_text_color', array(
        'label'       => __('Text Color', 'skyworld'),
        'description' => __('Main body text color', 'skyworld'),
        'section'     => 'skyworld_colors',
        'settings'    => 'skyworld_text_color',
    )));
    
    // === TYPOGRAPHY SECTION ===
    $wp_customize->add_section('skyworld_typography', array(
        'title'    => __('Typography', 'skyworld'),
        'panel'    => 'skyworld_options',
        'priority' => 20,
    ));
    
    // H1 Font Size
    $wp_customize->add_setting('skyworld_h1_size', array(
        'default'           => '48',
        'sanitize_callback' => 'absint',
        'transport'         => 'postMessage',
    ));
    $wp_customize->add_control('skyworld_h1_size', array(
        'label'       => __('H1 Font Size (px)', 'skyworld'),
        'section'     => 'skyworld_typography',
        'type'        => 'range',
        'input_attrs' => array(
            'min'  => 24,
            'max'  => 72,
            'step' => 2,
        ),
    ));
    
    // H2 Font Size
    $wp_customize->add_setting('skyworld_h2_size', array(
        'default'           => '32',
        'sanitize_callback' => 'absint',
        'transport'         => 'postMessage',
    ));
    $wp_customize->add_control('skyworld_h2_size', array(
        'label'       => __('H2 Font Size (px)', 'skyworld'),
        'section'     => 'skyworld_typography',
        'type'        => 'range',
        'input_attrs' => array(
            'min'  => 18,
            'max'  => 48,
            'step' => 2,
        ),
    ));
    
    // H3 Font Size
    $wp_customize->add_setting('skyworld_h3_size', array(
        'default'           => '24',
        'sanitize_callback' => 'absint',
        'transport'         => 'postMessage',
    ));
    $wp_customize->add_control('skyworld_h3_size', array(
        'label'       => __('H3 Font Size (px)', 'skyworld'),
        'section'     => 'skyworld_typography',
        'type'        => 'range',
        'input_attrs' => array(
            'min'  => 16,
            'max'  => 36,
            'step' => 2,
        ),
    ));
    
    // Body Font Size
    $wp_customize->add_setting('skyworld_body_size', array(
        'default'           => '16',
        'sanitize_callback' => 'absint',
        'transport'         => 'postMessage',
    ));
    $wp_customize->add_control('skyworld_body_size', array(
        'label'       => __('Body Text Size (px)', 'skyworld'),
        'section'     => 'skyworld_typography',
        'type'        => 'range',
        'input_attrs' => array(
            'min'  => 12,
            'max'  => 24,
            'step' => 1,
        ),
    ));
    
    // === BUTTONS SECTION ===
    $wp_customize->add_section('skyworld_buttons', array(
        'title'    => __('Buttons & Links', 'skyworld'),
        'panel'    => 'skyworld_options',
        'priority' => 30,
    ));
    
    // Button Style
    $wp_customize->add_setting('skyworld_button_style', array(
        'default'           => 'rounded',
        'sanitize_callback' => 'skyworld_sanitize_select',
        'transport'         => 'postMessage',
    ));
    $wp_customize->add_control('skyworld_button_style', array(
        'label'   => __('Button Style', 'skyworld'),
        'section' => 'skyworld_buttons',
        'type'    => 'select',
        'choices' => array(
            'square'  => __('Square', 'skyworld'),
            'rounded' => __('Rounded', 'skyworld'),
            'pill'    => __('Pill Shape', 'skyworld'),
        ),
    ));
    
    // Button Size
    $wp_customize->add_setting('skyworld_button_size', array(
        'default'           => 'medium',
        'sanitize_callback' => 'skyworld_sanitize_select',
        'transport'         => 'postMessage',
    ));
    $wp_customize->add_control('skyworld_button_size', array(
        'label'   => __('Button Size', 'skyworld'),
        'section' => 'skyworld_buttons',
        'type'    => 'select',
        'choices' => array(
            'small'  => __('Small', 'skyworld'),
            'medium' => __('Medium', 'skyworld'),
            'large'  => __('Large', 'skyworld'),
        ),
    ));
    
    // === LAYOUT SECTION ===
    $wp_customize->add_section('skyworld_layout', array(
        'title'    => __('Layout & Spacing', 'skyworld'),
        'panel'    => 'skyworld_options',
        'priority' => 40,
    ));
    
    // Container Width
    $wp_customize->add_setting('skyworld_container_width', array(
        'default'           => '1400',
        'sanitize_callback' => 'absint',
        'transport'         => 'postMessage',
    ));
    $wp_customize->add_control('skyworld_container_width', array(
        'label'       => __('Container Max Width (px)', 'skyworld'),
        'section'     => 'skyworld_layout',
        'type'        => 'range',
        'input_attrs' => array(
            'min'  => 1000,
            'max'  => 1800,
            'step' => 50,
        ),
    ));
    
    // Section Spacing
    $wp_customize->add_setting('skyworld_section_spacing', array(
        'default'           => '60',
        'sanitize_callback' => 'absint',
        'transport'         => 'postMessage',
    ));
    $wp_customize->add_control('skyworld_section_spacing', array(
        'label'       => __('Section Spacing (px)', 'skyworld'),
        'section'     => 'skyworld_layout',
        'type'        => 'range',
        'input_attrs' => array(
            'min'  => 20,
            'max'  => 100,
            'step' => 10,
        ),
    ));
}
add_action('customize_register', 'skyworld_customize_register');

// Sanitization callback for select controls
function skyworld_sanitize_select($input, $setting) {
    $input = sanitize_key($input);
    $choices = $setting->manager->get_control($setting->id)->choices;
    return (array_key_exists($input, $choices) ? $input : $setting->default);
}

// Enqueue customizer live preview script
function skyworld_customize_preview_js() {
    wp_enqueue_script(
        'skyworld-customizer-preview',
        get_stylesheet_directory_uri() . '/assets/js/customizer-preview.js',
        array('customize-preview'),
        '1.0.0',
        true
    );
}
add_action('customize_preview_init', 'skyworld_customize_preview_js');

// Output custom CSS
function skyworld_customizer_css() {
    // Get theme mods
    $primary_color    = get_theme_mod('skyworld_primary_color', '#27ae60');
    $secondary_color  = get_theme_mod('skyworld_secondary_color', '#2c3e50');
    $bg_color         = get_theme_mod('skyworld_bg_color', '#f8f9fa');
    $text_color       = get_theme_mod('skyworld_text_color', '#495057');
    $h1_size          = get_theme_mod('skyworld_h1_size', '48');
    $h2_size          = get_theme_mod('skyworld_h2_size', '32');
    $h3_size          = get_theme_mod('skyworld_h3_size', '24');
    $body_size        = get_theme_mod('skyworld_body_size', '16');
    $button_style     = get_theme_mod('skyworld_button_style', 'rounded');
    $button_size      = get_theme_mod('skyworld_button_size', 'medium');
    $container_width  = get_theme_mod('skyworld_container_width', '1400');
    $section_spacing  = get_theme_mod('skyworld_section_spacing', '60');
    
    // Button styles
    $button_radius = '6px';
    $button_padding = '12px 24px';
    if ($button_style === 'square') {
        $button_radius = '0';
    } elseif ($button_style === 'pill') {
        $button_radius = '50px';
    }
    
    if ($button_size === 'small') {
        $button_padding = '8px 16px';
    } elseif ($button_size === 'large') {
        $button_padding = '16px 32px';
    }
    ?>
    <style type="text/css" id="skyworld-customizer-css">
        :root {
            --color-primary: <?php echo esc_attr($primary_color); ?>;
            --color-secondary: <?php echo esc_attr($secondary_color); ?>;
            --color-sativa: <?php echo esc_attr($primary_color); ?>;
            --color-bg: <?php echo esc_attr($bg_color); ?>;
            --color-text: <?php echo esc_attr($text_color); ?>;
            --container-width: <?php echo esc_attr($container_width); ?>px;
            --section-padding: <?php echo esc_attr($section_spacing); ?>px;
        }
        
        /* Layout */
        .container {
            max-width: <?php echo esc_attr($container_width); ?>px;
            margin: 0 auto;
            padding: 0 2rem;
        }
        
        /* Background */
        body {
            background-color: <?php echo esc_attr($bg_color); ?>;
            color: <?php echo esc_attr($text_color); ?>;
        }
        
        /* Typography */
        .hero-title,
        h1 {
            font-size: <?php echo esc_attr($h1_size); ?>px !important;
            color: <?php echo esc_attr($text_color); ?> !important;
        }
        
        .section-header h2,
        .about-text h2,
        h2 {
            font-size: <?php echo esc_attr($h2_size); ?>px !important;
            color: <?php echo esc_attr($text_color); ?> !important;
        }
        
        .feature-card h3,
        .strain-name,
        .product-title,
        h3 {
            font-size: <?php echo esc_attr($h3_size); ?>px !important;
            color: <?php echo esc_attr($text_color); ?> !important;
        }
        
        body,
        p,
        .hero-subtitle,
        .feature-card p,
        .product-description,
        .strain-description,
        .about-text p {
            font-size: <?php echo esc_attr($body_size); ?>px !important;
            color: <?php echo esc_attr($text_color); ?> !important;
        }
        
        /* Buttons */
        .btn-primary,
        .age-gate-yes {
            background-color: <?php echo esc_attr($primary_color); ?> !important;
            border-radius: <?php echo esc_attr($button_radius); ?> !important;
            padding: <?php echo esc_attr($button_padding); ?> !important;
            color: white !important;
            border: none !important;
        }
        
        .btn-primary:hover,
        .age-gate-yes:hover {
            background-color: <?php echo esc_attr($primary_color); ?>dd !important;
        }
        
        .btn-secondary {
            background-color: <?php echo esc_attr($bg_color); ?> !important;
            color: <?php echo esc_attr($text_color); ?> !important;
            border: 2px solid <?php echo esc_attr($primary_color); ?>33 !important;
            border-radius: <?php echo esc_attr($button_radius); ?> !important;
            padding: <?php echo esc_attr($button_padding); ?> !important;
        }
        
        .btn-secondary:hover {
            background-color: <?php echo esc_attr($primary_color); ?> !important;
            color: white !important;
            border-color: <?php echo esc_attr($primary_color); ?> !important;
        }
        
        .btn-outline {
            background-color: transparent !important;
            color: <?php echo esc_attr($text_color); ?> !important;
            border: 2px solid <?php echo esc_attr($primary_color); ?>66 !important;
            border-radius: <?php echo esc_attr($button_radius); ?> !important;
            padding: <?php echo esc_attr($button_padding); ?> !important;
        }
        
        .btn-outline:hover {
            border-color: <?php echo esc_attr($primary_color); ?> !important;
            color: <?php echo esc_attr($primary_color); ?> !important;
        }
        
        /* Accents and Highlights */
        .hero-badge,
        .feature-icon,
        .product-thc,
        .strain-type.sativa,
        .effect-tag {
            background-color: <?php echo esc_attr($primary_color); ?>1a !important;
            color: <?php echo esc_attr($primary_color); ?> !important;
        }
        
        .stat-number {
            color: <?php echo esc_attr($primary_color); ?> !important;
        }
        
        /* Links */
        a {
            color: <?php echo esc_attr($primary_color); ?>;
        }
        
        a:hover {
            color: <?php echo esc_attr($primary_color); ?>cc;
        }
        
        /* Section Spacing */
        .hero-section,
        .features-section,
        .products-section,
        .strains-section,
        .about-section {
            padding: <?php echo esc_attr($section_spacing); ?>px 0 !important;
        }
        
        /* Brand Colors Integration */
        .strain-type.indica {
            background-color: <?php echo esc_attr($secondary_color); ?>1a !important;
            color: <?php echo esc_attr($secondary_color); ?> !important;
        }
        
        .strain-type.hybrid {
            background: linear-gradient(45deg, <?php echo esc_attr($primary_color); ?>1a, <?php echo esc_attr($secondary_color); ?>1a) !important;
            color: <?php echo esc_attr($primary_color); ?> !important;
        }
        .product-potency,
        .thc-stat {
            background-color: <?php echo esc_attr($primary_color); ?>;
        }
        
        .section-title {
            border-bottom-color: <?php echo esc_attr($primary_color); ?>;
        }
        
        .quick-stat .thc-value,
        .cannabinoid-fill.thc-fill {
            color: <?php echo esc_attr($primary_color); ?>;
            background: linear-gradient(90deg, <?php echo esc_attr($primary_color); ?>, <?php echo esc_attr($primary_color); ?>99);
        }
        
        /* Buttons */
        .product-link,
        .strain-link,
        button,
        .wp-block-button__link {
            background-color: <?php echo esc_attr($primary_color); ?>;
            border-radius: <?php echo esc_attr($button_radius); ?>;
            padding: <?php echo esc_attr($button_padding); ?>;
            color: white;
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s ease;
        }
        
        .product-link:hover,
        .strain-link:hover,
        button:hover,
        .wp-block-button__link:hover {
            background-color: <?php echo esc_attr($primary_color); ?>cc;
            transform: translateY(-2px);
        }
        
        /* Spacing */
        .strain-hero,
        .detail-section,
        .related-products-section,
        .related-strains-section {
            padding: <?php echo esc_attr($section_spacing); ?>px;
            margin-bottom: <?php echo esc_attr($section_spacing * 0.67); ?>px;
        }
        
        /* Links */
        a {
            color: <?php echo esc_attr($primary_color); ?>;
        }
        
        a:hover {
            color: <?php echo esc_attr($primary_color); ?>cc;
        }
    </style>
    <?php
}
add_action('wp_head', 'skyworld_customizer_css');