<?php
/**
 * Skyworld Gravity Forms Integration
 * 
 * This file contains helper functions for integrating Gravity Forms
 * with Brevo email service and other Skyworld-specific functionality.
 */

// Prevent direct access
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Enhanced Gravity Forms styling for Skyworld theme
 */
add_filter( 'gform_field_container', 'skyworld_gform_field_container', 10, 6 );
function skyworld_gform_field_container( $field_container, $field, $form, $css_class, $style, $field_content ) {
    $id = $field->id;
    $field_id = is_admin() || $form == 0 ? "field_{$field->id}" : 'field_' . $form['id'] . "_$field->id";
    
    return '<li id="' . $field_id . '" class="' . $css_class . ' skyworld-field-container">' . $field_content . '</li>';
}

// Add custom CSS classes to forms
add_filter( 'gform_form_tag', 'skyworld_gform_form_tag', 10, 2 );
function skyworld_gform_form_tag( $form_tag, $form ) {
    $form_tag = str_replace( 'gform_wrapper', 'gform_wrapper skyworld-form', $form_tag );
    return $form_tag;
}

/**
 * Newsletter signup specific functionality
 */
add_filter( 'gform_confirmation', 'skyworld_newsletter_confirmation', 10, 4 );
function skyworld_newsletter_confirmation( $confirmation, $form, $entry, $ajax ) {
    // Check if this is the newsletter form (adjust form ID as needed)
    if ( $form['id'] == '1' ) {
        $confirmation = '<div class="skyworld-newsletter-success">
            <h3>Thank you for subscribing!</h3>
            <p>You\'ve been added to our newsletter list. You\'ll be the first to know about new drops, exclusive offers, and Skyworld updates.</p>
            <div class="success-icon">
                <i class="fas fa-check-circle"></i>
            </div>
        </div>';
    }
    
    return $confirmation;
}

/**
 * Contact form specific functionality
 */
add_filter( 'gform_confirmation', 'skyworld_contact_confirmation', 10, 4 );
function skyworld_contact_confirmation( $confirmation, $form, $entry, $ajax ) {
    // Check if this is the contact form (adjust form ID as needed)
    if ( $form['id'] == '2' ) {
        $confirmation = '<div class="skyworld-contact-success">
            <h3>Message Sent Successfully!</h3>
            <p>Thank you for reaching out to Skyworld Cannabis. Our team will review your message and get back to you within 24-48 hours.</p>
            <div class="success-icon">
                <i class="fas fa-envelope-check"></i>
            </div>
        </div>';
    }
    
    return $confirmation;
}

/**
 * Wholesale inquiry form functionality
 */
add_filter( 'gform_confirmation', 'skyworld_wholesale_confirmation', 10, 4 );
function skyworld_wholesale_confirmation( $confirmation, $form, $entry, $ajax ) {
    // Check if this is the wholesale form (adjust form ID as needed)
    if ( $form['id'] == '3' ) {
        $confirmation = '<div class="skyworld-wholesale-success">
            <h3>Wholesale Inquiry Received!</h3>
            <p>Thank you for your interest in carrying Skyworld Cannabis products. Our wholesale team will review your application and contact you within 48 hours.</p>
            <p><strong>Next Steps:</strong></p>
            <ul>
                <li>Review of your dispensary information</li>
                <li>Product availability confirmation</li>
                <li>Pricing and terms discussion</li>
            </ul>
            <div class="success-icon">
                <i class="fas fa-handshake"></i>
            </div>
        </div>';
    }
    
    return $confirmation;
}

/**
 * Enhanced Brevo integration with form-specific handling
 */
add_action( 'gform_after_submission', 'skyworld_enhanced_brevo_integration', 10, 2 );
function skyworld_enhanced_brevo_integration( $entry, $form ) {
    $email = '';
    $first_name = '';
    $last_name = '';
    $phone = '';
    $company = '';
    
    // Extract field values
    foreach ( $form['fields'] as $field ) {
        $field_value = rgar( $entry, $field->id );
        
        switch ( $field->type ) {
            case 'email':
                $email = $field_value;
                break;
            case 'name':
                if ( is_array( $field_value ) ) {
                    $first_name = rgar( $field_value, $field->id . '.3' );
                    $last_name = rgar( $field_value, $field->id . '.6' );
                } else {
                    $name_parts = explode( ' ', $field_value, 2 );
                    $first_name = $name_parts[0];
                    $last_name = isset( $name_parts[1] ) ? $name_parts[1] : '';
                }
                break;
            case 'phone':
                $phone = $field_value;
                break;
            case 'text':
                $label_lower = strtolower( $field->label );
                if ( strpos( $label_lower, 'company' ) !== false || strpos( $label_lower, 'business' ) !== false ) {
                    $company = $field_value;
                } elseif ( strpos( $label_lower, 'first' ) !== false && strpos( $label_lower, 'name' ) !== false ) {
                    $first_name = $field_value;
                } elseif ( strpos( $label_lower, 'last' ) !== false && strpos( $label_lower, 'name' ) !== false ) {
                    $last_name = $field_value;
                }
                break;
        }
    }
    
    if ( empty( $email ) ) {
        return;
    }
    
    // Determine contact attributes based on form
    $attributes = array(
        'FIRSTNAME' => $first_name,
        'LASTNAME' => $last_name
    );
    
    if ( ! empty( $phone ) ) {
        $attributes['SMS'] = $phone;
    }
    
    if ( ! empty( $company ) ) {
        $attributes['COMPANY'] = $company;
    }
    
    // Form-specific attributes and list assignments
    $list_ids = array();
    
    switch ( $form['id'] ) {
        case 1: // Newsletter form
            $list_ids = array( 1 ); // Newsletter list
            $attributes['SOURCE'] = 'Newsletter Signup';
            break;
        case 2: // Contact form
            $list_ids = array( 2 ); // General contacts list
            $attributes['SOURCE'] = 'Contact Form';
            break;
        case 3: // Wholesale form
            $list_ids = array( 3 ); // Wholesale prospects list
            $attributes['SOURCE'] = 'Wholesale Inquiry';
            $attributes['LEAD_TYPE'] = 'Wholesale';
            break;
        default:
            $list_ids = array( 1 ); // Default to newsletter list
            $attributes['SOURCE'] = 'Website Form';
            break;
    }
    
    // Send to Brevo with enhanced data
    skyworld_add_to_brevo_enhanced( $email, $attributes, $list_ids );
}

/**
 * Enhanced Brevo contact creation function
 */
function skyworld_add_to_brevo_enhanced( $email, $attributes = array(), $list_ids = array( 1 ) ) {
    $api_key = get_option( 'skyworld_brevo_api_key' );
    
    if ( empty( $api_key ) ) {
        error_log( 'Skyworld: Brevo API key not configured' );
        return false;
    }
    
    $url = 'https://api.brevo.com/v3/contacts';
    
    // Add timestamp
    $attributes['SIGNUP_DATE'] = date( 'Y-m-d' );
    $attributes['SIGNUP_TIME'] = date( 'Y-m-d H:i:s' );
    
    $data = array(
        'email' => $email,
        'attributes' => $attributes,
        'listIds' => $list_ids,
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
    $body = wp_remote_retrieve_body( $response );
    
    if ( $response_code === 201 || $response_code === 204 ) {
        // Success - log for debugging if needed
        error_log( 'Skyworld: Successfully added contact to Brevo - ' . $email );
        return true;
    } else {
        error_log( 'Skyworld Brevo API Error (' . $response_code . '): ' . $body );
        return false;
    }
}

/**
 * Add custom validation for forms
 */
add_filter( 'gform_validation', 'skyworld_custom_validation' );
function skyworld_custom_validation( $validation_result ) {
    $form = $validation_result['form'];
    
    // Custom validation for wholesale forms
    if ( $form['id'] == '3' ) { // Wholesale form
        foreach ( $form['fields'] as &$field ) {
            // Validate business license number if present
            if ( strpos( strtolower( $field->label ), 'license' ) !== false ) {
                $value = rgpost( "input_{$field->id}" );
                if ( ! empty( $value ) && ! preg_match( '/^[A-Z0-9-]+$/', $value ) ) {
                    $validation_result['is_valid'] = false;
                    $field->failed_validation = true;
                    $field->validation_message = 'Please enter a valid license number (letters, numbers, and dashes only).';
                }
            }
        }
    }
    
    $validation_result['form'] = $form;
    return $validation_result;
}

/**
 * Add honeypot protection
 */
add_filter( 'gform_form_tag', 'skyworld_add_honeypot', 10, 2 );
function skyworld_add_honeypot( $form_tag, $form ) {
    // Add honeypot field for spam protection
    $honeypot = '<div style="position:absolute;left:-9999px;">';
    $honeypot .= '<label for="skyworld_hp_' . $form['id'] . '">Leave this field blank:</label>';
    $honeypot .= '<input type="text" name="skyworld_hp_' . $form['id'] . '" id="skyworld_hp_' . $form['id'] . '" value="" />';
    $honeypot .= '</div>';
    
    return $form_tag . $honeypot;
}

// Check honeypot on submission
add_filter( 'gform_validation', 'skyworld_check_honeypot' );
function skyworld_check_honeypot( $validation_result ) {
    $form = $validation_result['form'];
    $honeypot_field = 'skyworld_hp_' . $form['id'];
    
    if ( ! empty( $_POST[$honeypot_field] ) ) {
        $validation_result['is_valid'] = false;
        // Don't show error message to spammer
    }
    
    return $validation_result;
}