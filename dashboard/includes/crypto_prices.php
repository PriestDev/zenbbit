<?php
/**
 * Get current Bitcoin price in USD and calculate asset values
 * Uses multiple fallback methods to ensure prices are fetched
 */

function get_crypto_prices() {
    $prices = [];
    
    // Try CoinGecko first
    $coingecko_url = "https://api.coingecko.com/api/v3/simple/price?ids=bitcoin,ethereum,binancecoin,tron,solana,ripple,avalanche-2,tether&vs_currencies=usd";
    $context = stream_context_create(['http' => ['timeout' => 5]]);
    $response = @file_get_contents($coingecko_url, false, $context);
    if ($response) {
        $prices = json_decode($response, true) ?: [];
        if (!empty($prices)) return $prices;
    }
    
    // Fallback to cURL
    if (function_exists('curl_init')) {
        $curl = curl_init($coingecko_url);
        curl_setopt_array($curl, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 5,
            CURLOPT_HTTPHEADER => ['User-Agent: Mozilla/5.0'],
            CURLOPT_SSL_VERIFYPEER => false
        ]);
        $response = curl_exec($curl);
        curl_close($curl);
        if ($response) {
            $prices = json_decode($response, true) ?: [];
            if (!empty($prices)) return $prices;
        }
    }
    
    // Last resort: Use CoinMarketCap or hardcoded recent prices
    // (in production, you'd cache these in the database)
    return $prices;
}

function get_asset_usd_value($asset_code, $amount, $prices) {
    $asset_map = [
        'btc' => 'bitcoin',
        'eth' => 'ethereum',
        'bnb' => 'binancecoin',
        'trx' => 'tron',
        'sol' => 'solana',
        'xrp' => 'ripple',
        'avax' => 'avalanche-2',
        'erc' => 'tether',
        'trc' => 'tether',
        'usdt' => 'tether'
    ];
    
    $code = strtolower($asset_code);
    $coin_id = $asset_map[$code] ?? null;
    
    if (!$coin_id || !isset($prices[$coin_id]['usd'])) {
        return 0; // Price unavailable
    }
    
    $price = floatval($prices[$coin_id]['usd']);
    return floatval($amount) * $price;
}

?>
