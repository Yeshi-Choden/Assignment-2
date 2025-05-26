<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>admin_dashboard</title>
  <link rel="stylesheet" href="index.css">
  <script src="script.js"></script>
</head>
<body>
  <header>
    <div class="logo"><img src="dmy.png" height="45">COACHING</div>
    <nav>
	<ul>
	<li class="dropdown">
      <a href="index.html" id="coursesLink" class="droplist">Log out</a>
		
		</li>
      
		
	</ul>
    </nav>
  </header>

  <section class="hero">
    <h1>COACHING FOR KIDS</h1>
    <p>Interactive, lively and affordable coaching seesions for kids</p> 
  </section>
  

<?php
session_start();
if (!isset($_SESSION['admin'])) {
    die("Access denied. <a href='admin_login.html'>Login here</a>");
}

$conn = new mysqli("localhost", "root", "", "coaching_web");
if ($conn->connect_error) die("Connection failed");

// Delete user
if (isset($_GET['delete_user'])) {
    $conn->query("DELETE FROM users WHERE id = " . (int)$_GET['delete_user']);
}

// Delete enrollment
if (isset($_GET['delete_enroll'])) {
    $conn->query("DELETE FROM enrollments WHERE id = " . (int)$_GET['delete_enroll']);
}

// Fetch data
$users = $conn->query("SELECT * FROM users");
$enrollments = $conn->query("SELECT * FROM enrollments");
?>
<!DOCTYPE html>
<html>
<head><title>Admin Dashboard</title></head>
<body>
<h1><center>Welcome Admin: <?= $_SESSION['admin'] ?></center></h1>

<h3>Users</h3>
<table border="1" cellpadding="5">
  <tr>
    <th>ID</th>
    <th>Name</th>
    <th>Email</th>
    <th>Password</th>
    <th>Gender</th>
    <th>Phone</th>
    <th>DOB</th>
    <th>Address</th>
    <th>Action</th>
  </tr>
  <?php while ($u = $users->fetch_assoc()): ?>
    <tr>
      <form method="post" action="edit_user.php">
        <!-- hidden ID -->
        <input type="hidden" name="id" value="<?= $u['id'] ?>">

        <!-- ID cell -->
        <td><?= $u['id'] ?></td>

        <!-- Full Name -->
        <td>
          <input 
            type="text" 
            name="fullname" 
            value="<?= htmlspecialchars($u['fullname']) ?>" 
            size="15"
          >
        </td>

        <!-- Email -->
        <td>
          <input 
            type="email" 
            name="email" 
            value="<?= htmlspecialchars($u['email']) ?>" 
            size="20"
          >
        </td>

        <!-- Password (leave blank if you don't want to change) -->
        <td>
          <input 
            type="password" 
            name="password" 
            placeholder="••••••" 
            size="10"
          >
        </td>

        <!-- Gender -->
        <td>
          <select name="gender">
            <option value="female" <?= $u['gender']==='female'?'selected':'' ?>>Female</option>
            <option value="male"   <?= $u['gender']==='male'  ?'selected':'' ?>>Male</option>
            <option value="other"  <?= $u['gender']==='other' ?'selected':'' ?>>Other</option>
          </select>
        </td>

        <!-- Phone -->
        <td>
          <input 
            type="tel" 
            name="phone" 
            value="<?= htmlspecialchars($u['phone']) ?>" 
            size="12"
          >
        </td>

        <!-- DOB -->
        <td>
          <input 
            type="date" 
            name="dob" 
            value="<?= htmlspecialchars($u['dob']) ?>"
          >
        </td>

        <!-- Address -->
        <td>
          <textarea 
            name="address" 
            rows="1" cols="20"
          ><?= htmlspecialchars($u['address']) ?></textarea>
        </td>

        <!-- Actions -->
        <td>
          <button type="submit">Save</button>
          <a href="?delete_user=<?= $u['id'] ?>" onclick="return confirm('Delete user?')">
            Delete
          </a>
        </td>
      </form>
    </tr>
  <?php endwhile; ?>
</table>
<h3>Enrollments</h3>
<table border="1">
  <tr><th>ID</th><th>Name</th><th>DOB</th><th>Courses</th><th>School</th><th>Location</th><th>Action</th></tr>
  <?php while ($e = $enrollments->fetch_assoc()): ?>
    <tr>
      <form method="post" action="edit_enrollment.php">
        <input type="hidden" name="id" value="<?= $e['id'] ?>">
        <td><?= $e['id'] ?></td>
        <td>
          <input name="first_name" value="<?= $e['first_name'] ?>">
          <input name="last_name" value="<?= $e['last_name'] ?>">
        </td>
        <td><input name="dob" value="<?= $e['dob'] ?>"></td>
        <td><input name="courses" value="<?= $e['courses'] ?>"></td>
        <td><input name="school_name" value="<?= $e['school_name'] ?>"></td>
        <td>
          <input name="state" value="<?= $e['state'] ?>">
          <input name="country" value="<?= $e['country'] ?>">
        </td>
        <td>
          <button type="submit">Save</button>
          <a href="?delete_enroll=<?= $e['id'] ?>" onclick="return confirm('Delete enrollment?')">Delete</a>
        </td>
      </form>
    </tr>
  <?php endwhile; ?>
</table>
</body>
</html>

