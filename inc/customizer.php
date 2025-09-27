<?php
/**
 * Skyworld Theme Customizer
 * Clean, client-friendly interface for managing site content
 * NO BLOCK EDITOR - Everything controlled through Customizer & ACF
 */

add_action( 'customize_register', 'skyworld_customize_register' );
function skyworld_customize_register( $wp_customize ) {

    // ===== SITE IDENTITY SECTION =====
    $wp_customize->add_section( 'skyworld_identity', array(
        'title' => 'Company Information',
        'priority' => 30,
        'description' => 'Manage your company details and branding'
    ));

    // Company Name
    $wp_customize->add_setting( 'skyworld_company_name', array(
        'default' => 'Skyworld Cannabis',
        'sanitize_callback' => 'sanitize_text_field'
    ));
    $wp_customize->add_control( 'skyworld_company_name', array(
        'label' => 'Company Name',
        'section' => 'skyworld_identity',
        'type' => 'text'
    ));

    // Tagline
    $wp_customize->add_setting( 'skyworld_tagline', array(
        'default' => 'Premium Indoor Cultivation',
        'sanitize_callback' => 'sanitize_text_field'
    ));
    $wp_customize->add_control( 'skyworld_tagline', array(
        'label' => 'Company Tagline',
        'section' => 'skyworld_identity',
        'type' => 'text'
    ));

    // Phone Number
    $wp_customize->add_setting( 'skyworld_phone', array(
        'default' => '',
        'sanitize_callback' => 'sanitize_text_field'
    ));
    $wp_customize->add_control( 'skyworld_phone', array(
        'label' => 'Phone Number',
        'section' => 'skyworld_identity',
        'type' => 'text'
    ));

    // Email
    $wp_customize->add_setting( 'skyworld_email', array(
        'default' => 'info@skyworldcannabis.com',
        'sanitize_callback' => 'sanitize_email'
    ));
    $wp_customize->add_control( 'skyworld_email', array(
        'label' => 'Contact Email',
        'section' => 'skyworld_identity',
        'type' => 'email'
    ));

    // License Numbers
    $wp_customize->add_setting( 'skyworld_licenses', array(
        'default' => '#OCM-PROC-24-000030 #OCM-CULT-2023-000179',
        'sanitize_callback' => 'sanitize_textarea_field'
    ));
    $wp_customize->add_control( 'skyworld_licenses', array(
        'label' => 'License Numbers',
        'section' => 'skyworld_identity',
        'type' => 'textarea',
        'description' => 'Enter your cannabis license numbers'
    ));

    // ===== HOMEPAGE HERO SECTION =====
    $wp_customize->add_section( 'skyworld_hero', array(
        'title' => 'Homepage Hero',
        'priority' => 40,
        'description' => 'Manage the main hero section on your homepage'
    ));

    // Hero Headline
    $wp_customize->add_setting( 'skyworld_hero_headline', array(
        'default' => 'BORN FROM A PASSION FOR THE PLANT',
        'sanitize_callback' => 'sanitize_text_field'
    ));
    $wp_customize->add_control( 'skyworld_hero_headline', array(
        'label' => 'Hero Headline',
        'section' => 'skyworld_hero',
        'type' => 'text'
    ));

    // Hero Subtext
    $wp_customize->add_setting( 'skyworld_hero_subtext', array(
        'default' => 'We believe New Yorkers deserve access to consistent, high-quality cannabis grown with expertise and transparency. Our mission is simple: to elevate your cannabis experience through uncompromising quality, rooted right here in NY.',
        'sanitize_callback' => 'sanitize_textarea_field'
    ));
    $wp_customize->add_control( 'skyworld_hero_subtext', array(
        'label' => 'Hero Description',
        'section' => 'skyworld_hero',
        'type' => 'textarea',
        'description' => 'Main description text below the headline'
    ));

    // Hero Background Image
    $wp_customize->add_setting( 'skyworld_hero_background', array(
        'default' => '',
        'sanitize_callback' => 'esc_url_raw'
    ));
    $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'skyworld_hero_background', array(
        'label' => 'Hero Background Image',
        'section' => 'skyworld_hero'
    )));

    // ===== HOMEPAGE SECTIONS =====
    $wp_customize->add_section( 'skyworld_homepage', array(
        'title' => 'Homepage Sections',
        'priority' => 50,
        'description' => 'Control which sections appear on your homepage'
    ));

    // Show Hero Slider
    $wp_customize->add_setting( 'skyworld_show_hero_slider', array(
        'default' => true,
        'sanitize_callback' => 'wp_validate_boolean'
    ));
    $wp_customize->add_control( 'skyworld_show_hero_slider', array(
        'label' => 'Show Hero News Slider',
        'section' => 'skyworld_homepage',
        'type' => 'checkbox',
        'description' => 'Display top 3 featured news stories'
    ));

    // Show Genetic Library
    $wp_customize->add_setting( 'skyworld_show_genetic_library', array(
        'default' => true,
        'sanitize_callback' => 'wp_validate_boolean'
    ));
    $wp_customize->add_control( 'skyworld_show_genetic_library', array(
        'label' => 'Show Genetic Library Block',
        'section' => 'skyworld_homepage',
        'type' => 'checkbox',
        'description' => 'Display strain genetics library section'
    ));

    // Show Product Slider
    $wp_customize->add_setting( 'skyworld_show_product_slider', array(
        'default' => true,
        'sanitize_callback' => 'wp_validate_boolean'
    ));
    $wp_customize->add_control( 'skyworld_show_product_slider', array(
        'label' => 'Show Product Slider',
        'section' => 'skyworld_homepage',
        'type' => 'checkbox',
        'description' => 'Display featured products section'
    ));

    // Show News Block
    $wp_customize->add_setting( 'skyworld_show_news_block', array(
        'default' => true,
        'sanitize_callback' => 'wp_validate_boolean'
    ));
    $wp_customize->add_control( 'skyworld_show_news_block', array(
        'label' => 'Show News Block',
        'section' => 'skyworld_homepage',
        'type' => 'checkbox',
        'description' => 'Display recent news and updates'
    ));

    // ===== CTA SECTION =====
    $wp_customize->add_section( 'skyworld_cta', array(
        'title' => 'Call-to-Action Section',
        'priority' => 60,
        'description' => 'Manage the bottom CTA section'
    ));

    // CTA Headline
    $wp_customize->add_setting( 'skyworld_cta_headline', array(
        'default' => 'Ready to Experience Premium Cannabis?',
        'sanitize_callback' => 'sanitize_text_field'
    ));
    $wp_customize->add_control( 'skyworld_cta_headline', array(
        'label' => 'CTA Headline',
        'section' => 'skyworld_cta',
        'type' => 'text'
    ));

    // CTA Description
    $wp_customize->add_setting( 'skyworld_cta_description', array(
        'default' => 'Find Skyworld products at dispensaries throughout New York State.',
        'sanitize_callback' => 'sanitize_textarea_field'
    ));
    $wp_customize->add_control( 'skyworld_cta_description', array(
        'label' => 'CTA Description',
        'section' => 'skyworld_cta',
        'type' => 'textarea'
    ));

    // CTA Button Text
    $wp_customize->add_setting( 'skyworld_cta_button_text', array(
        'default' => 'Find Locations',
        'sanitize_callback' => 'sanitize_text_field'
    ));
    $wp_customize->add_control( 'skyworld_cta_button_text', array(
        'label' => 'CTA Button Text',
        'section' => 'skyworld_cta',
        'type' => 'text'
    ));

    // CTA Button Link
    $wp_customize->add_setting( 'skyworld_cta_button_link', array(
        'default' => '/store-locator/',
        'sanitize_callback' => 'esc_url_raw'
    ));
    $wp_customize->add_control( 'skyworld_cta_button_link', array(
        'label' => 'CTA Button Link',
        'section' => 'skyworld_cta',
        'type' => 'url'
    ));

    // ===== SOCIAL MEDIA =====
    $wp_customize->add_section( 'skyworld_social', array(
        'title' => 'Social Media Links',
        'priority' => 70,
        'description' => 'Add your social media profile links'
    ));

    // Instagram
    $wp_customize->add_setting( 'skyworld_instagram', array(
        'default' => 'https://www.instagram.com/skyworldsmoke/',
        'sanitize_callback' => 'esc_url_raw'
    ));
    $wp_customize->add_control( 'skyworld_instagram', array(
        'label' => 'Instagram URL',
        'section' => 'skyworld_social',
        'type' => 'url'
    ));

    // Facebook
    $wp_customize->add_setting( 'skyworld_facebook', array(
        'default' => '',
        'sanitize_callback' => 'esc_url_raw'
    ));
    $wp_customize->add_control( 'skyworld_facebook', array(
        'label' => 'Facebook URL',
        'section' => 'skyworld_social',
        'type' => 'url'
    ));

    // Twitter
    $wp_customize->add_setting( 'skyworld_twitter', array(
        'default' => '',
        'sanitize_callback' => 'esc_url_raw'
    ));
    $wp_customize->add_control( 'skyworld_twitter', array(
        'label' => 'Twitter URL',
        'section' => 'skyworld_social',
        'type' => 'url'
    ));

    // LinkedIn
    $wp_customize->add_setting( 'skyworld_linkedin', array(
        'default' => '',
        'sanitize_callback' => 'esc_url_raw'
    ));
    $wp_customize->add_control( 'skyworld_linkedin', array(
        'label' => 'LinkedIn URL',
        'section' => 'skyworld_social',
        'type' => 'url'
    ));

    // ===== SEO SETTINGS SECTION =====
    $wp_customize->add_section( 'skyworld_seo', array(
        'title' => 'SEO Settings',
        'priority' => 85,
        'description' => 'Manage SEO settings to help customers find your cannabis business'
    ));

    // Default Meta Description
    $wp_customize->add_setting( 'skyworld_default_meta_description', array(
        'default' => 'Premium indoor cannabis cultivation in New York. Quality strains, lab-tested products, and exceptional customer service.',
        'sanitize_callback' => 'sanitize_textarea_field'
    ));
    $wp_customize->add_control( 'skyworld_default_meta_description', array(
        'label' => 'Default Meta Description',
        'section' => 'skyworld_seo',
        'type' => 'textarea',
        'description' => 'This appears in search results when pages don\'t have custom descriptions'
    ));

    // Homepage Title
    $wp_customize->add_setting( 'skyworld_homepage_title', array(
        'default' => 'Premium Cannabis Cultivation | Skyworld Cannabis NY',
        'sanitize_callback' => 'sanitize_text_field'
    ));
    $wp_customize->add_control( 'skyworld_homepage_title', array(
        'label' => 'Homepage SEO Title',
        'section' => 'skyworld_seo',
        'type' => 'text',
        'description' => 'What appears in search results and browser tabs'
    ));

    // Focus Keywords
    $wp_customize->add_setting( 'skyworld_focus_keywords', array(
        'default' => 'cannabis, marijuana, weed, New York, dispensary, strains, indoor grown',
        'sanitize_callback' => 'sanitize_text_field'
    ));
    $wp_customize->add_control( 'skyworld_focus_keywords', array(
        'label' => 'Focus Keywords',
        'section' => 'skyworld_seo',
        'type' => 'text',
        'description' => 'Main keywords customers use to find you (comma separated)'
    ));

    // Local SEO - Service Areas
    $wp_customize->add_setting( 'skyworld_service_areas', array(
        'default' => 'New York, NYC, Manhattan, Brooklyn, Queens, Bronx, Staten Island',
        'sanitize_callback' => 'sanitize_text_field'
    ));
    $wp_customize->add_control( 'skyworld_service_areas', array(
        'label' => 'Service Areas',
        'section' => 'skyworld_seo',
        'type' => 'text',
        'description' => 'Cities/areas you serve (helps with local search)'
    ));

    // Schema Markup Toggle
    $wp_customize->add_setting( 'skyworld_enable_schema', array(
        'default' => true,
        'sanitize_callback' => 'wp_validate_boolean'
    ));
    $wp_customize->add_control( 'skyworld_enable_schema', array(
        'label' => 'Enable Rich Snippets',
        'section' => 'skyworld_seo',
        'type' => 'checkbox',
        'description' => 'Helps Google understand your cannabis business better'
    ));

    // Google Analytics Tracking ID
    $wp_customize->add_setting( 'skyworld_ga_tracking_id', array(
        'default' => '',
        'sanitize_callback' => 'sanitize_text_field'
    ));
    $wp_customize->add_control( 'skyworld_ga_tracking_id', array(
        'label' => 'Google Analytics ID',
        'section' => 'skyworld_seo',
        'type' => 'text',
        'description' => 'Format: G-XXXXXXXXXX or UA-XXXXXXXX-X'
    ));

    // Google Search Console
    $wp_customize->add_setting( 'skyworld_search_console_code', array(
        'default' => '',
        'sanitize_callback' => 'sanitize_text_field'
    ));
    $wp_customize->add_control( 'skyworld_search_console_code', array(
        'label' => 'Google Search Console Verification',
        'section' => 'skyworld_seo',
        'type' => 'text',
        'description' => 'Meta verification code from Google Search Console'
    ));

    // ===== AGE GATE SETTINGS =====
    $wp_customize->add_section( 'skyworld_age_gate', array(
        'title' => 'Age Gate Settings',
        'priority' => 80,
        'description' => 'Manage age verification popup'
    ));

    // Enable Age Gate
    $wp_customize->add_setting( 'skyworld_enable_age_gate', array(
        'default' => true,
        'sanitize_callback' => 'wp_validate_boolean'
    ));
    $wp_customize->add_control( 'skyworld_enable_age_gate', array(
        'label' => 'Enable Age Gate',
        'section' => 'skyworld_age_gate',
        'type' => 'checkbox',
        'description' => 'Show age verification popup for new visitors'
    ));

    // Age Gate Headline
    $wp_customize->add_setting( 'skyworld_age_gate_headline', array(
        'default' => 'Age Verification Required',
        'sanitize_callback' => 'sanitize_text_field'
    ));
    $wp_customize->add_control( 'skyworld_age_gate_headline', array(
        'label' => 'Age Gate Headline',
        'section' => 'skyworld_age_gate',
        'type' => 'text'
    ));

    // Age Gate Message
    $wp_customize->add_setting( 'skyworld_age_gate_message', array(
        'default' => 'You must be 21 years or older to view this website.',
        'sanitize_callback' => 'sanitize_textarea_field'
    ));
    $wp_customize->add_control( 'skyworld_age_gate_message', array(
        'label' => 'Age Gate Message',
        'section' => 'skyworld_age_gate',
        'type' => 'textarea'
    ));

    // ===== FOOTER SETTINGS =====
    $wp_customize->add_section( 'skyworld_footer', array(
        'title' => 'Footer Content',
        'priority' => 90,
        'description' => 'Manage footer information'
    ));

    // Footer About Text
    $wp_customize->add_setting( 'skyworld_footer_about', array(
        'default' => 'We believe New Yorkers deserve access to consistent, high-quality cannabis grown with expertise and transparency.',
        'sanitize_callback' => 'sanitize_textarea_field'
    ));
    $wp_customize->add_control( 'skyworld_footer_about', array(
        'label' => 'Footer About Text',
        'section' => 'skyworld_footer',
        'type' => 'textarea'
    ));

    // Operating Company
    $wp_customize->add_setting( 'skyworld_operating_company', array(
        'default' => 'Operated by SJR Horticulture, LLC',
        'sanitize_callback' => 'sanitize_text_field'
    ));
    $wp_customize->add_control( 'skyworld_operating_company', array(
        'label' => 'Operating Company',
        'section' => 'skyworld_footer',
        'type' => 'text'
    ));

    // Copyright Year
    $wp_customize->add_setting( 'skyworld_copyright_year', array(
        'default' => date('Y'),
        'sanitize_callback' => 'absint'
    ));
    $wp_customize->add_control( 'skyworld_copyright_year', array(
        'label' => 'Copyright Year',
        'section' => 'skyworld_footer',
        'type' => 'number',
        'input_attrs' => array(
            'min' => 2020,
            'max' => 2030,
            'step' => 1,
        ),
    ));

    // ===== COLORS & STYLING =====
    $wp_customize->add_section( 'skyworld_colors', array(
        'title' => 'Brand Colors',
        'priority' => 100,
        'description' => 'Customize your brand colors'
    ));

    // Primary Color
    $wp_customize->add_setting( 'skyworld_primary_color', array(
        'default' => '#ff793f',
        'sanitize_callback' => 'sanitize_hex_color'
    ));
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'skyworld_primary_color', array(
        'label' => 'Primary Brand Color',
        'section' => 'skyworld_colors'
    )));

    // Secondary Color
    $wp_customize->add_setting( 'skyworld_secondary_color', array(
        'default' => '#ffb142',
        'sanitize_callback' => 'sanitize_hex_color'
    ));
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'skyworld_secondary_color', array(
        'label' => 'Secondary Brand Color',
        'section' => 'skyworld_colors'
    )));

    // Accent Color
    $wp_customize->add_setting( 'skyworld_accent_color', array(
        'default' => '#34ace0',
        'sanitize_callback' => 'sanitize_hex_color'
    ));
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'skyworld_accent_color', array(
        'label' => 'Highlight/Accent Color',
        'section' => 'skyworld_colors'
    )));
}

// ===== HELPER FUNCTIONS FOR TEMPLATES =====

// Get customizer values easily
function skyworld_get_option( $option, $default = '' ) {
    return get_theme_mod( $option, $default );
}

// Generate custom CSS from customizer
add_action( 'wp_head', 'skyworld_customizer_css' );
function skyworld_customizer_css() {
    $primary_color = skyworld_get_option( 'skyworld_primary_color', '#ff793f' );
    $secondary_color = skyworld_get_option( 'skyworld_secondary_color', '#ffb142' );
    $accent_color = skyworld_get_option( 'skyworld_accent_color', '#34ace0' );
    ?>
    <style type="text/css">
        :root {
            --skyworld-primary: <?php echo esc_attr( $primary_color ); ?>;
            --skyworld-secondary: <?php echo esc_attr( $secondary_color ); ?>;
            --skyworld-accent: <?php echo esc_attr( $accent_color ); ?>;
        }
        
        .button-primary, 
        .cta-button, 
        .view-all-button {
            background-color: <?php echo esc_attr( $primary_color ); ?> !important;
        }
        
        .button-secondary,
        .strain-badge {
            background-color: <?php echo esc_attr( $secondary_color ); ?> !important;
        }
        
        .highlight,
        .accent-color,
        .product-price {
            color: <?php echo esc_attr( $accent_color ); ?> !important;
        }
    </style>
    <?php
}

// Add customizer shortcut to admin bar
add_action( 'admin_bar_menu', 'skyworld_customizer_admin_bar', 999 );
function skyworld_customizer_admin_bar( $wp_admin_bar ) {
    if ( current_user_can( 'customize' ) ) {
        $wp_admin_bar->add_node( array(
            'id'    => 'skyworld-customize',
            'title' => 'Customize Site',
            'href'  => admin_url( 'customize.php' ),
            'meta'  => array( 'class' => 'skyworld-customize-link' )
        ));
    }
}