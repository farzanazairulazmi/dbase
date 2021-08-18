<?php
session_start();
// include '../includes/redirect.php';
include '../includes/connection.php';

$sub_menu = $_GET["sub_menu"];

if ($sub_menu == 11){  //Pengguna Baru

    if(isset($_POST['new_user'])){
        $nama_penuh = addslashes($_POST["nama"]);	
        $no_ic = strip_tags(trim($_POST["no_ic"])); 
        $jawatan = addslashes($_POST["jawatan"]);	
        $jabatan = addslashes($_POST["jabatan"]);	
        $emel = addslashes($_POST["emel"]);	
        $no_telefon = strip_tags(trim($_POST["no_telefon"]));
        $pwd = "123456";

        // insert to db 
        $sql = "INSERT INTO step_dbase_users (username,password,nama_penuh,jawatan,jabatan,emel,no_telefon)
        VALUES ('".$no_ic."','".md5($pwd)."','".$nama_penuh."','".$jawatan."','".$jabatan."','".$emel."','".$no_telefon."')";
    
        if (mysqli_query($conn, $sql)) {
            //echo "Record updated successfully";		
            $_SESSION['status_message'] = "Rekod berjaya disimpan.";
            $_SESSION['status_class'] = "alert alert-important alert-success alert-dismissible";

            echo "<script>
            window.location.href = 'tetapan.php?sub_menu=1';
            </script>";		
        } else {
            echo "Error updating record: " . mysqli_error($conn);
        }	
    }

}elseif ($sub_menu == 12) {	//check if exist or not for new user (jabatan)
    
    $sql = "SELECT username FROM step_dbase_users";
    $result = mysqli_query($conn, $sql);
    
    $userUid = array();
    while($row = mysqli_fetch_assoc($result)) {	
        
        $userUid[] = $row['username'];
       
    }
    $registeredUid = $userUid;

    $requestedUid  = $_REQUEST['no_ic'];

    if(in_array($requestedUid, $registeredUid)){
        echo 'false';
    }
    else{
        echo 'true';
    }

}elseif ($sub_menu == 13) {	//form kemaskini pengguna 

    if(isset($_POST["sqno"]))  
    { $sqno = addslashes($_POST["sqno"]);
    
    $sql = "SELECT * FROM step_dbase_users
            WHERE sqno = '".$sqno."' AND flag=0 ORDER BY jabatan,nama_penuh";
    $result = mysqli_query($conn, $sql);							

    if (mysqli_num_rows($result) > 0) {
    while($row = mysqli_fetch_assoc($result)) {?>

    <div class="row">

        <input type="hidden" id="sqno" name="sqno" value="<?php echo $sqno; ?>" >

        <div class="col-lg-8">
            <div class="mb-3">
                <label class="form-label required">Nama Penuh</label>
                <input type="text" class="form-control" name="nama" id="nama" oninput="this.value = this.value.toUpperCase()" value="<?php echo $row['nama_penuh']; ?>">
            </div>
        </div>
        <div class="col-lg-4">
            <div class="mb-3">
                <label class="form-label required">No. Kad Pengenalan</label>
                <input type="text" class="form-control" name="no_kp" id="no_kp" value="<?php echo $row['username']; ?>">
            </div>
        </div>
        <div class="col-lg-6">
            <div class="mb-3">
                <label class="form-label required">Jawatan</label>
                <input type="text" class="form-control" name="jawatan" id="jawatan" oninput="this.value = this.value.toUpperCase()" value="<?php echo $row['jawatan']; ?>">
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
                                    if($row['jabatan']==$row1['ranking']) { 
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
                <input type="text" class="form-control" name="emel" id="emel" value="<?php echo $row['emel']; ?>">
            </div>
        </div>
        <div class="col-lg-6">
            <div class="mb-3">
                <label class="form-label required">No. Telefon</label>
                <input type="text" class="form-control" name="no_telefon" id="no_telefon" value="<?php echo $row['no_telefon']; ?>">
            </div>
        </div>
    </div>   
    
    <?php }
        }
    }

}elseif ($sub_menu == 14){ //Kemaskini Pengguna
    
    $sqno = strip_tags(trim($_POST["sqno"]));
    $nama_penuh = addslashes($_POST["nama"]);	
    $no_ic = strip_tags(trim($_POST["no_kp"])); 
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
    "WHERE sqno = ".$sqno;	

    if (mysqli_query($conn, $sql)) {
        //echo "Record updated successfully";	
        $_SESSION['status_message'] = "Rekod berjaya dikemaskini.";
        $_SESSION['status_class'] = "alert alert-important alert-success alert-dismissible";

        echo "<script>
        window.location.href = 'tetapan.php?sub_menu=1';
        </script>";			
    } else {
        echo "Error updating record: " . mysqli_error($conn);
    }	


}elseif ($sub_menu == 15){  //delete pengguna

    $sqno = $_GET["sqno"];
    
    // update to db
    $sql = "UPDATE step_dbase_users SET flag = 1 WHERE sqno = ".$sqno;

    if (mysqli_query($conn, $sql)) {
        //echo "Record updated successfully";
        $_SESSION['status_message'] = "Rekod berjaya dipadam.";
        $_SESSION['status_class'] = "alert alert-important alert-success alert-dismissible";

        echo "<script>
        window.location.href = 'tetapan.php?sub_menu=1';
        </script>";		
        // header("location:tetapan.php?&sub_menu=1");
    } else {
        echo "Error updating record: " . mysqli_error($conn);
    }

} elseif ($sub_menu == 21){  //Jabatan Baru

    if(isset($_POST['new_jabatan'])){

        $jabatan =  addslashes($_POST["jabatan"]);	
        
        $sql1 = "SELECT MAX(ranking) latest_rank FROM step_sso_refgen WHERE mastercode = 1001";
        $result1 = mysqli_query($conn, $sql1);
        if (mysqli_num_rows($result1) > 0) {
        while($row1 = mysqli_fetch_assoc($result1)) {	
            $ranking = $row1["latest_rank"];
        }
        }
        
        if($ranking != ''){
            $rank_latest = $ranking + 1;
        }else{
            $rank_latest = 1;
        }

        // insert to db 
        $sql = "INSERT INTO step_sso_refgen (ranking,mastercode,description)
        VALUES ('".$rank_latest."','1001','".$jabatan."')";
        
        if (mysqli_query($conn, $sql)) {
            //echo "Record updated successfully";	
            $_SESSION['status_message'] = "Rekod berjaya disimpan.";
            $_SESSION['status_class'] = "alert alert-important alert-success alert-dismissible";

            echo "<script>
            window.location.href = 'tetapan.php?sub_menu=2';
            </script>";			
        } else {
            echo "Error updating record: " . mysqli_error($conn);
        }	

    }

    
} elseif ($sub_menu == 22){  //Jabatan Kemaskini form

    if(isset($_POST["id"]))  
    { $id = addslashes($_POST["id"]);
    
    $sql = "SELECT * FROM step_sso_refgen
            WHERE id = '".$id."' AND flag=0 ORDER BY description";
    $result = mysqli_query($conn, $sql);							

    if (mysqli_num_rows($result) > 0) {
    while($row = mysqli_fetch_assoc($result)) {?>

    <div class="row">

        <input type="hidden" id="id" name="id" value="<?php echo $id; ?>" >

        <div class="col-lg-12">
            <div class="mb-3">
                <label class="form-label required">Nama Jabatan</label>
                <input type="text" class="form-control" name="jabatan" id="nama_jabatan" oninput="this.value = this.value.toUpperCase()" value="<?php echo $row['description']; ?>">
            </div>
        </div>
    </div>   
    
    <?php }
        }
    }

}elseif ($sub_menu == 23){ //update jabatan in db
    
    $id = strip_tags(trim($_POST["id"]));
    $jabatan = addslashes($_POST["jabatan"]);	

    // update to db 
    $sql = "UPDATE step_sso_refgen SET description = '".$jabatan."' ".
    "WHERE id = ".$id;	

    if (mysqli_query($conn, $sql)) {
        //echo "Record updated successfully";	
        $_SESSION['status_message'] = "Rekod berjaya dikemaskini.";
        $_SESSION['status_class'] = "alert alert-important alert-success alert-dismissible";

        echo "<script>
        window.location.href = 'tetapan.php?sub_menu=2';
        </script>";			
    } else {
        echo "Error updating record: " . mysqli_error($conn);
    }

}elseif ($sub_menu == 24){  //delete jabatan

    $id = $_GET["id"];
    
    // update to db
    $sql = "UPDATE step_sso_refgen SET flag=1 WHERE id = ".$id;

    if (mysqli_query($conn, $sql)) {
        $_SESSION['status_message'] = "Rekod berjaya dipadam.";
        $_SESSION['status_class'] = "alert alert-important alert-success alert-dismissible";

        echo "<script>
        window.location.href = 'tetapan.php?sub_menu=2';
        </script>";	
    } else {
        echo "Error updating record: " . mysqli_error($conn);
    }


}
    
?>