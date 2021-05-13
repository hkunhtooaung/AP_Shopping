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
  
  if ($_POST) {
    if (empty($_POST['name']) || empty($_POST['email']) || empty($_POST['phone']) || empty($_POST['address']) || empty($_POST['password']) || strlen($_POST['password']) < 4) {
    if (empty($_POST['name'])) {
      $nameError = 'Name cannot be null';
    }
    if (empty($_POST['email'])) {
      $emailError = 'Email cannot be null';
    }
    if (empty($_POST['phone'])) {
      $phoneError = 'Phone cannot be null';
    }
    if (empty($_POST['address'])) {
      $addressError = 'Address cannot be null';
    }
    if (empty($_POST['password'])) {
      $passwordError = 'Password cannot be null';
    }
    if(strlen($_POST['password']) < 4){
      $passwordError = 'Password should be 4 characters at least';
    }
  } else {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];

    
    if (empty($_POST['admin'])) {
      $admin = 0;
    } else {
      $admin = $_POST['admin'];
    }

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email=:email");

    $stmt->bindValue(':email', $email);
    $result = $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
      echo "<script>alert('Email Duplicated')</script>";
    } else {
        $stmt = $pdo->prepare("INSERT INTO users(password,name,email,phone,address,role) VALUES (
          :password,:name,:email,:phone,:address,:admin)");
        $result = $stmt->execute(
          array(':password'=>$password,':name'=>$name,'email'=>$email,':phone'=>$phone,':address'=>$address,':admin'=>$admin)
        );

        if ($result) {
          echo "<script>alert('successfully created, that user can now login');window.location.href='user_index.php';</script>";
        }
      }
    }
  }
  
?>

<?php include("header.php");?>
    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12 ">
            <div class="card">
              <div class="card-body">
                 <form class="" action="" method="post">
                  <input name="_token" type="hidden" value="<?php echo $_SESSION['_token']; ?>">
                  <div class="form-group">
                    <label for="">Name</label><p style="color:red"><?php echo empty($nameError) ? '' : '*'.$nameError; ?></p>
                    <input type="text" class="form-control" name="name" value="" >
                  </div>
                  <div class="form-group">
                    <label for="">Email</label><p style="color:red"><?php echo empty($emailError) ? '' : '*'.$emailError; ?></p>
                    <input type="email" class="form-control" name="email" value="">
                  </div>
                  <div class="form-group">
                    <label for="">Phone</label><p style="color:red"><?php echo empty($phoneError) ? '' : '*'.$phoneError; ?></p>
                    <input type="text" class="form-control" name="phone" value="" >
                  </div>
                  <div class="form-group">
                    <label for="">Address</label><p style="color:red"><?php echo empty($addressError) ? '' : '*'.$addressError; ?></p>
                    <input type="text" class="form-control" name="address" value="" >
                  </div>
                  <div class="form-group">
                    <label for="">Password</label><p style="color:red"><?php echo empty($passwordError) ? '' : '*'.$passwordError; ?></p>
                    <input type="password" name="password" class="form-control">
                  </div>
                  <div class="form-group">
                    <label for="image"><strong><font size="5">Role</font></strong></label><br>
                    <b>Admin</b>&nbsp;<input type="checkbox" name="admin" value="1">
                  </div>
                  <div class="form-group">
                    <input type="submit" class="btn btn-primary" name="" value="Create">
                    <a href="user_index.php" class="btn btn-secondary">Back</a>
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