<?php
session_start();

if (!isset($_SESSION['nome'])){
    header('location: adm-login.php?errp=true');
    exit;
}