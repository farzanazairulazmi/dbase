<?PHP
ob_start();

if (!isset($_SESSION['key_user'])) {
    if ($_SESSION['key_user']!='SESS_AUTH_P455') {
        header('Location: http://ems.kperak.com.my/hrms/');
    }
}

ob_end_flush();

?>