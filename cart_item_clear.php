<?php 
session_start();

unset($_SESSION['cart']['id'.$_GET['pid']]);

header('Location: cart.php');
?>