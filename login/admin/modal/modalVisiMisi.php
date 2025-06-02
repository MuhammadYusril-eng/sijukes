
<!-- MODAL ADD KATEGORY -->

<form action="function.php?addVisiMisi" method="POST" role="form" enctype="multipart/form-data">
            <div class="example-modal">
  <div id="addVisiMisi" class="modal fade" role="dialog" style="display:none;">
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
          <label class="col-sm-6 control-label text-right" for="pem">Visi</label>
          <textarea name="visi" id="" cols="30" rows="10" class="form-control"></textarea>
          </div>
          <div class="form-group mb-2">
          <label class="col-sm-6 control-label text-right" for="pem">Misi</label>
          <textarea name="misi" id="" cols="30" rows="10" class="form-control"></textarea>
          </div>
         
            
            <div class="modal-footer">
              <button id="nosave" type="button" class="btn btn-danger pull-left" data-bs-dismiss="modal">Batal</button>
              <input type="submit" class="btn btn-primary" name="addVisiMisi" value="Tambah">
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
      $query = mysqli_query($conn,"SELECT * FROM tbl_visi_misi");
      $rows = mysqli_fetch_assoc($query);
      @$id = $rows['id'];
      foreach($query as  $data ): 
      ?>
 <div id="delVisiMisi<?php echo $data['id']; ?>" class="modal fade" role="dialog" style="display:none;">
    <div class="modal-dialog"> 
      <div class="modal-content">
         <div class="modal-header">
      <pre class="modal-title fs-6 text-purple"><i class="lni lni-trash"></i> Delete</pre>
    </div>
        <div class="modal-body">
          <form action="function.php?id=<?= $id?>" method="post" role="form" enctype="multipart/form-data">
        
             <div class="form-group">
              <div class="row">
                <label class="control-label text-right">Visi</label>         
                <div class="col-md-12 mb-3">
                    <textarea class="form-control" name="visi" id="" cols="30" rows="10"><?php echo $data['visi']; ?></textarea>
                </div>
                <label class="control-label text-right">Misi</label>         
                <div class="col-md-12 mb-3">
                    <textarea class="form-control" name="misi" id="" cols="30" rows="10"><?php echo $data['misi']; ?></textarea>
                </div>
                
              </div>
            </div>
           
            <div class="modal-footer">
              <button id="nosave" type="button" class="btn btn-danger pull-left" data-bs-dismiss="modal">Batal</button>
              <button  type="submit" name="delVisiMisi" value="<?= $data['id'] ?>" class="btn btn-primary pull-left">Hapus</button>
           
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
      $query = mysqli_query($conn,"SELECT * FROM tbl_visi_misi WHERE id");
      $rows = mysqli_fetch_assoc($query);
      @$id = $rows['id'];
      foreach($query as  $rows ): 
      ?>
 <div id="upVisiMisi<?php echo $rows['id']; ?>" class="modal fade" role="dialog" style="display:none;">
    <div class="modal-dialog"> 
      <div class="modal-content">
         <div class="modal-header">
      <pre class="modal-title fs-6 text-purple"><i class="lni lni-pencil"></i> Update</pre>
    </div>
        <div class="modal-body">
          <form action="function.php?id=<?= $id?>" method="post" role="form" enctype="multipart/form-data">
        
             <div class="form-group">
              <div class="row">

                <label class="control-label text-right">VIsi</label>         
                <div class="col-md-12 mb-3">
                  <textarea class="form-control" name="visi" id="visi" cols="10" rows="8"><?php echo $rows['visi']; ?></textarea cla>
                </div>
                <label class="control-label text-right">Misi</label>         
                <div class="col-md-12 mb-3">
                <textarea class="form-control" name="misi" id="misi" cols="10" rows="8"><?php echo $rows['misi']; ?></textarea>

                </div>
     

              </div>
            </div>
           
            <div class="modal-footer">
              <button id="nosave" type="button" class="btn btn-danger pull-left" data-bs-dismiss="modal">Batal</button>
              <button  type="submit" name="upVisiMisi" value="" class="btn btn-primary pull-left">Update</button>
           
            </div>


          </form>
        </div>
      </div>
    </div>
</div><!-- end modal update -->
<?php endforeach ?>


