<!-- MODAL ADD KATEGORY -->

<form action="function.php?addGeografi" method="POST" role="form" enctype="multipart/form-data">
    <div class="example-modal">
        <div id="addGeografi" class="modal fade" role="dialog" style="display:none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <pre class="modal-title fs-6 text-purple"><i class="lni lni-plus"></i> Add</pre>
                    </div>
                    <div class="modal-body">

                        <div class="form-group mb-2">
                            <div class="row">
                            </div>
                        </div>

                        <div class="form-group mb-2">
                            <label class="col-sm-6 control-label text-right" for="pem">Foto</label>
                            <input type="file" name="foto" class="form-control" required>
                        </div>

                        <div class="form-group mb-2">
                            <label class="col-sm-6 control-label text-right" for="pem">Nama Tempat</label>
                            <input type="text" name="nama_tempat" class="form-control" required>
                        </div>

                        <div class="form-group mb-2">
                            <label class="col-sm-6 control-label text-right" for="pem">Jenis Tempat</label>
                            <select name="jenis_tempat" id="" class="form-control" required>
                                <option value="Alam">Alam</option>
                                <option value="Sejarah">Sejarah</option>
                                <option value="Adat & Budaya">Adat & Budaya</option>
                            </select>
                        </div>

                        <div class="form-group mb-2">
                            <label class="col-sm-6 control-label text-right" for="pem">Deskripsi</label>
                            <textarea name="deskripsi" id="" cols="30" rows="10" class="form-control" required></textarea>
                        </div>
                        
                        <div class="form-group mb-2">
                            <label class="col-sm-6 control-label text-right" for="pem">Koordinat</label>
                            <input type="text" name="koordinat" class="form-control">
                        </div>

                        <div class="form-group mb-2">
                            <label class="col-sm-6 control-label text-right" for="pem">Luas (km²)</label>
                            <input type="number" step="0.01" name="luas" class="form-control">
                        </div>

                        <div class="form-group mb-2">
                            <label class="col-sm-6 control-label text-right" for="pem">Tinggi (meter)</label>
                            <input type="number" step="0.01" name="tinggi" class="form-control">
                        </div>

                        <div class="form-group mb-2">
                            <label class="col-sm-6 control-label text-right" for="pem">Populasi</label>
                            <input type="number" name="populasi" class="form-control">
                        </div>
                       

                        <div class="modal-footer">
                            <button id="nosave" type="button" class="btn btn-danger pull-left"
                                data-bs-dismiss="modal">Batal</button>
                            <input type="submit" class="btn btn-primary" name="addGeografi" value="Tambah">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<!-- MODAL DELETE Penduduk -->
<?php
//  $id = $_GET['id'];
      $query = mysqli_query($conn,"SELECT * FROM geografi WHERE id");
      $rows = mysqli_fetch_assoc($query);
      @$id = $rows['id'];
      foreach($query as  $data ): 
      ?>
<div id="delGeografi<?php echo $data['id']; ?>" class="modal fade" role="dialog" style="display:none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <pre class="modal-title fs-6 text-purple"><i class="lni lni-trash"></i> Delete</pre>
            </div>
            <div class="modal-body">
                <form action="function.php?id=<?= $id?>" method="post" role="form" enctype="multipart/form-data">

                    <div class="form-group">
                        <div class="row">
                            <label class="control-label text-right">Nama Tempat</label>
                            <div class="col-md-12 mb-3">
                                <input type="text" class="form-control" name="nama_tempat" id="nama_tempat" readonly
                                    value="<?php echo $data['nama_tempat']; ?>">
                            </div>

                        </div>
                    </div>

                    <div class="modal-footer">
                        <button id="nosave" type="button" class="btn btn-danger pull-left"
                            data-bs-dismiss="modal">Batal</button>
                        <button type="submit" name="delGeografi" value="<?= $data['id'] ?>"
                            class="btn btn-primary pull-left">Hapus</button>

                    </div>


                </form>
            </div>
        </div>
    </div>
</div><!-- end modal DELETE -->
<?php endforeach ?>

<!-- MODAL UPDATE -->
<?php

      foreach ($query as $data) :

      ?>
<div id="upGeografi<?php echo $data['id']; ?>" class="modal fade" role="dialog" style="display:none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <pre class="modal-title fs-6 text-purple"><i class="lni lni-pencil"></i> Update</pre>
            </div>
            <div class="modal-body">
                <form action="function.php?id=<?= $data['id']?>" method="post" role="form"
                    enctype="multipart/form-data">

                    <div class="form-group">
        <div class="row">
            <div class="col-md-12 text-center">
                <img class="img-thumbnail mb-2" src="./file/images/geografi/<?= $data['gambar'] ?>" style="height: auto; width: 100%;"> <br>
                <input class="text-center" type="file" name="foto">
            </div>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label text-right">Nama Tempat</label>
        <input type="text" class="form-control" name="nama_tempat" id="nama_tempat" value="<?= htmlspecialchars($data['nama_tempat']); ?>" required>
    </div>
    <div class="form-group">
        <label class="control-label text-right">Jenis Tempat</label>
        <select name="jenis_tempat" id="jenis_tempat" class="form-control" required>
            <option value="Alam" <?= $data['jenis_tempat'] == 'Alam' ? 'selected' : ''; ?>>Alam</option>
            <option value="Sejarah" <?= $data['jenis_tempat'] == 'Sejarah' ? 'selected' : ''; ?>>Sejarah</option>
            <option value="Adat & Budaya" <?= $data['jenis_tempat'] == 'Adat & Budaya' ? 'selected' : ''; ?>>Adat & Budaya</option>

        </select>
    </div>
    <div class="form-group">
        <label class="control-label text-right">Deskripsi</label>
        <textarea name="deskripsi" id="deskripsi" class="form-control" rows="5" required><?= htmlspecialchars($data['deskripsi']); ?></textarea>
    </div>
    <div class="form-group">
        <label class="control-label text-right">Koordinat</label>
        <input type="text" class="form-control" name="koordinat" id="koordinat" value="<?= htmlspecialchars($data['koordinat']); ?>" required>
    </div>
    <div class="form-group">
        <label class="control-label text-right">Luas (km²)</label>
        <input type="number" step="0.01" class="form-control" name="luas" id="luas" value="<?= htmlspecialchars($data['luas']); ?>" required>
    </div>
    <div class="form-group">
        <label class="control-label text-right">Tinggi (meter)</label>
        <input type="number" step="0.01" class="form-control" name="tinggi" id="tinggi" value="<?= htmlspecialchars($data['tinggi']); ?>" required>
    </div>
    <div class="form-group">
        <label class="control-label text-right">Populasi</label>
        <input type="number" class="form-control" name="populasi" id="populasi" value="<?= htmlspecialchars($data['populasi']); ?>" required>
    </div>
 
    <div class="modal-footer">
                <button id="nosave" type="button" class="btn btn-danger pull-left"
                    data-bs-dismiss="modal">Batal</button>
                <button type="submit" name="upGeografi" value="<?= $data['id'] ?>"
                    class="btn btn-primary pull-left">Update</button>

            </div>
                    </div>
            </div>

        


            </form>
        </div>
    </div>
</div>
</div><!-- end modal update -->
<?php endforeach ?>