<?php
// Start the session
session_start();

if (isset($_GET['err'])) {
	if ($_GET['err'] == 1) {
		$error = "";
	} else {
		$error = "none";
	}
} else {
	$error = "none";
}                                                               
?>

<!doctype html>

<html lang="en">
  <head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
    <?php include 'includes/title.php'; ?>
    <!-- CSS files -->
    <link href="./dist/css/tabler.min.css" rel="stylesheet"/>
  </head>
  <body class="antialiased border-top-wide border-primary d-flex flex-column">
    <div class="page page-center">
      <div class="container-tight py-4">
        <div class="text-center mb-4">
          <a href="."><img src="./images/step.png" height="100" alt=""></a> </br>
          <h1 class="navbar-brand navbar-brand-autodark d-none-navbar-horizontal pe-0 pe-md-3">
           SME D-Base
          </h1>
        </div>
        <form class="card card-md" action="validate.php" method="post" autocomplete="off">
          <div class="card-body">
            <h2 class="card-title text-center mb-4">Log Masuk</h2>
            <div class="mb-3">
              <label class="form-label">ID Pengguna</label>
              <input type="text" class="form-control" name="username" id="username" placeholder="IC Pengguna">
            </div>
            <div class="mb-2">
              <label class="form-label">
                Kata Laluan
              </label>
              <div class="input-group input-group-flat">
                <input type="password" class="form-control" name="password" id="password" placeholder="Kata Laluan" autocomplete="off">
                <span class="input-group-text">
                  <a href="#" class="link-secondary" title="Show password" data-bs-toggle="tooltip"><!-- Download SVG icon from http://tabler-icons.io/i/eye -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><circle cx="12" cy="12" r="2" /><path d="M22 12c-2.667 4.667 -6 7 -10 7s-7.333 -2.333 -10 -7c2.667 -4.667 6 -7 10 -7s7.333 2.333 10 7" /></svg>
                  </a>
                </span>
              </div>
              <div class="result" style="display: <?php echo $error;?>; color: red;">
									<div> ID Pengguna atau Kata Laluan tidak tepat. </div>
            </div>
            <div class="form-footer">
              <button type="submit" class="btn btn-primary w-100">Log Masuk</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </body>
</html>