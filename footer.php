<!-- Professional Cannabis Business Footer -->
<footer class="skyworld-footer" role="contentinfo">
    <div class="skyworld-footer-content">
        
        <!-- Footer Top Section -->
        <div class="skyworld-footer-top">
            <div class="footer-section footer-brand">
                <div class="footer-logo">
                    <i class="ph ph-leaf"></i>
                    <span><?php bloginfo( 'name' ); ?></span>
                </div>
                <p class="footer-tagline">Premium Cannabis. Professional Excellence.</p>
                <p class="footer-description">
                    <?php 
                    $description = get_bloginfo( 'description' );
                    echo $description ? esc_html( $description ) : 'Quality cannabis products for New York\'s adult-use market.';
                    ?>
                </p>
            </div>
            
            <div class="footer-section footer-links">
                <h4>Products</h4>
                <ul>
                    <li><a href="<?php echo esc_url( home_url( '/strains/' ) ); ?>"><i class="ph ph-leaf"></i> Strain Library</a></li>
                    <li><a href="<?php echo esc_url( home_url( '/products/' ) ); ?>"><i class="ph ph-package"></i> Cannabis Products</a></li>
                    <li><a href="<?php echo esc_url( home_url( '/labs/' ) ); ?>"><i class="ph ph-flask"></i> Lab Results</a></li>
                    <li><a href="<?php echo esc_url( home_url( '/wholesale/' ) ); ?>"><i class="ph ph-handshake"></i> Wholesale</a></li>
                </ul>
            </div>
            
            <div class="footer-section footer-company">
                <h4>Company</h4>
                <ul>
                    <li><a href="<?php echo esc_url( home_url( '/about/' ) ); ?>"><i class="ph ph-info"></i> About Us</a></li>
                    <li><a href="<?php echo esc_url( home_url( '/news/' ) ); ?>"><i class="ph ph-newspaper"></i> News</a></li>
                    <li><a href="<?php echo esc_url( home_url( '/careers/' ) ); ?>"><i class="ph ph-briefcase"></i> Careers</a></li>
                    <li><a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>"><i class="ph ph-envelope"></i> Contact</a></li>
                </ul>
            </div>
            
            <div class="footer-section footer-locations">
                <h4>Find Us</h4>
                <ul>
                    <li><a href="<?php echo esc_url( home_url( '/store-locator/' ) ); ?>"><i class="ph ph-map-pin"></i> Store Locator</a></li>
                    <li><a href="<?php echo esc_url( home_url( '/locations/' ) ); ?>"><i class="ph ph-buildings"></i> All Locations</a></li>
                </ul>
                
                <div class="footer-social">
                    <h5>Follow Us</h5>
                    <div class="social-links">
                        <a href="#" aria-label="Instagram" title="Follow us on Instagram">
                            <i class="ph ph-instagram-logo"></i>
                        </a>
                        <a href="#" aria-label="Facebook" title="Like us on Facebook">
                            <i class="ph ph-facebook-logo"></i>
                        </a>
                        <a href="#" aria-label="Twitter" title="Follow us on Twitter">
                            <i class="ph ph-twitter-logo"></i>
                        </a>
                        <a href="#" aria-label="LinkedIn" title="Connect on LinkedIn">
                            <i class="ph ph-linkedin-logo"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Footer Bottom Section -->
        <div class="skyworld-footer-bottom">
            <div class="footer-legal">
                <p class="copyright">
                    &copy; <?php echo date( 'Y' ); ?> <?php bloginfo( 'name' ); ?>. All rights reserved.
                </p>
                <p class="license-info">
                    Licensed Cannabis Processor & Cultivator | New York State
                </p>
                <p class="ocm-licenses">
                    <strong>OCM License Numbers:</strong> #OCM-PROC-24-000030 #OCM-CULT-2023-000179
                </p>
            </div>
            
            <div class="footer-legal-links">
                <a href="<?php echo esc_url( home_url( '/privacy-policy/' ) ); ?>">Privacy Policy</a>
                <a href="<?php echo esc_url( home_url( '/terms-of-service/' ) ); ?>">Terms of Service</a>
                <a href="<?php echo esc_url( home_url( '/media-kit/' ) ); ?>">Media Kit</a>
            </div>
            
            <div class="footer-attribution">
                <p class="made-by">
                    Made to Inspire by <a href="https://therealjohndough.com" target="_blank" rel="noopener">John Dough</a>
                </p>
            </div>
        </div>
        
        <!-- Age Compliance Notice -->
        <div class="age-compliance-notice">
            <p><i class="ph ph-warning"></i> Must be 21+ to purchase. Keep out of reach of children and pets.</p>
        </div>
        
    </div>
</footer>

<?php wp_footer(); ?>

</body>
</html>