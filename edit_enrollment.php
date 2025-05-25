<?php
// edit_enrollment.php
$conn = new mysqli("localhost", "root", "", "coaching_web");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Debugging helper—uncomment to see posted data
// echo '<pre>'; print_r($_POST); echo '</pre>';

if (
    isset($_POST['id'], $_POST['first_name'], $_POST['last_name'],
           $_POST['dob'], $_POST['courses'],
           $_POST['school_name'], $_POST['state'], $_POST['country'])
) {
    $id          = (int) $_POST['id'];
    $first_name  = trim($_POST['first_name']);
    $last_name   = trim($_POST['last_name']);
    $dob         = $_POST['dob'];
    $courses     = trim($_POST['courses']);
    $school_name = trim($_POST['school_name']);
    $state       = trim($_POST['state']);
    $country     = trim($_POST['country']);

    $sql = "UPDATE enrollments 
            SET first_name=?, last_name=?, dob=?, courses=?, 
                school_name=?, state=?, country=? 
            WHERE id=?";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }
    $stmt->bind_param(
        "sssssssi",
        $first_name, $last_name, $dob,
        $courses,    $school_name, $state,
        $country,    $id
    );

    if (!$stmt->execute()) {
        die("Execute failed: " . $stmt->error);
    }

    // No output before header!
    header("Location: admin_dashboard.php");
    exit();
} else {
    die("Missing POST data. Please make sure all fields are filled.");
}
?>