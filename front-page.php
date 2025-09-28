<?php
/**
 * Front Page Template for Skyworld WP Child
 * Template Name: Skyworld Catalog Front Page
 */

get_header();
?>

<!-- Age Gate Modal -->
<div id="age-gate-modal" class="age-gate-modal">
    <div class="age-gate-content">
        <div class="age-gate-logo">
            <i class="fas fa-cannabis"></i>
            <h2>Welcome to Skyworld</h2>
        </div>
        <p class="age-gate-message">You must be 21 or older to view this content</p>
        <div class="age-gate-buttons">
            <button id="age-gate-yes" class="age-gate-btn age-gate-yes">I am 21 or older</button>
            <button id="age-gate-no" class="age-gate-btn age-gate-no">I am under 21</button>
        </div>
        <p class="age-gate-disclaimer">
            <i class="fas fa-exclamation-circle"></i>
            This product has not been analyzed or approved by the FDA. 
            Keep out of reach of children and pets.
        </p>
    </div>
</div>

<!-- Main Content Container -->
<main class="skyworld-front-page">
    
    <!-- Hero Slider Section -->
    <?php get_template_part('template-parts/hero-slider'); ?>
    
    <!-- Genetic Library Section -->
    <?php get_template_part('template-parts/genetic-library-block'); ?>
    
    <!-- Product Slider Section -->
    <?php get_template_part('template-parts/product-slider-block'); ?>
    
    <!-- News & Updates Section -->
    <?php get_template_part('template-parts/news-block'); ?>
    
    <!-- Call-to-Action Section -->
    <section class="skyworld-cta-section">
        <div class="cta-container">
            <div class="cta-content">
                <h2 class="cta-title">Ready to Experience Skyworld?</h2>
                <p class="cta-subtitle">Find our premium cannabis products at authorized dispensaries near you.</p>
                <div class="cta-actions">
                    <a href="<?php echo home_url('/store-locator/'); ?>" class="cta-button primary">
                        <i class="fas fa-map-marker-alt"></i>
                        Find Stores Near You
                    </a>
                    <a href="<?php echo home_url('/wholesale/'); ?>" class="cta-button secondary">
                        <i class="fas fa-handshake"></i>
                        Wholesale Partnership
                    </a>
                </div>
            </div>
        </div>
    </section>
    
</main>

<style>
/* Age Gate Styles */
.age-gate-modal {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.9);
    z-index: 10000;
    display: flex;
    align-items: center;
    justify-content: center;
    backdrop-filter: blur(10px);
}

.age-gate-modal.hidden {
    display: none;
}

.age-gate-content {
    background: var(--color-card-bg);
    padding: 3rem;
    border-radius: var(--border-radius);
    text-align: center;
    max-width: 500px;
    width: 90%;
    box-shadow: var(--shadow-lg);
}

.age-gate-logo {
    margin-bottom: 2rem;
}

.age-gate-logo i {
    font-size: 3rem;
    color: var(--color-sativa);
    margin-bottom: 1rem;
}

.age-gate-logo h2 {
    font-size: 2rem;
    font-weight: 700;
    color: var(--color-text);
    font-family: 'Playfair Display', serif;
}

.age-gate-message {
    font-size: 1.2rem;
    margin-bottom: 2rem;
    color: var(--color-text);
    font-weight: 500;
}

.age-gate-buttons {
    display: flex;
    gap: 1rem;
    justify-content: center;
    margin-bottom: 2rem;
    flex-wrap: wrap;
}

.age-gate-btn {
    padding: 1rem 2rem;
    border: none;
    border-radius: var(--border-radius);
    font-weight: 600;
    cursor: pointer;
    transition: var(--transition);
    font-size: 1.1rem;
}

.age-gate-yes {
    background: var(--color-sativa);
    color: white;
}

.age-gate-yes:hover {
    background: #1e7e34;
    transform: translateY(-2px);
}

.age-gate-no {
    background: var(--color-indica);
    color: white;
}

.age-gate-no:hover {
    background: #bd2130;
    transform: translateY(-2px);
}

.age-gate-disclaimer {
    font-size: 0.9rem;
    color: var(--color-text-muted);
    display: flex;
    align-items: flex-start;
    gap: 0.5rem;
    text-align: left;
}

/* CTA Section Styles */
.skyworld-cta-section {
    background: linear-gradient(135deg, var(--color-sativa), var(--color-orange-brand));
    color: white;
    padding: 4rem 0;
    text-align: center;
}

.cta-container {
    max-width: 1400px;
    margin: 0 auto;
    padding: 0 2rem;
}

.cta-title {
    font-size: 3rem;
    font-weight: 700;
    margin-bottom: 1rem;
    font-family: 'Playfair Display', serif;
}

.cta-subtitle {
    font-size: 1.3rem;
    margin-bottom: 2.5rem;
    opacity: 0.9;
    max-width: 600px;
    margin-left: auto;
    margin-right: auto;
}

.cta-actions {
    display: flex;
    gap: 1.5rem;
    justify-content: center;
    flex-wrap: wrap;
}

.cta-button {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 1.2rem 2.5rem;
    border-radius: var(--border-radius);
    text-decoration: none;
    font-weight: 600;
    transition: var(--transition);
    font-size: 1.1rem;
    box-shadow: var(--shadow-md);
}

.cta-button.primary {
    background: white;
    color: var(--color-sativa);
}

.cta-button.primary:hover {
    background: #f8f9fa;
    transform: translateY(-3px);
    box-shadow: var(--shadow-lg);
}

.cta-button.secondary {
    background: rgba(255, 255, 255, 0.2);
    color: white;
    border: 2px solid rgba(255, 255, 255, 0.3);
    backdrop-filter: blur(10px);
}

.cta-button.secondary:hover {
    background: rgba(255, 255, 255, 0.3);
    border-color: rgba(255, 255, 255, 0.5);
    transform: translateY(-3px);
}

/* Mobile responsive */
@media (max-width: 768px) {
    .cta-title {
        font-size: 2.2rem;
    }
    
    .cta-subtitle {
        font-size: 1.1rem;
    }
    
    .cta-actions {
        flex-direction: column;
        align-items: center;
    }
    
    .cta-button {
        width: 100%;
        max-width: 300px;
        justify-content: center;
    }
}
</style>

<script>
// Age Gate Functionality
document.addEventListener('DOMContentLoaded', function() {
    const ageGateModal = document.getElementById('age-gate-modal');
    const yesButton = document.getElementById('age-gate-yes');
    const noButton = document.getElementById('age-gate-no');
    
    // Error handling - make sure elements exist
    if (!ageGateModal || !yesButton || !noButton) {
        console.warn('Age gate elements not found');
        return;
    }
    
    // Check if user has already verified age
    const ageVerified = localStorage.getItem('skyworld-age-verified');
    const verificationDate = localStorage.getItem('skyworld-age-verification-date');
    const currentDate = new Date().toDateString();
    
    // Show age gate if not verified or verification is from a different day
    if (!ageVerified || verificationDate !== currentDate) {
        ageGateModal.style.display = 'flex';
        document.body.style.overflow = 'hidden';
    } else {
        ageGateModal.style.display = 'none';
    }
    
    // Handle age verification
    yesButton.addEventListener('click', function() {
        try {
            localStorage.setItem('skyworld-age-verified', 'true');
            localStorage.setItem('skyworld-age-verification-date', currentDate);
            ageGateModal.style.display = 'none';
            document.body.style.overflow = '';
        } catch (e) {
            console.warn('localStorage not available, using session verification');
            // Fallback - just hide for this session
            ageGateModal.style.display = 'none';
            document.body.style.overflow = '';
        }
    });
    
    noButton.addEventListener('click', function() {
        // Redirect to Google as requested
        window.location.href = 'https://www.google.com';
    });
});
</script>

<?php get_footer();
