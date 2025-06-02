
<!-- MODAL ADD KATEGORY -->

<form action="function.php?addKuliner" method="POST" role="form" enctype="multipart/form-data">
            <div class="example-modal">
  <div id="addKuliner" class="modal fade" role="dialog" style="display:none;">
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
          <div class="form-group mb-2">
          <label class="col-sm-6 control-label text-right" for="pem">No WhatsApp</label>
              <input type="text" name="noWa" class="form-control">
          </div>
          <div class="form-group mb-2">
          <label class="col-sm-6 control-label text-right" for="pem">username Instagram</label>
              <input type="text" name="usernameIG" class="form-control">
          </div>
          <label class="control-label text-right">Hari / Tanggal</label>         
                <div class="col-md-12 mb-3">
                  <input type="date" class="form-control" name="waktu_upload" id="waktu" value="">
                </div>
         
            
            <div class="modal-footer">
              <button id="nosave" type="button" class="btn btn-danger pull-left" data-bs-dismiss="modal">Batal</button>
              <input type="submit" class="btn btn-primary" name="addKuliner" value="Tambah">
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
      $query = mysqli_query($conn,"SELECT * FROM tbl_kuliner  ");
      $rows = mysqli_fetch_assoc($query);
      @$id = $rows['id'];
      foreach($query as  $data ): 
      ?>
 <div id="delKuliner<?php echo $data['id']; ?>" class="modal fade" role="dialog" style="display:none;">
    <div class="modal-dialog"> 
      <div class="modal-content">
         <div class="modal-header">
      <pre class="modal-title fs-6 text-purple"><i class="lni lni-trash"></i> Delete</pre>
    </div>
        <div class="modal-body">
          <form action="function.php?id=<?= $id?>" method="post" role="form" enctype="multipart/form-data">
        
             <div class="form-group">
              <div class="row">
                <label class="control-label text-right">Nama Kuliner</label>         
                <div class="col-md-12 mb-3">
                  <input type="text" class="form-control" name="judul" id="judul" readonly value="<?php echo $data['judul']; ?>">
                </div>
                
              </div>
            </div>
           
            <div class="modal-footer">
              <button id="nosave" type="button" class="btn btn-danger pull-left" data-bs-dismiss="modal">Batal</button>
              <button  type="submit" name="delKuliner" value="<?= $data['id'] ?>" class="btn btn-primary pull-left">Hapus</button>
           
            </div>


          </form>
        </div>
      </div>
    </div>
</div><!-- end modal DELETE -->
<?php endforeach ?>

<!-- MODAL UPDATE -->
<?php
//  $id = $_GET['id'];
      foreach($query as  $rows ): 
      ?>
 <div id="upKuliner<?php echo $rows['id']; ?>" class="modal fade" role="dialog" style="display:none;">
    <div class="modal-dialog"> 
      <div class="modal-content">
         <div class="modal-header">
      <pre class="modal-title fs-6 text-purple"><i class="lni lni-pencil"></i> Update</pre>
    </div>
        <div class="modal-body">
          <form action="function.php?id=<?= $rows['id']?>" method="post" role="form" enctype="multipart/form-data">
        
             <div class="form-group">
              <div class="row">

                <div class="col-md-12 text-center">
                <img class="img-thumbnail mb-2" src="./file/images/galeri/<?= $rows['foto'] ?>" style="height: auto; width: 100%;"> <br>
                <input class="text-center" type="file" name="foto">
                </div>
                <label class="control-label text-right">Judul</label>         
                <div class="col-md-12 mb-3">
                  <input type="text" class="form-control" name="judul" id="judul" value="<?php echo $rows['judul']; ?>">
                </div>
                
                <label class="control-label text-right">Deskripsi</label>         
                <div class="col-md-12 mb-3">
                  <textarea name="deskripsi" id="deskripsi" class="form-control" cols="30" rows="10"><?php echo $rows['deskripsi']; ?></textarea>
                </div>
                <label class="control-label text-right">Nomor WhatsApp</label>         
                <div class="col-md-12 mb-3">
                  <input type="text" class="form-control" name="noWa" id="noWa" value="<?php echo $rows['noWa']; ?>">
                </div>
                <label class="control-label text-right">Username IG</label>         
                <div class="col-md-12 mb-3">
                  <input type="text" class="form-control" name="usernameIG" id="usernameIG" value="<?php echo $rows['usernameIG']; ?>">
                </div>
                <label class="control-label text-right">Waktu Upload</label>         
                <div class="col-md-12 mb-3">
                  <input type="date" class="form-control" name="waktu_upload" id="waktu_upload" value="<?php echo $data['waktu_upload']; ?>">
                </div>
     

              </div>
            </div>
           
            <div class="modal-footer">
              <button id="nosave" type="button" class="btn btn-danger pull-left" data-bs-dismiss="modal">Batal</button>
              <button  type="submit" name="upKuliner" value="" class="btn btn-primary pull-left">Update</button>
           
            </div>


          </form>
        </div>
      </div>
    </div>
</div><!-- end modal update -->
<?php endforeach ?>


