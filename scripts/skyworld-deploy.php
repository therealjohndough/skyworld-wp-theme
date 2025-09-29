<?php
/**
 * Skyworld Cannabis Theme Auto-Deploy Webhook
 * Place this file in your website root directory
 * 
 * Setup Instructions:
 * 1. Upload this file to your server root
 * 2. Set your webhook secret below
 * 3. Add webhook URL to GitHub: https://yourdomain.com/skyworld-deploy.php
 * 4. Set webhook secret in GitHub settings
 */

// Configuration
$WEBHOOK_SECRET = 'your-secure-webhook-secret-here'; // Change this!
$THEME_PATH = '/home/sjradmin/dev.skyworldcannabis.com/wp-content/themes/skyworld-wp-child';
$LOG_FILE = '/tmp/skyworld-deploy.log';

// Security check
function verify_github_signature($payload, $signature, $secret) {
    $expected = 'sha256=' . hash_hmac('sha256', $payload, $secret);
    return hash_equals($expected, $signature);
}

// Logging function
function log_message($message) {
    global $LOG_FILE;
    $timestamp = date('Y-m-d H:i:s');
    file_put_contents($LOG_FILE, "[$timestamp] $message\n", FILE_APPEND | LOCK_EX);
}

// Get the payload
$payload = file_get_contents('php://input');
$signature = $_SERVER['HTTP_X_HUB_SIGNATURE_256'] ?? '';

// Verify the webhook signature
if (!verify_github_signature($payload, $signature, $WEBHOOK_SECRET)) {
    http_response_code(401);
    log_message('ERROR: Invalid webhook signature');
    die('Unauthorized');
}

// Parse the payload
$data = json_decode($payload, true);

// Check if this is a push to the dev/skyworld branch
if ($data['ref'] !== 'refs/heads/dev/skyworld') {
    log_message('INFO: Ignoring push to ' . $data['ref']);
    die('Not the target branch');
}

log_message('INFO: Starting deployment for commit ' . substr($data['after'], 0, 7));

// Change to theme directory and pull latest changes
chdir($THEME_PATH);

// Pull the latest changes
$output = [];
$return_code = 0;

exec('git pull origin dev/skyworld 2>&1', $output, $return_code);

if ($return_code === 0) {
    log_message('SUCCESS: Git pull completed successfully');
    
    // Set proper permissions
    exec('find . -type d -exec chmod 755 {} \; 2>&1');
    exec('find . -type f -exec chmod 644 {} \; 2>&1');
    
    log_message('INFO: File permissions updated');
    
    // Optional: Clear any caches
    if (function_exists('opcache_reset')) {
        opcache_reset();
        log_message('INFO: OPCache cleared');
    }
    
    // Success response
    http_response_code(200);
    echo json_encode([
        'status' => 'success',
        'message' => 'Skyworld theme deployed successfully!',
        'commit' => substr($data['after'], 0, 7),
        'branch' => 'dev/skyworld',
        'timestamp' => date('Y-m-d H:i:s')
    ]);
    
    log_message('SUCCESS: Deployment completed for commit ' . substr($data['after'], 0, 7));
    
} else {
    log_message('ERROR: Git pull failed with code ' . $return_code);
    log_message('ERROR: ' . implode("\n", $output));
    
    http_response_code(500);
    echo json_encode([
        'status' => 'error',
        'message' => 'Deployment failed',
        'error' => implode("\n", $output)
    ]);
}

// Log the deployment attempt
log_message('INFO: Deployment process completed');
?>