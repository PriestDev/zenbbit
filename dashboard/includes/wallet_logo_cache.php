<?php
/**
 * WALLET_LOGO_CACHE.PHP
 * Manages caching of wallet logos locally
 * Called on first page load to download and cache images
 */

// Define wallet logos to cache with their source URLs
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

// Ensure cache directory exists
if (!is_dir($cacheDir)) {
    mkdir($cacheDir, 0755, true);
}

/**
 * Get or download wallet logo
 */
function getWalletLogo($walletKey) {
    global $walletLogos, $cacheDir;
    
    if (!isset($walletLogos[$walletKey])) {
        return null;
    }
    
    $sourceUrl = $walletLogos[$walletKey];
    $extension = pathinfo(parse_url($sourceUrl, PHP_URL_PATH), PATHINFO_EXTENSION);
    if (empty($extension)) {
        $extension = 'png'; // Default to PNG if no extension
    }
    
    $localPath = $cacheDir . $walletKey . '.' . $extension;
    $relativePath = 'assets/wallet-logos/' . $walletKey . '.' . $extension;
    
    // If file exists and is less than 30 days old, use cached version
    if (file_exists($localPath) && (time() - filemtime($localPath)) < (30 * 24 * 60 * 60)) {
        return $relativePath;
    }
    
    // Download and cache the image
    try {
        $context = stream_context_create([
            'http' => [
                'timeout' => 5,
                'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36'
            ]
        ]);
        
        $imageData = @file_get_contents($sourceUrl, false, $context);
        
        if ($imageData !== false) {
            file_put_contents($localPath, $imageData);
            return $relativePath;
        }
    } catch (Exception $e) {
        error_log('Failed to cache wallet logo: ' . $walletKey . ' - ' . $e->getMessage());
    }
    
    // If download fails, return online URL as fallback
    return $sourceUrl;
}

/**
 * Pre-cache all wallet logos
 * Can be called in background to ensure all images are cached
 */
function precacheAllWalletLogos() {
    global $walletLogos;
    
    foreach (array_keys($walletLogos) as $walletKey) {
        getWalletLogo($walletKey);
    }
}

// Auto-cache logos if session variable not set (prevents multiple cache attempts)
if (!isset($_SESSION['wallet_logos_cached'])) {
    // Use async background request to cache logos (non-blocking)
    $_SESSION['wallet_logos_cached'] = true;
    
    // Try to cache in background using PHP's built-in functionality
    if (function_exists('fastcgi_finish_request')) {
        // For FastCGI (most hosting)
        precacheAllWalletLogos();
    } else {
        // For others, just cache on demand as images are requested
        foreach (array_keys($walletLogos) as $walletKey) {
            getWalletLogo($walletKey);
        }
    }
}
