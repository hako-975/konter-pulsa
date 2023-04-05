<?php 
require_once '../koneksi.php';

if (!isset($_SESSION['id_user'])) {
	header("Location: login.php");
	exit;
}

$id_user = htmlspecialchars($_SESSION['id_user']);
$data_profile = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM user WHERE id_user = '$id_user'"));

$id_transaksi = htmlspecialchars($_GET['id_transaksi']);
$id_detail_transaksi = htmlspecialchars($_GET['id_detail_transaksi']);

$barang = mysqli_query($koneksi, "SELECT * FROM barang INNER JOIN jenis_barang ON barang.id_jenis_barang = jenis_barang.id_jenis_barang ORDER BY nama_barang ASC");

// Convert the result set to an array
$barang_arr = array();
while ($row = mysqli_fetch_assoc($barang)) {
    $barang_arr[] = $row;
}

// Convert the array to a JSON string
$barangJson = json_encode($barang_arr);

$data_detail_transaksi = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM detail_transaksi INNER JOIN barang ON detail_transaksi.id_barang = barang.id_barang WHERE id_detail_transaksi = '$id_detail_transaksi'"));


if ($data_detail_transaksi == null) {
	echo "
		<script>
			window.location.href='transaksi.php';
		</script>
	";
	exit;
}

if (isset($_POST['btnUbahDetailTransaksi'])) {
	$id_barang = htmlspecialchars($_POST['id_barang']);
	$kuantitas = htmlspecialchars($_POST['kuantitas']);
	$subtotal = htmlspecialchars($_POST['subtotal']);

	if ($id_barang == 0) {
		echo "
			<script>
				alert('Pilih Barang terlebih dahulu!');
				window.history.back();
			</script>
		";
		exit;
	}

	$ubah_detail_transaksi = mysqli_query($koneksi, "UPDATE detail_transaksi SET id_barang = '$id_barang', kuantitas = '$kuantitas', subtotal = '$subtotal' WHERE id_detail_transaksi = '$id_detail_transaksi'");

	$get_total_harga = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(subtotal) as total_harga FROM detail_transaksi WHERE id_transaksi = '$id_transaksi'"));
	$total_harga = $get_total_harga['total_harga'];
	$update_total_harga = mysqli_query($koneksi, "UPDATE transaksi SET total_harga = '$total_harga' WHERE id_transaksi = '$id_transaksi'");

	$kuantitas_old = $data_detail_transaksi['kuantitas'];
	$id_barang_old = $data_detail_transaksi['id_barang'];
	
	if ($id_barang_old == $id_barang) {
		mysqli_query($koneksi, "UPDATE barang SET stok_barang = (stok_barang + '$kuantitas_old') - '$kuantitas' WHERE id_barang = '$id_barang'");
	}

	if ($id_barang_old != $id_barang) {
		mysqli_query($koneksi, "UPDATE barang SET stok_barang = (stok_barang + '$kuantitas_old') WHERE id_barang = '$id_barang_old'");
		mysqli_query($koneksi, "UPDATE barang SET stok_barang = stok_barang - '$kuantitas' WHERE id_barang = '$id_barang'");
	}


	if ($ubah_detail_transaksi) {
		echo "
			<script>
				alert('Transaksi Barang berhasil diubah!');
				window.location.href='detail_transaksi.php?id_transaksi=$id_transaksi';
			</script>
		";
	} else {
		echo "
			<script>
				alert('Transaksi Barang gagal diubah!');
				window.history.back();
			</script>
		";
	}
}

?>

<html>
<head>
	<title>Ubah Transaksi Barang - <?= $data_detail_transaksi['nama_barang']; ?></title>
	<?php include_once '../include/head.php'; ?>
</head>
<body class="bg-gradient">
	<div id="preloader">
      <div class="loader"></div>
    </div>
    <?php include_once '../include/topbar.php' ?>
	<?php include_once '../include/sidebar.php'; ?>
	<div class="main-content">
		<a href="<?= BASE_URL; ?>transaksi/detail_transaksi.php?id_transaksi=<?= $id_transaksi; ?>" class="btn">Kembali</a>
		<div class="my">
			<h1>Ubah Transaksi Barang - <?= $data_detail_transaksi['nama_barang']; ?></h1>
			<form method="post">
				<div class="form-group">
					<label for="id_barang">Nama Barang</label>
					<select name="id_barang" id="id_barang" class="form-input">
						<option value="<?= $data_detail_transaksi['id_barang']; ?>"><?= $data_detail_transaksi['nama_barang']; ?></option>
						<?php foreach ($barang as $db): ?>
							<?php if ($db['id_barang'] != $data_detail_transaksi['id_barang']): ?>
								<option value="<?= $db['id_barang']; ?>"><?= $db['nama_barang']; ?></option>
							<?php endif ?>
						<?php endforeach ?>
					</select>
				</div>
				<div class="form-group">
					<label for="kuantitas">Kuantitas</label>
					<input type="number" name="kuantitas" id="kuantitas" class="form-input" required value="<?= $data_detail_transaksi['kuantitas']; ?>">
				</div>
				<div class="form-group">
					<label for="subtotal">Subtotal</label>
					<input style="cursor: not-allowed;" type="number" name="subtotal" id="subtotal" class="form-input" value="<?= $data_detail_transaksi['subtotal']; ?>">
				</div>
				<div class="form-group">
					<button type="submit" name="btnUbahDetailTransaksi" class="btn">Ubah Transaksi Barang</button>
				</div>
			</form>
		</div>
	</div>
    <?php include_once '../include/script.php'; ?>

	<script>
	  // Initialize the barang variable with the PHP-generated $barang array
	  const barang = <?= $barangJson; ?>;

	  const idBarangSelect = document.getElementById('id_barang');
	  const kuantitasInput = document.getElementById('kuantitas');
	  const subtotalInput = document.getElementById('subtotal');

	  // Calculate subtotal when either "Nama Barang" or "Kuantitas" changes
	  idBarangSelect.addEventListener('change', () => {
	    const selectedBarang = idBarangSelect.options[idBarangSelect.selectedIndex];
	    updateSubtotal(selectedBarang);
	  });

	  kuantitasInput.addEventListener('input', () => {
	    const selectedBarang = idBarangSelect.options[idBarangSelect.selectedIndex];
	    updateSubtotal(selectedBarang);
	  });

	  // Function to calculate subtotal
	  function updateSubtotal(selectedBarang) {
		  const idBarang = selectedBarang.value;
		  const kuantitas = kuantitasInput.value;

		  // Find the selected barang object from the barang array
		  const selectedBarangObj = barang.find((b) => b.id_barang == idBarang);

		  // Get the harga_jual property of the selected barang object
		  const hargaBarang = selectedBarangObj.harga_jual;

		  // Calculate the new subtotal value and update the input field
		  const subtotal = hargaBarang * kuantitas;
		  subtotalInput.value = subtotal;
		}

	</script>
</body>
</html>