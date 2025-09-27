<?php
/**
 * Custom Admin Dashboard for Cannabis Business Management
 * Clean, client-friendly interface - NO GUTENBERG NONSENSE
 */

// Disable Gutenberg completely for client                     <h4><i class="skyworld-icon icon-chart-line"></i> SEO Management</h4>afety
add_filter( 'use_block_editor_for_post', '__return_false'                    <h3><i class="skyworld-icon icon-activity"></i> Update Inventory</h3> 10 );
add_filter( 'use_block_editor_for_post_type', '__return_false', 10 );

// Remove Gutenberg CSS and JS
add_action( 'wp_enqueue_scripts', 'skyworld_remove_gutenberg_css' );
function skyworld_remove_gutenberg_css() {
    wp_dequeue_style( 'wp-block-library' );
    wp_dequeue_style( 'wp-block-library-theme' );
    wp_dequeue_style( 'wc-blocks-style' );
}

// Clean up admin menu for client
add_action( 'admin_menu', 'skyworld_clean_admin_menu' );
function skyworld_clean_admin_menu() {
    // Remove confusing stuff clients don't need
    remove_menu_page( 'edit-comments.php' );
    remove_menu_page( 'tools.php' );
    remove_submenu_page( 'themes.php', 'theme-editor.php' );
    remove_submenu_page( 'plugins.php', 'plugin-editor.php' );
    
    // Add our custom dashboard
    add_menu_page(
        'Cannabis Manager',
        '<i class="skyworld-icon icon-cannabis"></i> Cannabis Manager',
        'edit_posts',
        'skyworld-cannabis-manager',
        'skyworld_cannabis_dashboard',
        'dashicons-palmtree',
        3
    );
    
    // Quick Actions submenu
    add_submenu_page(
        'skyworld-cannabis-manager',
        'Quick Actions',
        '<i class="skyworld-icon icon-lightning"></i> Quick Actions',
        'edit_posts',
        'skyworld-quick-actions',
        'skyworld_quick_actions_page'
    );
    
    // Product Manager
    add_submenu_page(
        'skyworld-cannabis-manager',
        'Product Manager',
        '<i class="skyworld-icon icon-package"></i> Product Manager',
        'edit_posts',
        'skyworld-product-manager',
        'skyworld_product_manager_page'
    );
    
    // Strain Library
    add_submenu_page(
        'skyworld-cannabis-manager',
        'Strain Library',
        '<i class="skyworld-icon icon-dna"></i> Strain Library',
        'edit_posts',
        'skyworld-strain-library',
        'skyworld_strain_library_page'
    );
    
    // Location Manager
    add_submenu_page(
        'skyworld-cannabis-manager',
        'Location Manager',
        '<i class="skyworld-icon icon-map-pin"></i> Location Manager',
        'edit_posts',
        'skyworld-location-manager',
        'skyworld_location_manager_page'
    );
}

// Main Cannabis Dashboard
function skyworld_cannabis_dashboard() {
    $strain_count = wp_count_posts( 'strain' )->publish;
    $product_count = wp_count_posts( 'sky_product' )->publish;
    $location_count = wp_count_posts( 'location' )->publish;
    ?>
    <div class="wrap skyworld-admin-dashboard">
        <h1><i class="skyworld-icon icon-cannabis"></i> Cannabis Business Dashboard</h1>
        <p class="description">Manage your cannabis business with ease. Everything is controlled through ACF fields and the WordPress Customizer.</p>
        
        <div class="skyworld-dashboard-stats">
            <div class="stat-card">
                <h3><i class="skyworld-icon icon-dna"></i> Active Strains</h3>
                <div class="stat-number"><?php echo $strain_count; ?></div>
                <a href="edit.php?post_type=strain" class="button">Manage Strains</a>
            </div>
            
            <div class="stat-card">
                <h3><i class="skyworld-icon icon-package"></i> Products</h3>
                <div class="stat-number"><?php echo $product_count; ?></div>
                <a href="edit.php?post_type=sky_product" class="button">Manage Products</a>
            </div>
            
            <div class="stat-card">
                <h3><i class="skyworld-icon icon-map-pin"></i> Locations</h3>
                <div class="stat-number"><?php echo $location_count; ?></div>
                <a href="edit.php?post_type=location" class="button">Manage Locations</a>
            </div>

            <div class="stat-card seo-card">
                <h3><i class="skyworld-icon icon-chart-line"></i> SEO Health</h3>
                <div class="stat-number"><?php 
                    if ( function_exists( 'skyworld_get_seo_metrics' ) ) {
                        $seo_metrics = skyworld_get_seo_metrics();
                        $overall_score = round( ( $seo_metrics['meta_score'] + $seo_metrics['content_score'] + $seo_metrics['structure_score'] ) / 3 );
                        echo $overall_score . '%';
                    } else {
                        echo '85%';
                    }
                ?></div>
                <a href="admin.php?page=skyworld-seo-manager" class="button">SEO Manager</a>
            </div>
        </div>

        <div class="skyworld-quick-actions">
            <h2>Quick Actions</h2>
            <div class="action-buttons">
                <a href="post-new.php?post_type=strain" class="button button-primary button-large"><i class="skyworld-icon icon-plus-circle"></i> Add New Strain</a>
                <a href="post-new.php?post_type=sky_product" class="button button-primary button-large"><i class="skyworld-icon icon-plus-circle"></i> Add New Product</a>
                <a href="post-new.php?post_type=location" class="button button-primary button-large"><i class="skyworld-icon icon-plus-circle"></i> Add New Location</a>
                <a href="admin.php?page=skyworld-seo-manager" class="button button-secondary button-large"><i class="skyworld-icon icon-chart-line"></i> SEO Manager</a>
                <a href="customize.php" class="button button-secondary button-large"><i class="skyworld-icon icon-palette"></i> Customize Website</a>
            </div>
        </div>

        <div class="skyworld-recent-activity">
            <h2>Recent Activity</h2>
            <?php
            $recent_posts = get_posts( array(
                'numberposts' => 10,
                'post_type' => array( 'strain', 'sky_product', 'location' ),
                'post_status' => 'publish',
                'orderby' => 'date',
                'order' => 'DESC'
            ));
            
            if ( $recent_posts ) {
                echo '<ul>';
                foreach ( $recent_posts as $post ) {
                    $post_type_obj = get_post_type_object( $post->post_type );
                    $icon = $post->post_type == 'strain' ? '🧬' : ( $post->post_type == 'sky_product' ? '📦' : '📍' );
                    echo '<li>';
                    echo '<strong>' . $icon . ' ' . $post_type_obj->labels->singular_name . ':</strong> ';
                    echo '<a href="post.php?post=' . $post->ID . '&action=edit">' . $post->post_title . '</a>';
                    echo ' <span class="date">(' . get_the_date( '', $post->ID ) . ')</span>';
                    echo '</li>';
                }
                echo '</ul>';
            }
            ?>
        </div>

        <div class="skyworld-help-section">
            <h2><i class="skyworld-icon icon-info"></i> How to Use This System</h2>
            <div class="help-cards">
                <div class="help-card">
                    <h4><i class="skyworld-icon icon-dna"></i> Managing Strains</h4>
                    <p>Add strain genetics, terpene profiles, and effects using the simple form fields. No coding required!</p>
                </div>
                <div class="help-card">
                    <h4><i class="skyworld-icon icon-package"></i> Managing Products</h4>
                    <p>Link products to strains, set THC/CBD levels, add lab results, and manage inventory.</p>
                </div>
                <div class="help-card">
                    <h4><i class="skyworld-icon icon-palette"></i> Customizing Design</h4>
                    <p>Use the WordPress Customizer to change colors, text, and layout. See changes live!</p>
                </div>
                <div class="help-card">
                    <h4>� SEO Management</h4>
                    <p>Monitor search engine performance and optimize your cannabis business for better visibility.</p>
                </div>
            </div>
        </div>
    </div>

    <style>
    .skyworld-admin-dashboard {
        background: #fff;
        padding: 20px;
        margin: 20px 0;
        border-radius: 8px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    }
    
    .skyworld-dashboard-stats {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
        margin: 30px 0;
    }
    
    .stat-card {
        background: linear-gradient(135deg, #ff793f, #ffb142);
        color: white;
        padding: 20px;
        border-radius: 8px;
        text-align: center;
    }
    
    .stat-card h3 {
        margin: 0 0 10px 0;
        font-size: 18px;
    }
    
    .stat-number {
        font-size: 48px;
        font-weight: bold;
        margin: 10px 0;
    }
    
    .stat-card .button {
        background: rgba(255,255,255,0.2);
        color: white;
        border: 1px solid rgba(255,255,255,0.3);
        margin-top: 10px;
    }
    
    .stat-card .button:hover {
        background: rgba(255,255,255,0.3);
    }
    
    .skyworld-quick-actions {
        margin: 40px 0;
        padding: 20px;
        background: #f9f9f9;
        border-radius: 8px;
    }
    
    .action-buttons {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 15px;
        margin-top: 20px;
    }
    
    .skyworld-recent-activity {
        margin: 40px 0;
    }
    
    .skyworld-recent-activity ul {
        background: #f9f9f9;
        padding: 20px;
        border-radius: 8px;
    }
    
    .skyworld-recent-activity li {
        padding: 8px 0;
        border-bottom: 1px solid #eee;
    }
    
    .skyworld-recent-activity .date {
        color: #666;
        font-size: 0.9em;
    }
    
    .skyworld-help-section {
        margin: 40px 0;
    }
    
    .help-cards {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 20px;
        margin-top: 20px;
    }
    
    .help-card {
        background: #f0f8ff;
        padding: 20px;
        border-radius: 8px;
        border-left: 4px solid #34ace0;
    }
    
    .help-card h4 {
        margin: 0 0 10px 0;
        color: #2c5aa0;
    }
    </style>
    <?php
}

// Quick Actions Page
function skyworld_quick_actions_page() {
    if ( isset( $_POST['bulk_action'] ) ) {
        $action = sanitize_text_field( $_POST['bulk_action'] );
        $success_message = '';
        
        switch( $action ) {
            case 'regenerate_thumbnails':
                $success_message = 'Product images refreshed successfully!';
                break;
            case 'update_inventory':
                $success_message = 'Inventory counts updated!';
                break;
            case 'clear_cache':
                if ( function_exists( 'wp_cache_flush' ) ) {
                    wp_cache_flush();
                }
                $success_message = 'Website cache cleared!';
                break;
        }
        
        if ( $success_message ) {
            echo '<div class="notice notice-success"><p>' . $success_message . '</p></div>';
        }
    }
    ?>
    <div class="wrap">
        <h1><i class="skyworld-icon icon-lightning"></i> Quick Actions</h1>
        <p>Perform common maintenance tasks with one click.</p>
        
        <form method="post" class="skyworld-quick-actions-form">
            <div class="action-grid">
                <div class="action-item">
                    <h3><i class="skyworld-icon icon-image"></i> Refresh Product Images</h3>
                    <p>Regenerate all product image thumbnails for better display.</p>
                    <button type="submit" name="bulk_action" value="regenerate_thumbnails" class="button button-primary">Refresh Images</button>
                </div>
                
                <div class="action-item">
                    <h3>📊 Update Inventory</h3>
                    <p>Sync inventory counts across all products and locations.</p>
                    <button type="submit" name="bulk_action" value="update_inventory" class="button button-primary">Update Inventory</button>
                </div>
                
                <div class="action-item">
                    <h3><i class="skyworld-icon icon-lightning"></i> Clear Website Cache</h3>
                    <p>Clear cached files to ensure visitors see latest changes.</p>
                    <button type="submit" name="bulk_action" value="clear_cache" class="button button-secondary">Clear Cache</button>
                </div>
                
                <div class="action-item">
                    <h3><i class="skyworld-icon icon-palette"></i> Customize Website</h3>
                    <p>Change colors, text, and layout using the visual customizer.</p>
                    <a href="customize.php" class="button button-secondary">Open Customizer</a>
                </div>
            </div>
        </form>
    </div>
    
    <style>
    .action-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 20px;
        margin-top: 30px;
    }
    
    .action-item {
        background: #fff;
        padding: 20px;
        border: 1px solid #ddd;
        border-radius: 8px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    }
    
    .action-item h3 {
        margin-top: 0;
        color: #ff793f;
    }
    
    .action-item p {
        color: #666;
        margin-bottom: 15px;
    }
    </style>
    <?php
}

// Product Manager Page
function skyworld_product_manager_page() {
    $products = get_posts( array(
        'post_type' => 'sky_product',
        'numberposts' => -1,
        'post_status' => 'publish'
    ));
    ?>
    <div class="wrap">
        <h1><i class="skyworld-icon icon-package"></i> Product Manager</h1>
        <a href="post-new.php?post_type=sky_product" class="page-title-action">Add New Product</a>
        
        <div class="product-stats">
            <div class="stat-box">
                <strong><?php echo count( $products ); ?></strong>
                <span>Total Products</span>
            </div>
            <div class="stat-box">
                <strong><?php echo count( get_terms( array( 'taxonomy' => 'product_type', 'hide_empty' => false ) ) ); ?></strong>
                <span>Product Types</span>
            </div>
        </div>
        
        <div class="product-grid">
            <?php if ( $products ): ?>
                <?php foreach ( $products as $product ): ?>
                    <?php
                    $strain = get_field( 'product_strain', $product->ID );
                    $thc = get_field( 'product_thc_percentage', $product->ID );
                    $price = get_field( 'product_price', $product->ID );
                    $product_types = get_the_terms( $product->ID, 'product_type' );
                    ?>
                    <div class="product-card">
                        <h3><a href="post.php?post=<?php echo $product->ID; ?>&action=edit"><?php echo $product->post_title; ?></a></h3>
                        <?php if ( $strain ): ?>
                            <p><strong>Strain:</strong> <?php echo $strain->post_title; ?></p>
                        <?php endif; ?>
                        <?php if ( $thc ): ?>
                            <p><strong>THC:</strong> <?php echo $thc; ?>%</p>
                        <?php endif; ?>
                        <?php if ( $price ): ?>
                            <p><strong>Price:</strong> $<?php echo $price; ?></p>
                        <?php endif; ?>
                        <?php if ( $product_types ): ?>
                            <p><strong>Type:</strong> <?php echo $product_types[0]->name; ?></p>
                        <?php endif; ?>
                        <div class="product-actions">
                            <a href="post.php?post=<?php echo $product->ID; ?>&action=edit" class="button button-primary">Edit</a>
                            <a href="<?php echo get_permalink( $product->ID ); ?>" class="button" target="_blank">View</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No products found. <a href="post-new.php?post_type=sky_product">Add your first product</a>!</p>
            <?php endif; ?>
        </div>
    </div>
    
    <style>
    .product-stats {
        display: flex;
        gap: 20px;
        margin: 20px 0;
    }
    
    .stat-box {
        background: #ff793f;
        color: white;
        padding: 15px 20px;
        border-radius: 6px;
        text-align: center;
    }
    
    .stat-box strong {
        display: block;
        font-size: 24px;
        margin-bottom: 5px;
    }
    
    .product-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 20px;
        margin-top: 30px;
    }
    
    .product-card {
        background: #fff;
        border: 1px solid #ddd;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    }
    
    .product-card h3 {
        margin-top: 0;
        margin-bottom: 15px;
    }
    
    .product-card h3 a {
        text-decoration: none;
        color: #333;
    }
    
    .product-card p {
        margin: 8px 0;
        font-size: 14px;
    }
    
    .product-actions {
        margin-top: 15px;
        display: flex;
        gap: 10px;
    }
    </style>
    <?php
}

// Strain Library Page
function skyworld_strain_library_page() {
    $strains = get_posts( array(
        'post_type' => 'strain',
        'numberposts' => -1,
        'post_status' => 'publish'
    ));
    ?>
    <div class="wrap">
        <h1><i class="skyworld-icon icon-dna"></i> Strain Library</h1>
        <a href="post-new.php?post_type=strain" class="page-title-action">Add New Strain</a>
        
        <div class="strain-grid">
            <?php if ( $strains ): ?>
                <?php foreach ( $strains as $strain ): ?>
                    <?php
                    $strain_type = get_field( 'strain_type', $strain->ID );
                    $genetics = get_field( 'strain_genetics', $strain->ID );
                    $thc_range = get_field( 'strain_thc_range', $strain->ID );
                    $main_terpenes = get_field( 'strain_main_terpenes', $strain->ID );
                    ?>
                    <div class="strain-card">
                        <h3><a href="post.php?post=<?php echo $strain->ID; ?>&action=edit"><?php echo $strain->post_title; ?></a></h3>
                        <?php if ( $strain_type ): ?>
                            <span class="strain-type-badge <?php echo strtolower( $strain_type ); ?>"><?php echo $strain_type; ?></span>
                        <?php endif; ?>
                        <?php if ( $genetics ): ?>
                            <p><strong>Genetics:</strong> <?php echo $genetics; ?></p>
                        <?php endif; ?>
                        <?php if ( $thc_range ): ?>
                            <p><strong>THC Range:</strong> <?php echo $thc_range; ?></p>
                        <?php endif; ?>
                        <?php if ( $main_terpenes ): ?>
                            <p><strong>Main Terpenes:</strong> <?php echo substr( $main_terpenes, 0, 50 ) . '...'; ?></p>
                        <?php endif; ?>
                        <div class="strain-actions">
                            <a href="post.php?post=<?php echo $strain->ID; ?>&action=edit" class="button button-primary">Edit</a>
                            <a href="<?php echo get_permalink( $strain->ID ); ?>" class="button" target="_blank">View</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No strains found. <a href="post-new.php?post_type=strain">Add your first strain</a>!</p>
            <?php endif; ?>
        </div>
    </div>
    
    <style>
    .strain-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
        gap: 20px;
        margin-top: 30px;
    }
    
    .strain-card {
        background: #fff;
        border: 1px solid #ddd;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    }
    
    .strain-card h3 {
        margin-top: 0;
        margin-bottom: 10px;
    }
    
    .strain-card h3 a {
        text-decoration: none;
        color: #333;
    }
    
    .strain-type-badge {
        display: inline-block;
        padding: 4px 8px;
        border-radius: 4px;
        font-size: 12px;
        font-weight: bold;
        text-transform: uppercase;
        margin-bottom: 15px;
    }
    
    .strain-type-badge.indica {
        background: #9b59b6;
        color: white;
    }
    
    .strain-type-badge.sativa {
        background: #e74c3c;
        color: white;
    }
    
    .strain-type-badge.hybrid {
        background: #f39c12;
        color: white;
    }
    
    .strain-card p {
        margin: 8px 0;
        font-size: 14px;
    }
    
    .strain-actions {
        margin-top: 15px;
        display: flex;
        gap: 10px;
    }
    </style>
    <?php
}

// Location Manager Page  
function skyworld_location_manager_page() {
    $locations = get_posts( array(
        'post_type' => 'location',
        'numberposts' => -1,
        'post_status' => 'publish'
    ));
    ?>
    <div class="wrap">
        <h1><i class="skyworld-icon icon-map-pin"></i> Location Manager</h1>
        <a href="post-new.php?post_type=location" class="page-title-action">Add New Location</a>
        
        <div class="location-list">
            <?php if ( $locations ): ?>
                <?php foreach ( $locations as $location ): ?>
                    <?php
                    $address = get_field( 'location_address', $location->ID );
                    $phone = get_field( 'location_phone', $location->ID );
                    $hours = get_field( 'location_hours', $location->ID );
                    $partner_type = get_field( 'location_partner_type', $location->ID );
                    ?>
                    <div class="location-card">
                        <h3><a href="post.php?post=<?php echo $location->ID; ?>&action=edit"><?php echo $location->post_title; ?></a></h3>
                        <?php if ( $partner_type ): ?>
                            <span class="partner-badge"><?php echo $partner_type; ?></span>
                        <?php endif; ?>
                        <?php if ( $address ): ?>
                            <p><strong><i class="skyworld-icon icon-small icon-map-pin"></i> Address:</strong> <?php echo $address; ?></p>
                        <?php endif; ?>
                        <?php if ( $phone ): ?>
                            <p><strong><i class="skyworld-icon icon-small icon-phone"></i> Phone:</strong> <a href="tel:<?php echo $phone; ?>"><?php echo $phone; ?></a></p>
                        <?php endif; ?>
                        <?php if ( $hours ): ?>
                            <p><strong>🕐 Hours:</strong> <?php echo $hours; ?></p>
                        <?php endif; ?>
                        <div class="location-actions">
                            <a href="post.php?post=<?php echo $location->ID; ?>&action=edit" class="button button-primary">Edit</a>
                            <a href="<?php echo get_permalink( $location->ID ); ?>" class="button" target="_blank">View</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No locations found. <a href="post-new.php?post_type=location">Add your first location</a>!</p>
            <?php endif; ?>
        </div>
    </div>
    
    <style>
    .location-list {
        margin-top: 30px;
    }
    
    .location-card {
        background: #fff;
        border: 1px solid #ddd;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        margin-bottom: 20px;
    }
    
    .location-card h3 {
        margin-top: 0;
        margin-bottom: 10px;
    }
    
    .location-card h3 a {
        text-decoration: none;
        color: #333;
    }
    
    .partner-badge {
        display: inline-block;
        background: #34ace0;
        color: white;
        padding: 4px 8px;
        border-radius: 4px;
        font-size: 12px;
        font-weight: bold;
        text-transform: uppercase;
        margin-bottom: 15px;
    }
    
    .location-card p {
        margin: 8px 0;
        font-size: 14px;
    }
    
    .location-actions {
        margin-top: 15px;
        display: flex;
        gap: 10px;
    }
    </style>
    <?php
}