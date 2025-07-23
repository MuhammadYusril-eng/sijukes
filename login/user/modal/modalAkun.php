<!-- MODAL UPDATE -->
<?php
//  $id = $_GET['id'];
        // $user_id = $_SESSION['user_id'];
        // $sql = "SELECT * FROM users WHERE id = :user_id";
        // $stmt = $conn->prepare($sql);
        // $stmt->execute(['user_id' => $user_id]);
        // $data = $stmt->fetchAll();
        $user_id = $_SESSION['user_id'];
        $query = mysqli_query($conn, "SELECT * FROM users WHERE id = '$user_id'");
        $data = mysqli_fetch_assoc($query);
      foreach($query as  $rows ): 
      ?>
 <div id="upAkun<?php echo $rows['id']; ?>" class="modal fade" role="dialog" style="display:none;">
    <div class="modal-dialog"> 
      <div class="modal-content">
         <div class="modal-header">
      <pre class="modal-title fs-6 text-purple"><i class="lni lni-pencil"></i> Update</pre>
    </div>
        <div class="modal-body">
          <form action="function.php" method="post" role="form" enctype="multipart/form-data">
        
             <div class="form-group">
              <div class="row">

                <label class="control-label text-right">Pssword</label>         
                <div class="col-md-12 mb-3">
                  <input type="password" name="password" class="form-control">
                </div>
                <label class="control-label text-right">Confirm Password</label>         
                <div class="col-md-12 mb-3">
                <input type="password" name="c_password" class="form-control">
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button id="nosave" type="button" class="btn btn-danger pull-left" data-bs-dismiss="modal">Batal</button>
              <button  type="submit" name="c_pwd" value="" class="btn btn-primary pull-left">Update</button>
           
            </div>


          </form>
        </div>
      </div>
    </div>
</div><!-- end modal update -->
<?php endforeach; ?>