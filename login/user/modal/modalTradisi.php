<!-- MODAL ADD TRADISI -->
<form action="function.php?addTradisi" method="POST" role="form" enctype="multipart/form-data">
    <div class="example-modal">
        <div id="addTradisi" class="modal fade" role="dialog" style="display:none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <pre class="modal-title fs-6 text-purple"><i class="lni lni-plus"></i> Add</pre>
                    </div>
                    <div class="modal-body">
                        <div class="form-group mb-2">
                            <label class="col-sm-6 control-label text-right" for="foto">Foto</label>
                            <input type="file" name="foto" class="form-control" required>
                        </div>
                        <div class="form-group mb-2">
                            <label class="col-sm-6 control-label text-right" for="nama_tradisi">Nama Tradisi</label>
                            <input type="text" name="nama_tradisi" class="form-control" required>
                        </div>
                        <div class="form-group mb-2">
                            <label class="col-sm-6 control-label text-right" for="deskripsi">Deskripsi</label>
                            <textarea name="deskripsi" cols="30" rows="10" class="form-control" required></textarea>
                        </div>
                        <div class="form-group mb-2">
                            <label class="col-sm-6 control-label text-right" for="asal_daerah">Asal Daerah</label>
                            <input type="text" name="asal_daerah" class="form-control" required>
                        </div>
                        <div class="form-group mb-2">
                            <label class="col-sm-6 control-label text-right" for="waktu_pelaksanaan">Waktu Pelaksanaan</label>
                            <input type="date" name="waktu_pelaksanaan" class="form-control" required>
                        </div>
                        <div class="modal-footer">
                            <button id="nosave" type="button" class="btn btn-danger pull-left" data-bs-dismiss="modal">Batal</button>
                            <input type="submit" class="btn btn-primary" name="addTradisi" value="Tambah">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<!-- MODAL DELETE TRADISI -->
<?php
$query = mysqli_query($conn, "SELECT * FROM tradisi");
foreach ($query as $data): 
?>
<div id="delTradisi<?php echo $data['id']; ?>" class="modal fade" role="dialog" style="display:none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <pre class="modal-title fs-6 text-purple"><i class="lni lni-trash"></i> Delete</pre>
            </div>
            <div class="modal-body">
                <form action="function.php?id=<?= $data['id']?>" method="post" role="form" enctype="multipart/form-data">
                    <div class="form-group">
                        <label class="control-label text-right">Nama Tradisi</label>
                        <div class="col-md-12 mb-3">
                            <input type="text" class="form-control" name="nama_tradisi" readonly value="<?php echo htmlspecialchars($data['nama_tradisi']); ?>">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button id="nosave" type="button" class="btn btn-danger pull-left" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" name="delTradisi" value="<?= $data['id'] ?>" class="btn btn-primary pull-left">Hapus</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php endforeach ?>

<!-- MODAL UPDATE TRADISI -->
<?php
foreach ($query as $data): 
?>
<div id="upTradisi<?php echo $data['id']; ?>" class="modal fade" role="dialog" style="display:none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <pre class="modal-title fs-6 text-purple"><i class="lni lni-pencil"></i> Update</pre>
            </div>
            <div class="modal-body">
                <form action="function.php?id=<?= $data['id']?>" method="post" role="form" enctype="multipart/form-data">
                    <div class="form-group text-center">
                        <img class="img-thumbnail mb-2" src="./file/images/tradisi/<?= $data['gambar'] ?>" style="height: auto; width: 100%;">
                        <input class="text-center" type="file" name="foto">
                    </div>
                    <div class="form-group">
                        <label class="control-label text-right">Nama Tradisi</label>
                        <input type="text" class="form-control" name="nama_tradisi" value="<?= htmlspecialchars($data['nama_tradisi']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label class="control-label text-right">Deskripsi</label>
                        <textarea name="deskripsi" class="form-control" rows="5" required><?= htmlspecialchars($data['deskripsi']); ?></textarea>
                    </div>
                    <div class="form-group">
                        <label class="control-label text-right">Asal Daerah</label>
                        <input type="text" class="form-control" name="asal_daerah" value="<?= htmlspecialchars($data['asal_daerah']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label class="control-label text-right">Waktu Pelaksanaan</label>
                        <input type="date" class="form-control" name="waktu_pelaksanaan" value="<?= htmlspecialchars($data['waktu_pelaksanaan']); ?>" required>
                    </div>
                    <div class="modal-footer">
                        <button id="nosave" type="button" class="btn btn-danger pull-left" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" name="upTradisi" value="<?= $data['id'] ?>" class="btn btn-primary pull-left">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php endforeach ?>
