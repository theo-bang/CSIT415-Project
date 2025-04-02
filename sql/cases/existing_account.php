<?php
session_start();

$servername = "localhost";
$username = "root"; 
$password = "";
$dbname = "your_database";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

function testLogin($conn, $testUser, $testPass) {
    $stmt = $conn->prepare("SELECT id, password FROM users WHERE username = ?");
    if ($stmt) {
        $stmt->bind_param("s", $testUser);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if (password_verify($testPass, $row['password'])) {
                return "Login successful for user: $testUser";
            } else {
                return "Login failed: Incorrect password.";
            }
        } else {
            return "Login failed: Username not found.";
        }
    }
    return "Error: Query preparation failed.";
}

$testUsername = "existingUser";
$testPassword = "correctPassword";

echo testLogin($conn, $testUsername, $testPassword);

$conn->close();
?>
