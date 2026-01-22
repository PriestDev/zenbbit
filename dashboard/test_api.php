<?php
// Test CoinGecko API directly from server

// Test 1: Simple price
$url1 = "https://api.coingecko.com/api/v3/simple/price?ids=bitcoin&vs_currencies=usd&include_24hr_change=true";
$response1 = @file_get_contents($url1);

echo "=== TEST 1: Current Price ===\n";
if ($response1) {
    echo "✅ API Response received\n";
    $data = json_decode($response1, true);
    echo json_encode($data, JSON_PRETTY_PRINT) . "\n\n";
} else {
    echo "❌ Failed to fetch from API\n";
    echo "Error: " . error_get_last()['message'] . "\n\n";
}

// Test 2: Market chart
$url2 = "https://api.coingecko.com/api/v3/coins/bitcoin/market_chart?vs_currency=usd&days=30";
$response2 = @file_get_contents($url2);

echo "=== TEST 2: Market Chart ===\n";
if ($response2) {
    echo "✅ API Response received\n";
    $data = json_decode($response2, true);
    echo "Data points: " . count($data['prices']) . " prices\n";
    echo "First 3 prices:\n";
    for ($i = 0; $i < 3; $i++) {
        echo "  " . date('Y-m-d H:i', $data['prices'][$i][0]/1000) . " -> $" . $data['prices'][$i][1] . "\n";
    }
} else {
    echo "❌ Failed to fetch from API\n";
    echo "Error: " . error_get_last()['message'] . "\n";
}
?>