<?php 
include('security.php');
include('includes/header.php');
include('includes/navbar.php');
?>

<main id="content">
    <h1 class="page-heading">Homepage Settings</h1>

    <!-- Status Messages -->
    <?php 
        if (isset($_SESSION['success']) && $_SESSION['success'] != '') {
            echo '<div class="alert alert-success">' . htmlspecialchars($_SESSION['success']) . '</div>';
            unset($_SESSION['success']);
        }
        if (isset($_SESSION['status']) && $_SESSION['status'] != '') {
            echo '<div class="alert alert-danger">' . htmlspecialchars($_SESSION['status']) . '</div>';
            unset($_SESSION['status']);
        }
    ?>

    <?php
        $stmt = mysqli_prepare($conn, "SELECT * FROM page_content LIMIT 1");
        if ($stmt) {
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            if ($row = mysqli_fetch_assoc($result)) {
    ?>

    <!-- Site Settings Card -->
    <div class="card" style="max-width: 700px; margin: 0 auto 30px;">
        <div class="card-header">
            <h3 class="m-0">Site Configuration</h3>
        </div>
        <div class="card-body">
            <form action="code.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?= htmlspecialchars($row['id'] ?? ''); ?>">

                <div class="form-group">
                    <label>Website Name *</label>
                    <input type="text" name="sitename" class="form-control" required value="<?= htmlspecialchars($row['site_name'] ?? ''); ?>" placeholder="Enter website name">
                </div>

                <div class="form-group">
                    <label>Phone Number *</label>
                    <input type="text" name="phone" class="form-control" required value="<?= htmlspecialchars($row['phone'] ?? ''); ?>" placeholder="Enter contact phone">
                </div>

                <div class="form-group">
                    <label>Email Address <small>(currently: <?= htmlspecialchars(EMAIL); ?>)</small></label>
                    <select class="form-control" name="email">
                        <option value="<?= htmlspecialchars(EMAIL); ?>">Keep Current</option>
                        <option value="admin@<?= DOMAIN ?>">admin@<?= DOMAIN ?></option>
                        <option value="support@<?= DOMAIN ?>">support@<?= DOMAIN ?></option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Address *</label>
                    <input type="text" name="address" class="form-control" required value="<?= htmlspecialchars($row['address'] ?? ''); ?>" placeholder="Enter business address">
                </div>

                <div class="form-group">
                    <label>BTC Wallet Address</label>
                    <input type="text" name="btc" class="form-control" value="<?= htmlspecialchars(BTC); ?>" placeholder="Enter Bitcoin address">
                </div>

                <div class="form-group">
                    <label>ETH Wallet Address</label>
                    <input type="text" name="eth" class="form-control" value="<?= htmlspecialchars(ETH); ?>" placeholder="Enter Ethereum address">
                </div>

                <div class="form-group">
                    <label>USDT (TRC20) Address</label>
                    <input type="text" name="trc" class="form-control" value="<?= htmlspecialchars(TRC); ?>" placeholder="Enter USDT TRC20 address">
                </div>

                <div class="form-group">
                    <label>USDT (ERC20) Address</label>
                    <input type="text" name="erc" class="form-control" value="<?= htmlspecialchars(ERC); ?>" placeholder="Enter USDT ERC20 address">
                </div>

                <div class="form-group">
                    <label>Referral Commission (%)</label>
                    <input type="number" name="ref" class="form-control" required step="0.01" value="<?= htmlspecialchars($row['ref'] ?? '0'); ?>" placeholder="Referral percentage">
                </div>

                <div class="form-group">
                    <label>Ethereum Withdrawal Message</label>
                    <textarea name="eth_message" class="form-control" rows="3" placeholder="Message to display for ETH withdrawals"><?= htmlspecialchars($row['eth_message'] ?? ''); ?></textarea>
                    <small class="form-text text-muted">This message will be shown to users withdrawing Ethereum and USDT (ERC20).</small>
                </div>

                <div class="form-group">
                    <label>Ethereum Gas Fee Information</label>
                    <textarea name="eth_gas" class="form-control" rows="2" placeholder="Gas fee details for ETH network"><?= htmlspecialchars($row['eth_gas'] ?? ''); ?></textarea>
                    <small class="form-text text-muted">Description of gas fees for Ethereum network transactions.</small>
                </div>

                <div class="form-group">
                    <label>TRON Withdrawal Message</label>
                    <textarea name="tron_message" class="form-control" rows="3" placeholder="Message to display for TRON withdrawals"><?= htmlspecialchars($row['tron_message'] ?? ''); ?></textarea>
                    <small class="form-text text-muted">This message will be shown to users withdrawing TRON and USDT (TRC20).</small>
                </div>

                <div class="form-group">
                    <label>TRON Gas Fee Information</label>
                    <textarea name="tron_gas" class="form-control" rows="2" placeholder="Gas fee details for TRON network"><?= htmlspecialchars($row['tron_gas'] ?? ''); ?></textarea>
                    <small class="form-text text-muted">Description of gas fees for TRON network transactions.</small>
                </div>

                <button type="submit" name="save_site" class="btn btn-primary">Save Settings</button>
            </form>
        </div>
    </div>

    <!-- Logo & Icon Card -->
    <div class="card" style="max-width: 700px; margin: 0 auto;">
        <div class="card-header">
            <h3 class="m-0">Logo & Favicon</h3>
        </div>
        <div class="card-body">
            <form action="code.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?= htmlspecialchars($row['id'] ?? ''); ?>">

                <!-- Logo Section -->
                <div class="form-group">
                    <label>Website Logo</label>
                    <input type="file" name="logo" class="form-control" accept="image/*">
                </div>

                <?php if (!empty($row['logo'])): ?>
                <div style="text-align: center; margin-bottom: 15px;">
                    <img src="../uploads/<?= htmlspecialchars($row['logo']); ?>" alt="logo" style="max-width: 150px; border: 1px solid #ddd; padding: 5px; border-radius: 4px;">
                    <br><br>
                    <button type="submit" name="delete_logo" class="btn btn-danger btn-sm">Delete Logo</button>
                </div>
                <?php endif; ?>

                <!-- Favicon Section -->
                <div class="form-group">
                    <label>Website Favicon</label>
                    <input type="file" name="fav" class="form-control" accept="image/*">
                </div>

                <?php if (!empty($row['fav'])): ?>
                <div style="text-align: center; margin-bottom: 15px;">
                    <img src="../uploads/<?= htmlspecialchars($row['fav']); ?>" alt="favicon" style="max-width: 100px; border: 1px solid #ddd; padding: 5px; border-radius: 4px;">
                    <br><br>
                    <button type="submit" name="delete_fav" class="btn btn-danger btn-sm">Delete Favicon</button>
                </div>
                <?php endif; ?>

                <button type="submit" name="save_logo" class="btn btn-primary">Save Images</button>
            </form>
        </div>
    </div>

    <?php
            mysqli_stmt_close($stmt);
            } else {
    ?>
    <div class="alert alert-warning">
        <strong>No site settings found.</strong> Please contact administrator.
    </div>
    <?php
            }
        }
    ?>
</main>


<?php 
include('includes/script.php');
include('includes/footer.php');
?>