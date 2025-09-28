
<?php
/**
 * Product Upload Script for Skyworld Cannabis
 * Run this to upload all your cannabis products and strains
 */

// Include WordPress
require_once('../../../wp-config.php');

echo "🌿 Skyworld Cannabis Product Upload Starting...\n\n";

// Define paths to your CSV files
$csv_files = array(
    'strains' => get_stylesheet_directory() . '/scripts/notion-strain-masters-real.csv',
    'products' => get_stylesheet_directory() . '/scripts/notion-product-batches-real.csv',
    'coas' => get_stylesheet_directory() . '/scripts/notion-coa-documents-real.csv'
);

$results = array();

// Import Strains First (products depend on strains)
echo "📋 Step 1: Importing Cannabis Strains...\n";
if (file_exists($csv_files['strains'])) {
    $strain_result = import_skyworld_strains($csv_files['strains']);
    $results['strains'] = $strain_result;
    echo "✅ Strains: " . $strain_result['message'] . "\n\n";
} else {
    echo "❌ Strain CSV file not found\n\n";
}

// Import Products
echo "📦 Step 2: Importing Cannabis Products...\n";
if (file_exists($csv_files['products'])) {
    $product_result = import_skyworld_products($csv_files['products']);
    $results['products'] = $product_result;
    echo "✅ Products: " . $product_result['message'] . "\n\n";
} else {
    echo "❌ Product CSV file not found\n\n";
}

// Import COAs
echo "🧪 Step 3: Importing COA Documents...\n";
if (file_exists($csv_files['coas'])) {
    $coa_result = import_skyworld_coas($csv_files['coas']);
    $results['coas'] = $coa_result;
    echo "✅ COAs: " . $coa_result['message'] . "\n\n";
} else {
    echo "❌ COA CSV file not found\n\n";
}

echo "🎉 Product Upload Complete!\n";
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
echo "Summary:\n";
foreach ($results as $type => $result) {
    echo "• " . ucfirst($type) . ": " . ($result['success'] ? '✅ Success' : '❌ Failed') . "\n";
}

/**
 * Import Strains from CSV
 */
function import_skyworld_strains($csv_path) {
    if (!file_exists($csv_path)) {
        return array('success' => false, 'message' => 'Strain CSV not found');
    }

    $handle = fopen($csv_path, 'r');
    $header = fgetcsv($handle);
    $imported = 0;
    $skipped = 0;

    while (($row = fgetcsv($handle)) !== FALSE) {
        $strain_data = array_combine($header, $row);
        
        // Check if strain already exists
        $existing = get_page_by_title($strain_data['Strain Name'], OBJECT, 'strain');
        if ($existing) {
            $skipped++;
            continue;
        }

        // Create strain post
        $strain_post = array(
            'post_title' => sanitize_text_field($strain_data['Strain Name']),
            'post_content' => 'Premium cannabis strain with detailed genetics and lab testing.',
            'post_status' => 'publish',
            'post_type' => 'strain'
        );

        $strain_id = wp_insert_post($strain_post);
        
        if ($strain_id) {
            // Add ACF fields
            update_field('strain_type', $strain_data['Type'], $strain_id);
            update_field('strain_genetics', $strain_data['Genetics'], $strain_id);
            update_field('strain_avg_thc', floatval($strain_data['Avg THC']), $strain_id);
            update_field('strain_avg_cbd', floatval($strain_data['Avg CBD']), $strain_id);
            update_field('strain_effects', $strain_data['Effects'], $strain_id);
            update_field('strain_aroma', $strain_data['Nose'], $strain_id);
            update_field('strain_flavor', $strain_data['Flavor'], $strain_id);
            
            $imported++;
        }
    }
    
    fclose($handle);
    
    return array(
        'success' => true, 
        'message' => "Imported {$imported} strains, skipped {$skipped} existing"
    );
}

/**
 * Import Products from CSV
 */
function import_skyworld_products($csv_path) {
    if (!file_exists($csv_path)) {
        return array('success' => false, 'message' => 'Product CSV not found');
    }

    $handle = fopen($csv_path, 'r');
    $header = fgetcsv($handle);
    $imported = 0;
    $skipped = 0;

    while (($row = fgetcsv($handle)) !== FALSE) {
        $product_data = array_combine($header, $row);
        
        // Check if product already exists by batch number
        $existing = get_posts(array(
            'post_type' => 'sw-product',
            'meta_query' => array(
                array(
                    'key' => 'product_batch_number',
                    'value' => $product_data['Batch Number'],
                    'compare' => '='
                )
            )
        ));
        
        if (!empty($existing)) {
            $skipped++;
            continue;
        }

        // Find related strain
        $strain = get_page_by_title($product_data['Strain Name'], OBJECT, 'strain');
        $strain_id = $strain ? $strain->ID : null;

        // Create product post
        $product_title = $product_data['Strain Name'] . ' - ' . $product_data['Product Type'];
        $product_post = array(
            'post_title' => sanitize_text_field($product_title),
            'post_content' => $product_data['Notes'] ?: 'Premium cannabis product with lab testing.',
            'post_status' => 'publish',
            'post_type' => 'sw-product'
        );

        $product_id = wp_insert_post($product_post);
        
        if ($product_id) {
            // Add ACF fields
            update_field('product_batch_number', $product_data['Batch Number'], $product_id);
            update_field('product_strain', $strain_id, $product_id);
            update_field('product_type', $product_data['Product Type'], $product_id);
            update_field('product_thc_percentage', floatval($product_data['THC %']), $product_id);
            update_field('product_cbd_percentage', floatval($product_data['CBD %']), $product_id);
            update_field('product_price_1g', floatval($product_data['Price 1g']), $product_id);
            update_field('product_price_eighth', floatval($product_data['Price 3.5g']), $product_id);
            update_field('product_price_quarter', floatval($product_data['Price 7g']), $product_id);
            update_field('product_test_date', $product_data['Test Date'], $product_id);
            update_field('product_lab_name', $product_data['Lab Name'], $product_id);
            update_field('product_status', $product_data['Status'], $product_id);
            
            $imported++;
        }
    }
    
    fclose($handle);
    
    return array(
        'success' => true, 
        'message' => "Imported {$imported} products, skipped {$skipped} existing"
    );
}

/**
 * Import COAs from CSV
 */
function import_skyworld_coas($csv_path) {
    if (!file_exists($csv_path)) {
        return array('success' => false, 'message' => 'COA CSV not found');
    }

    $handle = fopen($csv_path, 'r');
    $header = fgetcsv($handle);
    $imported = 0;
    $skipped = 0;

    while (($row = fgetcsv($handle)) !== FALSE) {
        $coa_data = array_combine($header, $row);
        
        // Find related product by batch number
        $products = get_posts(array(
            'post_type' => 'sw-product',
            'meta_query' => array(
                array(
                    'key' => 'product_batch_number',
                    'value' => $coa_data['Batch Number'],
                    'compare' => '='
                )
            )
        ));
        
        if (!empty($products)) {
            $product_id = $products[0]->ID;
            
            // Update product with COA data
            update_field('product_coa_url', $coa_data['COA URL'], $product_id);
            update_field('product_coa_date', $coa_data['Test Date'], $product_id);
            
            $imported++;
        } else {
            $skipped++;
        }
    }
    
    fclose($handle);
    
    return array(
        'success' => true, 
        'message' => "Updated {$imported} products with COAs, skipped {$skipped} missing products"
    );
}
?>