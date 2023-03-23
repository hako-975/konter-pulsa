<?php 
require_once 'koneksi.php';

if (!isset($_SESSION['id_user'])) {
	header("Location: login.php");
	exit;
}

?>

<html>
<head>
	<title>Dashboard</title>
</head>
<body>
	<nav>
		<ul>
			<li>
				<a href="user/profile.php">Profile</a>
			</li>
			<li>
				<a href="user/user.php">User</a>
			</li>
			<li>
				<a href="jenis_barang/jenis_barang.php">Jenis Barang</a>
			</li>
			<li>
				<a href="barang/barang.php">Barang</a>
			</li>
			<li>
				<a href="supplier/supplier.php">Supplier</a>
			</li>
			<li>
				<a href="logout.php">Logout</a>
			</li>
		</ul>
	</nav>
</body>
</html>