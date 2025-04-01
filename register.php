<?php
require_once 'Connect.php';
connectDB();

$error = [];
$success = false;

#Registering new account
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    #Inputted information
    $username = trim(string: $_POST["username"]);
    $password = trim(string: $_POST["password"]);
    
    #not sure how creation of user vs librarian will be implemented, this is temporary
    #so im not putting input validation for this
    $role = trim(string: $_POST["role"]);


    #Input validation
    if (empty($username)) {
        $error[] = "Username is required.";
    } elseif (strlen(string: $username) < 3) {
        $error[] = "Username must be at least 3 characters long.";
    }

    if (empty($password)) {
        $error[] = "Password is required.";
    } elseif (strlen(string: $password) < 6) {
        $error[] = "Password must be at least 6 characters long.";
    }

    #Check if username already exists
    $stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    if ($stmt->get_result()->num_rows > 0) {
        $error[] = "Username already exists.";
    }

    #If no errors, proceed with registration
    if (empty($error)) {
        #Add new user to table
        $stmt = $conn->prepare("INSERT INTO UserAccounts (username, password, role) VALUES (?,?, ?)");
        $stmt->bind_param("sss", $username, $password, $role);
        
        if ($stmt->execute()) {
            $success = true;
            #Redirect to website after successful registration
            #header("Location: website.php");   #<----- replace with proper filename later
            $conn->close();
            exit();
        } else {
            $error[] = "Registration failed. Please try again.";
        }
    }
}
?>