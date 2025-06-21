<?php 
include 'config.php';

$id = $_GET['id'];


$sql = "SELECT photo FROM `students` WHERE ID = $id";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);


if (!empty($row['photo']) && file_exists("uploads/" . $row['photo'])) {
    unlink("uploads/" . $row['photo']);
}


$sqli = "DELETE FROM `students` WHERE ID = $id";

if (mysqli_query($conn, $sqli)) {
    header("Location: index.php");
    exit;
} else {
    echo "Delete failed: " . mysqli_error($conn);
}
?>
