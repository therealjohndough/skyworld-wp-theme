<?php
/**
 * Cannabis Product Upload Admin Page
 * Access via WordPress Admin: Tools > Upload Cannabis Products
 */

// Add admin menu
add_action('admin_menu', 'skyworld_add_upload_menu');
function skyworld_add_upload_menu() {
    add_management_page(
        'Upload Cannabis Products',
        'Upload Cannabis Products',
        'manage_options',
        'skyworld-upload',
        'skyworld_upload_page'
    );
}

function skyworld_upload_page() {
    $message = '';
    
    if (isset($_POST['upload_products'])) {
        $message = skyworld_handle_product_upload();
    }
    
    ?>
    <div class="wrap">
        <h1>🌿 Skyworld Cannabis Product Upload</h1>
        
        <?php if ($message): ?>
            <div class="notice notice-success">
                <p><?php echo esc_html($message); ?></p>
            </div>
        <?php endif; ?>
        
        <div class="card">
            <h2>Upload Cannabis Products & Strains</h2>
            <p>This will import your cannabis products and strains from the CSV files.</p>
            
            <form method="post">
                <table class="form-table">
                    <tr>
                        <th>Data to Import</th>
                        <td>
                            <label><input type="checkbox" name="import_strains" checked> Cannabis Strains</label><br>
                            <label><input type="checkbox" name="import_products" checked> Cannabis Products</label><br>
                            <label><input type="checkbox" name="import_coas" checked> COA Documents</label>
                        </td>
                    </tr>
                </table>
                
                <p class="submit">
                    <input type="submit" name="upload_products" class="button-primary" value="Upload Products">
                </p>
            </form>
            
            <h3>CSV File Status</h3>
            <ul>
                <li>Strains CSV: <?php echo file_exists(get_stylesheet_directory() . '/scripts/notion-strain-masters-real.csv') ? '✅ Found' : '❌ Missing'; ?></li>
                <li>Products CSV: <?php echo file_exists(get_stylesheet_directory() . '/scripts/notion-product-batches-real.csv') ? '✅ Found' : '❌ Missing'; ?></li>
                <li>COAs CSV: <?php echo file_exists(get_stylesheet_directory() . '/scripts/notion-coa-documents-real.csv') ? '✅ Found' : '❌ Missing'; ?></li>
            </ul>
        </div>
        
        <div class="card">
            <h2>Current Content</h2>
            <ul>
                <li>Strains: <?php echo wp_count_posts('strain')->publish ?? 0; ?> published</li>
                <li>Products: <?php echo wp_count_posts('product')->publish ?? 0; ?> published</li>
            </ul>
        </div>
    </div>
    
    <style>
    .wrap h1 { color: #2d5016; }
    .card { background: white; padding: 20px; margin: 20px 0; border-left: 4px solid #2d5016; }
    </style>
    <?php
}

function skyworld_handle_product_upload() {
    $results = array();
    $total_imported = 0;
    
    // Import Strains
    if (isset($_POST['import_strains'])) {
        $strain_file = get_stylesheet_directory() . '/scripts/notion-strain-masters-real.csv';
        if (file_exists($strain_file)) {
            $result = skyworld_import_strains_csv($strain_file);
            $results[] = "Strains: " . $result['message'];
            $total_imported += $result['count'];
        }
    }
    
    // Import Products
    if (isset($_POST['import_products'])) {
        $product_file = get_stylesheet_directory() . '/scripts/notion-product-batches-real.csv';
        if (file_exists($product_file)) {
            $result = skyworld_import_products_csv($product_file);
            $results[] = "Products: " . $result['message'];
            $total_imported += $result['count'];
        }
    }
    
    return "Upload Complete! " . implode(' | ', $results);
}

function skyworld_import_strains_csv($csv_path) {
    $handle = fopen($csv_path, 'r');
    $header = fgetcsv($handle);
    $imported = 0;
    $skipped = 0;

    while (($row = fgetcsv($handle)) !== FALSE) {
        $data = array_combine($header, $row);
        
        // Skip if strain exists
        if (get_page_by_title($data['Strain Name'], OBJECT, 'strain')) {
            $skipped++;
            continue;
        }

        // Create strain
        $post_id = wp_insert_post(array(
            'post_title' => sanitize_text_field($data['Strain Name']),
            'post_content' => 'Premium cannabis strain: ' . $data['Genetics'],
            'post_status' => 'publish',
            'post_type' => 'strain'
        ));

        if ($post_id) {
            // Add ACF fields if function exists
            if (function_exists('update_field')) {
                update_field('strain_type', $data['Type'], $post_id);
                update_field('strain_genetics', $data['Genetics'], $post_id);
                update_field('strain_avg_thc', floatval($data['Avg THC']), $post_id);
                update_field('strain_avg_cbd', floatval($data['Avg CBD']), $post_id);
                update_field('strain_effects', $data['Effects'], $post_id);
                update_field('strain_aroma', $data['Nose'], $post_id);
                update_field('strain_flavor', $data['Flavor'], $post_id);
            }
            $imported++;
        }
    }
    
    fclose($handle);
    
    return array(
        'success' => true,
        'count' => $imported,
        'message' => "{$imported} imported, {$skipped} skipped"
    );
}

function skyworld_import_products_csv($csv_path) {
    $handle = fopen($csv_path, 'r');
    $header = fgetcsv($handle);
    $imported = 0;
    $skipped = 0;

    while (($row = fgetcsv($handle)) !== FALSE) {
        $data = array_combine($header, $row);
        
        // Skip if product exists (check by batch number)
        $existing = get_posts(array(
            'post_type' => 'sw-product',
            'meta_query' => array(array(
                'key' => 'product_batch_number',
                'value' => $data['Batch Number']
            )),
            'posts_per_page' => 1
        ));
        
        if (!empty($existing)) {
            $skipped++;
            continue;
        }

        // Find strain
        $strain = get_page_by_title($data['Strain Name'], OBJECT, 'strain');
        
        // Create product
        $title = $data['Strain Name'] . ' - ' . $data['Product Type'];
        $post_id = wp_insert_post(array(
            'post_title' => sanitize_text_field($title),
            'post_content' => $data['Notes'] ?: 'Premium cannabis product.',
            'post_status' => 'publish',
            'post_type' => 'sw-product'
        ));

        if ($post_id && function_exists('update_field')) {
            update_field('product_batch_number', $data['Batch Number'], $post_id);
            update_field('product_strain', $strain ? $strain->ID : null, $post_id);
            update_field('product_type', $data['Product Type'], $post_id);
            update_field('product_thc_percentage', floatval($data['THC %']), $post_id);
            update_field('product_cbd_percentage', floatval($data['CBD %']), $post_id);
            update_field('product_price_1g', floatval($data['Price 1g']), $post_id);
            update_field('product_price_eighth', floatval($data['Price 3.5g']), $post_id);
            update_field('product_price_quarter', floatval($data['Price 7g']), $post_id);
            update_field('product_test_date', $data['Test Date'], $post_id);
            update_field('product_lab_name', $data['Lab Name'], $post_id);
            update_field('product_status', $data['Status'], $post_id);
            
            $imported++;
        }
    }
    
    fclose($handle);
    
    return array(
        'success' => true,
        'count' => $imported,
        'message' => "{$imported} imported, {$skipped} skipped"
    );
}
?>