<?php 
include('security.php');
include('includes/header.php');
include('includes/navbar.php');
?>

<main id="content">
    <!-- Page Heading -->
    <h1 class="page-heading">Mail History</h1>

    <!-- Search Bar -->
    <div style="margin-bottom: 20px;">
        <input type="text" id="myInput" class="form-control" onkeyup="myFunction()" placeholder="Search by user, subject, or mailer..." style="max-width: 300px;">
    </div>

    <!-- Mail History Table -->
    <div class="card">
        <div class="card-header">
            <h3 class="m-0">Sent Emails</h3>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover" id="myTable">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>From</th>
                            <th>To</th>
                            <th>Subject</th>
                            <th>Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            $stmt = mysqli_prepare($conn, "SELECT id, mailer, user, subject, message, date FROM mails ORDER BY date DESC");
                            if ($stmt) {
                                mysqli_stmt_execute($stmt);
                                $result = mysqli_stmt_get_result($stmt);

                                if (mysqli_num_rows($result) > 0) {
                                    while ($row = mysqli_fetch_assoc($result)) {
                        ?>
                        <tr>
                            <td><span class="badge"><?= htmlspecialchars($row['id']); ?></span></td>
                            <td><?= htmlspecialchars($row['mailer']); ?></td>
                            <td><?= htmlspecialchars($row['user']); ?></td>
                            <td><?= htmlspecialchars(substr($row['subject'], 0, 40)); ?></td>
                            <td><?= date('M d, Y H:i', strtotime($row['date'])); ?></td>
                            <td>
                                <form action="mail_v.php" method="POST" style="display: inline;">
                                    <input type="hidden" name="id" value="<?= htmlspecialchars($row['id']); ?>">
                                    <input type="hidden" name="message" value="<?= htmlspecialchars($row['message']); ?>">
                                    <button type="submit" class="btn btn-sm btn-info">View</button>
                                </form>
                            </td>
                        </tr>
                        <?php
                                    }
                                    mysqli_stmt_close($stmt);
                                } else {
                        ?>
                        <tr>
                            <td colspan="6" style="text-align: center; padding: 20px; color: #999;">
                                No emails sent yet
                            </td>
                        </tr>
                        <?php
                                }
                            }
                        ?>
                    </tbody>
                </table>
        </div>
    </div>
</main>

<script>
function myFunction() {
    var input = document.getElementById("myInput");
    var filter = input.value.toUpperCase();
    var table = document.getElementById("myTable");
    var tr = table.getElementsByTagName("tr");
    
    for (var i = 1; i < tr.length; i++) {
        var tds = tr[i].getElementsByTagName("td");
        var found = false;
        for (var j = 0; j < tds.length - 1; j++) {
            if (tds[j].textContent.toUpperCase().indexOf(filter) > -1) {
                found = true;
                break;
            }
        }
        tr[i].style.display = found ? "" : "none";
    }
}
</script>

<?php 
include('includes/script.php');
include('includes/footer.php');
?>

<script>
function myFunction() {
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById("myInput");
  filter = input.value.toUpperCase();
  table = document.getElementById("myTable");
  tr = table.getElementsByTagName("tr");
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[0];
    if (td) {
      txtValue = td.textContent || td.innerText;
      if (txtValue.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }       
  }
}
</script>


<?php 
include('includes/script.php');
include('includes/footer.php');
?>