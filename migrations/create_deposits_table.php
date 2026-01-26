<?php
/**
 * MIGRATION HELPER - Deposits Using Existing Transaction Table
 * 
 * Deposits are stored in the existing 'transaction' table with:
 * - name: currency (BTC, ETH, USDT (TRC20), USDT (ERC20), LTC)
 * - status: 'deposit'
 * - gate_way: 1 (indicates Balance funding)
 * - proof: path to receipt file (uploads/proofs/)
 * - serial: 0 (Pending), 1 (Approved), 2 (Declined)
 * - All other columns set to NULL by default
 */

echo "✓ Deposit system uses existing 'transaction' table\n";
echo "✓ Receipt uploads stored in: uploads/proofs/\n";
echo "✓ No migration needed - table already exists\n";
?>

