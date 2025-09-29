<?php
/**
 * Demo Page Template for Customizer Testing
 * Template Name: Customizer Demo
 * 
 * This page showcases all the customizable elements for testing
 */
get_header(); ?>

<div class="customizer-demo-page">
    <div class="container">
        
        <!-- Hero Section -->
        <div class="strain-hero demo-hero">
            <div class="strain-hero-content">
                <div class="strain-hero-info">
                    <h1 class="strain-title">Customizer Demo Page</h1>
                    <p class="strain-description">
                        Test all your design changes in real-time! This page contains all the elements you can customize with the Skyworld Design panel in the WordPress Customizer.
                    </p>
                    
                    <div class="demo-buttons">
                        <a href="#" class="product-link">Primary Button</a>
                        <a href="#" class="strain-link">Secondary Button</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Typography Demo -->
        <div class="detail-section">
            <h2 class="section-title">
                <span class="section-icon"><i class="ph ph-text-aa"></i></span>
                Typography Showcase
            </h2>
            
            <h1>Heading 1 (H1) - Strain Titles</h1>
            <h2>Heading 2 (H2) - Section Titles</h2>
            <h3>Heading 3 (H3) - Product Names</h3>
            
            <p>This is body text (paragraph). You can adjust the font size of all text elements using the Typography section in the customizer. Changes appear instantly as you move the sliders!</p>
            
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation.</p>
        </div>

        <!-- Colors Demo -->
        <div class="detail-section">
            <h2 class="section-title">
                <span class="section-icon"><i class="ph ph-palette"></i></span>
                Color System Demo
            </h2>
            
            <div class="color-demo-grid">
                <div class="effect-tag">Primary Color Tag</div>
                <div class="qa-badge">Quality Badge</div>
                <div class="product-potency">THC: 25%</div>
                <div class="thc-stat">Lab Result</div>
            </div>
            
            <p>All these elements use your primary color. The section titles use the secondary color, and this body text uses your custom text color.</p>
            
            <p><a href="#">This is a link</a> that uses your primary color with hover effects.</p>
        </div>

        <!-- Button Demo -->
        <div class="detail-section">
            <h2 class="section-title">
                <span class="section-icon"><i class="ph ph-cursor-click"></i></span>
                Button Styles
            </h2>
            
            <div class="button-demo-row">
                <button class="product-link">Product Button</button>
                <a href="#" class="strain-link">Strain Link</a>
                <button>Regular Button</button>
            </div>
            
            <p>Test different button styles: Square, Rounded (default), or Pill shape. Also try different sizes: Small, Medium, or Large.</p>
        </div>

        <!-- Layout Demo -->
        <div class="detail-section">
            <h2 class="section-title">
                <span class="section-icon"><i class="ph ph-layout"></i></span>
                Layout & Spacing
            </h2>
            
            <p>This container width and section spacing can be adjusted in real-time. The container width affects the maximum width of content, while section spacing controls the padding and margins around sections like this one.</p>
        </div>

        <!-- Strain Card Demo -->
        <div class="related-strains-section">
            <h2 class="section-title">Sample Strain Cards</h2>
            
            <div class="related-strains-grid">
                <div class="related-strain-card">
                    <div class="strain-image">
                        <div class="strain-placeholder"><i class="ph ph-leaf"></i></div>
                    </div>
                    
                    <div class="strain-info">
                        <h3 class="strain-name">Sample Strain</h3>
                        <span class="strain-type hybrid">Hybrid</span>
                        
                        <div class="strain-stats">
                            <span class="thc-stat">THC: 24%</span>
                        </div>
                        
                        <a href="#" class="strain-link">Learn More</a>
                    </div>
                </div>
                
                <div class="related-strain-card">
                    <div class="strain-image">
                        <div class="strain-placeholder"><i class="ph ph-leaf"></i></div>
                    </div>
                    
                    <div class="strain-info">
                        <h3 class="strain-name">Another Strain</h3>
                        <span class="strain-type indica">Indica</span>
                        
                        <div class="strain-stats">
                            <span class="thc-stat">THC: 28%</span>
                        </div>
                        
                        <a href="#" class="strain-link">Learn More</a>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<style>
.customizer-demo-page {
    background: var(--skyworld-bg, #f8f9fa);
    min-height: 100vh;
    padding: 40px 0;
}

.demo-hero {
    text-align: center;
    background: white;
    border-radius: 16px;
    margin-bottom: 40px;
}

.demo-buttons {
    display: flex;
    gap: 20px;
    justify-content: center;
    margin-top: 30px;
}

.color-demo-grid {
    display: flex;
    gap: 15px;
    flex-wrap: wrap;
    margin: 20px 0;
}

.button-demo-row {
    display: flex;
    gap: 15px;
    flex-wrap: wrap;
    margin: 20px 0;
}

.related-strains-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 30px;
    margin-top: 30px;
}

@media (max-width: 768px) {
    .demo-buttons,
    .color-demo-grid,
    .button-demo-row {
        justify-content: center;
    }
    
    .related-strains-grid {
        grid-template-columns: 1fr;
    }
}
</style>

<?php get_footer(); ?>