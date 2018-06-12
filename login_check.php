<?php
if(!isset($_SESSION['idUser']))
{
    header("location:login.php");
}
?>