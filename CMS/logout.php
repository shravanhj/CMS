<?php

include 'database/dbconn.php';

session_start();
session_unset();
session_destroy();

header('location:home.php');

?>