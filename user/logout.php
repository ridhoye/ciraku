<?php
session_start();
session_unset();   // hapus semua session
session_destroy(); // hancurkan session

// redirect ke login
header("Location: login.php");
exit();
