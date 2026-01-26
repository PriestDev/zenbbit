<?php 
include('security.php');
include('includes/header.php');
require '../details.php';
include('includes/navbar.php');
?>

<main id="content">
    <!-- Page Heading -->
    <h1 class="page-heading">Send Email</h1>

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

    <!-- Mail Form Card -->
    <div class="card" style="max-width: 600px; margin: 0 auto;">
        <div class="card-header">
            <h3 class="m-0">Compose Email</h3>
        </div>
        <div class="card-body">
            <form action="code.php" method="POST">
                <div class="form-group">
                    <label>From Address *</label>
                    <select class="form-control" name="mailer" required>
                        <option value="">-- Select mailer account --</option>
                        <option value="admin@<?= DOMAIN ?>">admin@<?= DOMAIN ?></option>
                        <option value="support@<?= DOMAIN ?>">support@<?= DOMAIN ?></option>
                        <option value="info@<?= DOMAIN ?>">info@<?= DOMAIN ?></option>
                        <option value="no-reply@<?= DOMAIN ?>">no-reply@<?= DOMAIN ?></option>
                        <option value="kyc@<?= DOMAIN ?>">kyc@<?= DOMAIN ?></option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Send To *</label>
                    <?php
                        $stmt = mysqli_prepare($conn, "SELECT id, email FROM user ORDER BY email");
                        if ($stmt) {
                            mysqli_stmt_execute($stmt);
                            $result = mysqli_stmt_get_result($stmt);
                    ?>
                    <select class="form-control" name="email" required>
                        <option value="">-- Select recipient --</option>
                        <?php
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo '<option value="' . htmlspecialchars($row['email']) . '">' . htmlspecialchars($row['email']) . '</option>';
                            }
                            mysqli_stmt_close($stmt);
                        ?>
                    </select>
                    <?php } ?>
                </div>

                <div class="form-group">
                    <label>Subject *</label>
                    <input type="text" name="subject" required class="form-control" placeholder="Email subject">
                </div>

                <div class="form-group">
                    <label>Message *</label>
                    <textarea class="form-control" required name="message" rows="8" placeholder="Email content"></textarea>
                </div>

                <div style="display: flex; gap: 10px;">
                    <button type="submit" name="mail" class="btn btn-primary">Send Email</button>
                    <button type="reset" class="btn btn-secondary">Clear</button>
                </div>
            </form>
        </div>
    </div>
</main>

<?php 
include('includes/script.php');
include('includes/footer.php');
?>
        </div>
        <div class="modal-footer">
          <button type="submit" name="mail" required class="btn btn-dark">Send</button>
        </div>
     </form>
     </div>
      </div>
      </center>
  </div>
</div>
<script src="../ckeditor/ckeditor.js"></script>
 <script>
     CKEDITOR.replace('message');
 </script>

<?php 
include('includes/script.php');
include('includes/footer.php');
?>