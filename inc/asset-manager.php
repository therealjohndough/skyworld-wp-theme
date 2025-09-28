<?php
/**
 * Cannabis Asset Management System
 * Handles product images, COAs, lab reports, and compliance documents
 */

// Create upload directories for cannabis assets
add_action( 'init', 'skyworld_create_asset_directories' );

function skyworld_create_asset_directories() {
    $upload_dir = wp_upload_dir();
    $cannabis_dirs = [
        'cannabis-products' => $upload_dir['basedir'] . '/cannabis-products',
        'product-images' => $upload_dir['basedir'] . '/cannabis-products/images',
        'coa-documents' => $upload_dir['basedir'] . '/cannabis-products/coa',
        'lab-reports' => $upload_dir['basedir'] . '/cannabis-products/lab-reports',
        'strain-photos' => $upload_dir['basedir'] . '/cannabis-products/strains',
        'compliance-docs' => $upload_dir['basedir'] . '/cannabis-products/compliance'
    ];
    
    foreach ( $cannabis_dirs as $key => $dir ) {
        if ( ! file_exists( $dir ) ) {
            wp_mkdir_p( $dir );
            
            // Add index.php for security
            $index_file = $dir . '/index.php';
            if ( ! file_exists( $index_file ) ) {
                file_put_contents( $index_file, '<?php // Silence is golden' );
            }
        }
    }
}

// Add cannabis asset upload page to admin
add_action( 'admin_menu', 'skyworld_asset_manager_menu' );

function skyworld_asset_manager_menu() {
    add_submenu_page(
        'edit.php?post_type=sky_product',
        'Asset Manager',
        '<i class="ph ph-folder-open"></i> Asset Manager',
        'manage_options',
        'cannabis-assets',
        'skyworld_asset_manager_page'
    );
}

function skyworld_asset_manager_page() {
    ?>
    <div class="wrap">
        <h1><i class="ph ph-folder-open"></i> Cannabis Asset Manager</h1>
        <p>Upload and manage product images, COAs, lab reports, and compliance documents.</p>
        
        <div class="cannabis-asset-grid">
            <!-- Product Images -->
            <div class="asset-category">
                <h2><i class="ph ph-image"></i> Product Images</h2>
                <p>High-quality product photos for website display</p>
                <div class="upload-area" data-category="product-images">
                    <form method="post" enctype="multipart/form-data">
                        <?php wp_nonce_field( 'upload_product_images' ); ?>
                        <input type="file" name="product_images[]" multiple accept="image/*" id="product-images">
                        <label for="product-images" class="upload-button">
                            <i class="ph ph-upload-simple"></i> Choose Images
                        </label>
                        <input type="submit" name="upload_images" value="Upload Images" class="button-primary">
                    </form>
                </div>
                <div class="file-list">
                    <?php skyworld_list_assets( 'images' ); ?>
                </div>
            </div>
            
            <!-- COA Documents -->
            <div class="asset-category">
                <h2><i class="ph ph-file-pdf"></i> COA Documents</h2>
                <p>Certificate of Analysis for products and strains</p>
                <div class="upload-area" data-category="coa-documents">
                    <form method="post" enctype="multipart/form-data">
                        <?php wp_nonce_field( 'upload_coa_documents' ); ?>
                        <input type="file" name="coa_documents[]" multiple accept=".pdf,.jpg,.png" id="coa-docs">
                        <label for="coa-docs" class="upload-button">
                            <i class="ph ph-upload-simple"></i> Choose COAs
                        </label>
                        <input type="submit" name="upload_coa" value="Upload COAs" class="button-primary">
                    </form>
                </div>
                <div class="file-list">
                    <?php skyworld_list_assets( 'coa' ); ?>
                </div>
            </div>
            
            <!-- Lab Reports -->
            <div class="asset-category">
                <h2><i class="ph ph-flask"></i> Lab Reports</h2>
                <p>Detailed laboratory analysis and testing reports</p>
                <div class="upload-area" data-category="lab-reports">
                    <form method="post" enctype="multipart/form-data">
                        <?php wp_nonce_field( 'upload_lab_reports' ); ?>
                        <input type="file" name="lab_reports[]" multiple accept=".pdf,.doc,.docx" id="lab-reports">
                        <label for="lab-reports" class="upload-button">
                            <i class="ph ph-upload-simple"></i> Choose Reports
                        </label>
                        <input type="submit" name="upload_reports" value="Upload Reports" class="button-primary">
                    </form>
                </div>
                <div class="file-list">
                    <?php skyworld_list_assets( 'lab-reports' ); ?>
                </div>
            </div>
            
            <!-- Compliance Documents -->
            <div class="asset-category">
                <h2><i class="ph ph-shield-check"></i> Compliance</h2>
                <p>Regulatory compliance and licensing documents</p>
                <div class="upload-area" data-category="compliance">
                    <form method="post" enctype="multipart/form-data">
                        <?php wp_nonce_field( 'upload_compliance_docs' ); ?>
                        <input type="file" name="compliance_docs[]" multiple accept=".pdf,.jpg,.png" id="compliance-docs">
                        <label for="compliance-docs" class="upload-button">
                            <i class="ph ph-upload-simple"></i> Choose Documents
                        </label>
                        <input type="submit" name="upload_compliance" value="Upload Compliance" class="button-primary">
                    </form>
                </div>
                <div class="file-list">
                    <?php skyworld_list_assets( 'compliance' ); ?>
                </div>
            </div>
        </div>
        
        <?php
        // Handle uploads
        skyworld_handle_asset_uploads();
        ?>
    </div>
    
    <style>
    .cannabis-asset-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 2rem;
        margin-top: 2rem;
    }
    
    .asset-category {
        background: #fff;
        border: 1px solid #ccd0d4;
        border-radius: 8px;
        padding: 1.5rem;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    
    .asset-category h2 {
        margin-top: 0;
        color: #2d5016;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .upload-area {
        background: #f8f9fa;
        border: 2px dashed #dee2e6;
        border-radius: 4px;
        padding: 2rem;
        text-align: center;
        margin: 1rem 0;
    }
    
    .upload-button {
        display: inline-block;
        padding: 0.75rem 1.5rem;
        background: #2d5016;
        color: white;
        border-radius: 4px;
        cursor: pointer;
        margin-bottom: 1rem;
        transition: background 0.3s;
    }
    
    .upload-button:hover {
        background: #4a7c59;
    }
    
    .upload-area input[type="file"] {
        display: none;
    }
    
    .file-list {
        max-height: 200px;
        overflow-y: auto;
        border: 1px solid #dee2e6;
        border-radius: 4px;
        padding: 0.5rem;
    }
    
    .file-item {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.5rem;
        border-bottom: 1px solid #eee;
    }
    
    .file-item:last-child {
        border-bottom: none;
    }
    
    .file-icon {
        width: 20px;
        height: 20px;
        flex-shrink: 0;
    }
    
    .file-name {
        flex: 1;
        font-size: 0.9rem;
    }
    
    .file-size {
        font-size: 0.8rem;
        color: #666;
    }
    </style>
    <?php
}

function skyworld_list_assets( $category ) {
    $upload_dir = wp_upload_dir();
    $asset_dir = $upload_dir['basedir'] . '/cannabis-products/' . $category;
    
    if ( ! is_dir( $asset_dir ) ) {
        echo '<p>No files uploaded yet.</p>';
        return;
    }
    
    $files = array_diff( scandir( $asset_dir ), array( '..', '.', 'index.php' ) );
    
    if ( empty( $files ) ) {
        echo '<p>No files uploaded yet.</p>';
        return;
    }
    
    foreach ( $files as $file ) {
        $file_path = $asset_dir . '/' . $file;
        $file_size = size_format( filesize( $file_path ) );
        $file_ext = pathinfo( $file, PATHINFO_EXTENSION );
        
        $icon = 'ph-file';
        if ( in_array( $file_ext, ['jpg', 'jpeg', 'png', 'gif'] ) ) {
            $icon = 'ph-image';
        } elseif ( $file_ext === 'pdf' ) {
            $icon = 'ph-file-pdf';
        }
        
        echo '<div class="file-item">';
        echo '<i class="ph ' . $icon . ' file-icon"></i>';
        echo '<span class="file-name">' . esc_html( $file ) . '</span>';
        echo '<span class="file-size">' . $file_size . '</span>';
        echo '</div>';
    }
}

function skyworld_handle_asset_uploads() {
    // Handle product images upload
    if ( isset( $_POST['upload_images'] ) && wp_verify_nonce( $_POST['_wpnonce'], 'upload_product_images' ) ) {
        skyworld_process_file_upload( 'product_images', 'images' );
    }
    
    // Handle COA documents upload
    if ( isset( $_POST['upload_coa'] ) && wp_verify_nonce( $_POST['_wpnonce'], 'upload_coa_documents' ) ) {
        skyworld_process_file_upload( 'coa_documents', 'coa' );
    }
    
    // Handle lab reports upload
    if ( isset( $_POST['upload_reports'] ) && wp_verify_nonce( $_POST['_wpnonce'], 'upload_lab_reports' ) ) {
        skyworld_process_file_upload( 'lab_reports', 'lab-reports' );
    }
    
    // Handle compliance documents upload
    if ( isset( $_POST['upload_compliance'] ) && wp_verify_nonce( $_POST['_wpnonce'], 'upload_compliance_docs' ) ) {
        skyworld_process_file_upload( 'compliance_docs', 'compliance' );
    }
}

function skyworld_process_file_upload( $field_name, $category ) {
    if ( ! isset( $_FILES[ $field_name ] ) ) {
        return;
    }
    
    $upload_dir = wp_upload_dir();
    $target_dir = $upload_dir['basedir'] . '/cannabis-products/' . $category . '/';
    
    $uploaded_files = [];
    $files = $_FILES[ $field_name ];
    
    for ( $i = 0; $i < count( $files['name'] ); $i++ ) {
        if ( $files['error'][$i] !== UPLOAD_ERR_OK ) {
            continue;
        }
        
        $file_name = sanitize_file_name( $files['name'][$i] );
        $target_file = $target_dir . $file_name;
        
        if ( move_uploaded_file( $files['tmp_name'][$i], $target_file ) ) {
            $uploaded_files[] = $file_name;
        }
    }
    
    if ( ! empty( $uploaded_files ) ) {
        echo '<div class="notice notice-success"><p>Successfully uploaded: ' . implode( ', ', $uploaded_files ) . '</p></div>';
    }
}

// Add ACF fields for linking assets to products
function skyworld_add_asset_fields() {
    if ( function_exists( 'acf_add_local_field_group' ) ) {
        acf_add_local_field_group( array(
            'key' => 'group_product_assets',
            'title' => 'Product Assets',
            'fields' => array(
                array(
                    'key' => 'field_product_images',
                    'label' => 'Product Images',
                    'name' => 'product_images',
                    'type' => 'gallery',
                    'return_format' => 'array',
                    'preview_size' => 'medium',
                    'insert' => 'append',
                    'library' => 'all',
                ),
                array(
                    'key' => 'field_coa_document',
                    'label' => 'COA Document',
                    'name' => 'coa_document',
                    'type' => 'file',
                    'return_format' => 'array',
                    'library' => 'all',
                    'mime_types' => 'pdf,jpg,jpeg,png',
                ),
                array(
                    'key' => 'field_lab_reports',
                    'label' => 'Lab Reports',
                    'name' => 'lab_reports',
                    'type' => 'repeater',
                    'sub_fields' => array(
                        array(
                            'key' => 'field_lab_report_file',
                            'label' => 'Report File',
                            'name' => 'report_file',
                            'type' => 'file',
                            'return_format' => 'array',
                            'mime_types' => 'pdf,doc,docx',
                        ),
                        array(
                            'key' => 'field_report_date',
                            'label' => 'Report Date',
                            'name' => 'report_date',
                            'type' => 'date_picker',
                            'display_format' => 'F j, Y',
                            'return_format' => 'F j, Y',
                        ),
                    ),
                ),
            ),
            'location' => array(
                array(
                    array(
                        'param' => 'post_type',
                        'operator' => '==',
                        'value' => 'sky_product',
                    ),
                ),
                array(
                    array(
                        'param' => 'post_type',
                        'operator' => '==',
                        'value' => 'strain',
                    ),
                ),
            ),
        ) );
    }
}
add_action( 'acf/init', 'skyworld_add_asset_fields' );