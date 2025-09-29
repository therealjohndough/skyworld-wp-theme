<?php
/**
 * Template Name: Wholesale / CTA Block
 * SEO-optimized Wholesale page for Skyworld Cannabis
 */
get_header();
?>
<div class="wholesale-page">
    <div class="container">
        <div class="wholesale-header">
            <h1 class="page-title">Partner with Skyworld Cannabis</h1>
            
            <div class="wholesale-intro">
                <p class="lead">As a New York–licensed, Indigenous-owned cultivator, Skyworld offers premium indoor flower tailored for discerning dispensaries. From exclusive genetics to custom wholesale programs, we provide consistency, compliance, and quality you can trust.</p>
                
                <div class="wholesale-benefits">
                    <div class="benefit-grid">
                        <div class="benefit-item">
                            <div class="benefit-icon"><i class="ph ph-plant" aria-hidden="true"></i></div>
                            <h3>Premium Genetics</h3>
                            <p>Access to our exclusive strain library and award-winning cannabis genetics.</p>
                        </div>
                        
                        <div class="benefit-item">
                            <div class="benefit-icon"><i class="ph ph-package"></i></div>
                            <h3>Bulk Pricing</h3>
                            <p>Competitive wholesale pricing with volume discounts for qualified partners.</p>
                        </div>
                        
                        <div class="benefit-item">
                            <div class="benefit-icon">🚚</div>
                            <h3>Reliable Supply</h3>
                            <p>Consistent product availability with flexible delivery schedules.</p>
                        </div>
                        
                        <div class="benefit-item">
                            <div class="benefit-icon">🏆</div>
                            <h3>Marketing Support</h3>
                            <p>Co-marketing opportunities and promotional materials for retail partners.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="wholesale-requirements">
            <h2>Wholesale Requirements</h2>
            <div class="requirements-grid">
                <div class="requirement-card">
                    <h3><i class="ph ph-bank" aria-hidden="true"></i> Licensing</h3>
                    <ul>
                        <li>Valid New York cannabis license</li>
                        <li>Business registration documents</li>
                        <li>Tax identification numbers</li>
                        <li>Compliance certifications</li>
                    </ul>
                </div>
                
                <div class="requirement-card">
                    <h3>💼 Business Profile</h3>
                    <ul>
                        <li>Established dispensary operations</li>
                        <li>Proven track record in cannabis retail</li>
                        <li>Professional facility and storage</li>
                        <li>Quality control procedures</li>
                    </ul>
                </div>
                
                <div class="requirement-card">
                    <h3><i class="ph ph-chart-line"></i> Volume Commitments</h3>
                    <ul>
                        <li>Minimum monthly order quantities</li>
                        <li>Regular purchase schedules</li>
                        <li>Market expansion opportunities</li>
                        <li>Growth partnership potential</li>
                    </ul>
                </div>
            </div>
        </div>

        <section class="wholesale-form-section" id="form-container">
            <div class="form-intro">
                <h2>Supply Agreement Application</h2>
                <p>Complete our supply agreement and a member of our team will connect within 48 hours. Whether you're a dispensary looking to connect, or customer with feedback, we want to hear from you!</p>
            </div>

            <div class="form-container">
                <?php 
                // Display Gravity Forms shortcode for wholesale application
                // You can replace the form ID with your actual Gravity Form ID
                if (shortcode_exists('gravityform')) {
                    echo do_shortcode('[gravityform id="2" title="false" description="false" ajax="true"]');
                } else {
                    // Fallback content if Gravity Forms is not active
                    ?>
                    <div class="form-placeholder">
                        <div class="placeholder-content">
                            <h3>Wholesale Application Form</h3>
                            <p>This form requires Gravity Forms plugin to be installed and configured.</p>
                            
                            <div class="contact-info">
                                <h4>Contact Our Wholesale Team Directly:</h4>
                                <p><strong>Email:</strong> <a href="mailto:info@skyworldcannabis.com">info@skyworldcannabis.com</a></p>
                                <p><strong>Business Hours:</strong> Monday - Friday, 9 AM - 5 PM EST</p>
                                <p><strong>Response Time:</strong> Usually within 1-2 business days</p>
                            </div>
                        </div>
                    </div>
                    <?php
                }
                ?>
            </div>
        </section>

        <div class="wholesale-contact">
            <div class="contact-section">
                <div class="contact-info">
                    <h3>Have Questions?</h3>
                    <p>Our wholesale team is here to help you get started. Reach out with any questions about our products, pricing, or partnership requirements.</p>
                    
                    <div class="contact-details">
                        <div class="contact-item">
                            <strong>Business Contact:</strong><br>
                            <span>Skyworld Cannabis Team</span><br>
                            <a href="mailto:info@skyworldcannabis.com">info@skyworldcannabis.com</a>
                        </div>
                        
                        <div class="contact-item">
                            <strong>Response Time:</strong><br>
                            <span>1-2 Business Days</span><br>
                            <span>Monday - Friday, 9 AM - 5 PM EST</span>
                        </div>
                    </div>
                </div>
                
                <div class="contact-cta">
                    <h4>Ready to Get Started?</h4>
                    <p>Join our network of premium dispensaries and bring Skyworld's award-winning genetics to your customers.</p>
                    <div class="cta-buttons">
                        <a href="mailto:info@skyworldcannabis.com" class="btn btn-primary">Email Our Team</a>
                        <a href="#form-container" class="btn btn-outline scroll-to-form">Apply Now</a>
                    </div>
                </div>
            </div>
        </div>

        <footer class="wholesale-footer">
            <p><strong>Skyworld Cannabis</strong> &mdash; Premium Indoor Flower for New York Dispensaries</p>
            <p>Indigenous-owned cultivator committed to quality, compliance, and community.</p>
        </footer>

        <!-- SEO: Organization schema -->
        <script type="application/ld+json">
        {
          "@context": "https://schema.org",
          "@type": "Organization",
          "name": "Skyworld Cannabis",
          "url": "https://skyworldcannabis.com",
          "email": "info@skyworldcannabis.com",
          "description": "New York-licensed, Indigenous-owned cannabis cultivator offering premium indoor flower for dispensaries",
          "address": {
            "@type": "PostalAddress",
            "addressRegion": "NY",
            "addressCountry": "US"
          }
        }
        </script>
    </div>
</div>
<?php get_footer(); ?>

<style>
/* Wholesale Page Styles */
.wholesale-page {
    padding: 60px 0;
    background: #f8f9fa;
}

.container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
}

.wholesale-header {
    text-align: center;
    margin-bottom: 60px;
    background: white;
    padding: 60px 40px;
    border-radius: 12px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
}

.page-title {
    color: #2c3e50;
    font-size: 48px;
    font-weight: 800;
    margin-bottom: 30px;
    letter-spacing: 2px;
}

.wholesale-intro .lead {
    font-size: 20px;
    color: #6c757d;
    line-height: 1.6;
    max-width: 800px;
    margin: 0 auto 40px;
}

.wholesale-benefits {
    margin-top: 50px;
}

.benefit-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 30px;
    margin-top: 30px;
}

.benefit-item {
    text-align: center;
    padding: 30px 20px;
    background: #f8f9fa;
    border-radius: 10px;
    transition: transform 0.3s ease;
}

.benefit-item:hover {
    transform: translateY(-5px);
}

.benefit-icon {
    font-size: 48px;
    margin-bottom: 20px;
}

.benefit-item h3 {
    color: #2c3e50;
    margin-bottom: 15px;
    font-size: 20px;
    font-weight: 600;
}

.benefit-item p {
    color: #6c757d;
    line-height: 1.5;
}

.wholesale-requirements,
.wholesale-form-section,
.wholesale-contact {
    background: white;
    margin-bottom: 40px;
    padding: 50px 40px;
    border-radius: 12px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
}

.wholesale-requirements h2,
.wholesale-form-section h2,
.wholesale-contact h3 {
    color: #2c3e50;
    font-size: 32px;
    font-weight: 700;
    margin-bottom: 30px;
    text-align: center;
}

.requirements-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 30px;
    margin-top: 30px;
}

.requirement-card {
    background: #f8f9fa;
    padding: 30px;
    border-radius: 10px;
    border-left: 4px solid #27ae60;
}

.requirement-card h3 {
    color: #2c3e50;
    font-size: 20px;
    margin-bottom: 20px;
    display: flex;
    align-items: center;
    gap: 10px;
}

.requirement-card ul {
    list-style: none;
    padding: 0;
    margin: 0;
}

.requirement-card li {
    color: #6c757d;
    padding: 8px 0;
    border-bottom: 1px solid #eee;
    position: relative;
    padding-left: 20px;
}

.requirement-card li:before {
    content: "✓";
    color: #27ae60;
    font-weight: bold;
    position: absolute;
    left: 0;
}

.requirement-card li:last-child {
    border-bottom: none;
}

.form-intro {
    text-align: center;
    margin-bottom: 40px;
}

.form-intro p {
    color: #6c757d;
    font-size: 16px;
    line-height: 1.6;
    max-width: 600px;
    margin: 0 auto;
}

.form-container {
    max-width: 800px;
    margin: 0 auto;
}

.form-placeholder {
    background: #f8f9fa;
    border: 2px dashed #ddd;
    border-radius: 10px;
    padding: 60px 40px;
    text-align: center;
}

.placeholder-content h3 {
    color: #2c3e50;
    margin-bottom: 20px;
    font-size: 24px;
}

.placeholder-content p {
    color: #6c757d;
    margin-bottom: 30px;
}

.contact-info {
    background: white;
    border-radius: 8px;
    padding: 30px;
    border: 1px solid #eee;
}

.contact-info h4 {
    color: #2c3e50;
    margin-bottom: 20px;
    font-size: 18px;
}

.contact-info p {
    margin: 10px 0;
    color: #6c757d;
}

.contact-section {
    display: grid;
    grid-template-columns: 2fr 1fr;
    gap: 40px;
    align-items: start;
}

.contact-details {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 30px;
    margin-top: 30px;
}

.contact-item {
    padding: 20px;
    background: #f8f9fa;
    border-radius: 8px;
}

.contact-item strong {
    color: #2c3e50;
}

.contact-item span {
    color: #6c757d;
}

.contact-item a {
    color: #27ae60;
    text-decoration: none;
    font-weight: 500;
}

.contact-item a:hover {
    color: #219a52;
}

.contact-cta {
    background: #f8f9fa;
    padding: 30px;
    border-radius: 10px;
    text-align: center;
}

.contact-cta h4 {
    color: #2c3e50;
    margin-bottom: 15px;
    font-size: 20px;
}

.contact-cta p {
    color: #6c757d;
    margin-bottom: 25px;
    line-height: 1.5;
}

.cta-buttons {
    display: flex;
    flex-direction: column;
    gap: 15px;
}

.btn {
    padding: 12px 25px;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    font-size: 14px;
    font-weight: 600;
    transition: all 0.3s ease;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
}

.btn-primary {
    background: #27ae60;
    color: white;
}

.btn-primary:hover {
    background: #219a52;
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(39, 174, 96, 0.3);
}

.btn-outline {
    background: white;
    color: #6c757d;
    border: 2px solid #6c757d;
}

.btn-outline:hover {
    background: #6c757d;
    color: white;
}

.wholesale-footer {
    text-align: center;
    padding: 40px 0;
    border-top: 1px solid #eee;
    margin-top: 20px;
}

.wholesale-footer p {
    color: #6c757d;
    margin: 10px 0;
}

/* Smooth scrolling for anchor links */
html {
    scroll-behavior: smooth;
}

/* Responsive Design */
@media (max-width: 768px) {
    .wholesale-page {
        padding: 30px 0;
    }
    
    .container {
        padding: 0 15px;
    }
    
    .wholesale-header,
    .wholesale-requirements,
    .wholesale-form-section,
    .wholesale-contact {
        padding: 30px 20px;
        margin-bottom: 20px;
    }
    
    .page-title {
        font-size: 32px;
    }
    
    .benefit-grid,
    .requirements-grid {
        grid-template-columns: 1fr;
        gap: 20px;
    }
    
    .contact-section {
        grid-template-columns: 1fr;
        gap: 30px;
    }
    
    .contact-details {
        grid-template-columns: 1fr;
        gap: 20px;
    }
}

/* Dark Mode Support */
body.dark-mode .wholesale-page {
    background: #1a1a1a;
}

body.dark-mode .wholesale-header,
body.dark-mode .wholesale-requirements,
body.dark-mode .wholesale-form-section,
body.dark-mode .wholesale-contact {
    background: #2c3e50;
}

body.dark-mode .page-title,
body.dark-mode .wholesale-requirements h2,
body.dark-mode .wholesale-form-section h2,
body.dark-mode .wholesale-contact h3,
body.dark-mode .benefit-item h3,
body.dark-mode .requirement-card h3,
body.dark-mode .contact-cta h4 {
    color: #ecf0f1;
}

body.dark-mode .benefit-item,
body.dark-mode .requirement-card,
body.dark-mode .contact-cta,
body.dark-mode .contact-item {
    background: #34495e;
}

body.dark-mode .wholesale-intro .lead,
body.dark-mode .benefit-item p,
body.dark-mode .requirement-card li,
body.dark-mode .form-intro p,
body.dark-mode .contact-cta p {
    color: #bdc3c7;
}

body.dark-mode .contact-info {
    background: #34495e;
    border-color: #555;
}
</style>
