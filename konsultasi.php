<?php
$terjawab = get_terjawab();
$relasi = get_relasi($terjawab);
$kode_gejala = get_next_gejala($relasi);

$success = false;

$arr_gejala_terpilih = array();
$r_at = $db->get_results("select kode_gejala from tb_konsultasi where jawaban='Ya' order by kode_gejala");
foreach ($r_at as $row) {
    $arr_gejala_terpilih[] = $row->kode_gejala;
}

$r = $db->get_results("select * from tb_diagnosa order by kode_diagnosa");
foreach ($r as $row) {
    $kode_diagnosa = $row->kode_diagnosa;
    $arr_gejala_penyakit = array();
    $r_at = $db->get_results("select kode_gejala from tb_relasi where kode_diagnosa='$kode_diagnosa' order by kode_gejala");
    foreach ($r_at as $row_at) {
        $arr_gejala_penyakit[] = $row_at->kode_gejala;
    }
    if (arrays_are_equal($arr_gejala_terpilih, $arr_gejala_penyakit)) {
        $success = true;
    }
}

$row = $db->get_row("SELECT * FROM tb_gejala WHERE kode_gejala='$kode_gejala'");

if (empty($row)) {
    $success = true;
}

$count = $db->get_var("SELECT COUNT(*) FROM tb_konsultasi");

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Identifikasi Penyakit - Sistem Pakar</title>
    <link href="assets/css/yeti-bootstrap.min.css" rel="stylesheet" />
    <link href="assets/css/general.css" rel="stylesheet" />
    <link href="assets/css/select2.min.css" rel="stylesheet" />
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/select2.min.js"></script>
    <style type="text/css">
        .hi {
            background-image: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('assets/images/walet3.jpeg');
            background-size: cover;
            background-position: center center;
            background-repeat: no-repeat;
            background-attachment: fixed;
        }

        .dark {
            background-color: #000;
            color: #000;
        }

        .page-header {
            color: #fff;
        }

        .latar {
            background-color: #636e72;
        }

        .tambah {
            background-color: #353b48;
        }

        .tambah:hover {
            background-color: #718093;
            color: #fff;
        }

        .edit {
            background-color: #2f3640;
        }

        .edit:hover {
            background-color: #718093;
            color: #fff;
        }
    </style>
</head>

<body class="dark hi">
    <div class="page-header">
        <h1 align="center"><b>Konsultasi</b></h1>
    </div>
    <?php if ($success) : ?>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><b>Riwayat Pertanyaan</b></h3>
            </div>
            <div class="list-group">
                <?php
                $rows = $db->get_results("SELECT * FROM tb_konsultasi k INNER JOIN tb_gejala g ON g.kode_gejala=k.kode_gejala");
                foreach ($rows as $row) : ?>
                    <div class="list-group-item"><?= $row->ID ?>. Apakah <?= strtolower($row->nama_gejala) ?>? <strong><?= $row->jawaban ?></strong></div>
                <?php endforeach ?>
            </div>
        </div>
    <?php include 'konsultasi_hasil.php';
    else : ?>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title" align="center">Jawablah pertanyaan berikut ini <b>[<?= $row->kode_gejala ?>]</b></h3>
            </div>
            <div class="panel-body" style="background-color: #535c68; color: #fff;">
                <h3 align="center">Apakah <b><?= strtolower($row->nama_gejala) ?>?</b></h3>
                <form action="aksi.php?m=konsultasi" method="post">
                    <input type="hidden" name="kode_gejala" value="<?= $row->kode_gejala ?>" />
                    <p>&nbsp;</p>
                    <p align="center">
                        <button name="yes" class="btn tambah" value="1"><span class="glyphicon glyphicon-ok-sign"></span> Ya</button>
                        <button name="no" class="btn tambah" value="1"><span class="glyphicon glyphicon-remove-sign"></span> Tidak</button>

                        <?php if ($count) : ?>
                            <br><br>
                            <a class="btn btn-danger hapus" href="aksi.php?m=konsultasi&act=new"><span class="glyphicon glyphicon-ban-circle"></span> Batal</a>
                        <?php endif ?>
                    </p>
                </form>
            </div>
        </div>
    <?php endif ?>

</body>

</html>