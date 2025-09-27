<?php
/**
 * The template for displaying 404 pages (not found)
 * Professional Cannabis Management Theme
 */

get_header(); ?>

<div id="primary" class="content-area error-404">
    <main id="main" class="site-main">
        
        <section class="error-404 not-found">
            <header class="page-header">
                <div class="error-icon">
                    <i class="ph ph-warning-circle"></i>
                </div>
                <h1 class="page-title"><?php esc_html_e( '404 - Page Not Found', 'skyworld-cannabis' ); ?></h1>
                <p class="error-description"><?php esc_html_e( 'The page you are looking for might have been removed, had its name changed, or is temporarily unavailable.', 'skyworld-cannabis' ); ?></p>
            </header>

            <div class="page-content">
                
                <!-- Search Widget -->
                <div class="error-section">
                    <h2><i class="ph ph-magnifying-glass"></i> Search Our Site</h2>
                    <p>Try searching for what you were looking for:</p>
                    <?php get_search_form(); ?>
                </div>
                
                <!-- Quick Navigation -->
                <div class="error-section">
                    <h2><i class="ph ph-navigation-arrow"></i> Quick Navigation</h2>
                    <div class="quick-nav-grid">
                        <a href="<?php echo home_url(); ?>" class="nav-item">
                            <i class="ph ph-house"></i>
                            <span>Home</span>
                        </a>
                        
                        <a href="<?php echo home_url('/strains/'); ?>" class="nav-item">
                            <i class="ph ph-leaf"></i>
                            <span>Strain Library</span>
                        </a>
                        
                        <a href="<?php echo home_url('/products/'); ?>" class="nav-item">
                            <i class="ph ph-package"></i>
                            <span>Products</span>
                        </a>
                        
                        <a href="<?php echo home_url('/locations/'); ?>" class="nav-item">
                            <i class="ph ph-map-pin"></i>
                            <span>Store Locations</span>
                        </a>
                        
                        <a href="<?php echo home_url('/about/'); ?>" class="nav-item">
                            <i class="ph ph-info"></i>
                            <span>About Us</span>
                        </a>
                        
                        <a href="<?php echo home_url('/contact/'); ?>" class="nav-item">
                            <i class="ph ph-envelope"></i>
                            <span>Contact</span>
                        </a>
                    </div>
                </div>
                
                <!-- Recent Cannabis Content -->
                <?php
                $recent_strains = get_posts( array(
                    'post_type' => 'strain',
                    'posts_per_page' => 3,
                    'post_status' => 'publish'
                ) );
                
                if ( $recent_strains ) : ?>
                    <div class="error-section">
                        <h2><i class="ph ph-leaf"></i> Featured Strains</h2>
                        <div class="recent-items-grid">
                            <?php foreach ( $recent_strains as $strain ) : ?>
                                <article class="recent-item">
                                    <?php if ( has_post_thumbnail( $strain->ID ) ) : ?>
                                        <div class="item-thumbnail">
                                            <a href="<?php echo get_permalink( $strain->ID ); ?>">
                                                <?php echo get_the_post_thumbnail( $strain->ID, 'thumbnail' ); ?>
                                            </a>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <div class="item-content">
                                        <h3><a href="<?php echo get_permalink( $strain->ID ); ?>"><?php echo get_the_title( $strain->ID ); ?></a></h3>
                                        <p><?php echo wp_trim_words( get_the_excerpt( $strain->ID ), 15 ); ?></p>
                                    </div>
                                </article>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; wp_reset_postdata(); ?>
                
                <!-- Help Section -->
                <div class="error-section">
                    <h2><i class="ph ph-lifebuoy"></i> Need Help?</h2>
                    <p>If you believe this is an error, please contact our support team:</p>
                    <div class="help-actions">
                        <a href="<?php echo home_url('/contact/'); ?>" class="help-button">
                            <i class="ph ph-envelope"></i>
                            Contact Support
                        </a>
                        <a href="<?php echo home_url(); ?>" class="help-button">
                            <i class="ph ph-house"></i>
                            Return Home
                        </a>
                    </div>
                </div>
                
            </div>
        </section>

    </main>
</div>

<style>
/* Professional 404 Page Styles */
.error-404 {
    padding: 2rem 0;
    min-height: 60vh;
}

.error-404 .page-header {
    text-align: center;
    margin-bottom: 3rem;
}

.error-icon {
    font-size: 4rem;
    color: #dc3545;
    margin-bottom: 1rem;
}

.error-404 .page-title {
    font-size: 2.5rem;
    margin-bottom: 1rem;
    color: #333;
}

.error-description {
    font-size: 1.1rem;
    color: #666;
    max-width: 600px;
    margin: 0 auto;
}

.error-section {
    margin-bottom: 3rem;
    padding: 2rem;
    background: #f8f9fa;
    border-radius: 8px;
}

.error-section h2 {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    margin-bottom: 1rem;
    color: #333;
}

.quick-nav-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
    gap: 1rem;
    margin-top: 1rem;
}

.nav-item {
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 1.5rem;
    background: white;
    border-radius: 8px;
    text-decoration: none;
    color: #333;
    transition: transform 0.2s, box-shadow 0.2s;
}

.nav-item:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}

.nav-item i {
    font-size: 2rem;
    margin-bottom: 0.5rem;
    color: #28a745;
}

.recent-items-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 1.5rem;
    margin-top: 1rem;
}

.recent-item {
    background: white;
    border-radius: 8px;
    padding: 1rem;
    display: flex;
    gap: 1rem;
}

.item-thumbnail img {
    width: 60px;
    height: 60px;
    object-fit: cover;
    border-radius: 4px;
}

.item-content h3 {
    margin: 0 0 0.5rem 0;
    font-size: 1rem;
}

.item-content a {
    text-decoration: none;
    color: #333;
}

.item-content a:hover {
    color: #28a745;
}

.help-actions {
    display: flex;
    gap: 1rem;
    margin-top: 1rem;
}

.help-button {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.75rem 1.5rem;
    background: #28a745;
    color: white;
    text-decoration: none;
    border-radius: 5px;
    transition: background-color 0.2s;
}

.help-button:hover {
    background: #218838;
}
</style>

<?php get_footer(); ?>