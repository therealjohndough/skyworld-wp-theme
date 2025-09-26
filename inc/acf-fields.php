<?php
/**
 * Programmatic ACF field registration for Skyworld child theme.
 * This file is a fallback for environments where the ACF JSON importer isn't used.
 */

if ( ! function_exists( 'skyworld_register_acf_fields' ) ) :
    function skyworld_register_acf_fields() {
        if ( ! function_exists( 'acf_add_local_field_group' ) ) {
            return;
        }

        // Strain field group
        acf_add_local_field_group(array(
            'key' => 'group_strain_fields',
            'title' => 'Strain Fields',
            'fields' => array(
                array(
                    'key' => 'field_genetics',
                    'label' => 'Genetics',
                    'name' => 'genetics',
                    'type' => 'text',
                ),
                array(
                    'key' => 'field_strain_number',
                    'label' => 'Strain Number',
                    'name' => 'strain_number',
                    'type' => 'text',
                ),
                array(
                    'key' => 'field_nose',
                    'label' => 'Nose / Aroma',
                    'name' => 'nose',
                    'type' => 'text',
                ),
                array(
                    'key' => 'field_coa_link',
                    'label' => 'COA Link',
                    'name' => 'coa_link',
                    'type' => 'url',
                ),
            ),
            'location' => array(
                array(
                    array(
                        'param' => 'post_type',
                        'operator' => '==',
                        'value' => 'strain',
                    ),
                ),
            ),
        ));

        // Sky Product field group
        acf_add_local_field_group(array(
            'key' => 'group_product_fields',
            'title' => 'Product Fields',
            'fields' => array(
                array(
                    'key' => 'field_related_strain',
                    'label' => 'Related Strain',
                    'name' => 'related_strain',
                    'type' => 'post_object',
                    'post_type' => array('strain'),
                    'return_format' => 'object',
                ),
                array(
                    'key' => 'field_batch_number',
                    'label' => 'Batch Number',
                    'name' => 'batch_number',
                    'type' => 'text',
                ),
                array(
                    'key' => 'field_thc_percent',
                    'label' => 'THC %',
                    'name' => 'thc_percent',
                    'type' => 'number',
                    'step' => '0.01',
                ),
                array(
                    'key' => 'field_weight',
                    'label' => 'Weight',
                    'name' => 'weight',
                    'type' => 'text',
                ),
                array(
                    'key' => 'field_coa',
                    'label' => 'COA PDF',
                    'name' => 'coa_pdf',
                    'type' => 'file',
                    'return_format' => 'url',
                ),
            ),
            'location' => array(
                array(
                    array(
                        'param' => 'post_type',
                        'operator' => '==',
                        'value' => 'sky_product',
                    ),
                ),
            ),
        ));
    }
    add_action( 'acf/init', 'skyworld_register_acf_fields' );
endif;
