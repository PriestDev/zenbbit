<?php
/**
 * Download wallet logos from various sources
 * Saves them to dashboard/assets/wallet-logos/
 */

$logoDir = dirname(__DIR__) . '/assets/wallet-logos/';

// Create directory if it doesn't exist
if (!is_dir($logoDir)) {
    mkdir($logoDir, 0755, true);
}

// Wallet logo sources - using direct CDN and official sources
$wallets = [
    'coinbase' => 'https://cdn.jsdelivr.net/gh/spothq/cryptocurrency-icons/128/color/btc.png', // Fallback icon
    'gemini' => 'https://www.gemini.com/favicon.ico',
    'binance' => 'https://cdn.jsdelivr.net/gh/spothq/cryptocurrency-icons/128/color/bnb.png', // Fallback
    'atomic' => 'https://raw.githubusercontent.com/AtomicWallet/wallet/master/app/app/AppIcon.png',
    'trust-wallet' => 'https://raw.githubusercontent.com/trustwallet/assets/master/blockchains/ethereum/info/logo.png',
    'metamask' => 'https://raw.githubusercontent.com/MetaMask/brand-resources/master/SVGs/metamask-fox.svg',
    'phantom' => 'https://raw.githubusercontent.com/phantom-labs/phantom/main/app/assets/icon-256.png',
    'exodus' => 'https://raw.githubusercontent.com/ExodusMovement/exodus-desktop/master/assets/logo.png',
    'trezor' => 'https://cdn.trezor.io/trezor-suite/web/assets/images/logos/trezor.png',
    'okx' => 'https://raw.githubusercontent.com/okx/okx-wallet/main/apps/extension/public/icon-128.png',
    'rabby' => 'https://raw.githubusercontent.com/RabbyHub/Rabby/main/app/public/images/logo.svg',
    'argent' => 'https://raw.githubusercontent.com/argentlabs/argent-x/develop/logo.svg'
];

echo "Downloading wallet logos...\n";
echo "Destination: $logoDir\n\n";

$downloaded = 0;
$failed = 0;

foreach ($wallets as $wallet => $url) {
    $filename = $logoDir . $wallet . '.' . pathinfo(parse_url($url, PHP_URL_PATH), PATHINFO_EXTENSION);
    
    // Handle cases without extension
    if (empty(pathinfo($filename, PATHINFO_EXTENSION))) {
        $filename = $logoDir . $wallet . '.png';
    }
    
    echo "Downloading: $wallet from $url... ";
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)');
    
    $data = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    
    if ($httpCode === 200 && $data) {
        file_put_contents($filename, $data);
        echo "✓ Downloaded to " . basename($filename) . "\n";
        $downloaded++;
    } else {
        echo "✗ Failed (HTTP $httpCode)\n";
        $failed++;
    }
}

echo "\n";
echo "Summary: $downloaded downloaded, $failed failed\n";
echo "Logos saved to: $logoDir\n";

// List downloaded files
echo "\nDownloaded files:\n";
if (is_dir($logoDir)) {
    $files = array_diff(scandir($logoDir), ['.', '..']);
    foreach ($files as $file) {
        $size = filesize($logoDir . $file);
        echo "  - $file (" . round($size / 1024, 2) . " KB)\n";
    }
}
?>
