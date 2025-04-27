<?php
#include 'Connect.php';
connectDB();

$error = [];
$success = false;


// Function to query the "Books" table and return rows matching a string
function searchBooks($searchString) {
    $searchString = $conn->real_escape_string($searchString);
    $sql = "SELECT * FROM Books WHERE title LIKE '%$searchString%' OR author LIKE '%$searchString%' OR genre LIKE '%$searchString%'";
    $result = $conn->query($sql);

    $books = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $books[] = $row;
        }
    }

    $conn->close();
    return $books;
}

// Function to flag a book as checked out
function checkoutBook($bookId) {
    $bookId = $conn->real_escape_string($bookId);
    $sql = "UPDATE Books SET checkedOut = 1 WHERE id = '$bookId'";

    if ($conn->query($sql) === TRUE) {
        $conn->close();
        return true;
    } else {
        $conn->close();
        return false;
    }
}

// Function to apply fines for overdue books
function applyOverdueFines() {
    $currentTimestamp = date("Y-m-d H:i:s");

    $sql = "SELECT * FROM Books WHERE dueDate < '$currentTimestamp' AND checkedOut = 1";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $userId = $row['userID'];
            $fineSql = "UPDATE Users SET finesDue = finesDue + 5.00 WHERE id = '$userId'";
            $conn->query($fineSql);
        }
    }

    $conn->close();
}
?>