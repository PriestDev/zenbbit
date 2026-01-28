<?php
/**
 * WALLET_LOGO_CACHE.PHP
 * Manages caching of wallet logos locally
 * Uses quick cache lookup without blocking page render
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

// Ensure cache directory exists (only once)
if (!is_dir($cacheDir)) {
    mkdir($cacheDir, 0755, true);
}

/**
 * Quick logo path lookup - returns cached path if available, otherwise CDN URL
 * Non-blocking - doesn't download anything
 */
function getWalletLogo($walletKey) {
    global $walletLogos, $cacheDir;
    
    if (!isset($walletLogos[$walletKey])) {
        return null;
    }
    
    $sourceUrl = $walletLogos[$walletKey];
    $extension = pathinfo(parse_url($sourceUrl, PHP_URL_PATH), PATHINFO_EXTENSION);
    if (empty($extension)) {
        $extension = 'png';
    }
    
    $localPath = $cacheDir . $walletKey . '.' . $extension;
    $relativePath = 'assets/wallet-logos/' . $walletKey . '.' . $extension;
    
    // If file exists, use cached version (no download, no timeout)
    if (file_exists($localPath)) {
        return $relativePath;
    }
    
    // Otherwise return CDN URL (will be cached asynchronously later)
    return $sourceUrl;
}

/**
 * Asynchronous background caching via JavaScript
 * Call this to trigger background downloads without blocking page
 */
function initBackgroundCaching() {
    global $walletLogos;
    
    $walletKeys = array_keys($walletLogos);
    echo '<script>';
    echo '(function(){';
    echo 'var wallets = ' . json_encode($walletKeys) . ';';
    echo 'fetch("' . rtrim($_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['REQUEST_URI']), '/') . '/api/cache_wallet_logos.php", {';
    echo 'method: "POST",';
    echo 'headers: {"Content-Type": "application/json"},';
    echo 'body: JSON.stringify({wallets: wallets}),';
    echo 'credentials: "same-origin"';
    echo '}).catch(e => console.log("Background caching initiated"));';
    echo '})();';
    echo '</script>';
}

// Call background caching after page load (non-blocking)
// This runs AFTER page render completes
if (session_status() === PHP_SESSION_ACTIVE && !isset($_SESSION['wallet_cache_requested'])) {
    $_SESSION['wallet_cache_requested'] = true;
}
