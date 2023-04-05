<?php 
require_once '../koneksi.php';

if (!isset($_SESSION['id_user'])) {
	header("Location: ".BASE_URL."login.php");
	exit;
}

if ($_SESSION['hak_akses'] != 'administrator') {
	echo "
		<script>
			alert('Tidak dapat melakukan perubahan selain Administrator!');
			window.history.back();
		</script>
	";
	exit;
}

$id_user = htmlspecialchars($_SESSION['id_user']);
$data_profile = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM user WHERE id_user = '$id_user'"));

if (isset($_POST['btnTambahUser'])) {
	$username = htmlspecialchars($_POST['username']);
	$password = htmlspecialchars($_POST['password']);
	$verifikasi_password = htmlspecialchars($_POST['verifikasi_password']);
	$nama_lengkap = htmlspecialchars($_POST['nama_lengkap']);
	$no_telp_user = htmlspecialchars($_POST['no_telp_user']);

	// check username 
	$check_username = mysqli_query($koneksi, "SELECT * FROM user WHERE username = '$username'");
	if (mysqli_num_rows($check_username)) {
		echo "
			<script>
				alert('Username telah digunakan!');
				window.history.back();
			</script>
		";
		exit;
	}

	// check password with verify
	if ($password != $verifikasi_password) {
		echo "
			<script>
				alert('Password harus sama dengan verifikasi password!');
				window.history.back();
			</script>
		";
		exit;
	}

	$password = password_hash($password, PASSWORD_DEFAULT);

	$tambah_user = mysqli_query($koneksi, "INSERT INTO user VALUES('', '$username', '$password', 'operator', '$nama_lengkap', '$no_telp_user')");

	if ($tambah_user) {
		echo "
			<script>
				alert('User berhasil ditambahkan!');
				window.location.href='user.php';
			</script>
		";
	} else {
		echo "
			<script>
				alert('User gagal ditambahkan!');
				window.history.back();
			</script>
		";
	}
}

?>

<html>
<head>
	<title>Tambah User</title>
	<?php include_once '../include/head.php'; ?>
</head>
<body class="bg-gradient">
	<div id="preloader">
      <div class="loader"></div>
    </div>
    <?php include_once '../include/topbar.php' ?>
	<?php include_once '../include/sidebar.php'; ?>
	<div class="main-content">
		<a href="<?= BASE_URL; ?>user/user.php" class="btn">Kembali</a>
		<div class="my">
			<h1>Tambah User</h1>
			<form method="post">
				<div class="form-group">
					<label for="username">Username</label>
					<input type="text" name="username" id="username" class="form-input" required>
				</div>
				<div class="form-group">
					<label for="password">Password</label>
					<input type="password" name="password" id="password" class="form-input" required>
				</div>
				<div class="form-group">
					<label for="verifikasi_password">Verifikasi Password</label>
					<input type="password" name="verifikasi_password" id="verifikasi_password" class="form-input" required>
				</div>
				<div class="form-group">
					<label for="nama_lengkap">Nama Lengkap</label>
					<input type="text" name="nama_lengkap" id="nama_lengkap" class="form-input" required>
				</div>
				<div class="form-group">
					<label for="no_telp_user">No. Telp User</label>
					<input type="number" name="no_telp_user" id="no_telp_user" class="form-input" required>
				</div>
				<div class="form-group">
					<button type="submit" name="btnTambahUser" class="btn">Tambah User</button>
				</div>
			</form>
		</div>
	</div>

    <?php include_once '../include/script.php'; ?>
</body>
</html>