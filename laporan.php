<head>
    <script type="text/javascript">
        var s5_taf_parent = window.location;

        function popup_print() {
            window.open('laporan_cetak.php', 'page', 'toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,width=750,height=600,left=50,top=50,titlebar=yes')
        }
    </script>
</head>

<body class="latar">
    <div class="page-header">
        <h1 style="color: #fff;" align="center"><b>Laporan</b></h1>
    </div>
    <div class="panel panel-default">
        <div class="panel-heading">
            <form class="form-inline">
                <div class="form-group">
                    <a class="btn btn-info" onClick="popup_print()"><span class="glyphicon glyphicon-print"></span> Cetak</a>
                </div>
                <input type="hidden" name="m" value="laporan" />
                <div class="form-group pull-right">
                    <input class="form-control" type="text" placeholder="Pencarian. . ." name="q" value="<?= isset($_GET['q']) ? esc_field($_GET['q']) : '' ?>" />
                    <button class="btn tambah"><span class="glyphicon glyphicon-search"></span></button>
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
                    <td width="76" align="center" valign="middle"><b>Aksi</b></td>
                </tr>
                <?php
                require_once 'functions.php';
                $q = isset($_GET['q']) ? esc_field($_GET['q']) : ''; // Periksa apakah parameter 'q' ada
                $rows = $db->get_results("SELECT * FROM tb_hasil
                                           WHERE nama LIKE '%$q%' AND hasil_konsultasi <> ''
                                           ORDER BY id");
                $no = 0;

                if ($rows) :
                    foreach ($rows as $row) : ?>
                        <tr>
                            <td align="center" valign="middle"><?= ++$no ?></td>
                            <td valign="middle"> <?= $row->nama ?></td>
                            <td valign="middle"> <?= $row->no_hp ?></td>
                            <td valign="middle"> <?= $row->jk ?></td>
                            <td valign="middle"> <?= $row->alamat ?></td>
                            <td valign="middle"> <?= $row->tgl ?></td>
                            <td valign="middle"> <?= $row->hasil_konsultasi ?></td>
                            <td align="center" valign="middle" class="nw">
                                <a class="btn btn-xs btn-danger" href="aksi.php?act=laporan_hapus&ID=<?= $row->id ?>" onClick="return confirm('Hapus data?')"><span class="glyphicon glyphicon-trash"></span></a>
                            </td>
                        </tr>
                    <?php endforeach;
                else : ?>
                    <tr>
                        <td colspan="8" align="center">Data tidak ditemukan</td>
                    </tr>
                <?php endif; ?>
            </table>
        </div>
    </div>
</body>
