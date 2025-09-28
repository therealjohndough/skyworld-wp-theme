<?php
/**
 * Content Block Management Functions
 * Easy workflow for clients to manage content blocks
 */

// Add admin menu for content block management
add_action('admin_menu', 'skyworld_content_blocks_menu');

function skyworld_content_blocks_menu() {
    add_menu_page(
        'Content Blocks',
        'Content Blocks',
        'manage_options',
        'skyworld-content-blocks',
        'skyworld_content_blocks_page',
        'dashicons-layout',
        25
    );
}

function skyworld_content_blocks_page() {
    ?>
    <div class="wrap">
        <h1>Skyworld Content Block Management</h1>
        <p>Manage content for your homepage sections easily.</p>
        
        <div class="content-blocks-container">
            <!-- Hero Slider Management -->
            <div class="content-block-section">
                <h2>🎬 Hero Slider (Top 3 Stories)</h2>
                <p>To add stories to the hero slider:</p>
                <ol>
                    <li>Go to <strong>Posts</strong>, <strong>Strains</strong>, or <strong>Products</strong></li>
                    <li>Edit the item you want to feature</li>
                    <li>Scroll down to <strong>Featured in Hero</strong> checkbox</li>
                    <li>Check the box and add optional hero subtitle, button text, and button link</li>
                    <li>Set a <strong>Featured Image</strong> for the background</li>
                </ol>
                <a href="<?php echo admin_url('edit.php'); ?>" class="button button-primary">Manage Posts</a>
                <a href="<?php echo admin_url('edit.php?post_type=strain'); ?>" class="button button-secondary">Manage Strains</a>
                <a href="<?php echo admin_url('edit.php?post_type=sw_product'); ?>" class="button button-secondary">Manage Products</a>
            </div>
            
            <!-- Genetic Library Management -->
            <div class="content-block-section">
                <h2><i class="ph ph-dna"></i> Genetic Library Block</h2>
                <p>The genetic library automatically shows your strains. To manage:</p>
                <ul>
                    <li><strong>Add New Strains:</strong> Go to Strains → Add New</li>
                    <li><strong>Set as Featured:</strong> Check "Featured Strain" when editing</li>
                    <li><strong>Required Fields:</strong> Strain Type, THC Level, CBD Level, Effects</li>
                    <li><strong>Image:</strong> Upload a flower photo (not packaging)</li>
                </ul>
                <a href="<?php echo admin_url('edit.php?post_type=strain'); ?>" class="button button-primary">Manage Strains</a>
                <a href="<?php echo admin_url('post-new.php?post_type=strain'); ?>" class="button button-secondary">Add New Strain</a>
            </div>
            
            <!-- Product Slider Management -->
            <div class="content-block-section">
                <h2><i class="ph ph-package"></i> Product Slider Block</h2>
                <p>Featured products appear in the slider. To manage:</p>
                <ul>
                    <li><strong>Add New Products:</strong> Go to Products → Add New</li>
                    <li><strong>Set as Featured:</strong> Check "Featured Product" when editing</li>
                    <li><strong>Required Fields:</strong> Product Type, Weight, Price, THC/CBD Content</li>
                    <li><strong>Image:</strong> Upload a product packaging photo</li>
                </ul>
                <a href="<?php echo admin_url('edit.php?post_type=sw_product'); ?>" class="button button-primary">Manage Products</a>
                <a href="<?php echo admin_url('post-new.php?post_type=sw_product'); ?>" class="button button-secondary">Add New Product</a>
            </div>
            
            <!-- News Block Management -->
            <div class="content-block-section">
                <h2>📰 News & Updates Block</h2>
                <p>Latest news and updates from your blog posts:</p>
                <ul>
                    <li><strong>Featured News:</strong> Check "Featured News" on a post to make it the main story</li>
                    <li><strong>Regular News:</strong> Recent posts automatically appear in the sidebar</li>
                    <li><strong>Categories:</strong> Assign categories like "Strain Release", "Awards", "Expansion"</li>
                    <li><strong>Images:</strong> Set featured images for visual appeal</li>
                </ul>
                <a href="<?php echo admin_url('edit.php'); ?>" class="button button-primary">Manage News Posts</a>
                <a href="<?php echo admin_url('post-new.php'); ?>" class="button button-secondary">Add News Post</a>
            </div>
        </div>
        
        <div class="content-blocks-tips">
            <h2><i class="ph ph-lightbulb"></i> Content Tips</h2>
            <div class="tips-grid">
                <div class="tip-card">
                    <h3>Image Guidelines</h3>
                    <ul>
                        <li><strong>Flower Photos:</strong> For strains, use actual flower/plant photos</li>
                        <li><strong>Packaging Photos:</strong> For products, use packaging/container photos</li>
                        <li><strong>Size:</strong> Minimum 800x600px, max 2MB</li>
                        <li><strong>Format:</strong> JPG or PNG</li>
                    </ul>
                </div>
                
                <div class="tip-card">
                    <h3>SEO Best Practices</h3>
                    <ul>
                        <li>Write descriptive titles (50-60 characters)</li>
                        <li>Include keywords naturally</li>
                        <li>Add alt text to all images</li>
                        <li>Use categories and tags appropriately</li>
                    </ul>
                </div>
                
                <div class="tip-card">
                    <h3>Content Strategy</h3>
                    <ul>
                        <li>Rotate hero content monthly</li>
                        <li>Feature new strains prominently</li>
                        <li>Post news regularly (2-3 times per week)</li>
                        <li>Update product availability</li>
                    </ul>
                </div>
            </div>
        </div>
        
        <style>
        .content-blocks-container {
            margin-top: 20px;
        }
        
        .content-block-section {
            background: #fff;
            border: 1px solid #ccd0d4;
            border-radius: 4px;
            padding: 20px;
            margin-bottom: 20px;
        }
        
        .content-block-section h2 {
            color: #23282d;
            margin-top: 0;
            margin-bottom: 10px;
        }
        
        .content-block-section ul,
        .content-block-section ol {
            margin: 15px 0;
        }
        
        .content-block-section li {
            margin-bottom: 8px;
        }
        
        .content-blocks-tips {
            margin-top: 30px;
        }
        
        .tips-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
            margin-top: 15px;
        }
        
        .tip-card {
            background: #f9f9f9;
            border: 1px solid #ddd;
            border-radius: 4px;
            padding: 15px;
        }
        
        .tip-card h3 {
            margin-top: 0;
            color: #0073aa;
        }
        
        .tip-card ul {
            margin-bottom: 0;
        }
        
        .button {
            margin-right: 10px;
        }
        </style>
    </div>
    <?php
}

// Add custom meta fields for content block management
add_action('add_meta_boxes', 'skyworld_add_content_block_meta_boxes');

function skyworld_add_content_block_meta_boxes() {
    // Hero slider meta box for posts, strains, products
    $post_types = array('post', 'strain', 'sw_product');
    foreach ($post_types as $post_type) {
        add_meta_box(
            'skyworld-hero-settings',
            'Hero Slider Settings',
            'skyworld_hero_settings_callback',
            $post_type,
            'normal',
            'high'
        );
    }
    
    // Featured content meta box for strains and products
    add_meta_box(
        'skyworld-featured-settings',
        'Featured Content Settings',
        'skyworld_featured_settings_callback',
        'strain',
        'side',
        'high'
    );
    
    add_meta_box(
        'skyworld-featured-settings',
        'Featured Content Settings',
        'skyworld_featured_settings_callback',
        'sky_product',
        'side',
        'high'
    );
    
    // News settings for posts
    add_meta_box(
        'skyworld-news-settings',
        'News Block Settings',
        'skyworld_news_settings_callback',
        'post',
        'side',
        'high'
    );
}

function skyworld_hero_settings_callback($post) {
    wp_nonce_field('skyworld_hero_settings', 'skyworld_hero_nonce');
    
    $featured_in_hero = get_post_meta($post->ID, 'featured_in_hero', true);
    $hero_subtitle = get_post_meta($post->ID, 'hero_subtitle', true);
    $hero_button_text = get_post_meta($post->ID, 'hero_button_text', true);
    $hero_button_link = get_post_meta($post->ID, 'hero_button_link', true);
    
    ?>
    <table class="form-table">
        <tr>
            <th scope="row">Feature in Hero Slider</th>
            <td>
                <label>
                    <input type="checkbox" name="featured_in_hero" value="1" <?php checked($featured_in_hero, '1'); ?>>
                    Show this content in the hero slider
                </label>
            </td>
        </tr>
        <tr>
            <th scope="row">Hero Subtitle</th>
            <td>
                <input type="text" name="hero_subtitle" value="<?php echo esc_attr($hero_subtitle); ?>" class="large-text" placeholder="Optional custom subtitle for hero slide">
            </td>
        </tr>
        <tr>
            <th scope="row">Button Text</th>
            <td>
                <input type="text" name="hero_button_text" value="<?php echo esc_attr($hero_button_text); ?>" placeholder="e.g., Learn More, Shop Now">
            </td>
        </tr>
        <tr>
            <th scope="row">Button Link</th>
            <td>
                <input type="url" name="hero_button_link" value="<?php echo esc_attr($hero_button_link); ?>" class="large-text" placeholder="https://example.com">
            </td>
        </tr>
    </table>
    <?php
}

function skyworld_featured_settings_callback($post) {
    wp_nonce_field('skyworld_featured_settings', 'skyworld_featured_nonce');
    
    $featured_field = $post->post_type === 'strain' ? 'featured_strain' : 'featured_product';
    $featured = get_post_meta($post->ID, $featured_field, true);
    
    ?>
    <label>
        <input type="checkbox" name="<?php echo $featured_field; ?>" value="1" <?php checked($featured, '1'); ?>>
        Feature this <?php echo $post->post_type; ?> on the homepage
    </label>
    <?php
}

function skyworld_news_settings_callback($post) {
    wp_nonce_field('skyworld_news_settings', 'skyworld_news_nonce');
    
    $featured_news = get_post_meta($post->ID, 'featured_news', true);
    $read_time = get_post_meta($post->ID, 'estimated_read_time', true);
    
    ?>
    <p>
        <label>
            <input type="checkbox" name="featured_news" value="1" <?php checked($featured_news, '1'); ?>>
            Feature as main news story
        </label>
    </p>
    <p>
        <label>
            <strong>Estimated Read Time:</strong><br>
            <input type="text" name="estimated_read_time" value="<?php echo esc_attr($read_time); ?>" placeholder="3 min read">
        </label>
    </p>
    <?php
}

// Save meta box data
add_action('save_post', 'skyworld_save_content_block_meta');

function skyworld_save_content_block_meta($post_id) {
    // Hero settings
    if (isset($_POST['skyworld_hero_nonce']) && wp_verify_nonce($_POST['skyworld_hero_nonce'], 'skyworld_hero_settings')) {
        $featured_in_hero = isset($_POST['featured_in_hero']) ? '1' : '0';
        update_post_meta($post_id, 'featured_in_hero', $featured_in_hero);
        
        if (isset($_POST['hero_subtitle'])) {
            update_post_meta($post_id, 'hero_subtitle', sanitize_text_field($_POST['hero_subtitle']));
        }
        
        if (isset($_POST['hero_button_text'])) {
            update_post_meta($post_id, 'hero_button_text', sanitize_text_field($_POST['hero_button_text']));
        }
        
        if (isset($_POST['hero_button_link'])) {
            update_post_meta($post_id, 'hero_button_link', esc_url_raw($_POST['hero_button_link']));
        }
    }
    
    // Featured settings
    if (isset($_POST['skyworld_featured_nonce']) && wp_verify_nonce($_POST['skyworld_featured_nonce'], 'skyworld_featured_settings')) {
        if (isset($_POST['featured_strain'])) {
            $featured_strain = isset($_POST['featured_strain']) ? '1' : '0';
            update_post_meta($post_id, 'featured_strain', $featured_strain);
        }
        
        if (isset($_POST['featured_product'])) {
            $featured_product = isset($_POST['featured_product']) ? '1' : '0';
            update_post_meta($post_id, 'featured_product', $featured_product);
        }
    }
    
    // News settings
    if (isset($_POST['skyworld_news_nonce']) && wp_verify_nonce($_POST['skyworld_news_nonce'], 'skyworld_news_settings')) {
        $featured_news = isset($_POST['featured_news']) ? '1' : '0';
        update_post_meta($post_id, 'featured_news', $featured_news);
        
        if (isset($_POST['estimated_read_time'])) {
            update_post_meta($post_id, 'estimated_read_time', sanitize_text_field($_POST['estimated_read_time']));
        }
    }
}

// Add quick links to admin bar
add_action('admin_bar_menu', 'skyworld_add_content_blocks_admin_bar', 100);

function skyworld_add_content_blocks_admin_bar($wp_admin_bar) {
    if (!current_user_can('manage_options')) {
        return;
    }
    
    $wp_admin_bar->add_node(array(
        'id' => 'skyworld-content-blocks',
        'title' => 'Content Blocks',
        'href' => admin_url('admin.php?page=skyworld-content-blocks'),
    ));
    
    $wp_admin_bar->add_node(array(
        'parent' => 'skyworld-content-blocks',
        'id' => 'manage-hero-content',
        'title' => 'Manage Hero Content',
        'href' => admin_url('edit.php'),
    ));
    
    $wp_admin_bar->add_node(array(
        'parent' => 'skyworld-content-blocks',
        'id' => 'manage-strains',
        'title' => 'Manage Strains',
        'href' => admin_url('edit.php?post_type=strain'),
    ));
    
    $wp_admin_bar->add_node(array(
        'parent' => 'skyworld-content-blocks',
        'id' => 'manage-products',
        'title' => 'Manage Products',
        'href' => admin_url('edit.php?post_type=sky_product'),
    ));
}
?>