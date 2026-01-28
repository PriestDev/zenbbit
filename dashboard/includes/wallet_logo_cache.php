<?php
/**
 * WALLET_LOGO_CACHE.PHP
 * Wallet logo URL mapping - uses official wallet logos
 */

$walletLogos = [
    'metamask' => 'https://upload.wikimedia.org/wikipedia/commons/3/36/MetaMask_Fox.svg',
    'trust-wallet' => 'https://raw.githubusercontent.com/trustwallet/assets/master/blockchains/ethereum/assets/0x0000000000085d4780B73119b8B580991DEe8d52/logo.png',
    'coinbase' => 'https://images.ctfassets.net/c5bd0wqwc5v0/5mRJMxJWqKgQE9Y0QJJVi/cf5a7f0b82e1dd62a8c006f9c3f2d4d3/coinbase-logo.png',
    'phantom' => 'https://raw.githubusercontent.com/phantom/brand-assets/main/png/Phantom%20Logo%20-%20Purple.png',
    'ledger' => 'https://raw.githubusercontent.com/ledgerhq/ledger-live/develop/apps/ledger-live-desktop/public/icon.png',
    'okx' => 'https://www.okx.com/cdn/assets/imgs/202305/logo.png',
    'trezor' => 'https://trezor.io/static/images/trezor-logo.png',
    'exodus' => 'https://raw.githubusercontent.com/ExodusMovement/exodus-desktop/master/public/assets/icon.png',
    'argent' => 'https://raw.githubusercontent.com/argentlabs/argent-x/main/packages/extension/public/argent.svg',
    'myetherwallet' => 'https://raw.githubusercontent.com/MyEtherWallet/MyEtherWallet/master/public/images/logo.png'
];

/**
 * Get wallet logo URL
 */
function getWalletLogo($walletKey) {
    global $walletLogos;
    return $walletLogos[$walletKey] ?? null;
}
