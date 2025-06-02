

<!-- modal add -->
     
          <form action="function-akun.php?act=tambah_akun" method="POST" role="form" enctype="multipart/form-data">
            <div class="example-modal">
  <div id="tambah_akun" class="modal fade" role="dialog" style="display:none;">
    <div class="modal-dialog"> 
      <div class="modal-content">
        <div class="modal-header">
        <pre class="modal-title fs-6 text-purple"><i class="bi bi-node-plus-fill"></i> Add</pre>
        </div>
        <div class="modal-body">
                     
             <div class="form-group mb-2">
              <div class="row">
               <!-- <label for="upload-file" class="img-upload text-center" title="Klik untuk upload gambar">
          <img src="" onerror="this.src='files/thumbnail/upload_image.png'" class="img-thumbnail" id="showPreview">
        </label> -->
        <!-- <input type="file" id="upload-file" name="img" id="img" class="d-none" accept="image/*"  onchange="ImgPreview(event,'showPreview');"> -->
              </div>
            </div>
            <div class="form-group mb-2">
              <div class="row">
              <label class="col-sm-6 control-label text-right">Username</label>   
              <div class=""><input type="text" class="form-control" name="nama" id="nama" required></div>
              </div>
            </div>

               <div class="form-group mb-2">
              <div class="row">
              <label class="col-sm-6 control-label text-right">Email</label>   
              <div class=""><input type="text" class="form-control" name="email" id="email" required></div>
              </div>
            </div>


               <div class="form-group mb-2">
              <div class="row">
              <label class="col-sm-6 control-label text-right">Password</label>   
              <div class=""><input type="text" class="form-control" name="password" id="password" required></div>
              </div>
            </div>
            
            
            
            
            
            <div class="modal-footer">
              <button id="nosave" type="button" class="btn btn-danger pull-left" data-bs-dismiss="modal">Batal</button>
              <input type="submit" class="btn btn-primary" name="tambahartikel">
            </div>
                   </div>
      </div>
    </div>
  </div>
</div>
 </form>
 <!-- modal Add close --> 


      <?php
      $query = mysqli_query($conn,"SELECT * FROM users WHERE level='admin'");
      // $no = 1;
      foreach($query as  $data ): 
      ?>
 <div id="edit<?= $data['id_user'];?>" class="modal fade" role="dialog" style="display:none;">
    <div class="modal-dialog"> 
      <div class="modal-content">
         <div class="modal-header">
      <pre class="modal-title fs-6 text-purple"><i class="bi bi-vector-pen"></i> Update</pre>
    </div>
        <div class="modal-body">
          <form action="function.php?act=update" method="post" role="form" enctype="multipart/form-data">

            <div class="form-group">
              <div class="row">
                <label class="control-label text-right">Username</label>         
                <div class="col-md-12 mb-3">
                  <input type="text" class="form-control" name="nama_tim" id="nama_tim" value="<?php echo $data['nama']; ?>">
                </div>
              </div>
            </div>

             <div class="form-group">
              <div class="row">
                <label class="control-label text-right">Email</label>         
                <div class="col-md-12 mb-3">
                  <input type="text" class="form-control" name="ketua_tim" id="ketua_tim" value="<?php echo $data['email']; ?>">
                </div>
              </div>
            </div>
            
             <div class="form-group">
              <div class="row">
                <label class="control-label text-right">Password</label>         
                <div class="col-md-12 mb-3">
                  <input type="text" class="form-control" name="pembimbing_tim" id="pembimbing_tim" value="<?php echo $data['password']; ?>">
                </div>
              </div>
            </div>
           
            <div class="modal-footer">
              <button id="nosave" type="button" class="btn btn-danger pull-left" data-bs-dismiss="modal">Batal</button>
              <button  type="submit" name="update" value="<?= $data['id_user']?>" class="btn btn-primary pull-left">Simpan</button>
           
            </div>


          </form>
        </div>
      </div>
    </div>
</div><!-- end modal update -->
<?php endforeach ?>