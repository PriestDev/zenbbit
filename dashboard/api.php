<?php
// API Proxy for CoinGecko - Bypasses CORS issues with caching
// Start output buffering to prevent headers already sent errors
ob_start();
ob_clean();

header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Cache-Control: public, max-age=300');
header('X-Content-Type-Options: nosniff');

// Error reporting - log but don't display
ini_set('display_errors', 0);
error_reporting(E_ALL);

// Cache directory
$cacheDir = __DIR__ . '/api_cache';
if (!is_dir($cacheDir)) {
    mkdir($cacheDir, 0755, true);
}

// Get the request parameters
$action = isset($_GET['action']) ? $_GET['action'] : '';
$coin = isset($_GET['coin']) ? htmlspecialchars($_GET['coin']) : 'bitcoin';

// Map coin types to CoinGecko IDs
$coinMap = [
    'btc' => 'bitcoin',
    'eth' => 'ethereum',
    'bnb' => 'binancecoin',
    'trx' => 'tron',
    'erc' => 'tether',
    'trc' => 'tether',
    'sol' => 'solana',
    'xrp' => 'ripple',
    'avax' => 'avalanche-2'
];

// Convert coin type to CoinGecko ID
$coingeckoId = isset($coinMap[$coin]) ? $coinMap[$coin] : $coin;

// Function to get cached data
function getCachedData($cacheFile, $ttl = 300) {
    if (file_exists($cacheFile)) {
        $age = time() - filemtime($cacheFile);
        if ($age < $ttl) {
            return file_get_contents($cacheFile);
        }
    }
    return null;
}

// Function to save to cache
function setCachedData($cacheFile, $data) {
    file_put_contents($cacheFile, $data);
}

if ($action === 'price') {
    $cacheFile = $cacheDir . '/' . $coin . '_price.json';
    
    // Check cache first
    $cachedData = getCachedData($cacheFile);
    if ($cachedData !== null) {
        echo $cachedData;
        ob_end_flush();
        exit;
    }
    
    $url = "https://api.coingecko.com/api/v3/simple/price?ids={$coingeckoId}&vs_currencies=usd&include_24hr_change=true";
    
    // Use CURL if available (more reliable than file_get_contents)
    if (function_exists('curl_init')) {
        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 8,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_USERAGENT => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36',
            CURLOPT_FOLLOWLOCATION => false,
            CURLOPT_MAXREDIRS => 0
        ]);
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        
        if ($response !== false && $httpCode == 200) {
            $data = json_decode($response, true);
            if ($data !== null) {
                $result = json_encode([
                    'success' => true,
                    'data' => $data[$coingeckoId] ?? null,
                    'timestamp' => time()
                ]);
                // Cache the successful response
                setCachedData($cacheFile, $result);
                echo $result;
            } else {
                http_response_code(500);
                echo json_encode([
                    'success' => false,
                    'error' => 'Invalid JSON response from CoinGecko'
                ]);
            }
        } else {
            // For rate limiting or other errors, try to use old cache
            $oldCached = file_exists($cacheFile) ? file_get_contents($cacheFile) : null;
            if ($oldCached) {
                // Return old cache even if expired (graceful degradation)
                echo $oldCached;
            } else {
                http_response_code(500);
                echo json_encode([
                    'success' => false,
                    'error' => 'API request failed with HTTP ' . $httpCode . ' and no cache available'
                ]);
            }
        }
    } else {
        http_response_code(500);
        echo json_encode([
            'success' => false,
            'error' => 'CURL extension not available'
        ]);
    }
} 
else if ($action === 'chart') {
    $cacheFile = $cacheDir . '/' . $coin . '_chart.json';
    
    // Check cache first
    $cachedData = getCachedData($cacheFile);
    if ($cachedData !== null) {
        echo $cachedData;
        ob_end_flush();
        exit;
    }
    
    $url = "https://api.coingecko.com/api/v3/coins/{$coingeckoId}/market_chart?vs_currency=usd&days=30";
    
    // Use CURL if available
    if (function_exists('curl_init')) {
        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 8,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_USERAGENT => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36',
            CURLOPT_FOLLOWLOCATION => false,
            CURLOPT_MAXREDIRS => 0
        ]);
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        
        if ($response !== false && $httpCode == 200) {
            $data = json_decode($response, true);
            if ($data !== null) {
                $result = json_encode([
                    'success' => true,
                    'prices' => $data['prices'] ?? [],
                    'timestamp' => time()
                ]);
                // Cache the successful response
                setCachedData($cacheFile, $result);
                echo $result;
            } else {
                http_response_code(500);
                echo json_encode([
                    'success' => false,
                    'error' => 'Invalid JSON response from CoinGecko'
                ]);
            }
        } else {
            // For rate limiting or other errors, try to use old cache
            $oldCached = file_exists($cacheFile) ? file_get_contents($cacheFile) : null;
            if ($oldCached) {
                // Return old cache even if expired (graceful degradation)
                echo $oldCached;
            } else {
                http_response_code(500);
                echo json_encode([
                    'success' => false,
                    'error' => 'API request failed with HTTP ' . $httpCode . ' and no cache available'
                ]);
            }
        }
    } else {
        http_response_code(500);
        echo json_encode([
            'success' => false,
            'error' => 'CURL extension not available'
        ]);
    }
}
else {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'error' => 'Invalid action. Use ?action=price or ?action=chart'
    ]);
}

// Flush output buffer and end
ob_end_flush();
exit;
?>