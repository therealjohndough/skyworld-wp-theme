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

        // helper: import media from URL or local path and attach to post
        if ( ! function_exists( 'skyworld_import_media' ) ) {
            function skyworld_import_media( $image, $post_id, $options = array(), $csv_dir = '' ) {
                if ( ! $image ) return 0;

                // Ensure required WP includes
                if ( ! function_exists( 'media_handle_sideload' ) ) {
                    require_once ABSPATH . 'wp-admin/includes/file.php';
                    require_once ABSPATH . 'wp-admin/includes/media.php';
                    require_once ABSPATH . 'wp-admin/includes/image.php';
                }

                // If remote URL
                if ( filter_var( $image, FILTER_VALIDATE_URL ) ) {
                    $tmp = download_url( $image );
                    if ( is_wp_error( $tmp ) ) return 0;
                    $file_array = array();
                    $file_array['name'] = basename( parse_url( $image, PHP_URL_PATH ) );
                    $file_array['tmp_name'] = $tmp;
                    $id = media_handle_sideload( $file_array, $post_id );
                    if ( is_wp_error( $id ) ) {
                        @unlink( $tmp );
                        return 0;
                    }
                    return $id;
                }

                // Local file path — try absolute, then relative to CSV dir, then media_base_path
                $path = $image;
                if ( ! file_exists( $path ) ) {
                    if ( $csv_dir ) {
                        $try = rtrim( $csv_dir, '/' ) . '/' . ltrim( $image, '/' );
                        if ( file_exists( $try ) ) $path = $try;
                    }
                    if ( ! file_exists( $path ) && ! empty( $options['media_base_path'] ) ) {
                        $try2 = rtrim( $options['media_base_path'], '/' ) . '/' . ltrim( $image, '/' );
                        if ( file_exists( $try2 ) ) $path = $try2;
                    }
                }

                if ( file_exists( $path ) ) {
                    $file_contents = file_get_contents( $path );
                    if ( $file_contents === false ) return 0;
                    $filename = wp_basename( $path );
                    $upload = wp_upload_bits( $filename, null, $file_contents );
                    if ( ! empty( $upload['error'] ) ) return 0;
                    $wp_filetype = wp_check_filetype( $upload['file'], null );
                    $attachment = array(
                        'post_mime_type' => $wp_filetype['type'] ?? 'image/jpeg',
                        'post_title'     => sanitize_file_name( $filename ),
                        'post_content'   => '',
                        'post_status'    => 'inherit'
                    );
                    $attach_id = wp_insert_attachment( $attachment, $upload['file'], $post_id );
                    if ( is_wp_error( $attach_id ) ) return 0;
                    require_once ABSPATH . 'wp-admin/includes/image.php';
                    $attach_data = wp_generate_attachment_metadata( $attach_id, $upload['file'] );
                    wp_update_attachment_metadata( $attach_id, $attach_data );
                    return $attach_id;
                }

                return 0;
            }
        }

    while ( ( $row = fgetcsv( $fh, 0, ',', '"', '\\' ) ) !== false ) {
            $rows++;
            $data = array();
            foreach ( $header as $i => $col ) {
                $data[ $col ] = isset( $row[ $i ] ) ? trim( $row[ $i ] ) : '';
            }

            // Map CSV columns to our fields
            $strain_name = $data['strain_name'] ?? $data['strain'] ?? '';
            $strain_type = $data['type'] ?? '';
            $genetics = $data['genetics'] ?? '';
            $thc = isset( $data['thc'] ) ? rtrim( $data['thc'], '%' ) : '';
            $pert_total = $data['terp_total'] ?? '';
            $terp_1 = $data['terp_1'] ?? '';
            $terp_2 = $data['terp_2'] ?? '';
            $terp_3 = $data['terp_3'] ?? '';
            $effects = $data['effects'] ?? '';
            $nose = $data['nose'] ?? '';
            $flavor = $data['flavor'] ?? '';
            $image = $data['@image'] ?? $data['image'] ?? '';
            $batch = $data['batch_lot_'] ?? $data['batch_lot_#'] ?? $data['batch_lot_#_'] ?? $data['batch/lot_#'] ?? $data['batch/lot_#_'] ?? $data['batch/lot_#'] ?? $data['batch/lot_#_'] ?? $data['batch/lot_#'] ?? $data['batch/lot_'] ?? $data['batch/lot_#'] ?? $data['batch/lot_'] ?? $data['batch_lot_'] ?? $data['batch/lot_#'] ?? $data['batch_lot_#'] ?? $data['batch/lot_'] ?? $data['batch/lot_#'] ?? $data['batch/lot_'] ?? $data['batch/lot_#'] ?? $data['batch/lot_#_'] ?? $data['batch_lot_#'] ?? $data['batch/lot_'] ?? $data['batch_lot'] ?? $data['batch'] ?? $data['batch_lot_#_'] ?? $data['batch_lot_#'];
            $batch = $batch ?: ( $data['batch/lot_#'] ?? ( $data['batch/lot_'] ?? ( $data['batch/lot'] ?? ( $data['batch_lot'] ?? '' ) ) ) );
            $status = $data['status'] ?? '';

            // Find or create strain
            $strain_post = null;
            if ( $strain_name ) {
                $strain_post = get_page_by_title( $strain_name, OBJECT, 'strain' );
                if ( ! $strain_post ) {
                    $sargs = array(
                        'post_title' => wp_strip_all_tags( $strain_name ),
                        'post_type' => 'strain',
                        'post_status' => 'publish',
                    );
                    $sid = wp_insert_post( $sargs );
                    if ( $sid ) {
                        $created++;
                        $strain_post = get_post( $sid );
                    }
                }

                if ( $strain_post ) {
                    if ( $genetics ) update_post_meta( $strain_post->ID, 'genetics', $genetics );
                    if ( $nose ) update_post_meta( $strain_post->ID, 'nose', $nose );
                    if ( $pert_total ) update_post_meta( $strain_post->ID, 'pert_total', $pert_total );
                    if ( $strain_type ) update_post_meta( $strain_post->ID, 'type', $strain_type );

                    // terpenes
                    $terps = array();
                    if ( $terp_1 ) $terps[] = $terp_1;
                    if ( $terp_2 ) $terps[] = $terp_2;
                    if ( $terp_3 ) $terps[] = $terp_3;
                    if ( ! empty( $terps ) ) {
                        foreach ( $terps as $t ) {
                            if ( ! term_exists( $t, 'terpene' ) ) wp_insert_term( $t, 'terpene' );
                        }
                        wp_set_object_terms( $strain_post->ID, $terps, 'terpene', false );
                    }

                    // effects
                    if ( $effects ) {
                        $effects_list = array_map( 'trim', explode( ',', $effects ) );
                        foreach ( $effects_list as $e ) {
                            if ( $e && ! term_exists( $e, 'effects' ) ) wp_insert_term( $e, 'effects' );
                        }
                        wp_set_object_terms( $strain_post->ID, $effects_list, 'effects', false );
                    }
                }
            }

            // Create or update product by batch number
            $existing = null;
            if ( $batch ) {
                $q = new WP_Query( array( 'post_type' => 'sky_product', 'meta_query' => array( array( 'key' => 'batch_number', 'value' => $batch, 'compare' => '=' ) ), 'posts_per_page' => 1 ) );
                if ( $q->have_posts() ) {
                    $existing = $q->posts[0];
                    wp_reset_postdata();
                }
            }

            $p_title = $strain_name ? ( $strain_name . ' — ' . $batch ) : ( $batch ?: ( $strain_name ?: 'Untitled Product' ) );

            if ( $existing ) {
                $pid = $existing->ID;
                wp_update_post( array( 'ID' => $pid, 'post_title' => $p_title ) );
                $updated++;
            } else {
                $pid = wp_insert_post( array( 'post_title' => $p_title, 'post_type' => 'sky_product', 'post_status' => 'publish' ) );
                if ( $pid ) $created++;
            }

                if ( $pid ) {
                    if ( $batch ) update_post_meta( $pid, 'batch_number', $batch );
                    if ( $thc ) update_post_meta( $pid, 'thc_percent', $thc );
                    if ( $pert_total ) update_post_meta( $pid, 'pert_total', $pert_total );
                    if ( $status ) update_post_meta( $pid, 'stock_status', $status );
                    if ( $image ) update_post_meta( $pid, 'image_path', $image );

                    // optionally import and attach media
                    if ( ! empty( $options['import_media'] ) && $image ) {
                        $attach_id = skyworld_import_media( $image, $pid, $options, $csv_dir );
                        if ( $attach_id ) {
                            set_post_thumbnail( $pid, $attach_id );
                            update_post_meta( $pid, '_thumbnail_id', $attach_id );
                        }
                    }

                    if ( $strain_post ) {
                        // link product to strain
                        if ( function_exists( 'update_field' ) ) {
                            update_field( 'related_strain', $strain_post->ID, $pid );
                        } else {
                            update_post_meta( $pid, 'related_strain', $strain_post->ID );
                        }
                    }
                }
            }

        fclose( $fh );

        return array( 'success' => true, 'rows' => $rows, 'created' => $created, 'updated' => $updated );
    }
}

// Placeholder function to fix syntax error
function skyworld_import_products_csv( $file, $options = array() ) {
    return array( 'success' => false, 'message' => 'Legacy importer disabled' );
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
