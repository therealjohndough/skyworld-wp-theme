/**
 * Live Preview JavaScript for Skyworld Customizer
 * Real-time updates for new front page layout
 */
(function($) {
    'use strict';

    // Helper function to update CSS custom properties
    function updateCSSProperty(property, value) {
        $(':root').get(0).style.setProperty(property, value);
    }

    // Color Controls with Live Preview
    wp.customize('skyworld_primary_color', function(value) {
        value.bind(function(to) {
            updateCSSProperty('--color-primary', to);
            updateCSSProperty('--color-sativa', to);
            
            // Update buttons
            $('.btn-primary, .age-gate-yes').css('background-color', to);
            
            // Update accents
            $('.hero-badge, .feature-icon, .product-thc, .strain-type.sativa, .effect-tag').css({
                'background-color': to + '1a',
                'color': to
            });
            
            // Update stat numbers
            $('.stat-number').css('color', to);
            
            // Update links
            $('a').css('color', to);
        });
    });

    wp.customize('skyworld_secondary_color', function(value) {
        value.bind(function(to) {
            updateCSSProperty('--color-secondary', to);
            $('.strain-type.indica').css({
                'background-color': to + '1a',
                'color': to
            });
        });
    });

    wp.customize('skyworld_bg_color', function(value) {
        value.bind(function(to) {
            updateCSSProperty('--color-bg', to);
            $('body').css('background-color', to);
        });
    });

    wp.customize('skyworld_text_color', function(value) {
        value.bind(function(to) {
            updateCSSProperty('--color-text', to);
            $('body, p, .hero-subtitle, .feature-card p, .product-description, .strain-description, .about-text p').css('color', to);
            $('.hero-title, h1, .section-header h2, .about-text h2, h2, .feature-card h3, .strain-name, .product-title, h3').css('color', to);
        });
    });

    // Typography Controls
    wp.customize('skyworld_h1_size', function(value) {
        value.bind(function(to) {
            $('.hero-title, h1').css('font-size', to + 'px');
        });
    });

    wp.customize('skyworld_h2_size', function(value) {
        value.bind(function(to) {
            $('.section-header h2, .about-text h2, h2').css('font-size', to + 'px');
        });
    });

    wp.customize('skyworld_h3_size', function(value) {
        value.bind(function(to) {
            $('.feature-card h3, .strain-name, .product-title, h3').css('font-size', to + 'px');
        });
    });

    wp.customize('skyworld_body_size', function(value) {
        value.bind(function(to) {
            $('body, p, .hero-subtitle, .feature-card p, .product-description, .strain-description, .about-text p').css('font-size', to + 'px');
        });
    });

    // Button Controls
    wp.customize('skyworld_button_style', function(value) {
        value.bind(function(to) {
            var radius = '6px';
            if (to === 'square') {
                radius = '0';
            } else if (to === 'pill') {
                radius = '50px';
            }
            $('.btn-primary, .btn-secondary, .btn-outline').css('border-radius', radius);
        });
    });

    wp.customize('skyworld_button_size', function(value) {
        value.bind(function(to) {
            var padding = '12px 24px';
            if (to === 'small') {
                padding = '8px 16px';
            } else if (to === 'large') {
                padding = '16px 32px';
            }
            $('.btn-primary, .btn-secondary, .btn-outline').css('padding', padding);
        });
    });

    // Layout Controls
    wp.customize('skyworld_container_width', function(value) {
        value.bind(function(to) {
            updateCSSProperty('--container-width', to + 'px');
            $('.container').css('max-width', to + 'px');
        });
    });

    wp.customize('skyworld_section_spacing', function(value) {
        value.bind(function(to) {
            updateCSSProperty('--section-padding', to + 'px');
            $('.hero-section, .features-section, .products-section, .strains-section, .about-section').css('padding', to + 'px 0');
        });
    });

})(jQuery);