<?php 
require_once '../koneksi.php';

if (!isset($_SESSION['id_user'])) {
	header("Location: login.php");
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
</head>
<body>
	<a href="user.php">Kembali</a>
	<form method="post">
		<div>
			<label for="username">Username</label>
			<input type="text" name="username" id="username" required>
		</div>
		<div>
			<label for="password">Password</label>
			<input type="password" name="password" id="password" required>
		</div>
		<div>
			<label for="verifikasi_password">Verifikasi Password</label>
			<input type="password" name="verifikasi_password" id="verifikasi_password" required>
		</div>
		<div>
			<label for="nama_lengkap">Nama Lengkap</label>
			<input type="text" name="nama_lengkap" id="nama_lengkap" required>
		</div>
		<div>
			<label for="no_telp_user">No. Telp User</label>
			<input type="number" name="no_telp_user" id="no_telp_user" required>
		</div>
		<div>
			<button type="submit" name="btnTambahUser">Tambah User</button>
		</div>
	</form>
</body>
</html>