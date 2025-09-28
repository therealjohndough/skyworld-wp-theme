<?php
/**
 * Professional Cannabis Product Importer for Skyworld
 * Created by John Dough - MADE TO INSPIRE
 * 
 * Handles import of cannabis products, strains, and locations
 * with proper ACF field mapping and taxonomy assignment
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
        $message .= '. Errors: ' . implode( ', ', array_slice( $errors, 0, 5 ) );
    }

    return array( 'success' => true, 'message' => $message );
}

/**
 * Update Product ACF Fields
 */
function skyworld_update_product_fields( $post_id, $data ) {
    $field_mappings = array(
        'thc_percentage' => 'thc_content',
        'thc_percent' => 'thc_content',
        'cbd_percentage' => 'cbd_content', 
        'cbd_percent' => 'cbd_content',
        'terpenes' => 'terpene_profile',
        'dominant_terpenes' => 'terpene_profile',
        'effects' => 'effects',
        'genetics' => 'genetics',
        'strain_lineage' => 'genetics',
        'package_size' => 'package_size',
        'weight' => 'package_size',
        'price' => 'price',
        'retail_price' => 'price',
    );

    foreach ( $field_mappings as $csv_field => $acf_field ) {
        if ( isset( $data[ $csv_field ] ) && ! empty( $data[ $csv_field ] ) ) {
            update_field( $acf_field, sanitize_text_field( $data[ $csv_field ] ), $post_id );
        }
    }
}

/**
 * Assign Product Taxonomies
 */
function skyworld_assign_product_taxonomies( $post_id, $data ) {
    // Strain Type (Indica, Sativa, Hybrid)
    if ( ! empty( $data['strain_type'] ) || ! empty( $data['type'] ) ) {
        $strain_type = $data['strain_type'] ?? $data['type'];
        wp_set_object_terms( $post_id, sanitize_text_field( $strain_type ), 'strain_type' );
    }

    // Product Type (Flower, Pre-roll, etc)
    if ( ! empty( $data['product_type'] ) || ! empty( $data['category'] ) ) {
        $product_type = $data['product_type'] ?? $data['category'];
        wp_set_object_terms( $post_id, sanitize_text_field( $product_type ), 'product_type' );
    }

    // Package Size
    if ( ! empty( $data['package_size'] ) || ! empty( $data['weight'] ) ) {
        $package_size = $data['package_size'] ?? $data['weight'];
        wp_set_object_terms( $post_id, sanitize_text_field( $package_size ), 'package_size' );
    }
}

/**
 * Import Featured Image from URL
 */
function skyworld_import_featured_image( $post_id, $image_url ) {
    if ( ! filter_var( $image_url, FILTER_VALIDATE_URL ) ) {
        return false;
    }

    // Check if post already has featured image
    if ( has_post_thumbnail( $post_id ) ) {
        return true; // Skip if already has image
    }

    // Ensure required WP includes
    if ( ! function_exists( 'media_handle_sideload' ) ) {
        require_once ABSPATH . 'wp-admin/includes/file.php';
        require_once ABSPATH . 'wp-admin/includes/media.php';
        require_once ABSPATH . 'wp-admin/includes/image.php';
    }

    // Download the image
    $tmp = download_url( $image_url );
    if ( is_wp_error( $tmp ) ) {
        return false;
    }

    $file_array = array(
        'name' => basename( parse_url( $image_url, PHP_URL_PATH ) ),
        'tmp_name' => $tmp,
    );

    // Import as attachment
    $attachment_id = media_handle_sideload( $file_array, $post_id );

    // Clean up temp file
    @unlink( $tmp );

    if ( is_wp_error( $attachment_id ) ) {
        return false;
    }

    // Set as featured image
    set_post_thumbnail( $post_id, $attachment_id );
    
    return true;
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

        // Update ACF fields for strains
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
        $message .= '. Errors: ' . implode( ', ', array_slice( $errors, 0, 5 ) );
    }

    return array( 'success' => true, 'message' => $message );
}

/**
 * Update Strain ACF Fields
 */
function skyworld_update_strain_fields( $post_id, $data ) {
    $field_mappings = array(
        'genetics' => 'genetics',
        'lineage' => 'genetics',
        'thc_min' => 'thc_min',
        'thc_max' => 'thc_max', 
        'cbd_min' => 'cbd_min',
        'cbd_max' => 'cbd_max',
        'dominant_terpenes' => 'dominant_terpenes',
        'terpenes' => 'dominant_terpenes',
        'effects' => 'effects',
        'medical_benefits' => 'medical_benefits',
        'grow_info' => 'grow_information',
    );

    foreach ( $field_mappings as $csv_field => $acf_field ) {
        if ( isset( $data[ $csv_field ] ) && ! empty( $data[ $csv_field ] ) ) {
            update_field( $acf_field, sanitize_text_field( $data[ $csv_field ] ), $post_id );
        }
    }
}

/**
 * Assign Strain Taxonomies
 */
function skyworld_assign_strain_taxonomies( $post_id, $data ) {
    // Strain Type (Indica, Sativa, Hybrid)
    if ( ! empty( $data['type'] ) || ! empty( $data['strain_type'] ) ) {
        $strain_type = $data['type'] ?? $data['strain_type'];
        wp_set_object_terms( $post_id, sanitize_text_field( $strain_type ), 'strain_type' );
    }
}

/**
 * Admin Interface for Manual Import
 */
add_action( 'admin_menu', 'skyworld_importer_admin_menu' );

function skyworld_importer_admin_menu() {
    add_submenu_page(
        'edit.php?post_type=product',
        'Import Cannabis Data',
        'Import Data',
        'manage_options',
        'skyworld-importer',
        'skyworld_importer_admin_page'
    );
}

function skyworld_importer_admin_page() {
    ?>
    <div class="wrap">
        <h1><i class="ph ph-download-simple"></i> Skyworld Cannabis Data Importer</h1>
        <p>Import cannabis products, strains, and locations from CSV files.</p>
        
        <div class="skyworld-import-sections">
            <div class="import-section">
                <h2>Products Import</h2>
                <p>Expected CSV columns: name, description, strain_type, thc_percentage, cbd_percentage, terpenes, effects, image_url</p>
                <form method="post" enctype="multipart/form-data">
                    <?php wp_nonce_field( 'skyworld_import_products' ); ?>
                    <input type="file" name="products_csv" accept=".csv" required>
                    <input type="submit" name="import_products" class="button-primary" value="Import Products">
                </form>
            </div>
            
            <div class="import-section">
                <h2>Strains Import</h2>
                <p>Expected CSV columns: name, description, type, genetics, thc_min, thc_max, cbd_min, cbd_max, dominant_terpenes, effects</p>
                <form method="post" enctype="multipart/form-data">
                    <?php wp_nonce_field( 'skyworld_import_strains' ); ?>
                    <input type="file" name="strains_csv" accept=".csv" required>
                    <input type="submit" name="import_strains" class="button-primary" value="Import Strains">
                </form>
            </div>
        </div>
        
        <?php
        // Handle form submissions
        if ( isset( $_POST['import_products'] ) && wp_verify_nonce( $_POST['_wpnonce'], 'skyworld_import_products' ) ) {
            skyworld_handle_products_upload();
        }
        
        if ( isset( $_POST['import_strains'] ) && wp_verify_nonce( $_POST['_wpnonce'], 'skyworld_import_strains' ) ) {
            skyworld_handle_strains_upload();
        }
        ?>
    </div>
    
    <style>
    .skyworld-import-sections {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
        gap: 2rem;
        margin-top: 2rem;
    }
    
    .import-section {
        background: #fff;
        border: 1px solid #ccd0d4;
        border-radius: 4px;
        padding: 1.5rem;
        box-shadow: 0 1px 1px rgba(0,0,0,.04);
    }
    
    .import-section h2 {
        margin-top: 0;
        color: #2d5016;
    }
    
    .import-section form {
        margin-top: 1rem;
    }
    
    .import-section input[type="file"] {
        margin-bottom: 1rem;
        width: 100%;
    }
    </style>
    <?php
}

function skyworld_handle_products_upload() {
    if ( ! isset( $_FILES['products_csv'] ) || $_FILES['products_csv']['error'] !== UPLOAD_ERR_OK ) {
        echo '<div class="notice notice-error"><p>Error uploading CSV file.</p></div>';
        return;
    }
    
    $result = skyworld_import_cannabis_products( $_FILES['products_csv']['tmp_name'] );
    
    if ( $result['success'] ) {
        echo '<div class="notice notice-success"><p>' . esc_html( $result['message'] ) . '</p></div>';
    } else {
        echo '<div class="notice notice-error"><p>' . esc_html( $result['message'] ) . '</p></div>';
    }
}

function skyworld_handle_strains_upload() {
    if ( ! isset( $_FILES['strains_csv'] ) || $_FILES['strains_csv']['error'] !== UPLOAD_ERR_OK ) {
        echo '<div class="notice notice-error"><p>Error uploading CSV file.</p></div>';
        return;
    }
    
    $result = skyworld_import_cannabis_strains( $_FILES['strains_csv']['tmp_name'] );
    
    if ( $result['success'] ) {
        echo '<div class="notice notice-success"><p>' . esc_html( $result['message'] ) . '</p></div>';
    } else {
        echo '<div class="notice notice-error"><p>' . esc_html( $result['message'] ) . '</p></div>';
    }
}