<?php
/**
 * WALLET_LOGO_CACHE.PHP
 * Wallet logo URL mapping - uses official wallet logos
 */

$walletLogos = [
    'metamask' => 'https://upload.wikimedia.org/wikipedia/commons/3/36/MetaMask_Fox.svg',
    'trust-wallet' => 'https://avatars.githubusercontent.com/u/24244296?s=200&v=4',
    'coinbase' => 'https://avatars.githubusercontent.com/u/18732972?s=200&v=4',
    'phantom' => 'https://pbs.twimg.com/profile_images/1505143332707299332/_CVhNp6n_400x400.jpg',
    'ledger' => 'https://avatars.githubusercontent.com/u/6879968?s=200&v=4',
    'okx' => 'https://avatars.githubusercontent.com/u/67220159?s=200&v=4',
    'trezor' => 'https://avatars.githubusercontent.com/u/4419015?s=200&v=4',
    'exodus' => 'https://avatars.githubusercontent.com/u/20166188?s=200&v=4',
    'argent' => 'https://avatars.githubusercontent.com/u/48281670?s=200&v=4',
    'myetherwallet' => 'https://avatars.githubusercontent.com/u/16744597?s=200&v=4'
];

/**
 * Get wallet logo URL
 */
function getWalletLogo($walletKey) {
    global $walletLogos;
    return $walletLogos[$walletKey] ?? null;
}
