<div class="page-header">
    <h1 align="center" style="font-size: 26px">
        <p>Hasil Diagnosa Sistem Pakar<br />Identifikasi Masalah</p>
    </h1>
</div>
<?php
$gejala = $_SESSION['gejala'];
$rows = $db->get_results("SELECT * FROM tb_gejala WHERE kode_gejala IN (SELECT kode_gejala FROM tb_konsultasi WHERE jawaban='Ya')");
?>
<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title"><b>Biodata Konsultasi</b></h3>
    </div>
    <table class="table table-bordered table-hover">
        <thead>
            <tr style="background-color: #535c68; color: #fff;">
                <th>Nama</th>
                <th>No. Hp</th>
                <th>Jenis Kelamin</th>
                <th>Alamat</th>
                <th>Tanggal</th>
            </tr>
        </thead>
        <?php
        $q = isset($_GET['q']) ? esc_field($_GET['q']) : ''; // Gunakan nilai default jika tidak ada
        $rowss = $db->get_results("SELECT * FROM tb_hasil  order by id desc limit 1");
        $no = 0;
        foreach ($rowss as $rowd) : ?>
            <tr>
                <td><?= $rowd->nama ?></td>
                <td><?= $rowd->no_hp ?></td>
                <td><?= $rowd->jk ?></td>
                <td><?= $rowd->alamat ?></td>
                <td><?= $rowd->tgl ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>
<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title"><b>Tanda-tanda yang  Terpilih</b></h3>
        <table class="table table-bordered table-hover">
            <thead>
                <tr style="background-color: #535c68; color: #fff;">
                    <th>No</th>
                    <th>Nama Tanda-tanda</th>
                </tr>
            </thead>
            <?php
            $no = 1;
            foreach ($rows as $row) : ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= $row->nama_gejala ?></td>
                </tr>
            <?php endforeach; ?>
        </table>

        <?php
        $arr_gejala_terpilih = array();
        $r_at = $db->get_results("select kode_gejala from tb_konsultasi where jawaban='Ya' order by kode_gejala");
        foreach ($r_at as $row) {
            $arr_gejala_terpilih[] = $row->kode_gejala;
        }

        $nama_diagnosa = '';
        $penyebab = '';
        $solusi = '';
        $r = $db->get_results("select * from tb_diagnosa order by kode_diagnosa");
        foreach ($r as $row) {
            $kode_diagnosa = $row->kode_diagnosa;
            $arr_gejala_penyakit = array();
            $r_at = $db->get_results("select kode_gejala from tb_relasi where kode_diagnosa='$kode_diagnosa' order by kode_gejala");
            foreach ($r_at as $row_at) {
                $arr_gejala_penyakit[] = $row_at->kode_gejala;
            }
            if (arrays_are_equal($arr_gejala_terpilih, $arr_gejala_penyakit)) {
                $nama_diagnosa = $row->nama_diagnosa;
                $penyebab = $row->penyebab;
                $solusi = $row->solusi;
            }
        }
        $nama_diagnosa = empty($nama_diagnosa) ? 'Gejala tidak sesuai/penyakit tidak ditemukan!' : $nama_diagnosa;
        $penyebab = empty($penyebab) ? '-' : $penyebab;
        $solusi = empty($solusi) ? '-' : $solusi;
        ?>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><b>Hasil Analisa</b></h3>
            </div>
            <div class="panel-body">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr style="background-color: #535c68; color: #fff;">
                            <th>Permasalahan</th>
                        </tr>
                    </thead>
                    <tr class="text-success">
                        <td><b><?= $nama_diagnosa ?></b></td>
                    </tr>
                    <?php
                    $_SESSION['gejala'] = $gejala;
                    ?>
                </table>
                <table class="table table-bordered">
                    <tr>
                        <td width="100">Penyakit</td>
                        <td><b><?= $nama_diagnosa ?></b></td>
                    </tr>
                    <tr>
                        <td>Penyebab</td>
                        <td><?= $penyebab ?></td>
                    </tr>
                    <tr>
                        <td>Solusi</td>
                        <td><?= $solusi ?></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>