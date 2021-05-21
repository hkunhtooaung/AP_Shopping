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
?>
<?php include('header.php'); ?>
    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Royal Users</h3>
              </div>
              <?php
                $currentDate = date("Y-m-d");
                $stmt = $pdo->prepare("SELECT * FROM sale_order WHERE total_price > 300000 GROUP BY user_id ORDER BY id DESC");
                $stmt->execute();
                $result = $stmt->fetchAll();
                echo "<pre>";
              ?>
              <!-- /.card-header -->
              <div class="card-body">
                <table class="table table-bordered" id="d-table">
                  <thead>
                    <tr>
                      <th style="width: 10px">#</th>
                      <th>UserID</th>
                      <th>Total Amount</th>
                      <th>Order Date</th>
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
                          <td><?php echo $i;?></td>
                          <td><?php echo escape($userResult[0]['name'])?></td>
                          <td><?php echo escape($value['total_price'])?></td>
                          <td><?php echo escape(date("Y-m-d",strtotime($value['order_date'])))?></td>
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

            </div>
            <!-- /.card -->
          </div>
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->

  <?php include('footer.html')?>

  <script>
  $( document ).ready(function() {
    $('#d-table').DataTable();
  });
  </script>
