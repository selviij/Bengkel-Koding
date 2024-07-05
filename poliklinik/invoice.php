<?php
include "koneksi.php";

if (isset($_GET['id'])) {
    $id_periksa = $_GET['id'];

    // Query untuk mendapatkan informasi pemeriksaan
    $periksa_query = mysqli_query($mysqli, "SELECT pr.*, d.nama as 'nama_dokter', d.alamat as 'alamat_dokter', d.no_hp as 'nomor_hp_dokter', 
                                            p.nama as 'nama_pasien', p.alamat as 'alamat_pasien', p.no_hp as 'nomor_hp_pasien'
                                            FROM periksa pr 
                                            LEFT JOIN dokter d ON (pr.id_dokter=d.id) 
                                            LEFT JOIN pasien p ON (pr.id_pasien=p.id) 
                                            WHERE pr.id = '$id_periksa'");

    
    if (mysqli_num_rows($periksa_query) > 0) {
        $periksa_data = mysqli_fetch_assoc($periksa_query);

        // Query untuk mendapatkan obat yang terkait dengan pemeriksaan
        $obat_query = mysqli_query($mysqli, "SELECT o.nama_obat, o.harga FROM detail_periksa dp 
                                            JOIN obat o ON dp.id_obat = o.id 
                                            WHERE dp.id_periksa = '$id_periksa'");
        
        // Biaya jasa dokter
        $biaya_jasa_dokter = 150000;
        
        $total_harga_obat = 0;
        while ($obat_data = mysqli_fetch_assoc($obat_query)) {
            $total_harga_obat += $obat_data['harga'];
        }
        
        $total_harga = $total_harga_obat + $biaya_jasa_dokter;
        
    } else {
        // Jika id periksa tidak ditemukan
        die("Data periksa tidak ditemukan.");
    }
} else {
    // Jika tidak ada id periksa yang diberikan
    die("ID periksa tidak valid.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Invoice</title>
</head>
<body>
    <div class="container mt-5">
        <div class="card">
            <div class="card-body">
            <h3 class="mb-5">Nota Pembayaran</h3>
                <table>
                    <tr>
                        <td>
                            <div class="mb-5">
                                <p>No Periksa<br><strong>#<?php echo $periksa_data['id']; ?></strong></p>
                            </div>
                        </td>
                        <td>
                            <div class="right mb-5">
                                <p>Tanggal Periksa<br><strong><?php echo $periksa_data['tgl_periksa']; ?></strong></p>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="mb-5">
                                
                                <p>Pasien<br><strong><?php echo $periksa_data['nama_pasien']; ?></strong><br><?php echo $periksa_data['alamat_pasien']; ?><br><span style="color: blue;"><?php echo $periksa_data['nomor_hp_pasien']; ?></span></p>
                            </div>
                        </td>
                        <td>
                            <div class="right mb-5">
                            <p>Dokter<br><strong><?php echo $periksa_data['nama_dokter']; ?></strong><br><?php echo $periksa_data['alamat_dokter']; ?><br><span style="color: blue;"><?php echo $periksa_data['nomor_hp_dokter']; ?></span></p>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="mb-2">
                                <strong>Deskripsi</strong>
                            </div>
                        </td>
                        <td>
                            <div class="right mb-2">
                                <strong>Harga</strong>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <div class="horizontal-line"></div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="mb-3">
                                <p>Jasa Dokter</p>
                            </div>
                        </td>
                        <td>
                            <div class="right mb-3">

                                <p>Rp <?php echo number_format($biaya_jasa_dokter, 2, ',', '.'); ?></p>
                            </div>
                        </td>
                    </tr>
                    <?php
                        mysqli_data_seek($obat_query, 0); // Reset pointer query untuk mengulang
                        while ($obat_data = mysqli_fetch_assoc($obat_query)) {
                    ?>
                    <tr>
                        <td>
                            <div class="mb-3">
                                <p><?php echo $obat_data['nama_obat']; ?></p>
                            </div>
                        </td>
                        <td>
                            <div class="right mb-3">
                                <p>Rp <?php echo number_format($obat_data['harga'], 2, ',', '.'); ?></p>
                            </div>
                        </td>
                    </tr>
                    <?php
                        }
                    ?>
                </table>

                <div class="right mb-2 mt-3">
                    <p>Jasa Dokter: Rp <?php echo number_format($biaya_jasa_dokter, 2, ',', '.'); ?></p>
                </div>
                <div class="right mb-4">
                    <p>Subtotal Obat: Rp <?php echo number_format($total_harga_obat, 2, ',', '.'); ?></p>
                </div>
                <div class="right mb-3">
                     <strong style="font-size: 20px;">Total: <span style="font-size: 20px; color: green;">Rp <?php echo number_format($total_harga, 2, ',', '.'); ?></span></strong>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
