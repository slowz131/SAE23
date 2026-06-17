<?php
include("connect.php");
if (session_status() == PHP_SESSION_NONE) { session_start(); }

// Security check: If not logged in OR not a manager, redirect to login.php
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'gestionnaire') {
    header("Location: login.php");
    exit();
}

include("header.php");
?>
