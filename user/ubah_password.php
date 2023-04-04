<?php 
require_once '../koneksi.php';

if (!isset($_SESSION['id_user'])) {
	header("Location: ".BASE_URL."login.php");
	exit;
}

$id_user = htmlspecialchars($_SESSION['id_user']);

$data_profile = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM user WHERE id_user = '$id_user'"));

if (isset($_POST['btnUbahPassword'])) {
	$password_lama = htmlspecialchars($_POST['password_lama']);
	$password_baru = htmlspecialchars($_POST['password_baru']);
	$verifikasi_password_baru = htmlspecialchars($_POST['verifikasi_password_baru']);

	// check password with verify
	if ($password_baru != $verifikasi_password_baru) {
		echo "
			<script>
				alert('Password baru harus sama dengan verifikasi password baru!');
				window.history.back();
			</script>
		";
		exit;
	}

	// check password lama
	if (!password_verify($password_lama, $data_profile['password'])) {
		echo "
			<script>
				alert('Password lama tidak sesuai!');
				window.history.back();
			</script>
		";
		exit;
	}

	$password_baru = password_hash($password_baru, PASSWORD_DEFAULT);

	$ubah_password = mysqli_query($koneksi, "UPDATE user SET password = '$password_baru' WHERE id_user = '$id_user'");

	if ($ubah_password) {
		echo "
			<script>
				alert('Password berhasil diubah!');
				window.location.href='profile.php';
			</script>
		";
		exit;
	} else {
		echo "
			<script>
				alert('Password gagal diubah!');
				window.history.back();
			</script>
		";
		exit;
	}
}

?>

<html>
<head>
	<title>Ubah Password - <?= $data_profile['username']; ?></title>
	<?php include_once '../include/head.php'; ?>
</head>
<body class="bg-gradient">
	<div id="preloader">
      <div class="loader"></div>
    </div>
    <?php include_once '../include/topbar.php' ?>
	<?php include_once '../include/sidebar.php'; ?>
	<div class="main-content">
		<a href="<?= BASE_URL; ?>user/profile.php" class="btn">Kembali</a>
		<div class="my">
			<h1>Ubah Password - <?= $data_profile['username']; ?></h1>
			<form method="post">
				<div class="form-group">
					<label for="password_lama">Password Lama</label>
					<input type="password" name="password_lama" id="password_lama" class="form-input" required>
				</div>
				<div class="form-group">
					<label for="password_baru">Password Baru</label>
					<input type="password" name="password_baru" id="password_baru" class="form-input" required>
				</div>
				<div class="form-group">
					<label for="verifikasi_password_baru">Verifikasi Password Baru</label>
					<input type="password" name="verifikasi_password_baru" id="verifikasi_password_baru" class="form-input" required>
				</div>
				<div class="form-group">
					<button type="submit" name="btnUbahPassword" class="btn">Ubah Password</button>
				</div>
			</form>
		</div>
	</div>
	
    <?php include_once '../include/script.php'; ?>
</body>
</html>