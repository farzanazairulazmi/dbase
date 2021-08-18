<?php
// Start the session
session_start();
include '../includes/redirect.php';
include '../includes/connection.php';
$uid = $_SESSION["uid"];
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
              <div class="col">
                <!-- Page pre-title -->
                <div class="page-pretitle">
                  Overview
                </div>
                <h2 class="page-title">
                  Laman Utama
                </h2>
              </div>
            </div>
          </div>
        </div>
        <div class="page-body">
          <div class="container-xl">
            <div class="row row-deck row-cards">
							
							<div class="col-md-12">
                <div class="card">
								<div class="card-header">
                  <h3 class="card-title">Senarai Usahawan</h3>
                </div>
							
								<div class="table-responsive">
                  <table class="table table-vcenter card-table datatable">
                    <thead>
                      <tr>
                         <th class="w-1">Bil. </th>
                         <th>Nama</th>
                         <th>No. Kad Pengenalan</th>
												 <th>No. Telefon</th>
                         <th width=15%>Tindakan</th>
                      </tr>
                    </thead>
                    <tbody>
										
                    </tbody>
                  </table>
              	</div>
								</div>
							</div>
            </div>
          </div>
        </div>
        <footer class="footer footer-transparent d-print-none">
					<?php include '../includes/footer.php';?>
        </footer>
      </div>
    </div>
		

					
    <script>
			//datatables
      require(['datatables', 'jquery'], function(datatable, $) {
        $('.datatable').DataTable({
					// "searching":   false
				});
      });
     
    </script>
    
  </body>
</html>