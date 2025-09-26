<?php
/**
 * Simple CSV importer for Skyworld products.
 *
 * Usage (WP-CLI):
 *   wp skyworld import_products /absolute/path/to/file.csv
 *
 * Or call programmatically: skyworld_import_products_csv( '/path/to/file.csv' );
 */

if ( ! function_exists( 'skyworld_import_products_csv' ) ) {
    function skyworld_import_products_csv( $csv_path ) {
        if ( ! file_exists( $csv_path ) ) {
            return array( 'success' => false, 'message' => 'CSV file not found: ' . $csv_path );
        }

        if ( ( $fh = fopen( $csv_path, 'r' ) ) === false ) {
            return array( 'success' => false, 'message' => 'Unable to open CSV.' );
        }

        $header = fgetcsv( $fh );
        if ( ! $header ) {
            fclose( $fh );
            return array( 'success' => false, 'message' => 'Empty CSV or invalid header.' );
        }

        // Normalize headers
        $header = array_map( function( $h ) { return trim( strtolower( str_replace( array( ' ', '#', '/' ), array( '_', '', '_' ), $h ) ) ); }, $header );

        $created = 0;
        $updated = 0;
        $rows = 0;

        while ( ( $row = fgetcsv( $fh ) ) !== false ) {
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

// WP-CLI command registration
if ( defined( 'WP_CLI' ) && WP_CLI ) {
    
    WP_CLI::add_command( 'skyworld import_products', function( $args, $assoc ) {
        $file = $args[0] ?? null;
        if ( ! $file ) {
            WP_CLI::error( 'Please provide a CSV file path.' );
            return;
        }
        $res = skyworld_import_products_csv( $file );
        if ( empty( $res['success'] ) ) {
            WP_CLI::error( $res['message'] ?? 'Import failed' );
        } else {
            WP_CLI::success( "Imported: rows={$res['rows']}, created={$res['created']}, updated={$res['updated']}" );
        }
    } );
}
