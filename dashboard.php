<?php
require_once 'config/database.php';
require_once 'includes/functions.php';
redirectIfNotLoggedIn();
$role = $_SESSION['role'];
if($role == 'admin') header('Location: admin/dashboard.php');
elseif($role == 'hod') header('Location: hod/dashboard.php');
else header('Location: teacher/dashboard.php');
exit();
?>