<?php
/**
 * Template Name: Careers
 * SEO-optimized Careers page for Skyworld Cannabis
 */
get_header();
?>
<main class="site-main site-careers">
    <h1>Careers at Skyworld</h1>
    <section class="careers-intro">
        <p>Join Skyworld, a New York–licensed, Indigenous-owned cannabis brand dedicated to quality, community, and innovation. We’re always looking for passionate, talented people to help us grow our movement and elevate the cannabis experience for all.</p>
    </section>

    <section class="open-positions">
        <h2>Open Positions</h2>
        <ul>
            <li><strong>Indoor Cultivation Specialist</strong> – Full-time, Buffalo NY</li>
            <li><strong>Lab Technician</strong> – Full-time, Buffalo NY</li>
            <li><strong>Sales & Outreach Coordinator</strong> – Remote/NY</li>
            <!-- Add more positions as needed -->
        </ul>
    </section>

    <section class="culture">
        <h2>Our Culture</h2>
        <p>At Skyworld, we value integrity, collaboration, and respect for both plant and people. We foster a supportive, inclusive environment where every team member can thrive and contribute to our shared mission.</p>
    </section>

    <section class="apply-form">
        <h2>Apply Now</h2>
        <p>Interested in joining the Skyworld team? Send your resume and a brief introduction to <a href="mailto:careers@skyworldcannabis.com">careers@skyworldcannabis.com</a> or use the form below.</p>
        <!-- Contact/apply form placeholder: integrate with WPForms, Gravity Forms, etc. -->
        <div class="apply-form-placeholder">
            <p><em>Application form goes here (WPForms, Gravity Forms, etc.)</em></p>
        </div>
    </section>

    <footer class="careers-footer">
        <p><strong>Skyworld Cannabis</strong> &mdash; Indigenous-Owned | Licensed | Rooted in New York</p>
    </footer>

    <!-- SEO: Organization schema -->
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "Organization",
      "name": "Skyworld Cannabis",
      "url": "https://skyworldcannabis.com",
      "email": "careers@skyworldcannabis.com"
    }
    </script>
</main>
<?php get_footer(); ?>
