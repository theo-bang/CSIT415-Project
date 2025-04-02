<?php
$servername = "localhost";
$username = "root"; 
$password = ""; 
$dbname = "your_database"; 

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

function testCreateUser($conn, $newUser, $newPass) {
    $hashedPass = password_hash($newPass, PASSWORD_DEFAULT);
    
    $checkStmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
    $checkStmt->bind_param("s", $newUser);
    $checkStmt->execute();
    $result = $checkStmt->get_result();
    
    if ($result->num_rows > 0) {
        return "Account creation failed: Username already exists.";
    }
    
    $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
    if ($stmt) {
        $stmt->bind_param("ss", $newUser, $hashedPass);
        if ($stmt->execute()) {
            return "Account successfully created for user: $newUser";
        } else {
            return "Error: Could not create account.";
        }
    }
    return "Error: Query preparation failed.";
}

$testUsername = "newTestUser";
$testPassword = "testPassword123";

echo testCreateUser($conn, $testUsername, $testPassword);

$conn->close();
?>
