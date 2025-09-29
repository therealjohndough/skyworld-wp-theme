<?php
/**
 * Template Part: News & Updates Block
 * Displays latest news, blog posts, and company updates
 */
?>

<section class="skyworld-news-block" id="newsBlock">
    <div class="news-block-container">
        <div class="section-header">
            <div class="section-badge">
                <i class="fas fa-newspaper"></i>
                <span>News & Updates</span>
            </div>
            <h2 class="section-title">Latest from Skyworld</h2>
            <p class="section-subtitle">Stay updated with our latest news, strain releases, and cannabis industry insights.</p>
        </div>
        
        <div class="news-block-content">
            <div class="featured-news">
                <?php
                // Query for featured news article
                $featured_news = new WP_Query(array(
                    'post_type' => 'post',
                    'posts_per_page' => 1,
                    'meta_query' => array(
                        array(
                            'key' => 'featured_news',
                            'value' => '1',
                            'compare' => '='
                        )
                    )
                ));
                
                if ($featured_news->have_posts()) :
                    $featured_news->the_post();
                    $featured_image = get_the_post_thumbnail_url(get_the_ID(), 'large');
                    $news_category = get_the_category_list(', ');
                    $read_time = get_field('estimated_read_time') ?: '3 min read';
                    ?>
                    
                    <article class="featured-news-card">
                        <div class="featured-news-image">
                            <?php if ($featured_image): ?>
                                <img src="<?php echo $featured_image; ?>" 
                                     alt="<?php the_title(); ?>"
                                     loading="lazy">
                            <?php else: ?>
                                <div class="featured-news-placeholder">
                                    <i class="fas fa-cannabis"></i>
                                    <span>📰</span>
                                </div>
                            <?php endif; ?>
                            
                            <div class="featured-news-overlay">
                                <div class="news-category-badge">
                                    <i class="fas fa-tag"></i>
                                    <?php echo wp_strip_all_tags($news_category); ?>
                                </div>
                                <div class="news-read-time">
                                    <i class="fas fa-clock"></i>
                                    <?php echo $read_time; ?>
                                </div>
                            </div>
                        </div>
                        
                        <div class="featured-news-content">
                            <div class="news-meta">
                                <span class="news-date">
                                    <i class="fas fa-calendar"></i>
                                    <?php echo get_the_date('M j, Y'); ?>
                                </span>
                                <span class="news-author">
                                    <i class="fas fa-user"></i>
                                    <?php the_author(); ?>
                                </span>
                            </div>
                            
                            <h3 class="featured-news-title">
                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                            </h3>
                            
                            <p class="featured-news-excerpt">
                                <?php echo wp_trim_words(get_the_excerpt(), 25); ?>
                            </p>
                            
                            <div class="featured-news-actions">
                                <a href="<?php the_permalink(); ?>" class="news-read-more-btn">
                                    <span>Read Full Article</span>
                                    <i class="fas fa-arrow-right"></i>
                                </a>
                                
                                <div class="news-share-buttons">
                                    <button class="share-btn" title="Share on Twitter" 
                                            onclick="window.open('https://twitter.com/intent/tweet?url=<?php echo urlencode(get_permalink()); ?>&text=<?php echo urlencode(get_the_title()); ?>', '_blank', 'width=600,height=400')">
                                        <i class="fab fa-twitter"></i>
                                    </button>
                                    <button class="share-btn" title="Share on Facebook"
                                            onclick="window.open('https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode(get_permalink()); ?>', '_blank', 'width=600,height=400')">
                                        <i class="fab fa-facebook"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </article>
                    
                    <?php wp_reset_postdata();
                else: ?>
                    
                    <!-- Fallback featured news -->
                    <article class="featured-news-card fallback">
                        <div class="featured-news-image">
                            <div class="featured-news-placeholder">
                                <i class="fas fa-cannabis"></i>
                                <span>📰</span>
                            </div>
                        </div>
                        <div class="featured-news-content">
                            <h3 class="featured-news-title">Welcome to Skyworld Cannabis</h3>
                            <p class="featured-news-excerpt">Stay tuned for the latest news, strain releases, and updates from our premium cannabis brand.</p>
                            <div class="featured-news-actions">
                                <a href="<?php echo home_url('/about/'); ?>" class="news-read-more-btn">
                                    <span>Learn About Us</span>
                                    <i class="fas fa-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    </article>
                    
                <?php endif; ?>
            </div>
            
            <div class="news-sidebar">
                <div class="recent-news">
                    <h4 class="sidebar-title">
                        <i class="fas fa-fire"></i>
                        Recent Updates
                    </h4>
                    
                    <?php
                    // Query for recent news
                    $recent_news = new WP_Query(array(
                        'post_type' => 'post',
                        'posts_per_page' => 4,
                        'meta_query' => array(
                            array(
                                'key' => 'featured_news',
                                'value' => '1',
                                'compare' => '!='
                            )
                        )
                    ));
                    
                    if ($recent_news->have_posts()) :
                        while ($recent_news->have_posts()) : $recent_news->the_post();
                            $thumbnail = get_the_post_thumbnail_url(get_the_ID(), 'thumbnail');
                            ?>
                            
                            <article class="recent-news-item">
                                <div class="recent-news-image">
                                    <?php if ($thumbnail): ?>
                                        <img src="<?php echo $thumbnail; ?>" 
                                             alt="<?php the_title(); ?>"
                                             loading="lazy">
                                    <?php else: ?>
                                        <div class="recent-news-icon">
                                            <i class="fas fa-newspaper"></i>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                
                                <div class="recent-news-content">
                                    <h5 class="recent-news-title">
                                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                    </h5>
                                    <div class="recent-news-meta">
                                        <span class="recent-news-date"><?php echo get_the_date('M j'); ?></span>
                                        <span class="recent-news-category"><?php echo get_the_category_list(', '); ?></span>
                                    </div>
                                </div>
                            </article>
                            
                        <?php endwhile;
                        wp_reset_postdata();
                    else: ?>
                        
                        <!-- Fallback recent news -->
                        <?php
                        $fallback_news = array(
                            'New Strain Alert: Skyworld OG',
                            'Lab Results Now Available Online',
                            'Expanding to New Dispensaries',
                            'Sustainable Growing Practices'
                        );
                        
                        foreach ($fallback_news as $news_title):
                        ?>
                        <article class="recent-news-item fallback">
                            <div class="recent-news-image">
                                <div class="recent-news-icon">
                                    <i class="fas fa-seedling"></i>
                                </div>
                            </div>
                            <div class="recent-news-content">
                                <h5 class="recent-news-title">
                                    <a href="#"><?php echo $news_title; ?></a>
                                </h5>
                                <div class="recent-news-meta">
                                    <span class="recent-news-date">Coming Soon</span>
                                </div>
                            </div>
                        </article>
                        <?php endforeach; ?>
                        
                    <?php endif; ?>
                </div>
                
                <div class="newsletter-signup">
                    <div class="newsletter-header">
                        <i class="fas fa-envelope"></i>
                        <h4>Stay Updated</h4>
                    </div>
                    <p>Get the latest news and exclusive offers delivered to your inbox.</p>
                    <form class="newsletter-form" id="newsletterForm">
                        <input type="email" 
                               class="newsletter-input" 
                               placeholder="Enter your email" 
                               required>
                        <button type="submit" class="newsletter-button">
                            <i class="fas fa-paper-plane"></i>
                            Subscribe
                        </button>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="news-block-footer">
            <a href="<?php echo home_url('/blog/'); ?>" class="view-all-button">
                <span>View All News</span>
                <i class="fas fa-arrow-right"></i>
            </a>
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const newsletterForm = document.getElementById('newsletterForm');
    
    if (newsletterForm) {
        newsletterForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const email = this.querySelector('.newsletter-input').value;
            const button = this.querySelector('.newsletter-button');
            const originalText = button.innerHTML;
            
            // Show loading state
            button.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Subscribing...';
            button.disabled = true;
            
            // Simulate subscription (replace with actual implementation)
            setTimeout(() => {
                button.innerHTML = '<i class="fas fa-check"></i> Subscribed!';
                button.style.background = 'var(--color-sativa)';
                
                setTimeout(() => {
                    button.innerHTML = originalText;
                    button.disabled = false;
                    button.style.background = '';
                    this.reset();
                }, 2000);
            }, 1500);
        });
    }
});
</script>