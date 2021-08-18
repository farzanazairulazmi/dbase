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
                  Jabatan: Senarai Pengguna
								<?php } elseif ($sub_menu == 2){ ?>
									Senarai Jabatan
								<?php } elseif ($sub_menu == 3){ }?>
                </h2>
              </div>
              <!-- Page title actions -->
              <div class="col-auto ms-auto d-print-none">
                <div class="d-flex">
                <?php if ($sub_menu == 1){ ?>
										<a href="#" class="btn btn-primary d-none d-sm-inline-block" data-bs-toggle="modal" data-bs-target="#modal-pengguna">
											<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><line x1="12" y1="5" x2="12" y2="19" /><line x1="5" y1="12" x2="19" y2="12" /></svg>
											Jabatan: Pengguna Baru
										</a>
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
        <div class="page-body">
          <div class="container-xl">
            <div class="row row-deck row-cards">
						<div class="col-12">
              <div class="card">
							<?php if ($sub_menu == 1){ //pengguna?> 
                  <div class="card-header">
                    <h3 class="card-title">Jabatan: Senarai Pengguna </h3>
                  </div>
                  <div class="table-responsive">
                    <table class="table table-vcenter card-table datatable">
                      <thead>
                        <tr>
													<th class="w-1">Bil.</th>
                          <th>Nama Penuh</th>
                          <th>No. Kad Pengenalan</th>
                          <th>Jawatan</th>
                          <th>Jabatan</th>
                          <th>Emel</th>
                          <th>No. Telefon</th>
                          <th width="17%">Tindakan</th>
                        </tr>
                      </thead>
                      <tbody>
                      <?php 
                        $x = 1;
                        $sql = "SELECT a.*,b.description nama_jabatan
                                FROM step_dbase_users a 
                                LEFT JOIN step_sso_refgen b 
                                ON a.jabatan = b.ranking
                                WHERE a.flag=0 AND b.mastercode=1001 ORDER BY a.jabatan,a.nama_penuh";
                        $result = mysqli_query($conn, $sql);							

                        if (mysqli_num_rows($result) > 0) {
                          while($row = mysqli_fetch_assoc($result)) {
                      ?>
                        <tr>
													<td><?php echo $x;?>.</td>
                          <td><?php echo $row["nama_penuh"];?></td>
                          <td><?php echo $row["username"];?></td>
                          <td><?php echo $row["jawatan"];?></td>
                          <td><?php echo $row["nama_jabatan"];?></td>
                          <td><?php echo $row["emel"];?></td>
                          <td><?php echo $row["no_telefon"];?></td>
                          <td>
                            <button type="submit" class="btn btn-primary btn-sm ms-auto edit_user" data-bs-toggle="modal" data-bs-target="#modal-kemaskini-pengguna" 
                            data-sqno=<?php echo $row["sqno"] ?>>Kemaskini</button>
                            <a href="tetapan_db.php?sub_menu=15&sqno=<?php echo $row['sqno'];?>" class="btn btn-danger btn-sm ms-auto" data-bs-dismiss="modal" onclick="return confirm('Adakah anda pasti mahu padam rekod ini?');">Padam</a>
                          </td>
                        </tr>
                        <?php
                        $x = $x + 1;
                          }
                        } 
                        ?>
                      </tbody>
                    </table>
                  </div>
              <?php } elseif ($sub_menu == 2){ //senarai jabatan?> 
                  <div class="card-header">
                    <h3 class="card-title">Senarai Jabatan </h3>
                  </div>
                  <div class="table-responsive">
                    <table class="table table-vcenter card-table datatable">
                      <thead>
                        <tr>
													<th class="w-1">Bil.</th>
                          <th>Nama </th>
                          <th width="17%">Tindakan</th>
                        </tr>
                      </thead>
                      <tbody>
                      <?php 
                        $x = 1;
                        $sql = "SELECT *
                                FROM step_sso_refgen
                                WHERE mastercode=1001 AND flag=0 ORDER BY description";
                        $result = mysqli_query($conn, $sql);							

                        if (mysqli_num_rows($result) > 0) {
                          while($row = mysqli_fetch_assoc($result)) {
                      ?>
                        <tr>
													<td><?php echo $x;?>.</td>
                          <td><?php echo $row["description"];?></td>
                          <td>
                            <button type="submit" class="btn btn-primary btn-sm ms-auto edit_jabatan" data-bs-toggle="modal" data-bs-target="#modal-kemaskini-jabatan" 
                            data-id=<?php echo $row["id"] ?>>Kemaskini</button>
                            <a href="tetapan_db.php?sub_menu=24&id=<?php echo $row['id'];?>" class="btn btn-danger btn-sm ms-auto" data-bs-dismiss="modal" onclick="return confirm('Adakah anda pasti mahu padam rekod ini?');">Padam</a>
                          </td>
                        </tr>
                        <?php
                        $x = $x + 1;
                          }
                        } 
                        ?>
                      </tbody>
                    </table>
                  </div>
              <?php }else{?>
										error
							<?php }?>	
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
    
    <!-- Form daftar baru pengguna -->
    <div class="modal modal-blur fade" id="modal-pengguna" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
      <form method="post" action="tetapan_db.php?sub_menu=11" class="card" id="smart-form">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Jabatan: Pengguna Baru</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="col-lg-12">
                <div class="mb-3">
                  <label class="form-label required">Nama Penuh</label>
                  <input type="text" class="form-control" name="nama" id="nama" oninput="this.value = this.value.toUpperCase()">
                </div>
              </div>
              <div class="col-lg-6">
                <div class="mb-3">
                  <label class="form-label required">No. Kad Pengenalan</label>
                  <input type="text" class="form-control" name="no_ic" id="no_ic" oninput="this.value = this.value.toUpperCase()">
                </div>
              </div>
              <div class="col-lg-6">
                <div class="mb-3">
                  <label class="form-label required">Jawatan</label>
                  <input type="text" class="form-control" name="jawatan" id="jawatan" oninput="this.value = this.value.toUpperCase()">
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
                                  echo "<option value=".$row1['ranking'].">".$row1['jabatan']."</option>";
                                  }
                              }
                        ?>
                    </select>
                  </div>
              </div>
              <div class="col-lg-6">
                <div class="mb-3">
                  <label class="form-label required">Emel</label>
                  <input type="text" class="form-control" name="emel" id="emel">
                </div>
              </div>
              <div class="col-lg-6">
                <div class="mb-3">
                  <label class="form-label required">No. Telefon</label>
                  <input type="text" class="form-control" name="no_telefon" id="no_telefon">
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
            <a href="#" class="btn btn-link link-secondary" data-bs-dismiss="modal">
              Batal
            </a>
            <button type="submit" name="new_user" class="btn btn-primary ms-auto">
              <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><line x1="12" y1="5" x2="12" y2="19" /><line x1="5" y1="12" x2="19" y2="12" /></svg>
              Simpan
            </button>
          </div>
        </div>
        </form>
      </div>
    </div>

    <!-- Form daftar baru jabatan -->
    <div class="modal modal-blur fade" id="modal-jabatan" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
      <form method="post" action="tetapan_db.php?sub_menu=21" class="card" id="smart-form2">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Jabatan Baru</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="col-lg-12">
                <div class="mb-3">
                  <label class="form-label required">Nama Jabatan</label>
                  <input type="text" class="form-control" name="jabatan" id="nama_jabatan" oninput="this.value = this.value.toUpperCase()">
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <a href="#" class="btn btn-link link-secondary" data-bs-dismiss="modal">
              Batal
            </a>
            <button type="submit" name="new_jabatan" class="btn btn-primary ms-auto">
              <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><line x1="12" y1="5" x2="12" y2="19" /><line x1="5" y1="12" x2="19" y2="12" /></svg>
              Simpan
            </button>
          </div>
        </div>
        </form>
      </div>
    </div>

    <!-- retrieve sqno of user from button kemaskini -->
    <script>
      $(document).ready(function(){  
          $(document).on('click', '.edit_user', function(){  
            var sqno=$(this).attr("data-sqno");
        
              if(sqno != '')  
              {  
                    $.ajax({  
                        url:"tetapan_db.php?sub_menu=13",  
                        method:"POST",  
                        data:{sqno:sqno},  
                        success:function(data){  
                              $('#retrieve_user').html(data);  
                              $('#modal-kemaskini-pengguna').modal('show');  
                        }  
                    });  
              }            
          });  
      });
    </script>

    <!-- Form kemaskini pengguna -->
    <div class="modal modal-blur fade" id="modal-kemaskini-pengguna" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
      <form method="post" action="tetapan_db.php?sub_menu=14" class="card" id="smart-form1">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Jabatan: Kemaskini Pengguna </h5>
            <button type="button" class="btn-close close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            
          <div id="retrieve_user"></div>

          </div>
          <div class="modal-footer">
            <a href="#" class="btn btn-link link-secondary close" data-bs-dismiss="modal">
              Batal
            </a>
            <button type="submit" name="edit_user" class="btn btn-primary ms-auto">
              <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><line x1="12" y1="5" x2="12" y2="19" /><line x1="5" y1="12" x2="19" y2="12" /></svg>
              Simpan
            </button>
          </div>
        </div>
        </form>
      </div>
    </div>

    <!-- retrieve id of jabatan from button kemaskini -->
    <script>
      $(document).ready(function(){  
          $(document).on('click', '.edit_jabatan', function(){  
            var id=$(this).attr("data-id");
        
              if(id != '')  
              {  
                    $.ajax({  
                        url:"tetapan_db.php?sub_menu=22",  
                        method:"POST",  
                        data:{id:id},  
                        success:function(data){  
                              $('#retrieve_jabatan').html(data);  
                              $('#modal-kemaskini-jabatan').modal('show');  
                        }  
                    });  
              }            
          });  

          // Close modal on button click
          $(".close").click(function(){
              $("#modal-kemaskini-jabatan").modal('hide');
              $("#modal-kemaskini-pengguna").modal('hide');
          });
      });
    </script>

    <!-- Form kemaskini jabatan -->
    <div class="modal modal-blur fade" id="modal-kemaskini-jabatan" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
      <form method="post" action="tetapan_db.php?sub_menu=23" class="card" id="smart-form3">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Kemaskini Jabatan </h5>
            <button type="button" class="btn-close close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            
          <div id="retrieve_jabatan"></div>

          </div>
          <div class="modal-footer">
            <a href="#" class="btn btn-link link-secondary close" data-bs-dismiss="modal">
              Batal
            </a>
            <button type="submit" class="btn btn-primary ms-auto">
              <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><line x1="12" y1="5" x2="12" y2="19" /><line x1="5" y1="12" x2="19" y2="12" /></svg>
              Simpan
            </button>
          </div>
        </div>
        </form>
      </div>
    </div>



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
                            minlength: 12,
                            remote: {
                                url: "tetapan_db.php?sub_menu=12",
                                type: "post"
                            }		
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
                            minlength: 'Sila masukkan no. tidak kurang 12 digit',
                            remote: 'No.K.P telah wujud'
                      },
                      no_telefon: {
                            required: 'Sila masukkan no. telefon',
                            number:'Nomor sahaja'
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