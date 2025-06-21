<?php
include 'config.php';

$id = $_GET["id"];
$sql = "SELECT * FROM `students` WHERE ID = $id";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
if (empty($row)) {
    header("Location:index.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name   = mysqli_real_escape_string($conn, $_POST['name']);
    $gender = mysqli_real_escape_string($conn, $_POST['gender']);
    $email  = mysqli_real_escape_string($conn, $_POST['email']);
    $phone  = mysqli_real_escape_string($conn, $_POST['phone']);

    // Image Upload
    $photo = $row['photo']; // default to old photo
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] == 0) {
        $photoName = time() . '_' . basename($_FILES['photo']['name']);
        $targetPath = "uploads/" . $photoName;

        if (move_uploaded_file($_FILES['photo']['tmp_name'], $targetPath)) {
            // Delete old photo if exists
            if (!empty($photo) && file_exists("uploads/" . $photo)) {
                unlink("uploads/" . $photo);
            }
            $photo = $photoName;
        }
    }

    $updateSql = "UPDATE `students` SET 
                    `name`='$name', 
                    `gender`='$gender', 
                    `email`='$email', 
                    `phone`='$phone', 
                    `photo`='$photo'
                  WHERE ID=$id";

    if (mysqli_query($conn, $updateSql)) {
        header("Location:index.php");
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Edit Student</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
</head>
<body>

<div class="container">
    <a href="./index.php" class="btn btn-primary mt-3">Students List</a>
    <h2 class="my-4">Edit Student</h2>

    <form method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label>Name:</label>
            <input type="text" class="form-control" name="name"
                   value="<?php echo $row['name']; ?>" required>
        </div>

        <label>Gender:</label><br>
        <input type="radio" name="gender" value="Male"
            <?php if ($row["gender"] == "Male") echo "checked"; ?>> Male
        <input type="radio" name="gender" value="Female"
            <?php if ($row["gender"] == "Female") echo "checked"; ?>> Female

        <div class="form-group mt-3">
            <label>Email:</label>
            <input type="email" class="form-control" name="email"
                   value="<?php echo $row['email']; ?>" required>
        </div>

        <div class="form-group">
            <label>Phone:</label>
            <input type="tel" class="form-control" name="phone"
                   value="<?php echo $row['phone']; ?>" required>
        </div>

        <div class="form-group">
            <label>Upload New Photo:</label>
            <input type="file" name="photo" class="form-control">
        </div>

        <?php if (!empty($row['photo'])): ?>
            <div class="form-group">
                <label>Current Photo:</label><br>
                <img src="uploads/<?php echo $row['photo']; ?>" width="120">
            </div>
        <?php endif; ?>

        <button type="submit" class="btn btn-success">Update</button>
    </form>
</div>

</body>
</html>
