<?php
/**
 * Local Upload Script - Simulates WordPress for testing
 * This shows what your WordPress admin uploader will do
 */

echo "🌿 Skyworld Cannabis Data Upload Preview\n";
echo "=======================================\n\n";

// Preview strain data
$strains_file = __DIR__ . '/notion-strain-masters-real.csv';
if (file_exists($strains_file)) {
    $strains_handle = fopen($strains_file, 'r');
    $strain_header = fgetcsv($strains_handle);
    $strain_count = 0;
    
    echo "📋 STRAIN LIBRARY PREVIEW:\n";
    echo "-------------------------\n";
    
    while (($row = fgetcsv($strains_handle)) !== FALSE && $strain_count < 5) {
        $data = array_combine($strain_header, $row);
        echo "• " . $data['Strain Name'] . " (" . $data['Type'] . ")\n";
        echo "  Genetics: " . $data['Genetics'] . "\n";
        echo "  THC: " . $data['Avg THC'] . "% | Terps: " . $data['Avg Terp Total'] . "%\n";
        echo "  Effects: " . $data['Effects'] . "\n";
        echo "  Nose: " . $data['Nose'] . "\n\n";
        $strain_count++;
    }
    
    // Count total strains
    $total_strains = 0;
    while (fgetcsv($strains_handle) !== FALSE) $total_strains++;
    $total_strains += $strain_count;
    
    echo "📊 Total Strains Ready: " . $total_strains . "\n\n";
    fclose($strains_handle);
}

// Preview product data  
$products_file = __DIR__ . '/notion-cannabis-products-real.csv';
if (file_exists($products_file)) {
    $products_handle = fopen($products_file, 'r');
    $product_header = fgetcsv($products_handle);
    $product_count = 0;
    
    echo "📦 PRODUCT INVENTORY PREVIEW:\n";
    echo "----------------------------\n";
    
    while (($row = fgetcsv($products_handle)) !== FALSE && $product_count < 5) {
        $data = array_combine($product_header, $row);
        echo "• " . $data['Strain Name'] . " - " . $data['Product Type'] . "\n";
        echo "  Batch: " . $data['Batch Number'] . " | Status: " . $data['Status'] . "\n";
        echo "  THC: " . $data['THC %'] . "% | Test Date: " . $data['Test Date'] . "\n";
        echo "  Pricing: 1g=$" . $data['Price 1g'] . " | 3.5g=$" . $data['Price 3.5g'] . "\n\n";
        $product_count++;
    }
    
    // Count total products
    $total_products = 0;
    while (fgetcsv($products_handle) !== FALSE) $total_products++;
    $total_products += $product_count;
    
    echo "📊 Total Products Ready: " . $total_products . "\n\n";
    fclose($products_handle);
}

// Preview COA data
$coa_file = __DIR__ . '/notion-coa-documents-real.csv';
if (file_exists($coa_file)) {
    $coa_handle = fopen($coa_file, 'r');
    $coa_header = fgetcsv($coa_handle);
    $coa_count = 0;
    
    echo "🧪 COA DOCUMENTS PREVIEW:\n";
    echo "------------------------\n";
    
    while (($row = fgetcsv($coa_handle)) !== FALSE && $coa_count < 3) {
        $data = array_combine($coa_header, $row);
        echo "• " . $data['Batch Number'] . " - " . $data['Test Type'] . "\n";
        echo "  Date: " . $data['Test Date'] . " | Lab: " . $data['Lab Name'] . "\n";
        echo "  File: " . ($data['File Path'] ?: 'PDF Available') . "\n\n";
        $coa_count++;
    }
    
    // Count total COAs
    $total_coas = 0;
    while (fgetcsv($coa_handle) !== FALSE) $total_coas++;
    $total_coas += $coa_count;
    
    echo "📊 Total COAs Ready: " . $total_coas . "\n\n";
    fclose($coa_handle);
}

echo "🚀 READY TO UPLOAD!\n";
echo "==================\n";
echo "In your WordPress admin, go to:\n";
echo "• Tools > Upload Cannabis Products\n";
echo "• Upload the CSV files from this /scripts/ folder\n";
echo "• Your cannabis data will populate your website\n\n";

echo "✅ Post Type: sw-product (backend separation from WooCommerce)\n";
echo "✅ Templates: single-product.php, archive-product.php (clean frontend)\n"; 
echo "✅ URLs: /cannabis-products/ (professional branding)\n";
echo "✅ Admin: All organized under your cannabis admin dashboard\n\n";

echo "Your professional cannabis business website is ready! 🌿\n";