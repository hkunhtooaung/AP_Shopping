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

                // sum() to sum the quantity from product_id
                //  GROUP BY product_ID column and aggregate amount column using SUM function.
                $stmt = $pdo->prepare("SELECT product_id, sum(quantity) FROM sale_order_detail GROUP BY product_id ORDER BY sum(quantity) DESC LIMIT 3");
                $stmt->execute();
                $result = $stmt->fetchAll();
                // echo "<pre>";
                // print_r($result);
                ?>
              <!-- /.card-header -->
              <div class="card-body">

                <table class="display" style="width:100%" id="d-table">
                  <thead>                  
                    <tr>
                      <th style="width: 10px">No</th>
                      <th>User Name</th>
                      <th>Total Amount</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php 
                    if ($result) {
                      $i = 1;
                      foreach ($result as $value) { ?>
                        <?php 
                          $pStmt = $pdo->prepare("SELECT * FROM products WHERE id=".$value['product_id']);  
                          $pStmt->execute();
                          $pResult = $pStmt->fetchAll();   
                        ?>
                        <tr>
                          <td><?php echo escape($i); ?></td>
                          <td><?php echo escape($pResult[0]['name']); ?></td>
                          <td><?php echo escape($value['sum(quantity)']); ?></td>
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