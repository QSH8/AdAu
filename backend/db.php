<?php
    require "./libraries/rb.php";
    R::setup( 'mysql:host=localhost;dbname=company',
              'root',
              ''
    );
    
    session_start();
?>