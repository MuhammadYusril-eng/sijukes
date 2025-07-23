
<!-- MODAL ADD KATEGORY -->

<form action="function.php?addpen" method="POST" role="form" enctype="multipart/form-data">
            <div class="example-modal">
  <div id="addPen" class="modal fade" role="dialog" style="display:none;">
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
          <label class="col-sm-6 control-label text-right" for="pem">Nama</label>
              <input type="text" name="nama" class="form-control">
          </div> 
          <div class="form-group mb-2">
          <label>Jenis Kelamin</label>
        <select id="jenis_kelamin" name="jenis_kelamin" class="form-control">
        <option value="">-- Pilih --</option>
        <?php
            $query = mysqli_query($conn,"SELECT * FROM tbl_jk");
            while ($data = mysqli_fetch_assoc($query))
            {
            ?>
        <option value="<?=$data['jenis_kelamin'];?>"><?=$data['jenis_kelamin'];?></option>
        <?php }?>
    </select>
         </div>    
         <div class="form-group mb-2">
          <label class="col-sm-6 control-label text-right">Umur</label>
              <input type="number" name="umur" class="form-control">
          </div>     
             
              <div class="form-group mb-2">
          <label class="col-sm-6 control-label text-right" for="pem">NIK / Nomor Induk Kependudukan</label>
              <input type="number" name="nik" class="form-control">
          </div> 
          <div class="form-group mb-2">
          <label>Pendidikan</label>
        <select id="pendidikan" name="pendidikan" class="form-control">
        <option value="">-- Pilih --</option>
        <?php
            $query = mysqli_query($conn,"SELECT * FROM tbl_pendidikan");
            while ($data = mysqli_fetch_assoc($query))
            {
            ?>
        <option value="<?=$data['nama_pendidikan'];?>"><?=$data['nama_pendidikan'];?></option>
        <?php }?>
    </select>
         </div> 
         <div class="form-group mb-2">
          <label>Agama</label>
        <select id="agama" name="agama" class="form-control">
        <option value="">-- Pilih --</option>
        <?php
            $query = mysqli_query($conn,"SELECT * FROM tbl_agama");
            while ($data = mysqli_fetch_assoc($query))
            {
            ?>
        <option value="<?=$data['agama'];?>"><?=$data['agama'];?></option>
        <?php }?>
    </select>
         </div>  
         <div class="form-group mb-2">
          <label>Pekerjaan</label>
        <select id="pekerjaan" name="pekerjaan" class="form-control">
        <option value="">-- Pilih --</option>
        <?php
            $query = mysqli_query($conn,"SELECT * FROM tbl_pekerjaan");
            while ($data = mysqli_fetch_assoc($query))
            {
            ?>
        <option value="<?=$data['nama_pekerjaan'];?>"><?=$data['nama_pekerjaan'];?></option>
        <?php }?>
    </select>
         </div>  
         <div class="form-group mb-2">
          <label class="col-sm-6 control-label text-right">Status</label>
          <select name="status_perkawinan" id="status_perkawinan" class="form-control">
            <option value="">-- Pilih --</option>
            <option value="Belum Menikah">Belum Menikah</option>
            <option value="Menikah">Menikah</option>
          </select>
              </div>      
            
            <div class="modal-footer">
              <button id="nosave" type="button" class="btn btn-danger pull-left" data-bs-dismiss="modal">Batal</button>
              <input type="submit" class="btn btn-primary" name="addpen" value="Tambah">
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
      $query = mysqli_query($conn,"SELECT * FROM tbl_penduduk WHERE id");
      $rows = mysqli_fetch_assoc($query);
      @$id = $rows['id'];
      foreach($query as  $data ): 
      ?>
 <div id="delPen<?php echo $data['id']; ?>" class="modal fade" role="dialog" style="display:none;">
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
                  <input type="text" class="form-control" name="nama" id="nama" readonly value="<?php echo $data['nama']; ?>">
                </div>
                <label class="control-label text-right"> NIK / Nomor Induk Kependudukan</label>         
                <div class="col-md-12 mb-3">
                <input type="text" class="form-control" name="nik" id="nik" readonly value="<?php echo $data['nik']; ?>">
                </div>
              </div>
            </div>
           
            <div class="modal-footer">
              <button id="nosave" type="button" class="btn btn-danger pull-left" data-bs-dismiss="modal">Batal</button>
              <button  type="submit" name="delPen" value="<?= $data['id'] ?>" class="btn btn-primary pull-left">Hapus</button>
           
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
 <div id="upPen<?php echo $data['id']; ?>" class="modal fade" role="dialog" style="display:none;">
    <div class="modal-dialog"> 
      <div class="modal-content">
         <div class="modal-header">
      <pre class="modal-title fs-6 text-purple"><i class="lni lni-pencil"></i> Update</pre>
    </div>
        <div class="modal-body">
          <form action="function.php?id=<?= $data['id']?>" method="post" role="form" enctype="multipart/form-data">

             <div class="form-group">
              <div class="row">
                <label class="control-label text-right">Nama</label>         
                <div class="col-md-12 mb-3">
                  <input type="text" class="form-control" name="nama" id="nama" value="<?php echo $data['nama']; ?>">
                </div>
                <label>Jenis Kelamin</label>
                <div class="col-md-12 mb-3">

                        <select id="jenis_kelamin" name="jenis_kelamin" class="form-control">
              <option value="<?= $data['jenis_kelamin'] ?>"><?= $data['jenis_kelamin'] ?></option>
              <?php
                  $query = mysqli_query($conn,"SELECT * FROM tbl_jk ORDER BY jenis_kelamin DESC");
                  while ($rows = mysqli_fetch_assoc($query))
                  {
                  ?>
                <option value="<?=$rows['jenis_kelamin'];?>"><?=$rows['jenis_kelamin'];?></option>
              <?php }?>
            </select>
                  </div>
                  <label>Agama</label>
                  <div class="col-md-12 mb-3">
                  <select id="agama" name="agama" class="form-control">
                  <option value="<?= $data['agama'] ?>"><?= $data['agama'] ?></option>
                  <?php
                      $query = mysqli_query($conn,"SELECT * FROM tbl_agama");
                      while ($rows = mysqli_fetch_assoc($query))
                      {
                      ?>
                  <option value="<?=$rows['agama'];?>"><?=$rows['agama'];?></option>
                  <?php }?>
              </select>
                  </div>  
                  <label>Pekerjaan</label>
                <div class="col-md-12 mb-3">

                        <select id="pekerjaan" name="pekerjaan" class="form-control">
              <option value="<?= $data['pekerjaan'] ?>"><?= $data['pekerjaan'] ?></option>
              <?php
                  $query = mysqli_query($conn,"SELECT * FROM tbl_pekerjaan ORDER BY nama_pekerjaan DESC");
                  while ($rows = mysqli_fetch_assoc($query))
                  {
                  ?>
                <option value="<?=$rows['nama_pekerjaan'];?>"><?=$rows['nama_pekerjaan'];?></option>
              <?php }?>
            </select>
                  </div>
                  <label>Pendidikan</label>
                <div class="col-md-12 mb-3">
                        <select id="pendidikan" name="pendidikan" class="form-control">
              <option value="<?= $data['pendidikan'] ?>"><?= $data['pendidikan'] ?></option>
              <?php
                  $query = mysqli_query($conn,"SELECT * FROM tbl_pendidikan ORDER BY nama_pendidikan DESC");
                  while ($rows = mysqli_fetch_assoc($query))
                  {
                  ?>
                <option value="<?=$rows['nama_pendidikan'];?>"><?=$rows['nama_pendidikan'];?></option>
              <?php }?>
            </select>
                  </div>
                  <label class="control-label text-right">Umur</label>         
                <div class="col-md-12 mb-3">
                  <input type="text" class="form-control" name="umur" id="umur" value="<?php echo $data['umur']; ?>">
                </div>
                <label class="control-label text-right">Status</label>         
                <div class="col-md-12 mb-3">
                 <select name="status_perkawinan" id="status_perkawinan" class="form-control">
                  <option value="<?= $data['status_perkawinan'] ?>"><?= $data['status_perkawinan'] ?></option>
                  <option value="Menikah">Menikah</option>
                  <option value="Belum Menikah">Belum Menikah</option>
                 </select>
                </div>

                <label class="control-label text-right">NIK / Nomor Induk Kependudukan</label>         
                <div class="col-md-12 mb-3">
                  <input type="number" class="form-control" name="nik" id="nik" value="<?php echo $data['nik']; ?>">
                </div>

              </div>
            </div>
           
            <div class="modal-footer">
              <button id="nosave" type="button" class="btn btn-danger pull-left" data-bs-dismiss="modal">Batal</button>
              <button  type="submit" name="upPen" value="" class="btn btn-primary pull-left">Update</button>
           
            </div>


          </form>
        </div>
      </div>
    </div>
</div><!-- end modal update -->
<?php endforeach ?>


