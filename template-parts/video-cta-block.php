<?php
/**
 * Video CTA Block - Explore Our Genetics
 * Professional cannabis genetics showcase with background video
 */
?>

<section class="skyworld-video-cta" data-section="genetics-cta">
    <div class="video-cta-container">
        <div class="video-cta-content">
            <!-- Background Video -->
            <div class="video-background">
                <video 
                    autoplay 
                    muted 
                    loop 
                    playsinline 
                    preload="auto"
                    poster="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/genetics-poster.jpg"
                    class="background-video"
                >
                    <source src="<?php echo get_stylesheet_directory_uri(); ?>/assets/videos/cannabis-genetics.mp4" type="video/mp4">
                    <source src="<?php echo get_stylesheet_directory_uri(); ?>/assets/videos/cannabis-genetics.webm" type="video/webm">
                </video>
                <div class="video-overlay"></div>
            </div>
            
            <!-- Content Overlay -->
            <div class="video-cta-text">
                <div class="cta-inner">
                    <h2 class="video-cta-title">
                        <i class="ph ph-dna"></i>
                        Explore Our Premium Genetics
                    </h2>
                    <p class="video-cta-description">
                        Discover our carefully curated strain library featuring 
                        award-winning genetics and exclusive cultivars.
                    </p>
                    <div class="video-cta-actions">
                        <a href="<?php echo home_url('/strain-library/'); ?>" class="video-cta-btn primary">
                            <i class="ph ph-leaf"></i>
                            Browse Strains
                        </a>
                        <a href="<?php echo home_url('/products/'); ?>" class="video-cta-btn secondary">
                            <i class="ph ph-package"></i>
                            Shop Products
                        </a>
                    </div>
                    
                    <!-- Features Grid -->
                    <div class="genetics-features">
                        <div class="feature-item">
                            <i class="ph ph-flask"></i>
                            <span>Lab Tested</span>
                        </div>
                        <div class="feature-item">
                            <i class="ph ph-certificate"></i>
                            <span>Award Winners</span>
                        </div>
                        <div class="feature-item">
                            <i class="ph ph-plant"></i>
                            <span>Indoor Grown</span>
                        </div>
                        <div class="feature-item">
                            <i class="ph ph-shield-check"></i>
                            <span>Quality Assured</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
/* Video CTA Block Styles */
.skyworld-video-cta {
    position: relative;
    min-height: 70vh;
    display: flex;
    align-items: center;
    overflow: hidden;
    margin: 4rem 0;
    border-radius: 16px;
    border: 2px solid var(--skyworld-cannabis-green);
}

.video-cta-container {
    position: relative;
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
}

.video-cta-content {
    position: relative;
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
}

/* Background Video */
.video-background {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    overflow: hidden;
    z-index: 1;
    border-radius: 12px;
}

.background-video {
    width: 100%;
    height: 100%;
    object-fit: cover;
    object-position: center;
    filter: brightness(0.4);
}

.video-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: linear-gradient(
        135deg,
        rgba(45, 80, 22, 0.8) 0%,
        rgba(28, 56, 36, 0.9) 50%,
        rgba(45, 80, 22, 0.8) 100%
    );
    z-index: 2;
}

/* Content Overlay */
.video-cta-text {
    position: relative;
    z-index: 3;
    width: 100%;
    max-width: 1200px;
    margin: 0 auto;
    padding: 4rem 2rem;
    text-align: center;
}

.cta-inner {
    max-width: 800px;
    margin: 0 auto;
}

.video-cta-title {
    font-size: 3rem;
    font-weight: 700;
    color: var(--skyworld-cannabis-light);
    margin-bottom: 1.5rem;
    line-height: 1.2;
    font-family: 'Inter', sans-serif;
}

.video-cta-title i {
    display: block;
    font-size: 2.5rem;
    margin-bottom: 1rem;
    color: var(--skyworld-cannabis-light);
}

.video-cta-description {
    font-size: 1.3rem;
    color: rgba(255, 255, 255, 0.9);
    margin-bottom: 3rem;
    line-height: 1.6;
    max-width: 600px;
    margin-left: auto;
    margin-right: auto;
}

/* CTA Buttons */
.video-cta-actions {
    display: flex;
    gap: 1.5rem;
    justify-content: center;
    margin-bottom: 4rem;
    flex-wrap: wrap;
}

.video-cta-btn {
    display: inline-flex;
    align-items: center;
    gap: 0.75rem;
    padding: 1.2rem 2.5rem;
    border-radius: 50px;
    font-weight: 600;
    font-size: 1.1rem;
    text-decoration: none;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.video-cta-btn.primary {
    background: var(--skyworld-cannabis-light);
    color: var(--skyworld-dark-green);
    border: 2px solid var(--skyworld-cannabis-light);
}

.video-cta-btn.primary:hover {
    background: transparent;
    color: var(--skyworld-cannabis-light);
    transform: translateY(-2px);
    box-shadow: 0 10px 30px rgba(216, 251, 24, 0.3);
}

.video-cta-btn.secondary {
    background: transparent;
    color: var(--skyworld-cannabis-light);
    border: 2px solid var(--skyworld-cannabis-light);
}

.video-cta-btn.secondary:hover {
    background: var(--skyworld-cannabis-light);
    color: var(--skyworld-dark-green);
    transform: translateY(-2px);
    box-shadow: 0 10px 30px rgba(216, 251, 24, 0.2);
}

/* Features Grid */
.genetics-features {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
    gap: 2rem;
    max-width: 600px;
    margin: 0 auto;
}

.feature-item {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 0.75rem;
    color: rgba(255, 255, 255, 0.9);
    font-weight: 500;
}

.feature-item i {
    font-size: 2rem;
    color: var(--skyworld-cannabis-light);
    background: rgba(216, 251, 24, 0.1);
    padding: 1rem;
    border-radius: 50%;
    border: 1px solid rgba(216, 251, 24, 0.3);
}

/* Responsive Design */
@media (max-width: 768px) {
    .skyworld-video-cta {
        min-height: 60vh;
        margin: 2rem 0;
        border-radius: 12px;
    }
    
    .video-cta-text {
        padding: 3rem 1.5rem;
    }
    
    .video-cta-title {
        font-size: 2.2rem;
    }
    
    .video-cta-description {
        font-size: 1.1rem;
        margin-bottom: 2rem;
    }
    
    .video-cta-actions {
        flex-direction: column;
        align-items: center;
        gap: 1rem;
        margin-bottom: 3rem;
    }
    
    .video-cta-btn {
        width: 100%;
        max-width: 280px;
        justify-content: center;
    }
    
    .genetics-features {
        grid-template-columns: repeat(2, 1fr);
        gap: 1.5rem;
    }
    
    .feature-item {
        font-size: 0.9rem;
    }
    
    .feature-item i {
        font-size: 1.5rem;
        padding: 0.8rem;
    }
}

@media (max-width: 480px) {
    .video-cta-title {
        font-size: 1.8rem;
    }
    
    .genetics-features {
        grid-template-columns: 1fr;
        gap: 1rem;
    }
}

/* Video Loading State */
.video-background::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: var(--skyworld-dark-green);
    z-index: 1;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.video-background.loading::before {
    opacity: 1;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const video = document.querySelector('.background-video');
    const videoBackground = document.querySelector('.video-background');
    
    if (video && videoBackground) {
        // Show loading state
        videoBackground.classList.add('loading');
        
        // Remove loading state when video can play
        video.addEventListener('canplay', function() {
            videoBackground.classList.remove('loading');
        });
        
        // Handle video load errors
        video.addEventListener('error', function() {
            videoBackground.classList.remove('loading');
            console.log('Video failed to load, using poster image fallback');
        });
        
        // Pause video when not in viewport (performance optimization)
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    video.play().catch(e => console.log('Video play failed:', e));
                } else {
                    video.pause();
                }
            });
        }, { threshold: 0.1 });
        
        observer.observe(video);
    }
});
</script>