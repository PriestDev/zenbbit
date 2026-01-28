<?php
/**
 * WALLET_LOGO_CACHE.PHP
 * Wallet logo URL mapping - uses verified official wallet logos
 */

$walletLogos = [
    'metamask' => 'https://upload.wikimedia.org/wikipedia/commons/3/36/MetaMask_Fox.svg',
    'trust-wallet' => 'https://trustwallet.com/assets/images/media/logos/trust-logo-4.svg',
    'coinbase' => 'https://dynamic.brandcrowd.com/asset/logo/4bec9e64-4a70-4b49-bff9-208d0ffa6782/logo?v=637933600000000000',
    'phantom' => 'https://phantombrand.s3.amazonaws.com/Phantom%20Logo%20-%20Purple.png',
    'ledger' => 'https://ledger.com/wp-content/uploads/2023/11/ledger-logo.png',
    'okx' => 'https://static.okx.com/cdn/assets/imgs/221/A08D7B316FB84D14',
    'trezor' => 'https://wiki.trezor.io/images/thumb/e/ef/Logo_T.png/200px-Logo_T.png',
    'exodus' => 'https://www.exodus.com/assets/images/exodus-logo-light.svg',
    'argent' => 'https://raw.githubusercontent.com/argentlabs/argent-x/main/packages/extension/public/argent.svg',
    'myetherwallet' => 'https://www.myetherwallet.com/img/logo-mew.png'
];

/**
 * Get wallet logo URL
 */
function getWalletLogo($walletKey) {
    global $walletLogos;
    return $walletLogos[$walletKey] ?? null;
}
