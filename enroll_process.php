<?php
$host = "localhost";
$db = "coaching_web";
$user = "root";
$pass = "";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

// Get form data
$firstName = $_POST['firstName'];
$lastName = $_POST['lastName'];
$dob = $_POST['dob'];
$courses = isset($_POST['courses']) ? implode(', ', $_POST['courses']) : '';
$schoolName = $_POST['schoolName'];
$state = $_POST['state'];
$country = $_POST['country'];

$sql = "INSERT INTO enrollments (first_name, last_name, dob, courses, school_name, state, country)
        VALUES (?, ?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sssssss", $firstName, $lastName, $dob, $courses, $schoolName, $state, $country);

if ($stmt->execute()) {
    echo "
    <script>
      alert('Registration successful!');
      window.location.href = 'course.html'; // Change this to your desired page
    </script>
    ";
} else {
    echo "
    <script>
      alert('Error: " . addslashes($stmt->error) . "');
      window.history.back();
    </script>
    ";
}

$conn->close();
?>
