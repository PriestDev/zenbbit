<?php
/**
 * WALLET_LOGO_CACHE.PHP
 * Local wallet logo paths - all logos stored in assets/wallet-logos/
 */

$walletLogos = [
    'coinbase' => 'assets/wallet-logos/coinbase.png',
    'gemini' => 'assets/wallet-logos/gemini.ico',
    'binance' => 'assets/wallet-logos/binance.png',
    'atomic' => 'assets/wallet-logos/atomic.svg',
    'trust-wallet' => 'assets/wallet-logos/trust-wallet.png',
    'metamask' => 'assets/wallet-logos/metamask.svg',
    'phantom' => 'assets/wallet-logos/phantom.svg',
    'exodus' => 'assets/wallet-logos/exodus.svg',
    'trezor' => 'assets/wallet-logos/trezor.svg',
    'okx' => 'assets/wallet-logos/okx.svg',
    'rabby' => 'assets/wallet-logos/rabby.svg',
    'argent' => 'assets/wallet-logos/argent.svg'
];

/**
 * Get wallet logo path
 */
function getWalletLogo($walletKey) {
    global $walletLogos;
    return $walletLogos[$walletKey] ?? null;
}
