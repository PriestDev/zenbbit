<?php
/**
 * Crypto Asset System - Database & Integration Test
 * 
 * Tests:
 * 1. Database columns exist
 * 2. asset_transaction table exists
 * 3. Crypto balance retrieval works
 * 4. Deposit/Withdrawal functions work
 * 5. Transaction logging works
 * 6. Assets list displays correctly
 */

require_once(__DIR__ . '/database/db_config.php');
require_once(__DIR__ . '/dashboard/api/crypto_assets.php');

if ($conn === null) {
    die("❌ Database connection failed.\n");
}

echo "═══════════════════════════════════════════════════════════════\n";
echo "🧪 Crypto Asset System - Integration Test\n";
echo "═══════════════════════════════════════════════════════════════\n\n";

$errors = [];
$tests_passed = 0;
$tests_failed = 0;

// ========== TEST 1: Database Columns ==========
echo "1️⃣  Testing Database Columns...\n";

$crypto_columns = ['btc_balance', 'eth_balance', 'bnb_balance', 'trx_balance', 'sol_balance', 'xrp_balance', 'avax_balance', 'erc_balance', 'trc_balance'];
$missing_columns = [];

foreach ($crypto_columns as $column) {
    $check = "SELECT * FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'user' AND COLUMN_NAME = '$column'";
    $result = $conn->query($check);
    
    if (!$result || $result->num_rows === 0) {
        $missing_columns[] = $column;
    }
}

if (empty($missing_columns)) {
    echo "   ✅ All 9 crypto balance columns exist\n";
    $tests_passed++;
} else {
    echo "   ❌ Missing columns: " . implode(', ', $missing_columns) . "\n";
    $tests_failed++;
    $errors[] = "Missing crypto balance columns";
}

// ========== TEST 2: Transaction Table ==========
echo "\n2️⃣  Testing Asset Transaction Table...\n";

$table_check = "SELECT * FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'asset_transaction'";
$result = $conn->query($table_check);

if ($result && $result->num_rows > 0) {
    echo "   ✅ asset_transaction table exists\n";
    
    // Check required columns
    $required_cols = ['id', 'user_id', 'acct_id', 'crypto_type', 'transaction_type', 'amount', 'previous_balance', 'new_balance', 'status', 'admin_id', 'created_at'];
    $missing_trans_cols = [];
    
    foreach ($required_cols as $col) {
        $col_check = "SELECT * FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'asset_transaction' AND COLUMN_NAME = '$col'";
        $col_result = $conn->query($col_check);
        
        if (!$col_result || $col_result->num_rows === 0) {
            $missing_trans_cols[] = $col;
        }
    }
    
    if (empty($missing_trans_cols)) {
        echo "   ✅ All transaction table columns exist\n";
        $tests_passed++;
    } else {
        echo "   ❌ Missing transaction columns: " . implode(', ', $missing_trans_cols) . "\n";
        $tests_failed++;
        $errors[] = "Missing transaction table columns";
    }
} else {
    echo "   ❌ asset_transaction table does not exist\n";
    $tests_failed++;
    $errors[] = "asset_transaction table missing";
}

// ========== TEST 3: API Functions Exist ==========
echo "\n3️⃣  Testing API Functions...\n";

$functions_to_test = ['get_asset_balance', 'deposit_crypto_asset', 'withdraw_crypto_asset', 'get_asset_transactions', 'get_all_asset_balances'];
$missing_functions = [];

foreach ($functions_to_test as $func) {
    if (!function_exists($func)) {
        $missing_functions[] = $func;
    }
}

if (empty($missing_functions)) {
    echo "   ✅ All crypto asset functions exist\n";
    $tests_passed++;
} else {
    echo "   ❌ Missing functions: " . implode(', ', $missing_functions) . "\n";
    $tests_failed++;
    $errors[] = "Missing crypto asset functions";
}

// ========== TEST 4: API Files Exist ==========
echo "\n4️⃣  Testing API Files...\n";

$api_files = [
    '/dashboard/api/crypto_assets.php',
    '/dashboard/api/asset_transaction.php',
    '/admin/api_crypto_admin.php'
];

$missing_files = [];
$base_path = __DIR__;

foreach ($api_files as $file) {
    if (!file_exists($base_path . $file)) {
        $missing_files[] = $file;
    }
}

if (empty($missing_files)) {
    echo "   ✅ All API files exist\n";
    $tests_passed++;
} else {
    echo "   ❌ Missing files: " . implode(', ', $missing_files) . "\n";
    $tests_failed++;
    $errors[] = "Missing API files";
}

// ========== TEST 5: Sample User Test ==========
echo "\n5️⃣  Testing with Sample Data...\n";

// Get a sample user
$stmt = $conn->prepare("SELECT id, acct_id FROM user LIMIT 1");
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    $test_user_id = $user['id'];
    $test_acct_id = $user['acct_id'];
    
    echo "   Using test user: $test_acct_id\n";
    
    // Test getting all balances
    $balances = get_all_asset_balances($conn, $test_acct_id);
    if (!empty($balances)) {
        echo "   ✅ Successfully retrieved all balances\n";
        echo "      BTC: " . $balances['btc'] . "\n";
        echo "      ETH: " . $balances['eth'] . "\n";
        $tests_passed++;
    } else {
        echo "   ❌ Failed to retrieve balances\n";
        $tests_failed++;
        $errors[] = "Could not retrieve sample balances";
    }
    
    // Test deposit function
    $before_balance = $balances['btc'];
    $test_amount = 0.001;
    $deposit_result = deposit_crypto_asset($conn, $test_user_id, $test_acct_id, 'btc', $test_amount, null, 'Test deposit');
    
    if ($deposit_result['success']) {
        echo "   ✅ Test deposit successful\n";
        echo "      Amount: $test_amount BTC\n";
        echo "      Transaction ID: " . $deposit_result['transaction_id'] . "\n";
        $tests_passed++;
        
        // Test withdrawal
        $withdraw_result = withdraw_crypto_asset($conn, $test_user_id, $test_acct_id, 'btc', $test_amount, null, 'Test withdrawal');
        
        if ($withdraw_result['success']) {
            echo "   ✅ Test withdrawal successful\n";
            echo "      Amount: $test_amount BTC\n";
            echo "      Transaction ID: " . $withdraw_result['transaction_id'] . "\n";
            $tests_passed++;
        } else {
            echo "   ❌ Test withdrawal failed: " . $withdraw_result['message'] . "\n";
            $tests_failed++;
            $errors[] = "Withdrawal test failed";
        }
    } else {
        echo "   ❌ Test deposit failed: " . $deposit_result['message'] . "\n";
        $tests_failed++;
        $errors[] = "Deposit test failed";
    }
    
    // Test transaction history
    $transactions = get_asset_transactions($conn, $test_acct_id, 'btc', 10);
    if (!empty($transactions)) {
        echo "   ✅ Transaction history retrieved (" . count($transactions) . " records)\n";
        $tests_passed++;
    } else {
        echo "   ⚠️  No transaction history found (may be normal if new)\n";
    }
    
} else {
    echo "   ⚠️  No users in database - skipping user tests\n";
}

$stmt->close();

// ========== Summary ==========
echo "\n" . str_repeat("═", 63) . "\n";
echo "📊 Test Summary\n";
echo str_repeat("═", 63) . "\n";
echo "✅ Tests Passed: $tests_passed\n";
echo "❌ Tests Failed: $tests_failed\n";

if (!empty($errors)) {
    echo "\n❌ Errors Found:\n";
    foreach ($errors as $error) {
        echo "   - $error\n";
    }
} else {
    echo "\n✅ All tests passed! System is ready.\n";
}

echo str_repeat("═", 63) . "\n";

$conn->close();
?>
