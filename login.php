<?php 
require_once 'koneksi.php';

// check login
if (isset($_SESSION['id_user'])) {
    header("Location: ".BASE_URL."index.php");
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
	<title>Login - Konter Pulsa</title>
    <?php include_once 'include/head.php'; ?>
</head>
<body class="bg-gradient">
    <div id="preloader">
      <div class="loader"></div>
    </div>
    <div class="form-login">
        <img src="<?= BASE_URL; ?>assets/img/logo.png" alt="logo" width="100" class="logo">
        <h2 class="text-center">Form Login <br> Konter Pulsa</h2>
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
                <button type="submit" class="form-input bg-button" name="btnLogin">Login</button>
            </div>
        </form>
    </div>
    <?php include_once 'include/script.php'; ?>
</body>
</html>