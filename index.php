<?php 
require_once 'koneksi.php';

if (!isset($_SESSION['id_user'])) {
	header("Location: login.php");
	exit;
}

$id_user = htmlspecialchars($_SESSION['id_user']);
$data_profile = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM user WHERE id_user = '$id_user'"));
?>

<html>
<head>
	<title>Dashboard - Konter Pulsa</title>
	<?php include_once 'include/head.php'; ?>
</head>
<body class="bg-gradient">
	<div id="preloader">
      <div class="loader"></div>
    </div>
	<?php include_once 'include/topbar.php' ?>
	<?php include_once 'include/sidebar.php'; ?>
	<div class="main-content">
		<h1>Dashboard</h1>
	</div>
	
    <?php include_once 'include/script.php'; ?>
</body>
</html>