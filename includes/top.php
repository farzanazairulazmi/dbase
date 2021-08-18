<header class="navbar navbar-expand-md sticky-top d-print-none" style="background: #eae91b;">
        <div class="container-xl">
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-menu">
            <span class="navbar-toggler-icon"></span>
          </button>
          <h1 class="navbar-brand navbar-brand-autodark d-none-navbar-horizontal pe-0 pe-md-3">
            <a href="home.php">
              <img src="../images/step.png" width="200" height="50" alt="DBase" class="navbar-brand-image">
            </a>
          </h1>
          <h1 class="navbar-brand navbar-brand-autodark pe-0 pe-md-3">
            SME D-Base
          </h1>
          <div class="navbar-nav flex-row order-md-last">
            <div class="nav-item dropdown">
              <a href="#" class="nav-link d-flex lh-1 text-reset p-0" data-bs-toggle="dropdown" aria-label="Open user menu">
                <span class="avatar avatar-sm" style="background-image: url(../static/avatars/000m.jpg)"></span>
                <div class="d-none d-xl-block ps-2">
                  <?php $sql = "SELECT nama_penuh,username FROM step_dbase_users WHERE uid = ".$_SESSION["uid"];
                        $result = mysqli_query($conn, $sql);
                          if (mysqli_num_rows($result) > 0) {
                            while($row = mysqli_fetch_assoc($result)) { ?>
                            <div><?php echo $row["nama_penuh"]; ?></div>
                            <div class="mt-1 small text-muted"><?php echo $row["username"]; ?></div>
                  <?php   }
                        } ?>
                </div>
              </a>
              <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                <a href="profil.php?sub_menu=1" class="dropdown-item">Profil</a>
                <div class="dropdown-divider"></div>
                <a href="../logout.php" class="dropdown-item">Log Keluar</a>
              </div>
            </div>
          </div>
        </div>        
</header>
