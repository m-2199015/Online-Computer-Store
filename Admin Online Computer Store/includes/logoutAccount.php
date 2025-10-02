<?php

require_once "security.php";

session_destroy();

echo "<script>alert ('Log out successfully'); window.location.href='../index.php'; </script>";
