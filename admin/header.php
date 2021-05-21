<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">

  <title>Ap Shopping | Starter</title>

  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">

  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">

  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">

</head>
<body class="hold-transition sidebar-mini">

<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>

    <!-- SEARCH FORM -->
    <?php 
      // session_start();
      $link = $_SERVER['PHP_SELF'];
      $link_array = explode('/', $link);
      $page = end($link_array);
    ?>
    <?php if ($page == 'index.php' || $page == 'category.php' || $page == 'user_index.php') { ?>
      <?php if ($page != 'order_list.php' && $page != 'weekly_report.php' && $page != 'montyly_report.php') { ?>
      <form class="form-inline ml-3" method="post" 
      <?php if ($page == 'index.php') :?> 
        action="index.php"
      <?php elseif($page == 'category.php'): ?>
        action="category.php"
      <?php elseif($page == 'user_index.php'): ?>
      action="user_index.php"
      <?php endif; ?>
      >
    <?php } ?>
    
      
        <input name="_token" type="hidden" value="<?php echo $_SESSION['_token']; ?>">
        <div class="">
          <input class="form-control form-control-navbar" type="search" placeholder="Search" name="search">
        </div>
      </div>
    </form>
    <?php } ?>
    

  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="#" class="brand-link">
      <img src="dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light">Blog panel</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block"><?php echo $_SESSION['username']; ?></a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item">
            <a href="index.php" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Products
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="category.php" class="nav-link">
              <i class="nav-icon fas fa-list"></i>
              <p>
                Categories
              </p>
            </a>
          </li>          
          <li class="nav-item">
            <a href="user_index.php" class="nav-link">
              <i class="nav-icon fas fa-user"></i>
              <p>
                Users
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="order_list.php" class="nav-link">
              <i class="nav-icon fas fa-table"></i>
              <p>
                Order List
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="weekly_report.php" class="nav-link">
              
              <p>
                >> Weekly Report
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="monthly_report.php" class="nav-link">
              
              <p>
                >> Monthly Report
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="royal_customer.php" class="nav-link">
              
              <p>
                >> Royal Customer
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="best_seller_items.php" class="nav-link">
              
              <p>
                >> Best Seller Item
              </p>
            </a>
          </li>
           


        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      
    </div>
    <!-- /.content-header -->