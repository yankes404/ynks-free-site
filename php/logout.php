<?php

session_start();

if(isset($_SESSION['logged']))
{
    unset($_SESSION['logged']);
    unset($_SESSION['userData']);
}

header("Location: ../index.php");