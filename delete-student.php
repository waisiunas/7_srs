<?php
require_once './database/connection.php';

session_start();
if (!isset($_SESSION['user'])) {
    header('location: ./');
}

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = $_GET['id'];
} else {
    header('location: ./show-students.php');
}

$sql = "SELECT * FROM `students` WHERE `id` = $id";
$result = $conn->query($sql);

if ($result->num_rows === 0) {
    header('location: ./show-students.php');
}

$sql = "DELETE FROM `students` WHERE `id` = $id";
if ($conn->query($sql)) {
    header('location: ./show-students.php');
} else {
    die("Failed to delete!");
}
