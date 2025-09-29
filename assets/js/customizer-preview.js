/**
 * Live Preview JavaScript for Skyworld Customizer
 * Real-time updates as user changes customizer settings
 */
(function($) {
    'use strict';

    // Helper function to update CSS custom properties
    function updateCSSProperty(property, value) {
        $(':root').get(0).style.setProperty(property, value);
    }

    // Helper function to update CSS rules
    function updateCSS(selector, property, value) {
        // Remove existing style if exists
        $('#skyworld-live-preview-css').remove();
        
        // Create new style element
        var css = '<style type="text/css" id="skyworld-live-preview-css">';
        css += selector + ' { ' + property + ': ' + value + ' !important; }';
        css += '</style>';
        
        $('head').append(css);
    }

    // Color Controls with Live Preview
    wp.customize('skyworld_primary_color', function(value) {
        value.bind(function(to) {
            updateCSSProperty('--skyworld-primary', to);
            
            // Update specific elements
            $('.strain-type-badge.hybrid, .effect-tag, .qa-badge, .product-potency, .thc-stat').css('background-color', to);
            $('.section-title').css('border-bottom-color', to);
            $('.quick-stat .thc-value').css('color', to);
            $('.product-link, .strain-link, button, .wp-block-button__link').css('background-color', to);
            $('a').css('color', to);
        });
    });

    wp.customize('skyworld_secondary_color', function(value) {
        value.bind(function(to) {
            updateCSSProperty('--skyworld-secondary', to);
            $('h1, .strain-title, h2, .section-title, h3, .strain-name, .product-name').css('color', to);
        });
    });

    wp.customize('skyworld_bg_color', function(value) {
        value.bind(function(to) {
            updateCSSProperty('--skyworld-bg', to);
            $('.single-strain-page, body').css('background-color', to);
        });
    });

    wp.customize('skyworld_text_color', function(value) {
        value.bind(function(to) {
            updateCSSProperty('--skyworld-text', to);
            $('body, p, .strain-description, .product-type').css('color', to);
        });
    });

    // Typography Controls
    wp.customize('skyworld_h1_size', function(value) {
        value.bind(function(to) {
            $('h1, .strain-title').css('font-size', to + 'px');
        });
    });

    wp.customize('skyworld_h2_size', function(value) {
        value.bind(function(to) {
            $('h2, .section-title').css('font-size', to + 'px');
        });
    });

    wp.customize('skyworld_h3_size', function(value) {
        value.bind(function(to) {
            $('h3, .strain-name, .product-name').css('font-size', to + 'px');
        });
    });

    wp.customize('skyworld_body_size', function(value) {
        value.bind(function(to) {
            $('body, p, .strain-description, .product-type').css('font-size', to + 'px');
        });
    });

    // Button Style Controls
    wp.customize('skyworld_button_style', function(value) {
        value.bind(function(to) {
            var radius = '6px';
            if (to === 'square') {
                radius = '0';
            } else if (to === 'pill') {
                radius = '50px';
            }
            $('.product-link, .strain-link, button, .wp-block-button__link').css('border-radius', radius);
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
            $('.product-link, .strain-link, button, .wp-block-button__link').css('padding', padding);
        });
    });

    // Layout Controls
    wp.customize('skyworld_container_width', function(value) {
        value.bind(function(to) {
            updateCSSProperty('--skyworld-container-width', to + 'px');
            $('.container').css('max-width', to + 'px');
        });
    });

    wp.customize('skyworld_section_spacing', function(value) {
        value.bind(function(to) {
            updateCSSProperty('--skyworld-section-spacing', to + 'px');
            var marginBottom = Math.round(to * 0.67) + 'px';
            $('.strain-hero, .detail-section, .related-products-section, .related-strains-section').css({
                'padding': to + 'px',
                'margin-bottom': marginBottom
            });
        });
    });

    // Add smooth transitions for live preview
    $(document).ready(function() {
        $('body *').css('transition', 'all 0.3s ease');
    });

})(jQuery);