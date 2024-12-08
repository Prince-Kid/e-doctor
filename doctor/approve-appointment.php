<?php
session_start();

// Check if the user is logged in and is an admin ('a' for admin usertype)
if (isset($_SESSION["user"])) {
    if ($_SESSION["user"] == "" || $_SESSION['usertype'] != 'd') {
        header("location: ../login.php");
    }
} else {
    header("location: ../login.php");
}

// If the request contains a GET parameter
if ($_GET) {
    // Import database connection
    include("../connection.php");

    // Get the appointment ID from the URL parameter
    $id = $_GET["id"];

    // Make sure the ID is properly sanitized to avoid SQL injection
    $id = mysqli_real_escape_string($database, $id);

    // SQL query to update the appointment status to 'approved'
    $sql = "UPDATE appointment SET status='approved' WHERE appoid='$id'";

    // Execute the query
    if ($result = $database->query($sql)) {
        if ($database->affected_rows > 0) {
            // If the query executed successfully and affected rows
            header("location: appointment.php?message=Appointment approved successfully!");
        } else {
            // If no rows were affected (e.g., invalid appointment ID)
            echo "Error: No rows were updated. Check if the appointment ID exists.";
        }
    } else {
        // If there was an error in the SQL query execution
        echo "SQL Error: " . $database->error;
    }
}
?>