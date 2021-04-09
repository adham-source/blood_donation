<?php 
    # Start session
    session_start();
    # unset the data
    session_unset();
    # Destory the session
    session_destroy();

    # Redirect after logout
    header('location: ./index.php');

    exit();