<?php 
include('security.php');

include('includes/header.php');
include('includes/navbar.php');
   ?>

<!-- Modal -->
<div class="modal show fade" id="myModal">
    <div class="modal-header">
        <a class="close" data-dismiss="modal">×</a>
        <h3>Modal header</h3>
    </div>
    <div class="modal-body">
        <p>One fine body…</p>
    </div>
    <div class="modal-footer">
        <a href="#" class="btn">Close</a>
        <a href="#" class="btn btn-primary">Save changes</a>
    </div>
</div>

 <div class="card-body">            
  <div class="table-responsive">
      <div class="mb-3">
        <input type="text" id="myInput" class="form-control" onkeyup="myFunction()" placeholder="Search User in table.." title="Type in a User">
      </div>
    <table class="table table-bordered" id="myTable" width="100%" cellspacing="0">
      <thead>
        <tr>
          <th>ID</th>
          <th>Mailer</th>
          <th>User</th>
          <th>Subject</th>
          <th>Message</th>
          <th>Date</th>
        </tr>
    </thead>
    <tbody>
      <?php 
       $sql = "SELECT * FROM mails ORDER BY id DESC";
      $run = mysqli_query($conn, $sql);

    if (mysqli_num_rows($run) > 0) {
      while ($row = mysqli_fetch_assoc($run)) {     
       ?>
        <tr>
          <td> <?php echo $row['id']; ?></td>
          <td><?php echo $row['mailer']; ?></td>
          <td><?php echo $row['user']; ?></td>
          <td><?php echo $row['subject']; ?></td>
          <td>
             <form action="mail_v.php" method="POST">
              <div style="display: flex;">
                <input type="hidden" name="id" value=" <?php echo $row['id']; ?> ">
                <input type="hidden" name="message" value=" <?php echo $row['message']; ?> ">
                <button type="submit" name="edit_plan" class="btn btn-dark btn-sm" style="padding: 4px; margin: 3px;"> View Message </button>
              </div>
            </form>
          </td>
          <td><?php echo $row['date']; ?></td>
        </tr>

       <?php
      }
    } else {
      echo "No Record Found";
    }
  ?>
      </tbody>
    </table>
  </div>
</div>

<script type="text/javascript">
    $(window).on('load', function() {
        $('#myModal').modal('show');
    });
</script>

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