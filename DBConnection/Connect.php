<?php

/* 
In any file that needs to connect to the database, include this file at the top.
This file contains the connection to the database through mysqli.
Invoke "connectDB()" and either "disconnectDB()" or $conn->close();
to connect and disconnect from the database, so we can keep our
files consistent. Thanks -NS
*/

function connectDB(): void {
    $servername = "localhost:3306";
    $username = "root";
    $password = "";
    $dbname = "libman";
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Adjust the dbname, username and password to access your own database.

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
}
// Logs into the database for using mysqli functions. 
// To disconnect from the DB, use "$conn->close();"
// Please ensure you always close when you are done with the DB.


?>
