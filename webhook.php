<?php
// Path to your repository folder
$repoDir = '/home/kbjnepa1/check.me/repository';

// Define a secret key to ensure only GitHub is sending the webhook
$secret = 'Reemorika6325'; // Change to something secure

// Get the payload
$payload = file_get_contents('php://input');
$headers = getallheaders();
$signature = $headers['X-Hub-Signature'];

// Verify the payload signature
$hash = 'sha1=' . hash_hmac('sha1', $payload, $secret);
if (hash_equals($signature, $hash)) {
    // Pull the latest changes from the repo
    chdir($repoDir);
    exec('git pull origin master', $output, $return_var);

    // If you need to clear cache and do migrations (if applicable), you can do this:
    // exec('php artisan migrate --force');
    // exec('php artisan cache:clear');
    
    // You can log the output for debugging purposes
    file_put_contents('deploy.log', implode("\n", $output), FILE_APPEND);

    echo "Deployment successful!";
} else {
    echo "Invalid signature!";
}
?>
