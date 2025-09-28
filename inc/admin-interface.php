<?php
/**
 * Robust Cannabis Industry Management Dashboard
 * Admin interface for managing strains, products, and locations
 */

// Add admin menu page
add_action( 'admin_menu', 'skyworld_add_admin_menu' );
function skyworld_add_admin_menu() {
    add_menu_page(
        'Skyworld Management',
        'Skyworld',
        'manage_options',
        'skyworld-management',
        'skyworld_management_page',
        'dashicons-carrot',
        3
    );

    add_submenu_page(
        'skyworld-management',
        'System Overview',
        'Overview',
        'manage_options',
        'skyworld-management',
        'skyworld_management_page'
    );

    add_submenu_page(
        'skyworld-management',
        'Strain Library',
        'Strain Library',
        'manage_options',
        'skyworld-strains',
        'skyworld_strains_page'
    );

    add_submenu_page(
        'skyworld-management',
        'Product Catalog',
        'Product Catalog',
        'manage_options',
        'skyworld-products',
        'skyworld_products_page'
    );

    add_submenu_page(
        'skyworld-management',
        'Retail Locations',
        'Retail Locations',
        'manage_options',
        'skyworld-locations',
        'skyworld_locations_page'
    );

    add_submenu_page(
        'skyworld-management',
        'Data Import/Export',
        'Import/Export',
        'manage_options',
        'skyworld-data',
        'skyworld_data_page'
    );
}

// Main management page
function skyworld_management_page() {
    ?>
    <div class="wrap">
        <h1><i class="ph ph-leaf"></i> Skyworld Cannabis Management</h1>
        <div class="skyworld-dashboard">
            
            <div class="skyworld-stats-grid">
                <div class="stat-card">
                    <h3>Strains</h3>
                    <div class="stat-number"><?php echo wp_count_posts('strain')->publish; ?></div>
                    <p>Active strains in library</p>
                </div>
                
                <div class="stat-card">
                    <h3>Products</h3>
                    <div class="stat-number"><?php echo wp_count_posts('product')->publish; ?></div>
                    <p>Products in catalog</p>
                </div>
                
                <div class="stat-card">
                    <h3>Locations</h3>
                    <div class="stat-number"><?php echo wp_count_posts('location')->publish; ?></div>
                    <p>Retail locations</p>
                </div>
                
                <div class="stat-card">
                    <h3>Terpenes</h3>
                    <div class="stat-number"><?php echo wp_count_terms('terpene'); ?></div>
                    <p>Tracked terpenes</p>
                </div>
            </div>

            <div class="skyworld-actions">
                <h2>Quick Actions</h2>
                <div class="action-buttons">
                    <a href="<?php echo admin_url('post-new.php?post_type=strain'); ?>" class="button button-primary">
                        <span class="dashicons dashicons-plus"></span> Add New Strain
                    </a>
                    <a href="<?php echo admin_url('post-new.php?post_type=sw-product'); ?>" class="button button-primary">
                        <span class="dashicons dashicons-plus"></span> Add New Product
                    </a>
                    <a href="<?php echo admin_url('post-new.php?post_type=location'); ?>" class="button button-primary">
                        <span class="dashicons dashicons-plus"></span> Add New Location
                    </a>
                    <a href="<?php echo admin_url('admin.php?page=skyworld-data'); ?>" class="button button-secondary">
                        <span class="dashicons dashicons-download"></span> Import Data
                    </a>
                </div>
            </div>

            <div class="skyworld-recent">
                <h2>Recent Activity</h2>
                <?php 
                $recent_posts = get_posts(array(
                    'numberposts' => 5,
                    'post_type' => array('strain', 'sw-product', 'location'),
                    'post_status' => 'publish'
                ));
                
                if ($recent_posts) {
                    echo '<ul>';
                    foreach ($recent_posts as $post) {
                        echo '<li>';
                        echo '<strong>' . ucfirst($post->post_type) . ':</strong> ';
                        echo '<a href="' . get_edit_post_link($post->ID) . '">' . $post->post_title . '</a>';
                        echo '<span class="post-date"> - ' . get_the_date('', $post->ID) . '</span>';
                        echo '</li>';
                    }
                    echo '</ul>';
                } else {
                    echo '<p>No recent activity.</p>';
                }
                ?>
            </div>
        </div>
    </div>

    <style>
    .skyworld-dashboard {
        max-width: 1200px;
    }
    
    .skyworld-stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
        margin: 20px 0;
    }
    
    .stat-card {
        background: #fff;
        border: 1px solid #ccd0d4;
        border-radius: 4px;
        padding: 20px;
        text-align: center;
        box-shadow: 0 1px 1px rgba(0,0,0,0.04);
    }
    
    .stat-card h3 {
        margin: 0 0 10px 0;
        color: #23282d;
    }
    
    .stat-number {
        font-size: 36px;
        font-weight: bold;
        color: #0073aa;
        margin: 10px 0;
    }
    
    .stat-card p {
        margin: 0;
        color: #666;
        font-size: 14px;
    }
    
    .skyworld-actions, .skyworld-recent {
        background: #fff;
        border: 1px solid #ccd0d4;
        border-radius: 4px;
        padding: 20px;
        margin: 20px 0;
    }
    
    .action-buttons {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }
    
    .action-buttons .button {
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }
    
    .skyworld-recent ul {
        margin: 0;
        padding: 0;
        list-style: none;
    }
    
    .skyworld-recent li {
        padding: 10px 0;
        border-bottom: 1px solid #eee;
    }
    
    .skyworld-recent li:last-child {
        border-bottom: none;
    }
    
    .post-date {
        color: #666;
        font-size: 13px;
    }
    </style>
    <?php
}

// Strain management page
function skyworld_strains_page() {
    ?>
    <div class="wrap">
        <h1><i class="ph ph-dna"></i> Strain Library Management</h1>
        <p>Manage your cannabis strain genetics library. Each strain represents unique genetics that can be used to create multiple products.</p>
        
        <div class="strain-management">
            <a href="<?php echo admin_url('post-new.php?post_type=strain'); ?>" class="button button-primary">
                <span class="dashicons dashicons-plus"></span> Add New Strain
            </a>
            <a href="<?php echo admin_url('edit.php?post_type=strain'); ?>" class="button button-secondary">
                <span class="dashicons dashicons-list-view"></span> View All Strains
            </a>
        </div>
        
        <h2>Strain Categories</h2>
        <div class="taxonomy-stats">
            <?php
            $strain_types = get_terms(array('taxonomy' => 'strain_type', 'hide_empty' => false));
            foreach ($strain_types as $type) {
                echo '<div class="taxonomy-item">';
                echo '<strong>' . $type->name . ':</strong> ' . $type->count . ' strains';
                echo '</div>';
            }
            ?>
        </div>
    </div>
    <?php
}

// Product management page
function skyworld_products_page() {
    ?>
    <div class="wrap">
        <h1><i class="ph ph-package"></i> Product Catalog Management</h1>
        <p>Manage your cannabis product inventory. Products are created from strains and represent what customers can purchase.</p>
        
        <div class="product-management">
            <a href="<?php echo admin_url('post-new.php?post_type=product'); ?>" class="button button-primary">
                <span class="dashicons dashicons-plus"></span> Add New Product
            </a>
            <a href="<?php echo admin_url('edit.php?post_type=sw-product'); ?>" class="button button-secondary">
                <span class="dashicons dashicons-list-view"></span> View All Products
            </a>
        </div>
        
        <h2>Product Types</h2>
        <div class="taxonomy-stats">
            <?php
            $product_types = get_terms(array('taxonomy' => 'product_type', 'hide_empty' => false));
            foreach ($product_types as $type) {
                echo '<div class="taxonomy-item">';
                echo '<strong>' . $type->name . ':</strong> ' . $type->count . ' products';
                echo '</div>';
            }
            ?>
        </div>
    </div>
    <?php
}

// Location management page
function skyworld_locations_page() {
    ?>
    <div class="wrap">
        <h1><i class="ph ph-map-pin"></i> Retail Location Management</h1>
        <p>Manage dispensaries, delivery services, and other retail locations that carry Skyworld products.</p>
        
        <div class="location-management">
            <a href="<?php echo admin_url('post-new.php?post_type=location'); ?>" class="button button-primary">
                <span class="dashicons dashicons-plus"></span> Add New Location
            </a>
            <a href="<?php echo admin_url('edit.php?post_type=location'); ?>" class="button button-secondary">
                <span class="dashicons dashicons-list-view"></span> View All Locations
            </a>
        </div>
    </div>
    <?php
}

// Data import/export page
function skyworld_data_page() {
    ?>
    <div class="wrap">
        <h1>📊 Data Import/Export</h1>
        <p>Import data from your existing site or export current data for backup.</p>
        
        <div class="data-tools">
            <h2>Migration Tools</h2>
            <p><strong>Coming Soon:</strong> Tools to import data from your current site structure and clean up taxonomy issues.</p>
            
            <h3>Manual Data Entry Guidelines:</h3>
            <ul>
                <li><strong>Strains First:</strong> Create strains in the genetic library before creating products</li>
                <li><strong>Taxonomies:</strong> Use proper strain types (Indica, Sativa, Hybrid)</li>
                <li><strong>Terpenes:</strong> Add terpenes with percentages, not just tags</li>
                <li><strong>Products:</strong> Link products to their parent strains</li>
                <li><strong>Lab Results:</strong> Always include THC/CBD percentages and COA links</li>
            </ul>
        </div>
    </div>
    <?php
}

// Add custom admin styles
add_action( 'admin_head', 'skyworld_admin_styles' );
function skyworld_admin_styles() {
    ?>
    <style>
    .taxonomy-stats {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: 15px;
        margin: 20px 0;
    }
    
    .taxonomy-item {
        background: #f9f9f9;
        padding: 15px;
        border-radius: 4px;
        border-left: 4px solid #0073aa;
    }
    
    .strain-management, .product-management, .location-management {
        margin: 20px 0;
        padding: 20px;
        background: #fff;
        border: 1px solid #ccd0d4;
        border-radius: 4px;
    }
    
    .data-tools {
        background: #fff;
        padding: 20px;
        border: 1px solid #ccd0d4;
        border-radius: 4px;
        margin: 20px 0;
    }
    
    .data-tools ul {
        margin-left: 20px;
    }
    
    .data-tools li {
        margin-bottom: 8px;
    }
    </style>
    <?php
}