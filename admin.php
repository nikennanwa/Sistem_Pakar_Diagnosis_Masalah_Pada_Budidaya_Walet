<body class="latar">
    <div class="page-header">
        <h1 style="color: #fff;" align="center"><b>Admin</b></h1>
    </div>
    <div class="panel panel-default">
        <div class="panel-heading" align="right">
            <form class="form-inline">
                <input type="hidden" name="m" value="admin" />
                <div class="form-group">
                    <!-- Tambahkan validasi isset() untuk menghindari undefined key -->
                    <input class="form-control" type="text" placeholder="Pencarian. . ." name="q" value="<?= isset($_GET['q']) ? esc_field($_GET['q']) : '' ?>" />
                </div>
                <div class="form-group">
                    <button class="btn tambah"><span class="glyphicon glyphicon-search"></span></button>
                </div>
                <span class="pull-left">
                    <div class="form-group">
                        <a class="btn tambah" href="?m=admin_tambah"><span class="glyphicon glyphicon-plus"></span> Tambah Data</a>
                    </div>
                </span>
            </form>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered table-hover ">
                <thead>
                    <tr class="nw">
                        <th>No</th>
                        <th>Username</th>
                        <th>Password</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <?php
                // Periksa apakah parameter q ada
                $q = isset($_GET['q']) ? esc_field($_GET['q']) : '';
                $rows = $db->get_results("SELECT * FROM tb_admin
                                        WHERE user LIKE '%$q%'
                                        ORDER BY user");
                $no = 0;

                // Periksa apakah ada hasil
                if ($rows) :
                    foreach ($rows as $row) : ?>
                        <tr>
                            <td><?= ++$no ?></td>
                            <td><?= $row->user ?></td>
                            <td><?= $row->pass ?></td>
                            <td class="nw">
                                <a class="btn btn-xs edit" href="?m=admin_ubah&ID=<?= $row->user ?>"><span class="glyphicon glyphicon-pencil"></span></a>
                                <a class="btn btn-xs edit" href="aksi.php?act=admin_hapus&ID=<?= $row->user ?>" onclick="return confirm('Hapus data?')"><span class="glyphicon glyphicon-trash"></span></a>
                            </td>
                        </tr>
                    <?php endforeach;
                else : ?>
                    <!-- Tampilkan pesan jika data tidak ditemukan -->
                    <tr>
                        <td colspan="4" align="center">Data tidak ditemukan</td>
                    </tr>
                <?php endif; ?>
            </table>
        </div>
    </div>
</body>
