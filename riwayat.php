<body class="latar">
    <div class="page-header">
        <h1 style="color: #fff;" align="center"><b>Riwayat Konsultasi</b></h1>
    </div>

    <div class="panel panel-default">
        <div class="panel-heading" align="right">
            <form class="form-inline">
                <input type="hidden" name="m" value="laporan" />
                <div class="form-group">
                    <!-- Pencarian -->
                    <input type="text" class="form-control" placeholder="Pencarian. . ." name="q" value="<?= isset($_GET['q']) ? esc_field($_GET['q']) : '' ?>" />
                </div>
            </form>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-hover table-striped">
                <tr>
                    <td width="50" align="center" valign="middle"><b>No</b></td>
                    <td width="150" align="center" valign="middle"><b>Nama</b></td>
                    <td width="100" align="center" valign="middle"><b>No. Hp</b></td>
                    <td width="100" align="center" valign="middle"><b>Jenis Kelamin</b></td>
                    <td width="100" align="center" valign="middle"><b>Alamat</b></td>
                    <td width="150" align="center" valign="middle"><b>Tanggal Konsultasi</b></td>
                    <td width="70" align="center" valign="middle"><b>Hasil Konsultasi</b></td>
                </tr>

                <?php
                require_once 'functions.php';

                // Mengambil data pencarian
                $q = isset($_GET['q']) ? esc_field($_GET['q']) : '';

                // Mengambil data riwayat dengan DISTINCT untuk menghindari duplikasi
                $rows = $db->get_results("SELECT * FROM tb_hasil WHERE nama LIKE '%$q%' ORDER BY id");

                // Mengecek jika ada data yang ditemukan
                if ($rows) :
                    $no = 0;

                    // Array untuk mengecek duplikasi
                    $seen = [];

                    foreach ($rows as $row) :
                        // Menggunakan kombinasi nama, no_hp, dan tgl untuk pengecekan duplikasi
                        $key = $row->nama . $row->no_hp . $row->tgl;

                        // Jika sudah ada data yang sama, lanjutkan ke iterasi berikutnya
                        if (in_array($key, $seen)) {
                            continue;
                        }

                        // Menambahkan data ke array $seen untuk pengecekan duplikasi
                        $seen[] = $key;
                        ?>

                        <tr>
                            <td align="center" valign="middle"><?= ++$no ?></td>
                            <td valign="middle"><?= $row->nama ?></td>
                            <td valign="middle"><?= $row->no_hp ?></td>
                            <td valign="middle"><?= $row->jk ?></td>
                            <td valign="middle"><?= $row->alamat ?></td>
                            <td valign="middle"><?= $row->tgl ?></td>
                            <td valign="middle"><?= $row->hasil_konsultasi ?></td>
                        </tr>

                    <?php endforeach; 
                else : ?>
                    <tr>
                        <td colspan="7" align="center">Data tidak ditemukan</td>
                    </tr>
                <?php endif; ?>
            </table>
        </div>
    </div>
</body>
