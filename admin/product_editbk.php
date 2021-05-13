<?php 
session_start();
require '../config/config.php';
require '../config/common.php';


if (empty($_SESSION['user_id']) && empty($_SESSION['logged_in'])) {
    echo header("Location: login.php");
}
    // print_r($result);
if ($_POST) {
    if (empty($_POST['name']) && empty($_POST['description']) && empty($_POST['category'])
	      && empty($_POST['quanity']) && empty($_POST['price']) && empty($_FILES['image'])) {
	    if (empty($_POST['name'])) {
	      $nameError = 'Name should not be empty';
	    }
	    if (empty($_POST['description'])) {
	    $descError = 'Description should not be empty';
	    }
	    if (empty($_POST['category'])) {
	    $catError = 'category should not be empty';
	    }
	    if (empty($_POST['qty'])) {
	    $qtyError = 'quantity should not be empty';
	    } elseif ($_POST['qty'] && is_numeric($_POST['qty']) != 1) {
	    $qtyError = 'quantity should be integer value';
	    }   

	    if (empty($_POST['price'])) {
	    $priceError = 'price should not be empty';
	    } elseif ($_POST['price'] && is_numeric($_POST['price']) != 1) {
	    $priceError = 'price should be integer value';
	    }

	    if (empty($_FILES['image'])) {
	    $imageError = 'image should not be empty';
	    }

    } else {
	    if ($_FILES['image']['name'] != null) {
	    	$file = 'images/'.($_FILES['image']['name']);
		    $imageType = pathinfo($file,PATHINFO_EXTENSION);

		    if ($imageType != 'jpg' && $imageType != 'jpeg' && $imageType != 'png') {
		      echo "<script>alert('Image should jpg, jpeg and png')</script>";
		    } else {//imagevalidation success
		      $name = $_POST['name'];
		      $description = $_POST['description'];
		      $category = $_POST['category'];
		      $description = $_POST['description'];
		      $quantity = $_POST['qty'];
		      $price = $_POST['price'];
		      $image = $_FILES['image']['name']; 

		      move_uploaded_file($_FILES['image']['tmp_name'], $file);

		      $stmt = $pdo->prepare("UPDATE products SET name=:name,description=:description,category_id=:category,quantity=:quantity,price=:price,image=:image WHERE id=:id") ;

		      $result = $stmt->execute(
		        array(':name'=>$name,':description'=>$description,':category'=>$category,':quantity'=>$quantity,':price'=>$price,':image'=>$image)
		      );

		      if ($result) {
		         echo "<script>alert('Product Is Updated');location.href='index.php';</script>";
		      }
		  	}

	    } else {
	    	$id = $_POST['id'];
	    	$name = $_POST['name'];
		    $description = $_POST['description'];
		    $category = $_POST['category'];
		    $description = $_POST['description'];
		    $quantity = $_POST['qty'];
		    $price = $_POST['price'];

	    	$stmt = $pdo->prepare("UPDATE products SET name=:name,description=:description,category_id=:category,quantity=:quantity,price=:price WHERE id=:id");

	      $result = $stmt->execute(
	        array(':name'=>$name,':description'=>$description,':category'=>$category,':quantity'=>$quantity,':price'=>$price,'id'=>	$id)
	      );

	      if ($result) {
	         echo "<script>alert('Product  Is Updated');location.href='index.php';</script>";
	      }
	    }
    }
}

$stmt = $pdo->prepare("SELECT * FROM products WHERE id=".$_GET['id']);  
$stmt->execute();
$result = $stmt->fetchAll();
?>
<?php include("header.php");?>
    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12 ">
            <div class="card">
              <div class="card-body">
                 <form class="" action="product_add.php" method="post" enctype="multipart/form-data">
                  
                  <input name="_token" type="hidden" value="<?php echo $_SESSION['_token']; ?>">
                  <input name="id" type="hidden" value="<?php echo $result[0]['id']; ?>">
                  <div class="form-group">
                    <label for="">Name</label><p style="color: red; margin:0; padding: 0;"><font size="2"> <?php echo empty($nameError) ? '' : '* '.$nameError; ?></font></p>
                    <input type="text" name="name" class="form-control" value="<?php echo escape($result[0]['name'])  ?>">
                  </div>
                  
                  <div class="form-group">
                  <label for="">Description</label><p style="color: red; margin:0; padding: 0;"><font size="2"> <?php echo empty($descError) ? '' : '* '.$descError; ?></font></p>
                  <textarea class="form-control" name="description" rows="8" cols="30"><?php echo escape($result[0]['description']) ?></textarea>
                  </div>
                  <?php
                    $catstmt = $pdo->prepare("SELECT * FROM categories");  
                    $catstmt->execute();
                    $catResult = $catstmt->fetchAll();
                  ?>
                  <div class="form-group">
                    <label for="">Category</label><p style="color: red; margin:0; padding: 0;"><font size="2"> <?php echo empty($catError) ? '' : '* '.$catError; ?></font></p>
                    <select class="form-control" name="category">
                      <option value="">Select Category</option>
                      <?php foreach($catResult   as $value) { ?>
                        <?php if ($value['id'] == $result[0]['category_id']): ?>
                        	<option value="<?php echo $value['id'] ?>" selected><?php echo $value['name'] ?></option>
                        <? else : ?>
							<option value="<?php echo $value['id'] ?>"><?php echo $value['name'] ?></option>
                    	<?php endif; ?>
                      <?php } ?>

                    </select>
                  </div>
                  
                  <div class="form-group">
                    <label for="">Quantity</label><p style="color: red; margin:0; padding: 0;"><font size="2"> <?php echo empty($qtyError) ? '' : '* '.$qtyError; ?></font></p>
                  <input type="text" name="qty" value="<?php echo escape($result[0]['quantity']) ?>" class="form-control">
                  </div>

                  <div class="form-group">
                    <label for="">Price</label><p style="color: red; margin:0; padding: 0;"><font size="2"> <?php echo empty($priceError) ? '' : '* '.$priceError; ?></font></p>
                  <input type="ntextmber" name="price" value="<?php echo escape($result[0]['price']) ?>" class="form-control">
                  </div>

                  <div class="form-group">
                  	<label for="">Image</label><br>
                  	<img src="images/<?php echo escape($result[0]['image']) ?>" width="150" height="150">
                    <p style="color: red; margin:0; padding: 0;"><font size="2"> <?php echo empty($imageError) ? '' : '* '.$imageError; ?></font></p><br>
                  <input type="file" name="image" value="">
                  </div>

                  <div class="form-group">
                    <input type="submit" class="btn btn-success" name="" value="SUBMIT">
                    <a href="category.php" class="btn btn-warning">Back</a>
                  </div>
                </form>
              </div>
            </div>
            <!-- /.card -->
          </div>
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
<?php include('footer.html'); ?>