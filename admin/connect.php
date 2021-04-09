<?php
    # Store connection details
    $server_name    = 'localhost';
    $user_name      = 'root';
    $password       = '';
    $db_name        = 'blood_donation';

    # Store all var connection
    $connect_db     = mysqli_connect($server_name, $user_name, $password, $db_name);
