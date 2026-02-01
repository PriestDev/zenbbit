<?php
/**
 * API Endpoint: Get Cached Asset Prices
 * Returns cached prices from the local cache file as a fallback for when API is down
 */

header('Content-Type: application/json');

// Read cached prices from file
$cache_file = __DIR__ . '/api_cache/prices.json';
$cached_prices = [];
$fetched_at = null;

if (file_exists($cache_file)) {
    $cached = @json_decode(@file_get_contents($cache_file), true);
    if (is_array($cached) && isset($cached['data'])) {
        $cached_prices = $cached['data'];
        $fetched_at = isset($cached['fetched_at']) ? $cached['fetched_at'] : null;
    }
}

echo json_encode([
    'status' => !empty($cached_prices) ? 'success' : 'no_cache',
    'data' => $cached_prices,
    'fetched_at' => $fetched_at,
    'cache_file' => $cache_file,
    'file_exists' => file_exists($cache_file)
]);
?>
