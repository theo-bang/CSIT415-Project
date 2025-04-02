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

function authenticateUser($conn, $user, $pass) {
    $stmt = $conn->prepare("SELECT id, password FROM users WHERE username = ?");
    if ($stmt) {
        $stmt->bind_param("s", $user);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if (password_verify($pass, $row['password'])) {
                return $row['id'];
            }
        }
    }
    return false;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    
    $userId = authenticateUser($conn, $username, $password);
    
    if ($userId) {
        $_SESSION['user_id'] = $userId;
        $_SESSION['username'] = $username;
        header("Location: dashboard.php"); 
        exit();
    } else {
        echo "Invalid username or password.";
    }
}

$conn->close();
?>
