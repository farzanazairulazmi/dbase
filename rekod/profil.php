<?php
// Start the session
session_start();
include '../includes/redirect.php';
include '../includes/connection.php';

$sub_menu = $_GET["sub_menu"];

?>
<!doctype html>
<html lang="en">
  <head>
    <?php include '../includes/header.php'; ?>
  </head>
  <body class="antialiased">
    <div class="wrapper">
      <div class="sticky-top">
        <?php include '../includes/top.php';?>
        <?php include '../includes/menu.php';?>
      </div>
      
      <div class="page-wrapper">
        <div class="container-xl">
          <!-- Page title -->
          <div class="page-header d-print-none">
            <div class="row align-items-center">
              <?php
                if(isset($_SESSION['status_message']) && isset($_SESSION['status_class'])) {
                    echo "
                    <div class='".$_SESSION['status_class']."' role='alert'>
                        ".$_SESSION['status_message']."
                    </div>";
                    
                    $_SESSION['status_message'] = NULL;
                    $_SESSION['status_class'] = NULL;
                }   
              ?>
              <div class="col">
                <!-- Page pre-title -->
                <div class="page-pretitle">
                  Overview
                </div>
                <h2 class="page-title">
								<?php if ($sub_menu == 1){ ?>
                  Maklumat Peribadi
								<?php } elseif ($sub_menu == 2){ ?>
									Senarai Jabatan
								<?php } elseif ($sub_menu == 3){ }?>
                </h2>
              </div>
              <!-- Page title actions -->
              <div class="col-auto ms-auto d-print-none">
                <div class="d-flex">
                <?php if ($sub_menu == 1){ ?>
										<!-- <a href="#" class="btn btn-primary d-none d-sm-inline-block" data-bs-toggle="modal" data-bs-target="#modal-pengguna">
											<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><line x1="12" y1="5" x2="12" y2="19" /><line x1="5" y1="12" x2="19" y2="12" /></svg>
											Kemaskini
										</a> -->
                <?php } elseif ($sub_menu == 2){?>
                  <a href="#" class="btn btn-primary d-none d-sm-inline-block" data-bs-toggle="modal" data-bs-target="#modal-jabatan">
											<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><line x1="12" y1="5" x2="12" y2="19" /><line x1="5" y1="12" x2="19" y2="12" /></svg>
											Jabatan Baru
										</a>
                <?php } ?>
                </div>
              </div>
            </div>
          </div>
        </div>

    <!-- kemaskini maklumat peribadi-->
    <?php
      if(isset($_POST['edit_profile'])){
        $uid = addslashes($_POST["uid"]);	
        $nama_penuh = addslashes($_POST["nama"]);	
        $no_ic = strip_tags(trim($_POST["no_ic"])); 
        $jawatan = addslashes($_POST["jawatan"]);	
        $jabatan = addslashes($_POST["jabatan"]);	
        $emel = addslashes($_POST["emel"]);	
        $no_telefon = strip_tags(trim($_POST["no_telefon"]));
    
        // update to db 
        $sql = "UPDATE step_dbase_users SET username = '".$no_ic."', ".
        "nama_penuh = '".$nama_penuh."', ".
        "jawatan = '".$jawatan."', ".
        "jabatan = '".$jabatan."', ".
        "emel = '".$emel."', ".
        "no_telefon = '".$no_telefon."' ".
        "WHERE uid = ".$uid;	

        if (mysqli_query($conn, $sql)) {
            //echo "Record updated successfully";	
            $_SESSION['status_message'] = "Rekod berjaya dikemaskini.";
            $_SESSION['status_class'] = "alert alert-important alert-success alert-dismissible";

            echo "<script>
            window.location.href = 'profil.php?sub_menu=1';
            </script>";			
        } else {
            echo "Error updating record: " . mysqli_error($conn);
        }	

        mysqli_close($conn);
      }
    ?>
        <div class="page-body">
          <div class="container-xl">
            <div class="row">
              <div class="col-md-4 col-xl-4">
                <div class="card">
                  <div class="card-body text-center">
                    <div class="mb-3">
                      <span class="avatar avatar-xl avatar-rounded" style="background-image: url(../static/avatars/000m.jpg.)"></span>
                    </div>
                    <?php 
                        $x = 1;
                        $sql = "SELECT *
                                FROM step_dbase_users
                                WHERE uid = '".$_SESSION["uid"]."'";
                        $result = mysqli_query($conn, $sql);							

                        if (mysqli_num_rows($result) > 0) {
                          while($row = mysqli_fetch_assoc($result)) {
                          
                          $uid = $row["uid"];
                          $nama = $row["nama_penuh"];
                          $no_ic = $row["username"];
                          $jabatan = $row["jabatan"];
                          $jawatan = $row["jawatan"];
                          $emel = $row["emel"];
                          $no_tel = $row["no_telefon"];
                          
                          }
                        } 
                        ?>
                    <div class="card-title mb-1"><?php echo $nama; ?></div>
                    <div class="text-muted"><?php echo $jawatan; ?></div>
                  </div>
                  <a href="#" class="card-btn">View full profile</a>
                </div>
              </div>
              <div class="col-md-8 col-xl-8">
                <div class="card">
                <form method="post" action="" class="card" id="smart-form">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title">Maklumat Peribadi</h5>
                  </div>
                  <div class="modal-body">
                    <div class="row">

                    <input type="hidden" class="form-control" name="uid" id="uid" value="<?php echo $uid; ?>">

                      <div class="col-lg-12">
                        <div class="mb-3">
                          <label class="form-label required">Nama Penuh</label>
                          <input type="text" class="form-control" name="nama" id="nama" oninput="this.value = this.value.toUpperCase()" value="<?php echo $nama; ?>">
                        </div>
                      </div>
                      <div class="col-lg-6">
                        <div class="mb-3">
                          <label class="form-label required">No. Kad Pengenalan</label>
                          <input type="text" class="form-control" name="no_ic" id="no_ic" oninput="this.value = this.value.toUpperCase()" value="<?php echo $no_ic; ?>">
                        </div>
                      </div>
                      <div class="col-lg-6">
                        <div class="mb-3">
                          <label class="form-label required">Jawatan</label>
                          <input type="text" class="form-control" name="jawatan" id="jawatan" oninput="this.value = this.value.toUpperCase()" value="<?php echo $jawatan; ?>">
                        </div>
                      </div>
                      <div class="col-lg-6">
                          <div class="mb-3">
                            <label class="form-label required">Jabatan</label>
                            <select name="jabatan" id="jabatan" class="form-select">
                              <option value="">Sila pilih...</option>
                                <?php
                                $sql1 ="SELECT ranking, description jabatan FROM step_sso_refgen WHERE mastercode = 1001 AND flag=0 ORDER BY description";
                                $result1 = mysqli_query($conn, $sql1);
                                      if (mysqli_num_rows($result1) > 0) {
                                        while($row1 = mysqli_fetch_assoc($result1)) {
                                          if($jabatan==$row1['ranking']) { 
                                            echo "<option value=".$row1['ranking']." selected>".$row1['jabatan']."</option>";
                                          } else { 
                                              echo "<option value=".$row1['ranking'].">".$row1['jabatan']."</option>";
                                          } 
                                          }
                                      }
                                ?>
                            </select>
                          </div>
                      </div>
                      <div class="col-lg-6">
                        <div class="mb-3">
                          <label class="form-label required">Emel</label>
                          <input type="text" class="form-control" name="emel" id="emel" value="<?php echo $emel; ?>">
                        </div>
                      </div>
                      <div class="col-lg-6">
                        <div class="mb-3">
                          <label class="form-label required">No. Telefon</label>
                          <input type="text" class="form-control" name="no_telefon" id="no_telefon" value="<?php echo $no_tel; ?>">
                        </div>
                      </div>
                      <div class="col-lg-6">
                        <div class="mb-3">
                          <label class="form-label">Kata Laluan</label>
                          <input type="text" class="form-control" name="password" id="password" value="123456" readonly>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button type="submit" name="edit_profile" class="btn btn-primary ms-auto">
                      <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><line x1="12" y1="5" x2="12" y2="19" /><line x1="5" y1="12" x2="19" y2="12" /></svg>
                      Kemaskini
                    </button>
                  </div>
                </div>
                </form>
                </div>
              </div>

            </div>
          </div>
        </div>
        <footer class="footer footer-transparent d-print-none">
          <?php include '../includes/footer.php'; ?>
        </footer>
      </div>
    </div>

     <!-- to close modal -->
     <script>
      $(document).ready(function(){  
          // Close modal on button click
          $(".close").click(function(){
              $("#modal-kemaskini-jabatan").modal('hide');
              $("#modal-kemaskini-pengguna").modal('hide');
          });
      });
    </script>
    



    <script>
      //datatables
      require(['datatables', 'jquery'], function(datatable, $) {
        $('.datatable').DataTable();
      });
    </script>
    
    <script type="text/javascript">
	
    $(function() {

      /* @ validation and submition
      ---------------------------------- */		
      $('form').each(function() {   // <- selects every <form> on page
      $(this).validate({ 		
                    
                    errorClass: "is-invalid text-red",
                    validClass: "is-valid",
                    errorElement: "em",
                    rules: {
                      nama: {
                            required: true	
                      },
                      no_ic: {
                            required: true,
                            number: true,
                            maxlength: 12,
                            minlength: 12
                      },
                      no_telefon: {
                            required: true,
                            number: true	
                      },
                      jawatan: {
                            required: true
                      },
                      jabatan: {
                            required: true	
                      },
                      emel: {
                            required: true,
                            email: true	
                      },
                      no_kp: {
                            required: true,
                            number: true,
                            maxlength: 12,
                            minlength: 12
                      }
                    },
                    messages:{
                      nama: {
                            required: 'Sila masukkan nama penuh'
                      },
                      no_ic: {
                            required: 'Sila masukkan No.K.P',
                            number: 'Nombor sahaja',
                            maxlength: 'Sila masukkan no. tidak melebihi 12 digit',
                            minlength: 'Sila masukkan no. tidak kurang 12 digit'
                      },
                      no_telefon: {
                            required: 'Sila masukkan no. telefon',
                            number:'Nombor sahaja'
                      },
                      jawatan: {
                            required: 'Sila pilh jawatan'
                      },
                      jabatan: {
                            required: 'Sila masukkan jabatan'	
                      },
                      emel: {
                            required: 'Sila masukkan emel',
                            email:'Masukkan emel yang sah'
                      },
                      no_kp: {
                            required: 'Sila masukkan No.K.P',
                            number: 'Nombor sahaja',
                            maxlength: 'Sila masukkan no. tidak melebihi 12 digit',
                            minlength: 'Sila masukkan no. tidak kurang 12 digit'
                      },
                    },	
              });		
              });
                
      });			        
    </script>
		
   
  </body>
</html>