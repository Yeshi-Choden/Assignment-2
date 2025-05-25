<?php
// edit_user.php

$conn = new mysqli("localhost", "root", "", "coaching_web");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check that all expected fields are present
if (
    isset(
        $_POST['id'],
        $_POST['fullname'],
        $_POST['email'],
        $_POST['password'],
        $_POST['gender'],
        $_POST['phone'],
        $_POST['dob'],
        $_POST['address']
    )
) {
    // Grab and sanitize inputs
    $id       = (int) $_POST['id'];
    $fullname = trim($_POST['fullname']);
    $email    = trim($_POST['email']);
    $password = trim($_POST['password']);       // consider hashing with password_hash()
    $gender   = trim($_POST['gender']);
    $phone    = trim($_POST['phone']);
    $dob      = $_POST['dob'];                   // expect format YYYY-MM-DD
    $address  = trim($_POST['address']);

    // Prepare your UPDATE statement (no extra comma before WHERE)
    $sql = "
      UPDATE users 
         SET fullname = ?,
             email    = ?,
             password = ?,
             gender   = ?,
             phone    = ?,
             dob      = ?,
             address  = ?
       WHERE id = ?
    ";

    if ($stmt = $conn->prepare($sql)) {
        // Bind in the same order as the placeholders:
        // s = string, i = integer
        $stmt->bind_param(
            "sssssssi",
            $fullname,
            $email,
            $password,
            $gender,
            $phone,
            $dob,
            $address,
            $id
        );

        if ($stmt->execute()) {
            // Redirect back to dashboard on success
            header("Location: admin_dashboard.php");
            exit();
        } else {
            echo "❌ Failed to execute update: " . $stmt->error;
        }

    } else {
        echo "❌ Failed to prepare statement: " . $conn->error;
    }

} else {
    echo "❌ Missing POST data. Please fill all fields.";
}
?>
<input type="hidden" name="id" value="<?= $u['id'] ?>">
<input name="fullname" value="<?= htmlspecialchars($u['fullname']) ?>">
<input name="email"    value="<?= htmlspecialchars($u['email']) ?>">
<input name="password" type="password" value="">    <!-- leave blank to not change? -->
<select name="gender">…</select>
<input name="phone">
<input name="dob" type="date">
<textarea name="address"><?= htmlspecialchars($u['address']) ?></textarea>