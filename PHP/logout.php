<?php
    unset($_COOKIE['user']);
    unset($_SESSION['logged_in']);
    header('location: /');
?>
