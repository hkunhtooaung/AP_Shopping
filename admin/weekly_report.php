<?php 
session_start();
require '../config/config.php';
require '../config/common.php';
error_reporting(1);
if ($_SESSION['role'] === "0") {
  echo "<script>alert('You are not an admin, Sorry');window.location.href='../index.php'</script>";
}

if (empty($_SESSION['user_id']) && empty($_SESSION['logged_in'])) {
    echo header("Location: login.php");
}

if ($_POST['search']) {
  setcookie('search', $_POST['search'], time() + (86400 * 30), "/");

} else {
  if (empty($_GET['pageno'])) {
    unset($_COOKIE['search']);
    setcookie('search', null, -1, '/');
  }
}

?>
<?php include("header.php");?>
    <!-- Main content -->
    <div class="content">
      <div class="container">
        <div class="row">
          <div class="col-md-12 ">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Weekly Report</h3>
              </div>
              <?php   
                // $currentDate = date("Y-m-d");
                // $fromDate = date("Y-m-d", strtotime($currentDate . '+1 day'));
                // $toDate = date("Y-m-d", strtotime($currentDate . '-7 day'));

              	// 	$stmt = $pdo->prepare("SELECT * FROM sale_order WHERE order_date>=:todate AND order_date<:from_date  ORDER BY id DESC");
                //   	$stmt->execute(
                //   		[':from_date'=>$fromDate , ':todate'=>$toDate]
                //   	);
                //   	$result = $stmt->fetchAll();


                // week function to get the week number of the date values
                // now function to get the current date
                $stmt = $pdo->prepare("SELECT * FROM sale_order WHERE week(order_date) = week(now())");
                $stmt->execute();
                $result = $stmt->fetchAll();

              ?>
              <!-- /.card-header -->
              <div class="card-body">

                <table class="display" style="width:100%" id="d-table">
                  <thead>                  
                    <tr>
                      <th style="width: 10px">No</th>
                      <th>User Name</th>
                      <th>Total Amount</th>
                      <th style="width: 40px">Order Date</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php 
                    if ($result) {
                      $i = 1;
                      foreach ($result as $value) { ?>
                        <?php 
                          $userStmt = $pdo->prepare("SELECT * FROM users WHERE id=".$value['user_id']);  
                          $userStmt->execute();
                          $userResult = $userStmt->fetchAll();   
                        ?>
                        <tr>
                          <td><?php echo escape($i); ?></td>
                          <td><?php echo escape($userResult[0]['name']); ?></td>
                          <td><?php echo escape($value['total_price']); ?></td>
                          <td><?php echo escape(date("Y-m-d", strtotime($value['order_date']))); ?></td>
                        </tr>
                        <?php
                        $i++;
                      }
                    }
                  ?>
                   
                  </tbody>
                </table><br>
                 
              </div>


              <!-- /.card-body -->
            <!-- /.card -->
            </div>
            <!-- /.card -->
          </div>
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->

<?php include('footer.html'); ?>

<script type="">
	$(document).ready(function() {
	    $('#d-table').DataTable({
	    	"paginationType": "full_numbers"
	    });
	} );
</script>