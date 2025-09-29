<?php
/**
 * Admin interface for strain import
 * Add this to functions.php or create as separate file
 */

add_action('admin_menu', function() {
    add_management_page(
        'Import Strains',
        'Import Strains',
        'manage_options',
        'import-strains',
        'skyworld_strain_import_page'
    );
});

function skyworld_strain_import_page() {
    if (isset($_POST['import_strains']) && wp_verify_nonce($_POST['_wpnonce'], 'import_strains')) {
        echo '<div class="wrap"><h1>Importing Strains...</h1><pre>';
        
        $json_file = get_stylesheet_directory() . '/data/skyworld-strains-sample.json';
        
        if (!file_exists($json_file)) {
            echo "JSON file not found: $json_file\n";
            return;
        }
        
        $data = json_decode(file_get_contents($json_file), true);
        if (!is_array($data)) {
            echo "Invalid JSON data\n";
            return;
        }
        
        // Run the import logic here (copy from the WP-CLI script)
        foreach ($data as $row) {
            $post_title = $row['post_title'] ?? '';
            echo "Processing: $post_title\n";
            // Add the import logic...
        }
        
        echo '</pre></div>';
        return;
    }
    
    echo '<div class="wrap">';
    echo '<h1>Import Skyworld Strains</h1>';
    echo '<p>This will import 3 sample strains (Lemon Oreoz, Wafflez, Sherb Cream Pie) with complete ACF data.</p>';
    echo '<form method="post">';
    wp_nonce_field('import_strains');
    echo '<p><input type="submit" name="import_strains" value="Import Sample Strains" class="button-primary" /></p>';
    echo '</form>';
    echo '</div>';
}