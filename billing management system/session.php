<?php 
session_start();
$_SESSION['user'];
if (!isset($_SESSION['user'])) {
	header('location:login.php');
}

?>