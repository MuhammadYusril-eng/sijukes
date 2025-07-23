
<!-- MODAL ADD KATEGORY -->

<form action="function.php?addPD" method="POST" role="form" enctype="multipart/form-data">
            <div class="example-modal">
  <div id="addPD" class="modal fade" role="dialog" style="display:none;">
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
          <label class="col-sm-6 control-label text-right" for="pem">nama</label>
              <input type="text" name="nama" class="form-control">
          </div> 
          <div class="form-group mb-2">
          <label class="col-sm-6 control-label text-right" for="pem">Jabatan</label>
              <select name="jabatan" id="jabatan" class="form-control">
              <option value="Kepala Desa">Kepala Desa</option>
                <option value="Sekretaris">Sekretaris</option>
                <option value="Bendahara">Bendahara</option>
              </select>
          </div>
          <div class="form-group mb-2">
          <label class="col-sm-6 control-label text-right" for="pem">Foto</label>
          <input type="file" name="foto" class="form-control">
          </div>
            
            <div class="modal-footer">
              <button id="nosave" type="button" class="btn btn-danger pull-left" data-bs-dismiss="modal">Batal</button>
              <input type="submit" class="btn btn-primary" name="addPD" value="Tambah">
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
      $query = mysqli_query($conn,"SELECT * FROM tbl_perangkat_desa WHERE id");
      $rows = mysqli_fetch_assoc($query);
      @$id = $rows['id'];
      foreach($query as  $data ): 
      ?>
 <div id="delPD<?php echo $data['id']; ?>" class="modal fade" role="dialog" style="display:none;">
    <div class="modal-dialog"> 
      <div class="modal-content">
         <div class="modal-header">
      <pre class="modal-title fs-6 text-purple"><i class="lni lni-trash"></i> Delete</pre>
    </div>
        <div class="modal-body">
          <form action="function.php?id=<?= $id?>" method="post" role="form" enctype="multipart/form-data">
        
             <div class="form-group">
              <div class="row">
                <label class="control-label text-right">Nama Pegawai</label>         
                <div class="col-md-12 mb-3">
                  <input type="text" class="form-control" name="nama" id="nama" readonly value="<?php echo $data['nama']; ?>">
                </div>
                
              </div>
            </div>
           
            <div class="modal-footer">
              <button id="nosave" type="button" class="btn btn-danger pull-left" data-bs-dismiss="modal">Batal</button>
              <button  type="submit" name="delPD" value="<?= $data['id'] ?>" class="btn btn-primary pull-left">Hapus</button>
           
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
    <div id="upPD<?php echo $data['id']; ?>" class="modal fade" role="dialog" style="display:none;">
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
                                    <img class="img-thumbnail mb-2" src="./file/images/perangkatDesa/<?= $data['foto'] ?>" style="height: auto; width: 100%;"> <br>
                                    <input class="text-center" type="file" name="foto">
                                </div>
                                <label class="control-label text-right">Nama</label>         
                                <div class="col-md-12 mb-3">
                                    <input type="text" class="form-control" name="nama" id="nama" value="<?php echo $data['nama']; ?>">
                                </div>
                                <label class="control-label text-right">Jabatan</label>         
                                <div class="col-md-12 mb-3">
                                <select id="jabatan" name="jabatan" class="form-control">
                                    <option value="<?= $data['jabatan'] ?>"><?= $data['jabatan'] ?></option>
                                    <option value="Kepala Desa">Kepala Desa</option>
                                    <option value="Sekretaris">Sekretaris</option>
                                    <option value="Bendahara">Bendahara</option>
                                </select>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button id="nosave" type="button" class="btn btn-danger pull-left" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" name="upPD" value="<?= $data['id'] ?>" class="btn btn-primary pull-left">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div><!-- end modal update -->
<?php endforeach ?>


