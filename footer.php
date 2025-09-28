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
            </div>
            
            <!-- Quick Links -->
            <div class="skyworld-footer-links">
                <h4>Explore</h4>
                <ul>
                    <li><a href="<?php echo home_url('/strain-library/'); ?>">Strain Library</a></li>
                    <li><a href="<?php echo home_url('/store-locator/'); ?>">Find Stores</a></li>
                    <li><a href="<?php echo home_url('/coa/'); ?>">Lab Results</a></li>
                    <li><a href="<?php echo home_url('/wholesale/'); ?>">Wholesale</a></li>
                </ul>
            </div>
            
            <!-- Company -->
            <div class="skyworld-footer-links">
                <h4>Company</h4>
                <ul>
                    <li><a href="<?php echo home_url('/about/'); ?>">About Us</a></li>
                    <li><a href="<?php echo home_url('/careers/'); ?>">Careers</a></li>
                    <li><a href="<?php echo home_url('/sitemap/'); ?>">Sitemap</a></li>
                    <li><a href="<?php echo home_url('/contact/'); ?>">Contact</a></li>
                </ul>
            </div>
            
            <!-- Legal & Support -->
            <div class="skyworld-footer-links">
                <h4>Support</h4>
                <ul>
                    <li><a href="<?php echo home_url('/privacy-policy/'); ?>">Privacy Policy</a></li>
                    <li><a href="<?php echo home_url('/terms-of-service/'); ?>">Terms of Service</a></li>
                    <li><a href="<?php echo home_url('/compliance/'); ?>">Compliance</a></li>
                    <li><a href="mailto:support@skyworld.com">Help Center</a></li>
                </ul>
            </div>
        </div>
        
        <!-- Footer Bottom -->
        <div class="skyworld-footer-bottom">
            <div class="skyworld-footer-bottom-content">
                <div class="skyworld-footer-legal">
                    <p>&copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?>. All rights reserved.</p>
                    <p class="skyworld-footer-disclaimer">
                        <i class="fas fa-exclamation-circle"></i>
                        This product has not been analyzed or approved by the FDA. 
                        Keep out of reach of children and pets.
                    </p>
                </div>
                
                <div class="skyworld-footer-certification">
                    <div class="skyworld-certification-badge">
                        <i class="fas fa-certificate"></i>
                        <span>Lab Tested</span>
                    </div>
                    <div class="skyworld-certification-badge">
                        <i class="fas fa-shield-alt"></i>
                        <span>Quality Assured</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>

<!-- Back to Top Button -->
<button id="backToTop" class="skyworld-back-to-top" title="Back to top">
    <i class="fas fa-chevron-up"></i>
</button>

<script>
// Back to top functionality
document.addEventListener('DOMContentLoaded', function() {
    const backToTop = document.getElementById('backToTop');
    
    if (backToTop) {
        // Show/hide button based on scroll position
        window.addEventListener('scroll', function() {
            if (window.pageYOffset > 300) {
                backToTop.classList.add('visible');
            } else {
                backToTop.classList.remove('visible');
            }
        });
        
        // Smooth scroll to top
        backToTop.addEventListener('click', function() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    }
});
</script>

<?php wp_footer(); ?>
</body>
</html>