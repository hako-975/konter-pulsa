<?php 
	require_once 'koneksi.php';
	session_destroy();
	header("Location: ".BASE_URL."login.php");
	exit;
?>