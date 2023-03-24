<?php 
require_once '../koneksi.php';

if (!isset($_SESSION['id_user'])) {
	header("Location: login.php");
	exit;
}

$id_transaksi = htmlspecialchars($_GET['id_transaksi']);

$barang = mysqli_query($koneksi, "SELECT * FROM barang INNER JOIN jenis_barang ON barang.id_jenis_barang = jenis_barang.id_jenis_barang ORDER BY nama_barang ASC");

// Convert the result set to an array
$barang_arr = array();
while ($row = mysqli_fetch_assoc($barang)) {
    $barang_arr[] = $row;
}

// Convert the array to a JSON string
$barangJson = json_encode($barang_arr);

if (isset($_POST['btnTambahDetailTransaksi'])) {
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

	$tambah_detail_transaksi = mysqli_query($koneksi, "INSERT INTO detail_transaksi VALUES('', '$id_transaksi', '$id_barang', '$kuantitas', '$subtotal')");

	$get_total_harga = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(subtotal) as total_harga FROM detail_transaksi WHERE id_transaksi = '$id_transaksi'"));
	$total_harga = $get_total_harga['total_harga'];
	$update_total_harga = mysqli_query($koneksi, "UPDATE transaksi SET total_harga = '$total_harga' WHERE id_transaksi = '$id_transaksi'");

	if ($tambah_detail_transaksi) {
		echo "
			<script>
				alert('Transaksi Barang berhasil ditambahkan!');
				window.location.href='detail_transaksi.php?id_transaksi=$id_transaksi';
			</script>
		";
	} else {
		echo "
			<script>
				alert('Transaksi Barang gagal ditambahkan!');
				window.history.back();
			</script>
		";
	}
}

?>

<html>
<head>
	<title>Tambah Transaksi Barang</title>
</head>
<body>
	<a href="detail_transaksi.php?id_transaksi=<?= $id_transaksi; ?>">Kembali</a>
	<form method="post">
		<div>
			<label for="id_barang">Nama Barang</label>
			<select name="id_barang" id="id_barang">
				<option value="0">--- Pilih Nama Barang ---</option>
				<?php foreach ($barang as $db): ?>
					<option value="<?= $db['id_barang']; ?>"><?= $db['nama_barang']; ?></option>
				<?php endforeach ?>
			</select>
		</div>
		<div>
			<label for="kuantitas">Kuantitas</label>
			<input type="number" name="kuantitas" id="kuantitas" required>
		</div>
		<div>
			<label for="subtotal">Subtotal</label>
			<input style="cursor: not-allowed;" type="number" name="subtotal" id="subtotal">
		</div>
		<div>
			<button type="submit" name="btnTambahDetailTransaksi">Tambah Transaksi Barang</button>
		</div>
	</form>
	
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