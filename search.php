<?php
/**
 * The template for displaying search results pages
 * Professional Cannabis Management Theme
 */

get_header(); ?>

<div id="primary" class="content-area search-results">
    <main id="main" class="site-main">
        
        <header class="page-header">
            <div class="search-header">
                <h1 class="page-title">
                    <i class="ph ph-magnifying-glass"></i>
                    <?php printf( esc_html__( 'Search Results for: %s', 'skyworld-cannabis' ), '<span class="search-term">' . get_search_query() . '</span>' ); ?>
                </h1>
                
                <div class="search-meta">
                    <?php
                    global $wp_query;
                    $total_results = $wp_query->found_posts;
                    if ( $total_results ) {
                        printf( _n( '%s result found', '%s results found', $total_results, 'skyworld-cannabis' ), number_format_i18n( $total_results ) );
                    }
                    ?>
                </div>
            </div>
            
            <!-- Enhanced search form -->
            <div class="search-form-container">
                <?php get_search_form(); ?>
            </div>
        </header>

        <?php if ( have_posts() ) : ?>
            
            <div class="search-results-grid">
                <?php while ( have_posts() ) : the_post(); ?>
                    
                    <article id="post-<?php the_ID(); ?>" <?php post_class( 'search-result-item' ); ?>>
                        
                        <?php if ( has_post_thumbnail() ) : ?>
                            <div class="result-thumbnail">
                                <a href="<?php the_permalink(); ?>">
                                    <?php the_post_thumbnail( 'medium' ); ?>
                                </a>
                            </div>
                        <?php endif; ?>
                        
                        <div class="result-content">
                            <header class="entry-header">
                                <div class="result-type">
                                    <i class="ph ph-<?php echo get_post_type_icon( get_post_type() ); ?>"></i>
                                    <?php echo get_post_type_object( get_post_type() )->labels->singular_name; ?>
                                </div>
                                
                                <h2 class="entry-title">
                                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                </h2>
                                
                                <div class="entry-meta">
                                    <time datetime="<?php echo get_the_date( 'c' ); ?>">
                                        <i class="ph ph-calendar"></i>
                                        <?php echo get_the_date(); ?>
                                    </time>
                                </div>
                            </header>

                            <div class="entry-summary">
                                <?php 
                                $excerpt = get_the_excerpt();
                                if ( $excerpt ) {
                                    echo wp_trim_words( $excerpt, 25, '...' );
                                } else {
                                    echo wp_trim_words( get_the_content(), 25, '...' );
                                }
                                ?>
                            </div>
                            
                            <footer class="entry-footer">
                                <a href="<?php the_permalink(); ?>" class="read-more-btn">
                                    View Details <i class="ph ph-arrow-right"></i>
                                </a>
                            </footer>
                        </div>
                    </article>

                <?php endwhile; ?>
            </div>

            <?php
            // Pagination for search results
            the_posts_pagination( array(
                'mid_size' => 2,
                'prev_text' => '<i class="ph ph-arrow-left"></i> Previous',
                'next_text' => 'Next <i class="ph ph-arrow-right"></i>',
                'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( 'Page', 'skyworld-cannabis' ) . ' </span>',
            ) );
            ?>

        <?php else : ?>

            <section class="no-results not-found">
                <header class="page-header">
                    <h1 class="page-title">
                        <i class="ph ph-magnifying-glass-minus"></i>
                        <?php esc_html_e( 'Nothing found', 'skyworld-cannabis' ); ?>
                    </h1>
                </header>

                <div class="page-content">
                    <p><?php esc_html_e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'skyworld-cannabis' ); ?></p>
                    
                    <div class="search-suggestions">
                        <h3>Search Suggestions:</h3>
                        <ul>
                            <li><i class="ph ph-leaf"></i> Try searching for strain names like "OG Kush" or "Blue Dream"</li>
                            <li><i class="ph ph-package"></i> Search product types like "flower", "pre-rolls", or "concentrates"</li>
                            <li><i class="ph ph-map-pin"></i> Look for dispensary locations by city or zip code</li>
                            <li><i class="ph ph-dna"></i> Search by effects like "relaxing", "energizing", or "pain relief"</li>
                        </ul>
                    </div>
                    
                    <?php get_search_form(); ?>
                </div>
            </section>

        <?php endif; ?>

    </main>
</div>

<?php
// Helper function for post type icons
function get_post_type_icon( $post_type ) {
    $icons = array(
        'strain' => 'leaf',
        'product' => 'package',
        'location' => 'map-pin',
        'post' => 'article',
        'page' => 'file-text',
    );
    
    return isset( $icons[ $post_type ] ) ? $icons[ $post_type ] : 'file';
}
?>

<?php get_footer(); ?>