<?php
/**
 * WALLET_LOGO_CACHE.PHP
 * Simple logo URL mapping - uses reliable CDN URLs
 */

$walletLogos = [
    'metamask' => 'https://cdn.jsdelivr.net/gh/MetaMask/brand-resources@master/SVG/metamask-fox.svg',
    'trust-wallet' => 'https://cdn.jsdelivr.net/npm/cryptocurrency-icons@0.18.0/128/color/bnb.png',
    'coinbase' => 'https://avatars.githubusercontent.com/u/18732972?s=200&v=4',
    'phantom' => 'https://cdn.jsdelivr.net/gh/phantom/brand-assets@main/png/Phantom%20Logo%20-%20Purple.png',
    'ledger' => 'https://cdn.jsdelivr.net/npm/cryptocurrency-icons@0.18.0/128/color/btc.png',
    'okx' => 'https://cdn.jsdelivr.net/npm/cryptocurrency-icons@0.18.0/128/color/okb.png',
    'trezor' => 'https://cdn.jsdelivr.net/npm/@trezor/connect@9.0.0/build/images/logo.png',
    'exodus' => 'https://img.icons8.com/?size=512&id=99955&format=png',
    'argent' => 'https://cdn.jsdelivr.net/gh/argentlabs/argent-x@main/packages/extension/public/argent.svg',
    'myetherwallet' => 'https://cdn.jsdelivr.net/npm/@myetherwallet/mewconnect-web-client@1.0.0/docs/mew-logo.png'
];

/**
 * Get wallet logo URL
 */
function getWalletLogo($walletKey) {
    global $walletLogos;
    return $walletLogos[$walletKey] ?? null;
}
