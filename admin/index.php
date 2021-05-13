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
                <h3 class="card-title">Product Listing</h3>
              </div>
              <?php   
                if (!empty($_GET['pageno'])) {
                  $pageno = $_GET['pageno'];
                } else {
                  $pageno = 1;
                }
                $numOfrecs = 3;
                $offset = ($pageno - 1) * $numOfrecs;

                if (empty($_POST['search']) && empty($_COOKIE['search'])) {
                  
                  $stmt = $pdo->prepare("SELECT * FROM products ORDER BY id DESC");
                  $stmt->execute();
                  $rawResult = $stmt->fetchAll();
                  $total_pages= ceil(count($rawResult) / $numOfrecs);

                  $stmt = $pdo->prepare("SELECT * FROM products ORDER BY id DESC LIMIT $offset,$numOfrecs");
                  $stmt->execute();
                  $result = $stmt->fetchAll();   
                
                } else {
                  $searchKey = $_POST['search'];
                  $stmt = $pdo->prepare("SELECT * FROM products WHERE name LIKE '%$searchKey%' ORDER BY id DESC");
                  $stmt->execute();
                  $rawResult = $stmt->fetchAll();
                  $total_pages= ceil(count($rawResult) / $numOfrecs);

                  $stmt = $pdo->prepare("SELECT * FROM products WHERE name LIKE '%$searchKey%' ORDER BY id DESC LIMIT $offset,$numOfrecs");
                  $stmt->execute();
                  $result = $stmt->fetchAll();   
                }
              ?>
              <!-- /.card-header -->
              <div class="card-body">
                <div>
                  <a href="product_add.php" type="button" class="btn btn-success">Crete New Product</a>
                </div><br>

                <table class="table table-bordered">
                  <thead>                  
                    <tr>
                      <th style="width: 10px">No</th>
                      <th>Name</th>
                      <th>Description</th>
                      <th style="width: 40px">Category</th>
                      <th style="width: 40px">In Stock</th>
                      <th style="width: 40px">Price</th>
                      <th style="width: 40px">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php 
                    if ($result) {
                      $i = 1;
                      foreach ($result as $value) { ?>
                        <?php 
                          $catstmt = $pdo->prepare("SELECT * FROM categories WHERE id=".$value['category_id']);  
                          $catstmt->execute();
                          $catresult = $catstmt->fetchAll();   
                        ?>
                        <tr>
                          <td><?php echo escape($i); ?></td>
                          <td><?php echo escape($value['name']); ?></td>
                          <td><?php echo escape(substr($value['description'], 0,30)); ?></td>
                          <td><?php echo escape($catresult[0]['name']); ?></td>
                          <td><?php echo escape($value['quantity']); ?></td>
                          <td><?php echo escape($value['price']); ?></td>
                          <td>
                            <div class="row">
                              <div class="btn-group">
                                <a href="product_edit.php?id=<?php echo $value['id']; ?>" type="button" class="btn btn-warning">Edit</a>&nbsp;&nbsp;
                                <a href="product_delete.php?id=<?php echo $value['id'] ?>" type="button" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this item?');">Delete</a>
                              </div>                          
                            </div>
                          </td> 
                        </tr>
                        <?php
                        $i++;
                      }
                    }
                  ?>
                   
                  </tbody>
                </table><br>
                 <nav aria-label="Page navigation example" style="float:right;">
                  <ul class="pagination">
                    <li class="page-item"><a class="page-link" href="?pageno=1">First</a></li>

                    <li class="page-item <?php if($pageno <= 1){echo 'disabled';} ?>">
                      <a class="page-link" href="<?php if($pageno <= 1){ echo '#'; }else {echo '?pageno='.($pageno-1);} ?>">Previous</a></li>


                    <li class="page-item"><a class="page-link" href="#"><?php echo $pageno; ?></a></li>

                    <li class="page-item <?php if($pageno >= $total_pages){echo 'disabled';} ?>"><a class="page-link" href="<?php if($pageno >= $total_pages){ echo '#'; }else {echo "?pageno=".($pageno+1);} ?>">Next</a></li>
                    <li class="page-item"><a class="page-link" href="<?php echo'?pageno='.($total_pages); ?>">Last</a></li>
                  </ul>
                </nav>
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