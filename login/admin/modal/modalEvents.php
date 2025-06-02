
<!-- MODAL ADD KATEGORY -->

<form action="function.php?addEvents" method="POST" role="form" enctype="multipart/form-data">
            <div class="example-modal">
  <div id="addEvents" class="modal fade" role="dialog" style="display:none;">
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
          <label class="col-sm-6 control-label text-right" for="pem">Nama Event</label>
              <input type="text" name="title" class="form-control" required>
          </div>
          <div class="form-group mb-2">
          <label class="col-sm-6 control-label text-right" for="pem">Tanggal Mulai</label>
              <input type="date" name="start" class="form-control" required>
          </div>
          <div class="form-group mb-2">
          <label class="col-sm-6 control-label text-right" for="pem">Tanggal Selesai</label>
              <input type="date" name="end" class="form-control" required>
          </div>
          <div class="form-group mb-2">
          <label class="col-sm-6 control-label text-right" for="pem">Deskripsi</label>
          <textarea name="description" id="" cols="30" rows="10" class="form-control" required></textarea>
          </div>
         
            
            <div class="modal-footer">
              <button id="nosave" type="button" class="btn btn-danger pull-left" data-bs-dismiss="modal">Batal</button>
              <input type="submit" class="btn btn-primary" name="addEvents" value="Tambah">
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
$query = mysqli_query($conn, "SELECT * FROM events");
foreach ($query as $data): 
      ?>
 <div id="delEvents<?php echo $data['id']; ?>" class="modal fade" role="dialog" style="display:none;">
    <div class="modal-dialog"> 
      <div class="modal-content">
         <div class="modal-header">
      <pre class="modal-title fs-6 text-purple"><i class="lni lni-trash"></i> Delete</pre>
    </div>
        <div class="modal-body">
          <form action="function.php?id=<?= $id?>" method="post" role="form" enctype="multipart/form-data">
        
             <div class="form-group">
              <div class="row">
                <label class="control-label text-right">Nama Event</label>         
                <div class="col-md-12 mb-3">
                  <input type="text" class="form-control" name="title" id="title" readonly value="<?php echo $data['title']; ?>">
                </div>
                
              </div>
            </div>
           
            <div class="modal-footer">
              <button id="nosave" type="button" class="btn btn-danger pull-left" data-bs-dismiss="modal">Batal</button>
              <button  type="submit" name="delEvents" value="<?= $data['id'] ?>" class="btn btn-primary pull-left">Hapus</button>
           
            </div>


          </form>
        </div>
      </div>
    </div>
</div><!-- end modal DELETE -->
<?php endforeach ?>
<!-- MODAL UPDATE -->
<?php
foreach ($query as $data):
?>
<div id="upEvents<?php echo $data['id']; ?>" class="modal fade" role="dialog" style="display:none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <pre class="modal-title fs-6 text-purple"><i class="lni lni-pencil"></i> Update</pre>
            </div>
            <div class="modal-body">
                <form action="function.php?id=<?= $data['id'] ?>" method="post" role="form" enctype="multipart/form-data">
                    <div class="form-group">
                        <div class="row">
                      <div class="form-group text-center">
                        <img class="img-thumbnail mb-2" src="./file/images/events/<?= $data['gambar'] ?>" style="height: auto; width: 100%;">
                        <input class="text-center" type="file" name="foto">
                    </div>
                            <label class="control-label text-right">Title</label>
                            <div class="col-md-12 mb-3">
                                <input type="text" class="form-control" name="title" value="<?php echo $data['title']; ?>">
                            </div>
                            <label class="control-label text-right">Start Date</label>
                            <div class="col-md-12 mb-3">
                            <input type="date" class="form-control" name="start" value="<?= htmlspecialchars($data['start']); ?>" required>
                            </div>
                            <label class="control-label text-right">End Date</label>
                            <div class="col-md-12 mb-3">
                                <input type="date" class="form-control" name="end" value="<?php echo $data['end'] ?>">
                            </div>
                            <label class="control-label text-right">Description</label>
                            <div class="col-md-12 mb-3">
                                <textarea name="description"  class="form-control" cols="30" rows="10"><?php echo $data['description']; ?></textarea>
                            </div>
                            
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button id="nosave" type="button" class="btn btn-danger pull-left" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" name="upEvents" value="<?= $data['id'] ?>" class="btn btn-primary pull-left">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div><!-- end modal update -->
<?php endforeach ?>

