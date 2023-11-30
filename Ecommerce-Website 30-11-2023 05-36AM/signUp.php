<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Include database connection details
    $dbHost = "localhost";
    $dbUser = "root";
    $dbPassword = "";
    $dbName = "ecommerce";

    // Create a database connection
    $conn = new mysqli($dbHost, $dbUser, $dbPassword, $dbName);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Get the form data
    $name = $_POST['name1'];
    $email = $_POST['email1'];
    $phoneNumber = $_POST['phoneNumper'];
    $password = $_POST['password1'];

    // Insert the data into the database
    $sql = "INSERT INTO customer (Name, Email, Password, Phone) 
            VALUES ('$name', '$email', '$password', '$phoneNumber')";

    if ($conn->query($sql) === TRUE) {
        // Registration successful, redirect to login page
        header("Location: login.php");
        exit();
    } else {
        // Error in SQL query
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Close the database connection
    $conn->close();
} else {
    // If someone tries to access this page directly, redirect to login page
    header("Location: login.php");
    exit();
}
?>
