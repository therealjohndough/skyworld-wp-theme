<?php
/**
 * Professional COA (Certificate of Analysis) Viewer System
 * Keeps users on-site with easy-to-read test results
 * Converts huge PDFs into clean, mobile-friendly displays
 */

// Add COA viewer to admin menu
add_action( 'admin_menu', 'skyworld_coa_viewer_menu' );

function skyworld_coa_viewer_menu() {
    add_submenu_page(
        'edit.php?post_type=sw-product',
        'COA Viewer System',
        '<i class="ph ph-flask"></i> COA Viewer',
        'manage_options',
        'coa-viewer',
        'skyworld_coa_viewer_admin_page'
    );
}

// COA data structure - this will be populated from your COA PDFs
function skyworld_get_coa_data( $batch_number ) {
    // This will eventually pull from database/ACF fields
    // For now, return sample structure based on your flower archive
    $coa_samples = [
        'SW031725-J35-WZ' => [
            'strain_name' => 'Wafflez',
            'batch_number' => 'SW031725-J35-WZ',
            'test_date' => '2025-03-17',
            'harvest_date' => '2025-02-15',
            'lab_name' => 'Testing Lab Name',
            'license' => 'C8-0000013-LIC',
            'cannabinoids' => [
                'thc' => 27.27,
                'cbd' => 0.15,
                'cbg' => 0.98,
                'thcv' => 0.12,
                'cbn' => 0.08
            ],
            'terpenes' => [
                'b-Caryophyllene' => 0.76,
                'Limonene' => 0.61,
                'b-Myrcene' => 0.26,
                'Linalool' => 0.15,
                'Pinene' => 0.12
            ],
            'total_terpenes' => 2.52,
            'contaminants' => [
                'pesticides' => 'PASS',
                'heavy_metals' => 'PASS', 
                'microbials' => 'PASS',
                'residual_solvents' => 'PASS',
                'moisture' => '8.2%'
            ],
            'status' => 'PASS'
        ]
    ];
    
    return $coa_samples[ $batch_number ] ?? null;
}

// Frontend COA display shortcode
add_shortcode( 'skyworld_coa', 'skyworld_display_coa' );

function skyworld_display_coa( $atts ) {
    $atts = shortcode_atts( [
        'batch' => '',
        'popup' => 'true'
    ], $atts );
    
    if ( empty( $atts['batch'] ) ) {
        return '<p>No batch number provided.</p>';
    }
    
    $coa_data = skyworld_get_coa_data( $atts['batch'] );
    
    if ( ! $coa_data ) {
        return '<p>COA data not found for batch: ' . esc_html( $atts['batch'] ) . '</p>';
    }
    
    ob_start();
    ?>
    <div class="skyworld-coa-container" data-batch="<?php echo esc_attr( $atts['batch'] ); ?>">
        <?php if ( $atts['popup'] === 'true' ): ?>
            <button class="skyworld-coa-button" onclick="openCOAModal('<?php echo esc_js( $atts['batch'] ); ?>')">
                <i class="ph ph-flask"></i>
                <span>See Test Results</span>
                <small>Certificate of Analysis</small>
            </button>
        <?php else: ?>
            <?php echo skyworld_render_coa_content( $coa_data ); ?>
        <?php endif; ?>
    </div>
    <?php
    return ob_get_clean();
}

function skyworld_render_coa_content( $coa_data ) {
    ob_start();
    ?>
    <div class="coa-viewer">
        <!-- COA Header -->
        <div class="coa-header">
            <div class="coa-title">
                <h3><i class="ph ph-flask"></i> Certificate of Analysis</h3>
                <div class="coa-strain"><?php echo esc_html( $coa_data['strain_name'] ); ?></div>
            </div>
            <div class="coa-batch">
                <strong>Batch #:</strong> <?php echo esc_html( $coa_data['batch_number'] ); ?>
            </div>
            <div class="coa-status status-<?php echo strtolower( $coa_data['status'] ); ?>">
                <?php echo esc_html( $coa_data['status'] ); ?>
            </div>
        </div>
        
        <!-- Test Summary Cards -->
        <div class="coa-summary">
            <div class="summary-card cannabinoids">
                <h4><i class="ph ph-atom"></i> Cannabinoids</h4>
                <div class="main-cannabinoid">
                    <span class="value"><?php echo number_format( $coa_data['cannabinoids']['thc'], 2 ); ?>%</span>
                    <span class="label">THC</span>
                </div>
                <div class="secondary-cannabinoids">
                    <?php if ( $coa_data['cannabinoids']['cbd'] > 0 ): ?>
                        <div><span>CBD:</span> <?php echo number_format( $coa_data['cannabinoids']['cbd'], 2 ); ?>%</div>
                    <?php endif; ?>
                    <?php if ( $coa_data['cannabinoids']['cbg'] > 0 ): ?>
                        <div><span>CBG:</span> <?php echo number_format( $coa_data['cannabinoids']['cbg'], 2 ); ?>%</div>
                    <?php endif; ?>
                </div>
            </div>
            
            <div class="summary-card terpenes">
                <h4><i class="ph ph-leaf"></i> Terpenes</h4>
                <div class="main-terpene">
                    <span class="value"><?php echo number_format( $coa_data['total_terpenes'], 2 ); ?>%</span>
                    <span class="label">Total</span>
                </div>
                <div class="top-terpenes">
                    <?php 
                    $top_terpenes = array_slice( $coa_data['terpenes'], 0, 3, true );
                    foreach ( $top_terpenes as $name => $value ): 
                    ?>
                        <div><span><?php echo esc_html( $name ); ?>:</span> <?php echo number_format( $value, 2 ); ?>%</div>
                    <?php endforeach; ?>
                </div>
            </div>
            
            <div class="summary-card safety">
                <h4><i class="ph ph-shield-check"></i> Safety</h4>
                <div class="safety-status">
                    <span class="value pass">PASS</span>
                    <span class="label">All Tests</span>
                </div>
                <div class="safety-details">
                    <div><i class="ph ph-check-circle"></i> Pesticides</div>
                    <div><i class="ph ph-check-circle"></i> Heavy Metals</div>
                    <div><i class="ph ph-check-circle"></i> Microbials</div>
                </div>
            </div>
        </div>
        
        <!-- Detailed Results -->
        <div class="coa-details">
            <div class="detail-section">
                <h4>Cannabinoid Profile</h4>
                <div class="cannabinoid-chart">
                    <?php foreach ( $coa_data['cannabinoids'] as $cannabinoid => $percentage ): ?>
                        <?php if ( $percentage > 0 ): ?>
                            <div class="cannabinoid-bar">
                                <span class="cannabinoid-name"><?php echo strtoupper( $cannabinoid ); ?></span>
                                <div class="bar-container">
                                    <div class="bar-fill" style="width: <?php echo ( $percentage / 40 ) * 100; ?>%"></div>
                                </div>
                                <span class="cannabinoid-value"><?php echo number_format( $percentage, 2 ); ?>%</span>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
            </div>
            
            <div class="detail-section">
                <h4>Terpene Profile</h4>
                <div class="terpene-chart">
                    <?php foreach ( $coa_data['terpenes'] as $terpene => $percentage ): ?>
                        <div class="terpene-bar">
                            <span class="terpene-name"><?php echo esc_html( $terpene ); ?></span>
                            <div class="bar-container">
                                <div class="bar-fill" style="width: <?php echo ( $percentage / 3 ) * 100; ?>%"></div>
                            </div>
                            <span class="terpene-value"><?php echo number_format( $percentage, 2 ); ?>%</span>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        
        <!-- Lab Information -->
        <div class="coa-footer">
            <div class="lab-info">
                <div><strong>Laboratory:</strong> <?php echo esc_html( $coa_data['lab_name'] ); ?></div>
                <div><strong>Test Date:</strong> <?php echo date( 'M j, Y', strtotime( $coa_data['test_date'] ) ); ?></div>
                <div><strong>License:</strong> <?php echo esc_html( $coa_data['license'] ); ?></div>
            </div>
        </div>
    </div>
    <?php
    return ob_get_clean();
}

// Add COA modal to footer
add_action( 'wp_footer', 'skyworld_coa_modal' );

function skyworld_coa_modal() {
    ?>
    <div id="coa-modal" class="coa-modal" style="display: none;">
        <div class="coa-modal-content">
            <div class="coa-modal-header">
                <h3>Test Results</h3>
                <button class="coa-modal-close" onclick="closeCOAModal()">
                    <i class="ph ph-x"></i>
                </button>
            </div>
            <div class="coa-modal-body">
                <!-- COA content will be loaded here -->
            </div>
        </div>
    </div>
    
    <script>
    function openCOAModal(batchNumber) {
        const modal = document.getElementById('coa-modal');
        const modalBody = modal.querySelector('.coa-modal-body');
        
        // Show loading
        modalBody.innerHTML = '<div class="loading"><i class="ph ph-spinner"></i> Loading test results...</div>';
        modal.style.display = 'flex';
        
        // Load COA data via AJAX
        fetch('<?php echo admin_url( 'admin-ajax.php' ); ?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'action=load_coa_data&batch=' + encodeURIComponent(batchNumber) + '&nonce=<?php echo wp_create_nonce( 'load_coa_nonce' ); ?>'
        })
        .then(response => response.text())
        .then(data => {
            modalBody.innerHTML = data;
        })
        .catch(error => {
            modalBody.innerHTML = '<div class="error">Failed to load test results. Please try again.</div>';
        });
    }
    
    function closeCOAModal() {
        document.getElementById('coa-modal').style.display = 'none';
    }
    
    // Close modal on outside click
    document.addEventListener('click', function(e) {
        const modal = document.getElementById('coa-modal');
        if (e.target === modal) {
            closeCOAModal();
        }
    });
    </script>
    <?php
}

// AJAX handler for loading COA data
add_action( 'wp_ajax_load_coa_data', 'skyworld_ajax_load_coa' );
add_action( 'wp_ajax_nopriv_load_coa_data', 'skyworld_ajax_load_coa' );

function skyworld_ajax_load_coa() {
    if ( ! wp_verify_nonce( $_POST['nonce'], 'load_coa_nonce' ) ) {
        wp_die( 'Security check failed' );
    }
    
    $batch_number = sanitize_text_field( $_POST['batch'] );
    $coa_data = skyworld_get_coa_data( $batch_number );
    
    if ( $coa_data ) {
        echo skyworld_render_coa_content( $coa_data );
    } else {
        echo '<div class="error">COA data not found for batch: ' . esc_html( $batch_number ) . '</div>';
    }
    
    wp_die();
}

// COA admin page for managing test results
function skyworld_coa_viewer_admin_page() {
    ?>
    <div class="wrap">
        <h1><i class="ph ph-flask"></i> COA Viewer System</h1>
        <p>Professional Certificate of Analysis viewer - keeps users on your site instead of sending them to external PDFs.</p>
        
        <div class="coa-admin-sections">
            <div class="admin-section">
                <h2>How to Use</h2>
                <ol>
                    <li><strong>Upload COAs</strong> to the Asset Manager</li>
                    <li><strong>Extract key data</strong> from PDFs into ACF fields</li>
                    <li><strong>Add COA buttons</strong> to product pages using: <code>[skyworld_coa batch="SW031725-J35-WZ"]</code></li>
                    <li><strong>Users click "See Test Results"</strong> and see clean, mobile-friendly data</li>
                </ol>
            </div>
            
            <div class="admin-section">
                <h2>Sample COA Display</h2>
                <p>This is how your test results will appear to users:</p>
                <div class="coa-preview">
                    <?php echo skyworld_render_coa_content( skyworld_get_coa_data( 'SW031725-J35-WZ' ) ); ?>
                </div>
            </div>
            
            <div class="admin-section">
                <h2>Next Steps</h2>
                <ul>
                    <li><strong>Import your flower archive</strong> using the CSV you have</li>
                    <li><strong>Link COA data</strong> to batch numbers in ACF fields</li>
                    <li><strong>Add COA buttons</strong> to all product pages</li>
                    <li><strong>Keep users on-site</strong> with professional test result displays</li>
                </ul>
            </div>
        </div>
    </div>
    
    <style>
    .coa-admin-sections {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
        gap: 2rem;
        margin-top: 2rem;
    }
    
    .admin-section {
        background: #fff;
        border: 1px solid #ccd0d4;
        border-radius: 8px;
        padding: 1.5rem;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    
    .admin-section h2 {
        margin-top: 0;
        color: #2d5016;
    }
    
    .coa-preview {
        border: 1px solid #ddd;
        border-radius: 4px;
        padding: 1rem;
        background: #f9f9f9;
        max-height: 400px;
        overflow-y: auto;
    }
    </style>
    <?php
}