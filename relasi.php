<body class="latar">
    <div class="page-header">
        <h1 style="color: #fff;" align="center"><b>Pengetahuan</b></h1>
    </div>
    <div class="panel panel-default">

        <div class="panel-heading" align="right">
            <form class="form-inline">
                <input type="hidden" name="m" value="relasi" />
                <div class="form-group">
                    <input class="form-control" type="text" placeholder="Pencarian. . ." name="q" value="<?= isset($_GET['q']) ? esc_field($_GET['q']) : '' ?>" />
                </div>
                <div class="form-group">
                    <button class="btn tambah"><span class="glyphicon glyphicon-search"></span></button>
                </div>
                <span class="pull-left">
                    <div class="form-group">
                        <a class="btn tambah" href="?m=relasi_tambah"><span class="glyphicon glyphicon-plus"></span> Tambah Data</a>
                    </div>
                </span>
            </form>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered table-hover table-striped">
                <thead>
                    <tr class="nw">
                        <th>No</th>
                        <th>Diagnosa</th>
                        <th>Gejala</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <?php
                $q = isset($_GET['q']) ? esc_field($_GET['q']) : ''; // Cek apakah parameter 'q' ada
                $rows = $db->get_results("SELECT r.ID, r.kode_gejala, d.kode_diagnosa, g.nama_gejala, d.nama_diagnosa
                                        FROM tb_relasi r 
                                        INNER JOIN tb_diagnosa d ON d.`kode_diagnosa` = r.`kode_diagnosa` 
                                        INNER JOIN tb_gejala g ON g.`kode_gejala` = r.`kode_gejala`
                                        WHERE r.kode_gejala LIKE '%$q%'
                                            OR r.kode_diagnosa LIKE '%$q%'
                                            OR g.nama_gejala LIKE '%$q%'
                                            OR d.nama_diagnosa LIKE '%$q%'
                                        ORDER BY r.kode_diagnosa, r.kode_gejala");
                $no = 0;

                if ($rows) :
                    foreach ($rows as $row) : ?>
                        <tr>
                            <td><?= ++$no ?></td>
                            <td>[<?= $row->kode_diagnosa . '] ' . $row->nama_diagnosa ?></td>
                            <td>[<?= $row->kode_gejala . '] ' . $row->nama_gejala ?></td>
                            <td class="nw">
                                <a class="btn btn-xs edit" href="?m=relasi_ubah&ID=<?= $row->ID ?>"><span class="glyphicon glyphicon-pencil"></span></a>
                                <a class="btn btn-xs edit" href="aksi.php?act=relasi_hapus&ID=<?= $row->ID ?>" onclick="return confirm('Hapus data?')"><span class="glyphicon glyphicon-trash"></span></a>
                            </td>
                        </tr>
                    <?php endforeach;
                else : ?>
                    <tr>
                        <td colspan="4" align="center">Data tidak ditemukan</td>
                    </tr>
                <?php endif; ?>
            </table>
        </div>
    </div>
</body>
