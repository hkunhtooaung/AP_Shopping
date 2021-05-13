<?php 
require '../config/config.php';

$stmt = $pdo->prepare("DELETE FROM categories WHERE id=".$_GET['id']);
$stmt->execute();

header("location: category.php");
?>