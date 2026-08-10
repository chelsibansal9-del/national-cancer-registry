<?php
session_start();

$username = $_POST['username'];
$password = $_POST['password'];

/* Temporary Login */

if($username=="admin" && $password=="admin123")
{
    $_SESSION['user_id']=1;
    $_SESSION['username']="Admin";

    header("Location: ../dashboard/dashboard.php");
    exit();
}
else
{
    echo "<script>
    alert('Invalid Username or Password');
    window.location='login.php';
    </script>";
}
?>