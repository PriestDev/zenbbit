<?php
/**
 * CACHE_WALLET_LOGOS.PHP
 * Background API endpoint for caching wallet logos
 * Non-blocking - runs after page render completes
 */

header('Content-Type: application/json');

// No need to validate session - this is just for caching
$input = json_decode(file_get_contents('php://input'), true);
$wallets = $input['wallets'] ?? [];

$walletLogos = [
    'metamask' => 'https://cdn.jsdelivr.net/gh/MetaMask/brand-resources@master/SVG/metamask-fox.svg',
    'trust-wallet' => 'https://cdn.jsdelivr.net/gh/trustwallet/assets@master/blockchains/ethereum/assets/0x0000000000085d4780B73119b8B580991DEe8d52/logo.png',
    'coinbase' => 'https://avatars.githubusercontent.com/u/18732972?s=200&v=4',
    'phantom' => 'https://cdn.jsdelivr.net/gh/phantom/brand-assets@main/png/Phantom%20Logo%20-%20Purple.png',
    'ledger' => 'https://cdn.jsdelivr.net/gh/spesmilo/electrum@master/electrum/gui/icons/ledger.png',
    'okx' => 'https://cdn.jsdelivr.net/gh/okx/okx-wallet@master/assets/logo.png',
    'trezor' => 'https://cdn.jsdelivr.net/gh/trezor/trezor-common@master/defs/device_icons/device_logo.svg',
    'exodus' => 'https://cdn.jsdelivr.net/gh/ExodusMovement/exodus-desktop@master/exodus.png',
    'argent' => 'https://cdn.jsdelivr.net/gh/argentlabs/argent-x@main/packages/extension/public/argent.svg',
    'myetherwallet' => 'https://cdn.jsdelivr.net/gh/MyEtherWallet/MyEtherWallet@master/images/logo-mew.png'
];

$cacheDir = __DIR__ . '/../assets/wallet-logos/';

if (!is_dir($cacheDir)) {
    mkdir($cacheDir, 0755, true);
}

$cached = 0;
$failed = 0;

// Cache each wallet logo
foreach ($wallets as $walletKey) {
    if (!isset($walletLogos[$walletKey])) {
        continue;
    }
    
    $sourceUrl = $walletLogos[$walletKey];
    $extension = pathinfo(parse_url($sourceUrl, PHP_URL_PATH), PATHINFO_EXTENSION);
    if (empty($extension)) {
        $extension = 'png';
    }
    
    $localPath = $cacheDir . $walletKey . '.' . $extension;
    
    // Skip if already cached
    if (file_exists($localPath)) {
        $cached++;
        continue;
    }
    
    // Try to download and cache with timeout
    try {
        $context = stream_context_create([
            'http' => [
                'timeout' => 3, // Short timeout - don't block user
                'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36'
            ],
            'https' => [
                'timeout' => 3,
                'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36'
            ]
        ]);
        
        $imageData = @file_get_contents($sourceUrl, false, $context);
        
        if ($imageData !== false && strlen($imageData) > 0) {
            @file_put_contents($localPath, $imageData);
            $cached++;
        } else {
            $failed++;
        }
    } catch (Exception $e) {
        $failed++;
        error_log('Background cache failed for ' . $walletKey . ': ' . $e->getMessage());
    }
}

// Return success immediately (non-blocking)
http_response_code(200);
echo json_encode([
    'success' => true,
    'cached' => $cached,
    'failed' => $failed,
    'total' => count($wallets)
]);

// Close connection to client immediately
if (function_exists('fastcgi_finish_request')) {
    fastcgi_finish_request();
}
