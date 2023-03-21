<?php 
require_once 'koneksi.php';

// check login
if (isset($_SESSION['id_user'])) {
	header("Location: index.php");
	exit;
}

if (isset($_POST['btnLogin'])) {
	$username = htmlspecialchars($_POST['username']);
	$password = htmlspecialchars($_POST['password']);

    // check username
    $check_username = mysqli_query($koneksi, "SELECT * FROM user WHERE username = '$username'");
    if ($data_user = mysqli_fetch_assoc($check_username)) {
        if (password_verify($password, $data_user['password'])) {
            $_SESSION['id_user'] = $data_user['id_user'];
            $_SESSION['hak_akses'] = $data_user['hak_akses'];
            header("Location: index.php");
            exit;
        }
        else
        {
            echo "
                <script>
                    alert('Username atau password yang Anda masukkan salah!')
                    window.location='login.php'
                </script>
            ";
            exit;
        }
    }
    else
    {
        echo "
            <script>
                alert('Username atau password yang Anda masukkan salah!')
                window.location='login.php'
            </script>
        ";
        exit;
    }
}

?>

<html>
<head>
	<title>Login</title>
</head>
<body>
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
			<button type="submit" name="btnLogin">Login</button>
		</div>
	</form>
</body>
</html>