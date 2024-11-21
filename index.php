<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "studentdb";

try {
  
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }
  
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $name = $_POST['name'];
        $age = $_POST['age'];
        $email = $_POST['email'];
        $course = $_POST['course'];

        $stmt = $conn->prepare("INSERT INTO students (name, age, email, course) VALUES (?, ?, ?, ?)");
        if (!$stmt) {
            throw new Exception("Prepare statement failed: " . $conn->error);
        }

        $stmt->bind_param("siss", $name, $age, $email, $course);

        if ($stmt->execute()) {
            echo "Student data inserted successfully!";
        } else {
            throw new Exception("Error executing statement: " . $stmt->error);
        }

        $stmt->close();
    }
} catch (Exception $e) {
    // Handle exceptions
    echo "Error: " . $e->getMessage();
} finally {
    // Close connection
    if (isset($conn) && $conn instanceof mysqli) {
        $conn->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Form</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <div class="form-container">
        <h1>Enter Student Details</h1>
        <form action="index.php" method="POST">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required><br><br>

            <label for="age">Age:</label>
            <input type="number" id="age" name="age" required><br><br>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required><br><br>

            <label for="course">Course:</label>
            <input type="text" id="course" name="course" required><br><br>

            <button type="submit">Submit</button>
        </form>
    </div>

</body>
</html>