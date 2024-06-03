<?php
// Path to your deployment script
$script = 'deploy.sh';

// Path to the secret key file
$secretFile = 'secret.key';

// Read the secret from the file
if (!file_exists($secretFile)) {
    http_response_code(500);
    die('Secret key file not found');
}

$secret = trim(file_get_contents($secretFile));

// Get payload and headers
$payload = file_get_contents('php://input');
$headers = getallheaders();

// Verify the webhook secret if set
if (isset($headers['X-Hub-Signature'])) {
    list($algo, $hash) = explode('=', $headers['X-Hub-Signature'], 2) + ['', ''];
    if ($hash !== hash_hmac($algo, $payload, $secret)) {
        http_response_code(403);
        die('Invalid secret');
    }
}

// Execute the deployment script
shell_exec($script . ' > /dev/null 2>&1 &');
?>
