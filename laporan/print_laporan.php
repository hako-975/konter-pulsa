<?php 
require_once '../koneksi.php';
if (!isset($_SESSION['id_user'])) {
	header("Location: ".BASE_URL."login.php");
	exit;
}

$id_user = $_SESSION['id_user'];

if (!isset($_GET['dari_tanggal'])) {
    header("Location: ".BASE_URL."laporan/laporan.php");
    exit;
}

$dari_tanggal = htmlspecialchars($_GET['dari_tanggal']);
$sampai_tanggal = htmlspecialchars($_GET['sampai_tanggal']);

$dari_tanggal_baru =  $dari_tanggal . ' 00:00:00';
$sampai_tanggal_baru =  $sampai_tanggal . ' 23:59:59';

$transaksi = mysqli_query($koneksi, "SELECT * FROM transaksi INNER JOIN user ON transaksi.id_user = user.id_user WHERE tanggal_transaksi BETWEEN '$dari_tanggal_baru' AND '$sampai_tanggal_baru' ORDER BY tanggal_transaksi ASC");

$omset = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT sum(total_harga) as omset FROM transaksi"));
$laba = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM((b.harga_jual - b.harga_beli) * dt.kuantitas) AS laba FROM detail_transaksi dt INNER JOIN barang b ON dt.id_barang = b.id_barang"));
$barang_paling_laku = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT barang.id_barang, barang.nama_barang, SUM(kuantitas) as laku FROM detail_transaksi INNER JOIN barang ON detail_transaksi.id_barang = barang.id_barang GROUP BY detail_transaksi.id_barang ORDER BY laku DESC LIMIT 1"));

$id_user = htmlspecialchars($_SESSION['id_user']);
$data_profile = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM user WHERE id_user = '$id_user'"));
 ?>

 <html>
 <head>
     <title>Laporan Konter Pulsa Dari Tanggal <?= $dari_tanggal; ?> Sampai Tanggal <?= $sampai_tanggal; ?></title>
    <link rel="icon" href="<?= BASE_URL; ?>assets/img/logo.png">
 </head>
 <body>
    <img style="display: block; text-align: center; margin: 0 auto;" src="<?= BASE_URL; ?>assets/img/logo.png" alt="Logo" width="100">
    <h3 style="text-align: center;">Laporan Konter Pulsa - Dari Tanggal <?= $dari_tanggal; ?> Sampai Tanggal <?= $sampai_tanggal; ?></h3>
    <h4>Omset: Rp. <?= str_replace(",", ".", number_format($omset['omset'])); ?>, Laba: Rp. <?= str_replace(",", ".", number_format($laba['laba'])); ?>, <?php if ($barang_paling_laku): ?>Barang Terlaku: <?= ucwords($barang_paling_laku['nama_barang']); ?> - <?= $barang_paling_laku['laku']; ?><?php endif ?></h4>
     <table border="1" cellspacing="0" cellpadding="10">
        <thead>
            <tr>
                <th>No.</th>
                <th>Tanggal Transaksi</th>
                <th>Total Harga</th>
                <th>Bayar</th>
                <th>Kembalian</th>
                <th>Detail Transaksi</th>
                <th>User</th>
            </tr>
        </thead>
        <tbody>
            <?php $i = 1; ?>
            <?php foreach ($transaksi as $dt): ?>
                <?php 
                    $id_transaksi = $dt['id_transaksi'];
                    $detail_transaksi = mysqli_query($koneksi, "SELECT * FROM detail_transaksi INNER JOIN barang ON detail_transaksi.id_barang = barang.id_barang WHERE id_transaksi = '$id_transaksi'");
                 ?>
                <tr>
                    <td><?= $i++; ?></td>
                    <td><?= $dt['tanggal_transaksi']; ?></td>
                    <td>Rp. <?= str_replace(",", ".", number_format($dt['total_harga'])); ?></td>
                    <td>Rp. <?= str_replace(",", ".", number_format($dt['bayar'])); ?></td>
                    <td>Rp. <?= str_replace(",", ".", number_format($dt['kembalian'])); ?></td>
                    <td style="min-width: 6rem">
                        <div>
                            <?php foreach ($detail_transaksi as $ddt): ?>
                                <div>
                                    • <?= $ddt['nama_barang']; ?> (<?= $ddt['kuantitas']; ?>)
                                </div>
                            <?php endforeach ?>
                        </div>
                    </td>
                    <td><?= $dt['username']; ?></td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
     <script>
         window.print();
     </script>
 </body>
 </html>