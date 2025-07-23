<!-- MODAL ADD KATEGORY -->

<form action="function.php?addFF" method="POST" role="form" enctype="multipart/form-data">
    <div class="example-modal">
        <div id="addFF" class="modal fade" role="dialog" style="display:none;">
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
                            <label class="col-sm-6 control-label text-right" for="pem">Nama</label>
                            <input type="text" name="nama" class="form-control" required>
                        </div>

                        <div class="form-group mb-2">
                            <label class="col-sm-6 control-label text-right" for="pem">Jenis</label>
                            <select name="jenis" id="" class="form-control" required>
                                <option value="Flora">Flora</option>
                                <option value="Fauna">Fauna</option>
                            </select>
                        </div>
                
                        <div class="form-group mb-2">
                            <label class="col-sm-6 control-label text-right" for="pem">Habitat</label>
                            <input type="text" name="habitat" class="form-control" required>
                        </div>

                        <div class="form-group mb-2">
                            <label class="col-sm-6 control-label text-right" for="pem">Deskripsi</label>
                            <textarea name="deskripsi" id="" cols="30" rows="10" class="form-control" required></textarea>
                        </div>
                      
                       

                        <div class="modal-footer">
                            <button id="nosave" type="button" class="btn btn-danger pull-left"
                                data-bs-dismiss="modal">Batal</button>
                            <input type="submit" class="btn btn-primary" name="addFF" value="Tambah">
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
      $query = mysqli_query($conn,"SELECT * FROM flora_fauna WHERE id");
      $rows = mysqli_fetch_assoc($query);
      @$id = $rows['id'];
      foreach($query as  $data ): 
      ?>
<div id="delFF<?php echo $data['id']; ?>" class="modal fade" role="dialog" style="display:none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <pre class="modal-title fs-6 text-purple"><i class="lni lni-trash"></i> Delete</pre>
            </div>
            <div class="modal-body">
                <form action="function.php?id=<?= $id?>" method="post" role="form" enctype="multipart/form-data">

                    <div class="form-group">
                        <div class="row">
                            <label class="control-label text-right">Nama</label>
                            <div class="col-md-12 mb-3">
                                <input type="text" class="form-control" name="nama" id="nama" readonly
                                    value="<?php echo $data['nama']; ?>">
                            </div>

                        </div>
                    </div>

                    <div class="modal-footer">
                        <button id="nosave" type="button" class="btn btn-danger pull-left"
                            data-bs-dismiss="modal">Batal</button>
                        <button type="submit" name="delFF" value="<?= $data['id'] ?>"
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
<div id="upFF<?php echo $data['id']; ?>" class="modal fade" role="dialog" style="display:none;">
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
                <img class="img-thumbnail mb-2" src="./file/images/flora_fauna/<?= $data['gambar'] ?>"
                    style="height: auto; width: 100%;"> <br>
                <input class="text-center" type="file" name="foto">
            </div>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label text-right">Nama Flora/Fauna</label>
        <input type="text" class="form-control" name="nama" id="nama"
            value="<?= htmlspecialchars($data['nama']); ?>">
    </div>
    <div class="form-group">
        <label class="control-label text-right">Jenis</label>
        <input type="text" class="form-control" name="jenis" id="jenis"
            value="<?= htmlspecialchars($data['jenis']); ?>">
    </div>
    <div class="form-group">
        <label class="control-label text-right">Habitat</label>
        <input type="text" class="form-control" name="habitat" id="habitat"
            value="<?= htmlspecialchars($data['habitat']); ?>">
    </div>
    <div class="form-group">
        <label class="control-label text-right">Deskripsi</label>
        <textarea name="deskripsi" id="deskripsi" class="form-control" rows="5"><?= htmlspecialchars($data['deskripsi']); ?></textarea>
    </div>
 
    <div class="modal-footer">
                <button id="nosave" type="button" class="btn btn-danger pull-left"
                    data-bs-dismiss="modal">Batal</button>
                <button type="submit" name="upFF" value="<?= $data['id'] ?>"
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