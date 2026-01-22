<?php
// Quick diagnostic for API issues
echo "<pre>";
echo "=== PHP Configuration ===\n";
echo "allow_url_fopen: " . (ini_get('allow_url_fopen') ? 'YES' : 'NO') . "\n";
echo "allow_url_include: " . (ini_get('allow_url_include') ? 'YES' : 'NO') . "\n";
echo "openssl enabled: " . (extension_loaded('openssl') ? 'YES' : 'NO') . "\n";
echo "curl enabled: " . (extension_loaded('curl') ? 'YES' : 'NO') . "\n\n";

echo "=== Testing API Request ===\n";

$url = "https://api.coingecko.com/api/v3/simple/price?ids=bitcoin&vs_currencies=usd&include_24hr_change=true";

// Try with different methods
echo "Method 1: file_get_contents\n";
$context = stream_context_create([
    'http' => ['timeout' => 5, 'user_agent' => 'Test'],
    'https' => ['timeout' => 5, 'user_agent' => 'Test', 'verify_peer' => false]
]);

$result = @file_get_contents($url, false, $context);
if ($result) {
    echo "✓ SUCCESS\n";
    echo "Response length: " . strlen($result) . " bytes\n";
    $decoded = json_decode($result, true);
    if ($decoded) {
        echo "✓ Valid JSON\n";
        echo json_encode($decoded, JSON_PRETTY_PRINT) . "\n";
    } else {
        echo "✗ Invalid JSON\n";
        echo substr($result, 0, 200) . "\n";
    }
} else {
    echo "✗ FAILED\n";
    $error = error_get_last();
    if ($error) echo "Error: " . $error['message'] . "\n";
}

echo "\n\nMethod 2: cURL\n";
if (extension_loaded('curl')) {
    $ch = curl_init();
    curl_setopt_array($ch, [
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT => 5,
        CURLOPT_USERAGENT => 'Test',
        CURLOPT_SSL_VERIFYPEER => false
    ]);
    
    $result = curl_exec($ch);
    $error = curl_error($ch);
    curl_close($ch);
    
    if ($result) {
        echo "✓ SUCCESS\n";
        echo "Response length: " . strlen($result) . " bytes\n";
        echo substr($result, 0, 200) . "\n";
    } else {
        echo "✗ FAILED: " . $error . "\n";
    }
} else {
    echo "cURL not available\n";
}

echo "</pre>";
?>