<!-- Skyworld Footer -->
<footer id="skyworld-footer" class="skyworld-footer">
    <div class="skyworld-footer-container">
        <!-- Footer Main Content -->
        <div class="skyworld-footer-content">
            <!-- Brand Section -->
            <div class="skyworld-footer-brand">
                <div class="skyworld-footer-logo">
                    <?php if (has_custom_logo()) : ?>
                        <?php the_custom_logo(); ?>
                    <?php else : ?>
                        <i class="fas fa-cannabis skyworld-footer-icon"></i>
                        <span class="skyworld-footer-brand-text"><?php bloginfo('name'); ?></span>
                    <?php endif; ?>
                </div>
                <p class="skyworld-footer-tagline">Premium Cannabis. Proven Excellence.</p>
                <div class="skyworld-footer-social">
                    <a href="#" class="skyworld-social-link" title="Follow us on Instagram">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a href="#" class="skyworld-social-link" title="Like us on Facebook">
                        <i class="fab fa-facebook"></i>
                    </a>
                    <a href="#" class="skyworld-social-link" title="Follow us on Twitter">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a href="#" class="skyworld-social-link" title="Connect on LinkedIn">
                        <i class="fab fa-linkedin"></i>
                    </a>
                </div>
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