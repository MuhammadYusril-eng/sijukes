
<!-- MODAL ADD KATEGORY -->

<form action="function.php?addSambutan" method="POST" role="form" enctype="multipart/form-data">
            <div class="example-modal">
  <div id="addSambutan" class="modal fade" role="dialog" style="display:none;">
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
              <input type="file" name="foto" class="form-control">
          </div> 
          <div class="form-group mb-2">
          <label class="col-sm-6 control-label text-right" for="pem">Nama</label>
              <input type="text" name="nama_lurah" class="form-control">
          </div>
          <div class="form-group mb-2">
          <label class="col-sm-6 control-label text-right" for="pem">Sambutan</label>
          <textarea name="sambutan" id="" cols="30" rows="10" class="form-control"></textarea>
          </div>
         
            
            <div class="modal-footer">
              <button id="nosave" type="button" class="btn btn-danger pull-left" data-bs-dismiss="modal">Batal</button>
              <input type="submit" class="btn btn-primary" name="addSambutan" value="Tambah">
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
      $query = mysqli_query($conn,"SELECT * FROM tbl_sambutan");
      $rows = mysqli_fetch_assoc($query);
      @$id = $rows['id'];
      foreach($query as  $data ): 
      ?>
 <div id="delSambutan<?php echo $data['id']; ?>" class="modal fade" role="dialog" style="display:none;">
    <div class="modal-dialog"> 
      <div class="modal-content">
         <div class="modal-header">
      <pre class="modal-title fs-6 text-purple"><i class="lni lni-trash"></i> Delete</pre>
    </div>
        <div class="modal-body">
          <form action="function.php?id=<?= $id?>" method="post" role="form" enctype="multipart/form-data">
        
             <div class="form-group">
              <div class="row">
                <label class="control-label text-right">Nama Lurah</label>         
                <div class="col-md-12 mb-3">
                  <input type="text" class="form-control" name="nama_lurah" id="nama_lurah" readonly value="<?php echo $data['nama_lurah']; ?>">
                </div>
                <label class="control-label text-right">Sambutan</label>         
                <div class="col-md-12 mb-3">
                  <textarea name="sambutan" id="sambutan" class="form-control" cols="30" rows="10"><?php echo $data['sambutan']; ?></textarea>
                </div>
                
              </div>
            </div>
           
            <div class="modal-footer">
              <button id="nosave" type="button" class="btn btn-danger pull-left" data-bs-dismiss="modal">Batal</button>
              <button  type="submit" name="delSambutan" value="<?= $data['id'] ?>" class="btn btn-primary pull-left">Hapus</button>
           
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
      foreach ($query as $data) :

      ?>
 <div id="upSambutan<?php echo $data['id']; ?>" class="modal fade" role="dialog" style="display:none;">
    <div class="modal-dialog"> 
      <div class="modal-content">
         <div class="modal-header">
      <pre class="modal-title fs-6 text-purple"><i class="lni lni-pencil"></i> Update</pre>
    </div>
        <div class="modal-body">
          <form action="function.php?id=<?= $id?>" method="post" role="form" enctype="multipart/form-data">
        
             <div class="form-group">
              <div class="row">

                <div class="col-md-12 text-center">
                <img class="img-thumbnail mb-2" src="./file/images/fotoLurah/<?= $data['foto'] ?>" style="height:auto; width: 100%;"> <br>
                <input class="text-center" type="file" name="foto">
                </div>
                <label class="control-label text-right">Nama Lurah</label>         
                <div class="col-md-12 mb-3">
                  <input type="text" class="form-control" name="nama_lurah" id="nama_lurah" value="<?php echo $data['nama_lurah']; ?>">
                </div>
                <label class="control-label text-right">Sambutan</label>         
                <div class="col-md-12 mb-3">
                  <textarea name="sambutan" id="sambutan" class="form-control" cols="30" rows="10"><?php echo $data['sambutan']; ?></textarea>
                </div>
     

              </div>
            </div>
           
            <div class="modal-footer">
              <button id="nosave" type="button" class="btn btn-danger pull-left" data-bs-dismiss="modal">Batal</button>
              <button  type="submit" name="upSambutan" value="" class="btn btn-primary pull-left">Update</button>
           
            </div>


          </form>
        </div>
      </div>
    </div>
</div><!-- end modal update -->
<?php endforeach ?>


