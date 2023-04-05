<?php 
require_once '../koneksi.php';

if (!isset($_SESSION['id_user'])) {
	header("Location: ".BASE_URL."login.php");
	exit;
}

$id_transaksi = htmlspecialchars($_GET['id_transaksi']);

$data_transaksi = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM transaksi INNER JOIN user ON transaksi.id_user = user.id_user WHERE transaksi.id_transaksi = '$id_transaksi'"));

$detail_transaksi = mysqli_query($koneksi, "SELECT * FROM detail_transaksi INNER JOIN transaksi ON detail_transaksi.id_transaksi = transaksi.id_transaksi INNER JOIN barang ON detail_transaksi.id_barang = barang.id_barang WHERE detail_transaksi.id_transaksi = '$id_transaksi' ORDER BY barang.nama_barang ASC");

$id_user = htmlspecialchars($_SESSION['id_user']);
$data_profile = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM user WHERE id_user = '$id_user'"));

if (isset($_POST['btnBayar'])) {
	$bayar = htmlspecialchars($_POST['bayar']);
	$kembalian = htmlspecialchars($_POST['kembalian']);

	$update_transaksi = mysqli_query($koneksi, "UPDATE transaksi SET bayar = '$bayar', kembalian = '$kembalian' WHERE id_transaksi = '$id_transaksi'");

	if ($update_transaksi) {
		echo "
			<script>
				alert('Pembayaran berhasil!');
				window.location.href='detail_transaksi.php?id_transaksi=$id_transaksi';
			</script>
		";
	} else {
		echo "
			<script>
				alert('Pembayaran gagal!');
				window.history.back();
			</script>
		";
	}
}

?>

<html>
<head>
	<title>Bayar</title>
	<?php include_once '../include/head.php'; ?>
</head>
<body class="bg-gradient">
	<div id="preloader">
      <div class="loader"></div>
    </div>
    <?php include_once '../include/topbar.php' ?>
	<?php include_once '../include/sidebar.php'; ?>
	<div class="main-content">
		<a href="<?= BASE_URL; ?>transaksi/detail_transaksi.php?id_transaksi=<?= $data_transaksi['id_transaksi']; ?>" class="btn">Kembali</a>
		<div class="my">
			<h4>Pembayaran Id Transaksi: <?= $data_transaksi['id_transaksi']; ?></h4>	
			<table border="1" cellpadding="10" cellspacing="0">
				<thead>
					<tr>
						<th>No.</th>
						<th>Nama Barang</th>
						<th>Kuantitas</th>
						<th>Subtotal</th>
						<th>Aksi</th>
					</tr>
				</thead>
				<tbody>
					<?php $i = 1; ?>
					<?php foreach ($detail_transaksi as $ddt): ?>
						<tr>
							<td><?= $i++; ?></td>
							<td><?= $ddt['nama_barang']; ?></td>
							<td><?= $ddt['kuantitas']; ?></td>
							<td>Rp. <?= str_replace(",", ".", number_format($ddt['subtotal'])); ?></td>
							<td>
								<a href="ubah_detail_transaksi.php?id_detail_transaksi=<?= $ddt['id_detail_transaksi']; ?>&id_transaksi=<?= $id_transaksi; ?>" class="btn">Ubah</a>
								<a onclick="return confirm('Apakah Anda yakin ingin menghapus transaksi <?= $ddt['nama_barang']; ?>?')" href="hapus_detail_transaksi.php?id_detail_transaksi=<?= $ddt['id_detail_transaksi']; ?>&id_transaksi=<?= $id_transaksi; ?>" class="btn">Hapus</a>
							</td>
						</tr>
					<?php endforeach ?>
				</tbody>
			</table>
			<h4>Total Harga: Rp. <?= str_replace(",", ".", number_format($data_transaksi['total_harga'])); ?></h4>
			<form method="post">
			  <div class="form-group">
			    <label for="bayar">Bayar</label>
			    <input type="number" name="bayar" id="bayar" class="form-input" required>
			  </div>
			  <div class="form-group">
			    <label for="kembalian">Kembalian</label>
			    <input style="cursor: not-allowed;" type="number" name="kembalian" id="kembalian" class="form-input">
			  </div>
			  <div class="form-group">
			    <button type="submit" name="btnBayar" class="btn">Bayar</button>
			  </div>
			</form>
		</div>
	</div>

    <?php include_once '../include/script.php'; ?>
	<script>
	  // Get the "bayar" and "kembalian" input fields
	  const bayarInput = document.getElementById("bayar");
	  const kembalianInput = document.getElementById("kembalian");

	  // Calculate the kembalian and update the input field when the "bayar" value changes
	  bayarInput.addEventListener("input", function() {
	    const totalHarga = <?= $data_transaksi['total_harga'] ?>;
	    const bayar = bayarInput.value;
	    const kembalian = bayar - totalHarga;
	    kembalianInput.value = kembalian;
	  });

	</script>

</body>
</html>