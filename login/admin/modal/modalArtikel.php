
<!-- MODAL ADD KATEGORY -->

<form action="function.php?addArtikel" method="POST" role="form" enctype="multipart/form-data">
            <div class="example-modal">
  <div id="addArtikel" class="modal fade" role="dialog" style="display:none;">
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
          <label class="col-sm-6 control-label text-right" for="pem">Gambar</label>
              <input type="file" name="foto" class="form-control">
          </div> 
          <div class="form-group mb-2">
          <label class="col-sm-6 control-label text-right" for="pem">Judul</label>
              <input type="text" name="judul" class="form-control">
          </div>
          <div class="form-group mb-2">
          <label class="col-sm-6 control-label text-right" for="pem">Deskripsi</label>
          <textarea name="deskripsi" id="" cols="30" rows="10" class="form-control"></textarea>
          </div>
          <label class="control-label text-right">Hari / Tanggal</label>         
                <div class="col-md-12 mb-3">
                  <input type="date" class="form-control" name="waktu_upload" id="waktu_upload" value="<?php echo $data['waktu']; ?>">
                </div>
         
            
            <div class="modal-footer">
              <button id="nosave" type="button" class="btn btn-danger pull-left" data-bs-dismiss="modal">Batal</button>
              <input type="submit" class="btn btn-primary" name="addArtikel" value="Tambah">
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
      $query = mysqli_query($conn,"SELECT * FROM tbl_berita WHERE id");
      $rows = mysqli_fetch_assoc($query);
      @$id = $rows['id'];
      foreach($query as  $data ): 
      ?>
 <div id="delArtikel<?php echo $data['id']; ?>" class="modal fade" role="dialog" style="display:none;">
    <div class="modal-dialog"> 
      <div class="modal-content">
         <div class="modal-header">
      <pre class="modal-title fs-6 text-purple"><i class="lni lni-trash"></i> Delete</pre>
    </div>
        <div class="modal-body">
          <form action="function.php?id=<?= $id?>" method="post" role="form" enctype="multipart/form-data">
        
             <div class="form-group">
              <div class="row">
                <label class="control-label text-right">Judul Berita</label>         
                <div class="col-md-12 mb-3">
                  <input type="text" class="form-control" name="judul" id="judul" readonly value="<?php echo $data['judul']; ?>">
                </div>
                
              </div>
            </div>
           
            <div class="modal-footer">
              <button id="nosave" type="button" class="btn btn-danger pull-left" data-bs-dismiss="modal">Batal</button>
              <button  type="submit" name="delArtikel" value="<?= $data['id'] ?>" class="btn btn-primary pull-left">Hapus</button>
           
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
    <div id="upArtikel<?php echo $data['id']; ?>" class="modal fade" role="dialog" style="display:none;">
        <div class="modal-dialog"> 
            <div class="modal-content">
                <div class="modal-header">
                    <pre class="modal-title fs-6 text-purple"><i class="lni lni-pencil"></i> Update</pre>
                </div>
                <div class="modal-body">
                    <form action="function.php?id=<?= $data['id'] ?>" method="post" role="form" enctype="multipart/form-data">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-12 text-center">
                                    <img class="img-thumbnail mb-2" src="./file/images/berita/<?= $data['foto'] ?>" style="height: auto; width: 100%;"> <br>
                                    <input class="text-center" type="file" name="foto">
                                </div>
                                <label class="control-label text-right">Judul</label>         
                                <div class="col-md-12 mb-3">
                                    <input type="text" class="form-control" name="judul" id="judul" value="<?php echo $data['judul']; ?>">
                                </div>
                                <label class="control-label text-right">Deskripsi</label>         
                                <div class="col-md-12 mb-3">
                                    <textarea name="deskripsi" id="deskripsi" class="form-control" cols="30" rows="10"><?php echo $data['deskripsi']; ?></textarea>
                                </div>
                                <label class="control-label text-right">Hari / Tanggal</label>         
                                <div class="col-md-12 mb-3">
                                    <input type="date" class="form-control" name="waktu_upload" id="waktu_upload" value="<?php echo date('Y-m-d',strtotime($data["waktu_upload"])) ?>">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button id="nosave" type="button" class="btn btn-danger pull-left" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" name="upArtikel" value="<?= $data['id'] ?>" class="btn btn-primary pull-left">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div><!-- end modal update -->
<?php endforeach ?>


