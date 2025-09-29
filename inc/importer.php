<?php
/**
 * Professional Cannabis Product Importer for Skyworld
 * Created by John Dough - MADE TO INSPIRE
 * 
 * Handles import of cannabis products, strains, and locations
 * with proper ACF field mapping and taxonomy assignment
 *
 * Usage (WP-CLI):
 *   wp skyworld import_products /path/to/products.csv
 *   wp skyworld import_strains /path/to/strains.csv
 *   wp skyworld import_locations /path/to/locations.csv
 *
 * CSV Format Expected:
 * Products: name, description, strain_type, thc_percentage, cbd_percentage, terpenes, effects, image_url
 * Strains: name, description, type, genetics, thc_min, thc_max, cbd_min, cbd_max, dominant_terpenes, effects
 * Locations: name, address, city, state, zip, phone, hours, dispensary_type, image_url
 */

// Register WP-CLI commands if available
if ( defined( 'WP_CLI' ) && WP_CLI ) {
    WP_CLI::add_command( 'skyworld import_products', 'skyworld_cli_import_products' );
    WP_CLI::add_command( 'skyworld import_strains', 'skyworld_cli_import_strains' );
    WP_CLI::add_command( 'skyworld import_locations', 'skyworld_cli_import_locations' );
}

function skyworld_cli_import_products( $args, $assoc_args ) {
    $csv_path = isset( $args[0] ) ? $args[0] : '';
    if ( ! $csv_path ) {
        WP_CLI::error( 'Please provide path to CSV file.' );
    }
    
    $result = skyworld_import_cannabis_products( $csv_path );
    
    if ( $result['success'] ) {
        WP_CLI::success( $result['message'] );
    } else {
        WP_CLI::error( $result['message'] );
    }
}

function skyworld_cli_import_strains( $args, $assoc_args ) {
    $csv_path = isset( $args[0] ) ? $args[0] : '';
    if ( ! $csv_path ) {
        WP_CLI::error( 'Please provide path to CSV file.' );
    }
    
    $result = skyworld_import_cannabis_strains( $csv_path );
    
    if ( $result['success'] ) {
        WP_CLI::success( $result['message'] );
    } else {
        WP_CLI::error( $result['message'] );
    }
}

function skyworld_cli_import_locations( $args, $assoc_args ) {
    $csv_path = isset( $args[0] ) ? $args[0] : '';
    if ( ! $csv_path ) {
        WP_CLI::error( 'Please provide path to CSV file.' );
    }
    
    $result = skyworld_import_cannabis_locations( $csv_path );
    
    if ( $result['success'] ) {
        WP_CLI::success( $result['message'] );
    } else {
        WP_CLI::error( $result['message'] );
    }
}

/**
 * Import Cannabis Products from CSV
 */
function skyworld_import_cannabis_products( $csv_path ) {
    if ( ! file_exists( $csv_path ) ) {
        return array( 'success' => false, 'message' => 'CSV file not found: ' . $csv_path );
    }

    if ( ( $fh = fopen( $csv_path, 'r' ) ) === false ) {
        return array( 'success' => false, 'message' => 'Unable to open CSV file.' );
    }

    $header = fgetcsv( $fh, 0, ',', '"', '\\' );
    if ( ! $header ) {
        fclose( $fh );
        return array( 'success' => false, 'message' => 'Empty CSV or invalid header.' );
    }

    // Normalize headers for consistency
    $header = array_map( function( $h ) { 
        return trim( strtolower( str_replace( array( ' ', '#', '/', '%' ), array( '_', '', '_', '_percent' ), $h ) ) ); 
    }, $header );

    $created = 0;
    $updated = 0;
    $errors = array();

    while ( ( $row = fgetcsv( $fh, 0, ',', '"', '\\' ) ) !== false ) {
        if ( count( $row ) != count( $header ) ) {
            continue; // Skip malformed rows
        }

        $data = array_combine( $header, $row );
        
        // Required fields check
        if ( empty( $data['name'] ) ) {
            $errors[] = 'Skipping row with empty name';
            continue;
        }

        // Check if product exists
        $existing = get_posts( array(
            'post_type' => 'product',
            'title' => $data['name'],
            'post_status' => 'any',
            'numberposts' => 1,
        ) );

        $post_data = array(
            'post_title' => sanitize_text_field( $data['name'] ),
            'post_content' => wp_kses_post( $data['description'] ?? '' ),
            'post_type' => 'product',
            'post_status' => 'publish',
        );

        if ( $existing ) {
            $post_data['ID'] = $existing[0]->ID;
            $post_id = wp_update_post( $post_data );
            $updated++;
        } else {
            $post_id = wp_insert_post( $post_data );
            $created++;
        }

        if ( is_wp_error( $post_id ) ) {
            $errors[] = 'Failed to create/update product: ' . $data['name'];
            continue;
        }

        // Update ACF fields
        skyworld_update_product_fields( $post_id, $data );
        
        // Assign taxonomies
        skyworld_assign_product_taxonomies( $post_id, $data );
        
        // Handle image import
        if ( ! empty( $data['image_url'] ) ) {
            skyworld_import_featured_image( $post_id, $data['image_url'] );
        }
    }

    fclose( $fh );

    $message = "Import complete: {$created} created, {$updated} updated";
    if ( ! empty( $errors ) ) {
        $message .= '. Errors: ' . implode( ', ', $errors );
    }

    return array( 'success' => true, 'message' => $message );
}

/**
 * Import Cannabis Strains from CSV
 */
function skyworld_import_cannabis_strains( $csv_path ) {
    if ( ! file_exists( $csv_path ) ) {
        return array( 'success' => false, 'message' => 'CSV file not found: ' . $csv_path );
    }

    if ( ( $fh = fopen( $csv_path, 'r' ) ) === false ) {
        return array( 'success' => false, 'message' => 'Unable to open CSV file.' );
    }

    $header = fgetcsv( $fh, 0, ',', '"', '\\' );
    if ( ! $header ) {
        fclose( $fh );
        return array( 'success' => false, 'message' => 'Empty CSV or invalid header.' );
    }

    $header = array_map( function( $h ) { 
        return trim( strtolower( str_replace( array( ' ', '#', '/', '%' ), array( '_', '', '_', '_percent' ), $h ) ) ); 
    }, $header );

    $created = 0;
    $updated = 0;
    $errors = array();

    while ( ( $row = fgetcsv( $fh, 0, ',', '"', '\\' ) ) !== false ) {
        if ( count( $row ) != count( $header ) ) {
            continue;
        }

        $data = array_combine( $header, $row );
        
        if ( empty( $data['name'] ) ) {
            $errors[] = 'Skipping row with empty name';
            continue;
        }

        // Check if strain exists
        $existing = get_posts( array(
            'post_type' => 'strain',
            'title' => $data['name'],
            'post_status' => 'any',
            'numberposts' => 1,
        ) );

        $post_data = array(
            'post_title' => sanitize_text_field( $data['name'] ),
            'post_content' => wp_kses_post( $data['description'] ?? '' ),
            'post_type' => 'strain',
            'post_status' => 'publish',
        );

        if ( $existing ) {
            $post_data['ID'] = $existing[0]->ID;
            $post_id = wp_update_post( $post_data );
            $updated++;
        } else {
            $post_id = wp_insert_post( $post_data );
            $created++;
        }

        if ( is_wp_error( $post_id ) ) {
            $errors[] = 'Failed to create/update strain: ' . $data['name'];
            continue;
        }

        // Update ACF fields
        skyworld_update_strain_fields( $post_id, $data );
        
        // Assign taxonomies
        skyworld_assign_strain_taxonomies( $post_id, $data );
        
        // Handle image import
        if ( ! empty( $data['image_url'] ) ) {
            skyworld_import_featured_image( $post_id, $data['image_url'] );
        }
    }

    fclose( $fh );

    $message = "Strain import complete: {$created} created, {$updated} updated";
    if ( ! empty( $errors ) ) {
        $message .= '. Errors: ' . implode( ', ', $errors );
    }

    return array( 'success' => true, 'message' => $message );
}

// Clean placeholder function for legacy compatibility
function skyworld_import_products_csv( $file, $options = array() ) {
    return array( 'success' => false, 'message' => 'Legacy importer disabled - use JSON import instead' );
}

// Legacy importer - disabled due to syntax issues
/*
// WP-CLI command registration with flags for media import
if ( defined( 'WP_CLI' ) && WP_CLI ) {

    WP_CLI::add_command( 'skyworld import_products', function( $args, $assoc ) {
        $file = $args[0] ?? null;
        if ( ! $file ) {
            WP_CLI::error( 'Please provide a CSV file path.' );
            return;
        }

        // Flags: --import-media (boolean), --media-base=/absolute/path
        $import_media = false;
        if ( isset( $assoc['import-media'] ) ) {
            $val = $assoc['import-media'];
            if ( $val === '' || strtolower( $val ) === 'true' || $val === '1' ) {
                $import_media = true;
            }
        }
        if ( isset( $assoc['import_media'] ) ) { // alternative flag
            $import_media = filter_var( $assoc['import_media'], FILTER_VALIDATE_BOOLEAN );
        }

        $media_base = $assoc['media-base'] ?? ( $assoc['media_base'] ?? '' );

        $options = array(
            'import_media'    => $import_media,
            'media_base_path' => $media_base,
        );

        WP_CLI::log( sprintf( 'Running import: file=%s import_media=%s media_base=%s', $file, $import_media ? 'yes' : 'no', $media_base ) );

        $res = skyworld_import_products_csv( $file, $options );
        if ( empty( $res['success'] ) ) {
            WP_CLI::error( $res['message'] ?? 'Import failed' );
        } else {
            WP_CLI::success( "Imported: rows={$res['rows']}, created={$res['created']}, updated={$res['updated']}" );
        }
    } );
}
*/
