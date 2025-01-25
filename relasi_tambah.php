<body class="latar">
    <div class="page-header">
        <h1 style="color: #fff;" align="center"><b>Tambah Pengetahuan</b></h1>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <?php if ($_POST) include 'aksi.php' ?>
            <form method="post">
                <div class="form-group">
                    <label style="color: #fff;">Permasalahan <span class="text-danger">*</span></label>
                    <select class="form-control" name="kode_diagnosa">
                        <option value="">&nbsp;</option>
                        <?= CF_get_diagnosa_option(set_value('kode_diagnosa')) ?>
                    </select>
                </div>
                <div class="form-group">
                    <label style="color: #fff;">Gejala <span class="text-danger">*</span></label>
                    <select class="form-control" name="kode_gejala">
                        <option value="">&nbsp;</option>
                        <?= CF_get_gejala_option(set_value('kode_gejala')) ?>
                    </select>
                </div>

                <div class="form-group">
                    <button class="btn edit"><span class="glyphicon glyphicon-save"></span> Simpan</button>
                    <a class="btn edit" href="?m=relasi"><span class="glyphicon glyphicon-arrow-left"></span> Kembali</a>
                </div>
            </form>
        </div>
    </div>
</body>