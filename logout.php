<?php
    require 'backend/db.php';
    
    unset($_SESSION['logged_user']);
    header('Location: http://localhost/AdAurum/');
?>