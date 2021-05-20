<?php 
session_start();
require 'config/config.php';



	if ($_POST) {
	$id = $_POST['id'];
	$quantity = $_POST['qty'];

	$stmt = $pdo->prepare("SELECT * FROM products WHERE id=".$id);
	$stmt->execute();
	$result = $stmt->fetch(PDO::FETCH_ASSOC);
	
	

	if ($quantity > $result['quantity']) {
		echo "<script>alert('not engough stock');location.href='product_detail.php?id=$id';</script>";
		
	} else {
		
		if (isset($_SESSION['cart']['id'.$id])) {

			$qty = $_SESSION['cart']['id'.$id];
			$qty += $quantity;

			if ($qty > $result['quantity']) {
				echo "<script>alert('not engough stock');location.href='cart.php?id=$id';</script>";
			} else {
				$_SESSION['cart']['id'.$id] += $quantity;
			}

		} else {
			$_SESSION['cart']['id'.$id] = $quantity;
			
		}
		echo "<script>location.href='cart.php?id=$id';</script>";
	}

	

	// header("Location: product_detail.php?id=".$id);

}
?>