<?php 
session_start();
include 'config.php';

$search = "";
if (isset($_GET['search'])) {
    $search = mysqli_real_escape_string($conn, $_GET['search']);
   $sql = "SELECT * FROM students 
        WHERE name LIKE '%$search%' 
        OR email LIKE '%$search%' 
        OR phone LIKE '%$search%'";

} else {
    $sql = "SELECT * FROM students";
}

$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Student List</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-4">
  <h2 class="mb-3">Student Records</h2>

  
  <form method="GET" class="form-inline justify-content-end mb-3">
  <input type="text" name="search" class="form-control mr-2" placeholder="Search by name,email,or phone">
  <button type="submit" class="btn btn-primary">Search</button>
</form>


  <a href="create.php" class="btn btn-success mb-3">+ Add New Student</a>

  <table class="table table-bordered table-striped">
    <thead>
      <tr>
        <th>ID</th>
        <th>Photo</th>
        <th>Name</th>
        <th>Email</th>
        <th>Phone</th>
        <th>Gender</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php if(mysqli_num_rows($result) > 0): ?>
        <?php while($row = mysqli_fetch_assoc($result)): ?>
        <tr>
          <td><?= $row["id"] ?></td>
          <td>
            <?php if (!empty($row["photo"])): ?>
              <img src="uploads/<?= $row["photo"] ?>" width="60" height="60" style="border-radius: 50%;">
            <?php else: ?>
              No Photo
            <?php endif; ?>
          </td>
          <td><?= $row["name"] ?></td>
          <td><?= $row["email"] ?></td>
          <td><?= $row["phone"] ?></td>
          <td><?= $row["gender"] ?></td>
          <td>
            <a href="edit.php?id=<?= $row["id"] ?>" class="btn btn-primary btn-sm" onclick="return confirm('Are You Sue To Edit')">Edit</a>
            <a href="delete.php?id=<?= $row["id"] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this student?')">Delete</a>
          </td>
        </tr>
        <?php endwhile; ?>
      <?php else: ?>
        <tr>
          <td colspan="7" class="text-center">No records found.</td>
        </tr>
      <?php endif; ?>
    </tbody>
  </table>
</div>

</body>
</html>
