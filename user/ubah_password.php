<?php 
require_once '../koneksi.php';

if (!isset($_SESSION['id_user'])) {
	header("Location: login.php");
	exit;
}

$id_user = htmlspecialchars($_SESSION['id_user']);

$data_user = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM user WHERE id_user = '$id_user'"));

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
	if (!password_verify($password_lama, $data_user['password'])) {
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
	} else {
		echo "
			<script>
				alert('Password gagal diubah!');
				window.history.back();
			</script>
		";
	}
}

?>

<html>
<head>
	<title>Ubah Password - <?= $data_user['username']; ?></title>
</head>
<body>
	<a href="profile.php">Kembali</a>
	<form method="post">
		<div>
			<label for="password_lama">Password Lama</label>
			<input type="password" name="password_lama" id="password_lama" required>
		</div>
		<div>
			<label for="password_baru">Password Baru</label>
			<input type="password" name="password_baru" id="password_baru" required>
		</div>
		<div>
			<label for="verifikasi_password_baru">Verifikasi Password Baru</label>
			<input type="password" name="verifikasi_password_baru" id="verifikasi_password_baru" required>
		</div>
		<div>
			<button type="submit" name="btnUbahPassword">Ubah Password</button>
		</div>
	</form>
</body>
</html>