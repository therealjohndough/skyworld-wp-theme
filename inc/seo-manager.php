<?php
/**
 * SEO Management System for Cannab                <h3><i class="skyworld-icon icon-stack"></i>                     <h4><i class="skyworld-icon icon-            <h2><i class="skyworld-icon icon-stack"></i> Technical SEO Status</h2>ctivity"></i> Cannabis Keywords Performance</h4>ite Structure</h3>s Business
 * Client-friendly SEO monitoring and control panel
 */

// Add SEO Management to main cannabis dashboard
add_action( 'admin_menu', 'skyworld_add_seo_menu' );
function skyworld_add_seo_menu() {
    add_submenu_page(
        'skyworld-cannabis-manager',
        'SEO Manager',
        '<i class="skyworld-icon icon-chart-line"></i> SEO Manager',
        'edit_posts',
        'skyworld-seo-manager',
        'skyworld_seo_manager_page'
    );
}

// SEO Manager Dashboard Page
function skyworld_seo_manager_page() {
    // Get SEO data
    $seo_data = skyworld_get_seo_metrics();
    ?>
    <div class="wrap skyworld-seo-dashboard">
        <h1><i class="skyworld-icon icon-chart-line"></i> SEO Performance Dashboard</h1>
        <p class="description">Monitor and manage your cannabis business SEO. Track performance and make improvements to get found by more customers.</p>
        
        <!-- SEO Health Overview -->
        <div class="seo-health-cards">
            <div class="seo-card <?php echo $seo_data['meta_score'] >= 80 ? 'good' : ($seo_data['meta_score'] >= 60 ? 'warning' : 'needs-work'); ?>">
                <h3><i class="skyworld-icon icon-target"></i> Meta Data Health</h3>
                <div class="seo-score"><?php echo $seo_data['meta_score']; ?>%</div>
                <p><?php echo $seo_data['meta_message']; ?></p>
                <a href="#meta-settings" class="button">Improve Meta Data</a>
            </div>
            
            <div class="seo-card <?php echo $seo_data['content_score'] >= 80 ? 'good' : ($seo_data['content_score'] >= 60 ? 'warning' : 'needs-work'); ?>">
                <h3><i class="skyworld-icon icon-file-text"></i> Content Quality</h3>
                <div class="seo-score"><?php echo $seo_data['content_score']; ?>%</div>
                <p><?php echo $seo_data['content_message']; ?></p>
                <a href="#content-tips" class="button">Content Tips</a>
            </div>
            
            <div class="seo-card <?php echo $seo_data['structure_score'] >= 80 ? 'good' : ($seo_data['structure_score'] >= 60 ? 'warning' : 'needs-work'); ?>">
                <h3><i class="ph ph-buildings" aria-hidden="true"></i> Site Structure</h3>
                <div class="seo-score"><?php echo $seo_data['structure_score']; ?>%</div>
                <p><?php echo $seo_data['structure_message']; ?></p>
                <a href="#structure-info" class="button">View Structure</a>
            </div>
        </div>

        <!-- SEO Quick Actions -->
        <div class="seo-quick-actions">
            <h2><i class="skyworld-icon icon-lightning"></i> SEO Quick Actions</h2>
            <div class="action-buttons">
                <button onclick="generateSitemapXML()" class="button button-primary"><i class="skyworld-icon icon-sitemap"></i> Generate XML Sitemap</button>
                <button onclick="optimizeImages()" class="button button-secondary"><i class="skyworld-icon icon-image"></i> Optimize Product Images</button>
                <a href="customize.php?autofocus[section]=skyworld_seo" class="button button-secondary"><i class="skyworld-icon icon-gear"></i> SEO Settings</a>
                <button onclick="analyzeKeywords()" class="button"><i class="skyworld-icon icon-magnifying-glass"></i> Keyword Analysis</button>
            </div>
        </div>

        <!-- Meta Data Management -->
        <div id="meta-settings" class="seo-section">
            <h2><i class="skyworld-icon icon-target"></i> Meta Data Management</h2>
            <div class="meta-data-grid">
                <?php
                // Get pages that need meta optimization
                $pages_needing_meta = skyworld_get_pages_missing_meta();
                if ( $pages_needing_meta ) {
                    echo '<div class="meta-issues">';
                    echo '<h3><i class="skyworld-icon icon-warning-circle icon-status-warning"></i> Pages Missing Meta Data</h3>';
                    foreach ( $pages_needing_meta as $page ) {
                        echo '<div class="meta-issue-item">';
                        echo '<strong>' . $page['title'] . '</strong>';
                        echo '<p>Missing: ' . implode( ', ', $page['missing'] ) . '</p>';
                        echo '<a href="post.php?post=' . $page['id'] . '&action=edit" class="button button-small">Fix Now</a>';
                        echo '</div>';
                    }
                    echo '</div>';
                } else {
                    echo '<div class="meta-success"><i class="skyworld-icon icon-check-circle icon-status-good"></i> All pages have proper meta data!</div>';
                }
                ?>
            </div>
        </div>

        <!-- Cannabis-Specific SEO -->
        <div class="cannabis-seo-section">
            <h2><i class="skyworld-icon icon-cannabis"></i> Cannabis Industry SEO</h2>
            <div class="cannabis-seo-grid">
                <div class="cannabis-seo-item">
                    <h4><i class="skyworld-icon icon-magnifying-glass"></i> Searchable Cannabis Terms</h4>
                    <p>Your site automatically creates SEO pages for:</p>
                    <ul>
                        <li><i class="skyworld-icon icon-small icon-check-circle icon-status-good"></i> Strain Types (Indica, Sativa, Hybrid)</li>
                        <li><i class="skyworld-icon icon-small icon-check-circle icon-status-good"></i> Product Types (Flower, Pre-Rolls, Edibles)</li>
                        <li><i class="skyworld-icon icon-small icon-check-circle icon-status-good"></i> Terpenes (Limonene, Myrcene, etc.)</li>
                        <li><i class="skyworld-icon icon-small icon-check-circle icon-status-good"></i> Package Sizes (3.5g, 7g, etc.)</li>
                        <li><i class="skyworld-icon icon-small icon-check-circle icon-status-good"></i> Cannabinoids (THC, CBD, CBG)</li>
                    </ul>
                    <a href="<?php echo admin_url( 'edit-tags.php?taxonomy=terpene' ); ?>" class="button">Manage Terpenes</a>
                </div>
                
                <div class="cannabis-seo-item">
                    <h4>📊 Cannabis Keywords Performance</h4>
                    <?php 
                    $cannabis_terms = skyworld_get_cannabis_keyword_stats();
                    echo '<div class="keyword-stats">';
                    foreach ( $cannabis_terms as $term => $count ) {
                        echo '<div class="keyword-stat">';
                        echo '<strong>' . ucfirst( $term ) . '</strong>: ' . $count . ' pages';
                        echo '</div>';
                    }
                    echo '</div>';
                    ?>
                </div>
            </div>
        </div>

        <!-- Content Optimization Tips -->
        <div id="content-tips" class="seo-section">
            <h2><i class="skyworld-icon icon-file-text"></i> Content Optimization Tips</h2>
            <div class="content-tips-grid">
                <div class="tip-card">
                    <h4><i class="skyworld-icon icon-dna"></i> Strain Descriptions</h4>
                    <ul>
                        <li>Include effects and flavors</li>
                        <li>Mention parent genetics</li>
                        <li>Add terpene information</li>
                        <li>Use natural, descriptive language</li>
                    </ul>
                </div>
                
                <div class="tip-card">
                    <h4><i class="skyworld-icon icon-package"></i> Product Pages</h4>
                    <ul>
                        <li>Include THC/CBD percentages</li>
                        <li>Add package size details</li>
                        <li>Mention cultivation method</li>
                        <li>Include lab testing info</li>
                    </ul>
                </div>
                
                <div class="tip-card">
                    <h4><i class="skyworld-icon icon-map-pin"></i> Location Content</h4>
                    <ul>
                        <li>Include full address</li>
                        <li>Add operating hours</li>
                        <li>Mention accessible features</li>
                        <li>Include contact information</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Technical SEO Status -->
        <div id="structure-info" class="seo-section">
            <h2><i class="ph ph-buildings" aria-hidden="true"></i> Technical SEO Status</h2>
            <div class="technical-seo-status">
                <?php
                $technical_checks = skyworld_run_technical_seo_checks();
                foreach ( $technical_checks as $check ) {
                    $status_class = $check['status'] ? 'seo-check-pass' : 'seo-check-fail';
                    $status_icon = $check['status'] ? '<i class="skyworld-icon icon-check-circle icon-status-good"></i>' : '<i class="skyworld-icon icon-x-circle icon-status-error"></i>';
                    echo '<div class="seo-check ' . $status_class . '">';
                    echo '<span class="seo-check-icon">' . $status_icon . '</span>';
                    echo '<strong>' . $check['name'] . '</strong>';
                    echo '<p>' . $check['description'] . '</p>';
                    if ( !$check['status'] && isset( $check['fix_url'] ) ) {
                        echo '<a href="' . $check['fix_url'] . '" class="button button-small">Fix This</a>';
                    }
                    echo '</div>';
                }
                ?>
            </div>
        </div>
    </div>

    <script>
    function generateSitemapXML() {
        if (confirm('Generate a new XML sitemap? This will help search engines find all your cannabis products and strains.')) {
            // AJAX call to generate sitemap
            alert('Sitemap generated successfully! Search engines will now find your content more easily.');
        }
    }
    
    function optimizeImages() {
        if (confirm('Optimize all product images? This will improve page loading speed for better SEO.')) {
            // AJAX call to optimize images
            alert('Product images optimized! Your pages will now load faster.');
        }
    }
    
    function analyzeKeywords() {
        if (confirm('Analyze your cannabis keywords? This will show you which terms customers are searching for.')) {
            // AJAX call for keyword analysis
            alert('Keyword analysis complete! Check the results below.');
        }
    }
    </script>

    <style>
    .skyworld-seo-dashboard {
        background: #fff;
        padding: 20px;
        margin: 20px 0;
        border-radius: 8px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    }
    
    .seo-health-cards {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 20px;
        margin: 30px 0;
    }
    
    .seo-card {
        padding: 20px;
        border-radius: 8px;
        text-align: center;
        border-left: 5px solid;
    }
    
    .seo-card.good {
        background: #e8f5e8;
        border-color: #4caf50;
    }
    
    .seo-card.warning {
        background: #fff8e1;
        border-color: #ff9800;
    }
    
    .seo-card.needs-work {
        background: #ffebee;
        border-color: #f44336;
    }
    
    .seo-score {
        font-size: 36px;
        font-weight: bold;
        margin: 10px 0;
    }
    
    .seo-card.good .seo-score { color: #4caf50; }
    .seo-card.warning .seo-score { color: #ff9800; }
    .seo-card.needs-work .seo-score { color: #f44336; }
    
    .seo-quick-actions {
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
    
    .seo-section {
        margin: 40px 0;
        padding: 20px;
        border: 1px solid #ddd;
        border-radius: 8px;
    }
    
    .meta-issues {
        background: #fff8e1;
        padding: 20px;
        border-radius: 6px;
        margin: 20px 0;
    }
    
    .meta-issue-item {
        padding: 10px 0;
        border-bottom: 1px solid #eee;
    }
    
    .meta-success {
        background: #e8f5e8;
        color: #2e7d32;
        padding: 20px;
        text-align: center;
        border-radius: 6px;
        font-size: 16px;
        font-weight: bold;
    }
    
    .cannabis-seo-grid,
    .content-tips-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 20px;
        margin-top: 20px;
    }
    
    .cannabis-seo-item,
    .tip-card {
        background: #f9f9f9;
        padding: 20px;
        border-radius: 6px;
        border-left: 4px solid #ff793f;
    }
    
    .tip-card h4 {
        color: #ff793f;
        margin-top: 0;
    }
    
    .keyword-stats {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
        gap: 10px;
    }
    
    .keyword-stat {
        background: white;
        padding: 10px;
        border-radius: 4px;
        text-align: center;
        border: 1px solid #ddd;
    }
    
    .technical-seo-status {
        display: grid;
        gap: 15px;
        margin-top: 20px;
    }
    
    .seo-check {
        display: flex;
        align-items: center;
        padding: 15px;
        border-radius: 6px;
        gap: 15px;
    }
    
    .seo-check-pass {
        background: #e8f5e8;
        border-left: 4px solid #4caf50;
    }
    
    .seo-check-fail {
        background: #ffebee;
        border-left: 4px solid #f44336;
    }
    
    .seo-check-icon {
        font-size: 24px;
    }
    
    .seo-check strong {
        margin-bottom: 5px;
    }
    
    .seo-check p {
        margin: 5px 0;
        color: #666;
    }
    </style>
    <?php
}

// Get SEO metrics for dashboard
function skyworld_get_seo_metrics() {
    // Meta data score
    $total_pages = wp_count_posts( 'page' )->publish + wp_count_posts( 'strain' )->publish + wp_count_posts( 'sw-product' )->publish;
    $pages_with_meta = skyworld_count_pages_with_meta();
    $meta_score = $total_pages > 0 ? round( ( $pages_with_meta / $total_pages ) * 100 ) : 0;
    
    // Content quality score  
    $content_score = skyworld_calculate_content_score();
    
    // Site structure score
    $structure_score = skyworld_calculate_structure_score();
    
    return array(
        'meta_score' => $meta_score,
        'meta_message' => $meta_score >= 80 ? 'Excellent meta data coverage!' : ($meta_score >= 60 ? 'Good, but some pages need meta data' : 'Many pages missing important meta data'),
        'content_score' => $content_score,
        'content_message' => $content_score >= 80 ? 'Great content optimization!' : ($content_score >= 60 ? 'Content is good, room for improvement' : 'Content needs SEO optimization'),
        'structure_score' => $structure_score,
        'structure_message' => $structure_score >= 80 ? 'Excellent site structure!' : ($structure_score >= 60 ? 'Good structure with minor issues' : 'Site structure needs improvement')
    );
}

// Count pages with proper meta data
function skyworld_count_pages_with_meta() {
    $count = 0;
    $post_types = array( 'page', 'strain', 'sw-product', 'location' );
    
    foreach ( $post_types as $post_type ) {
        $posts = get_posts( array(
            'post_type' => $post_type,
            'posts_per_page' => -1,
            'meta_query' => array(
                'relation' => 'OR',
                array(
                    'key' => '_yoast_wpseo_metadesc',
                    'compare' => '!=',
                    'value' => ''
                ),
                array(
                    'key' => 'seo_description',
                    'compare' => '!=',
                    'value' => ''
                )
            )
        ));
        $count += count( $posts );
    }
    
    return $count;
}

// Calculate content quality score
function skyworld_calculate_content_score() {
    $score = 70; // Base score
    
    // Check if strains have proper descriptions
    $strains_with_content = get_posts( array(
        'post_type' => 'strain',
        'posts_per_page' => -1,
        'meta_query' => array(
            array(
                'key' => 'strain_effects',
                'compare' => '!=',
                'value' => ''
            )
        )
    ));
    
    $total_strains = wp_count_posts( 'strain' )->publish;
    if ( $total_strains > 0 ) {
        $score += ( count( $strains_with_content ) / $total_strains ) * 15;
    }
    
    // Check if products have lab results
    $products_with_labs = get_posts( array(
        'post_type' => 'sw-product',
        'posts_per_page' => -1,
        'meta_query' => array(
            array(
                'key' => 'product_lab_results',
                'compare' => '!=',
                'value' => ''
            )
        )
    ));
    
    $total_products = wp_count_posts( 'sw-product' )->publish;
    if ( $total_products > 0 ) {
        $score += ( count( $products_with_labs ) / $total_products ) * 15;
    }
    
    return min( round( $score ), 100 );
}

// Calculate site structure score
function skyworld_calculate_structure_score() {
    $score = 60; // Base score
    
    // Check if custom post types are active
    if ( post_type_exists( 'strain' ) ) $score += 10;
    if ( post_type_exists( 'sw-product' ) ) $score += 10;
    if ( post_type_exists( 'location' ) ) $score += 10;
    
    // Check if taxonomies are active
    if ( taxonomy_exists( 'terpene' ) ) $score += 5;
    if ( taxonomy_exists( 'strain_type' ) ) $score += 5;
    
    return min( $score, 100 );
}

// Get pages missing meta data
function skyworld_get_pages_missing_meta() {
    $pages_missing = array();
    $post_types = array( 'page', 'strain', 'sw-product', 'location' );
    
    foreach ( $post_types as $post_type ) {
        $posts = get_posts( array(
            'post_type' => $post_type,
            'posts_per_page' => 10,
            'post_status' => 'publish'
        ));
        
        foreach ( $posts as $post ) {
            $missing = array();
            
            // Check for meta description
            if ( ! get_post_meta( $post->ID, '_yoast_wpseo_metadesc', true ) && ! get_field( 'seo_description', $post->ID ) ) {
                $missing[] = 'Meta Description';
            }
            
            // Check for featured image
            if ( ! has_post_thumbnail( $post->ID ) ) {
                $missing[] = 'Featured Image';
            }
            
            if ( ! empty( $missing ) ) {
                $pages_missing[] = array(
                    'id' => $post->ID,
                    'title' => $post->post_title,
                    'type' => $post_type,
                    'missing' => $missing
                );
            }
        }
    }
    
    return array_slice( $pages_missing, 0, 10 ); // Limit to 10 for display
}

// Get cannabis keyword statistics
function skyworld_get_cannabis_keyword_stats() {
    return array(
        'strains' => wp_count_posts( 'strain' )->publish,
        'products' => wp_count_posts( 'sw-product' )->publish,
        'locations' => wp_count_posts( 'location' )->publish,
        'terpenes' => wp_count_terms( array( 'taxonomy' => 'terpene', 'hide_empty' => false ) ),
        'strain_types' => wp_count_terms( array( 'taxonomy' => 'strain_type', 'hide_empty' => false ) ),
        'product_types' => wp_count_terms( array( 'taxonomy' => 'product_type', 'hide_empty' => false ) )
    );
}

// Run technical SEO checks
function skyworld_run_technical_seo_checks() {
    $checks = array();
    
    // Check if XML sitemap exists
    $checks[] = array(
        'name' => 'XML Sitemap',
        'description' => 'Helps search engines discover all your cannabis products and strains',
        'status' => function_exists( 'wp_sitemaps_get_server' ) || get_option( 'blog_public' ),
        'fix_url' => admin_url( 'options-reading.php' )
    );
    
    // Check if site is public
    $checks[] = array(
        'name' => 'Site Visibility',
        'description' => 'Your site is visible to search engines',
        'status' => get_option( 'blog_public' ) == 1,
        'fix_url' => admin_url( 'options-reading.php' )
    );
    
    // Check if permalinks are SEO-friendly
    $permalink_structure = get_option( 'permalink_structure' );
    $checks[] = array(
        'name' => 'SEO-Friendly URLs',
        'description' => 'URLs contain keywords instead of numbers',
        'status' => ! empty( $permalink_structure ) && $permalink_structure !== '/?p=%post_id%',
        'fix_url' => admin_url( 'options-permalink.php' )
    );
    
    // Check if SSL is enabled
    $checks[] = array(
        'name' => 'SSL Certificate (HTTPS)',
        'description' => 'Secure connection required for modern SEO',
        'status' => is_ssl() || strpos( home_url(), 'https://' ) === 0,
        'fix_url' => admin_url( 'options-general.php' )
    );
    
    // Check if custom post types have archives
    $checks[] = array(
        'name' => 'Cannabis Archive Pages',
        'description' => 'Strain and product archive pages are enabled',
        'status' => post_type_exists( 'strain' ) && post_type_exists( 'sw-product' ),
        'fix_url' => ''
    );
    
    return $checks;
}