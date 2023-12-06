<?php 
require_once 'Models/Customer.php';
require_once 'Controllers/AuthController.php';
session_start();
if (isset($_SESSION["CustomerId"])) {
	$CustomerId = $_SESSION["CustomerId"];
    $db = new dbController();
    $db->openConnection();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $name = $_POST['Name'];
    $email = $_POST['Email'];
    $phone = $_POST['Phone'];
    $password = $_POST['Password'];
    $new_password = $_POST['new_password'];

    // Retrieve existing operator information from the database
    $query = "  SELECT * FROM Customer
                WHERE password ='$password';";
                
    $result = $db->select($query);
    // print_r($result);

    if ($result) {
        $existingOperator = $result[0];

        // Update operator information only for the provided fields
        if (!empty($name)) {
            $existingOperator['Name'] = $name;
        }
        else
        {
            $existingOperator['Name'] = $result[0]['Name'];
        }
        if (!empty($email)) {
            $existingOperator['Email'] = $email;
        }
        else
        {
            $existingOperator['Email'] = $result[0]['Email'];
        }

        if (!empty($phone)) {
            $existingOperator['Phone'] = $phone;
        }
        else
        {
            $existingOperator['Phone'] = $result[0]['Phone'];
        }
        

        if (!empty($new_password)) {
            $existingOperator['Password'] = $new_password;
        }
        else
        {
            $existingOperator['Password'] = $result[0]['Password'];
        }
        

        // Perform data validation and sanitization as needed

        // Update operator information in the database
        $query = "UPDATE customer SET Name='{$existingOperator['Name']}', Email='{$existingOperator['Email']}', Phone='{$existingOperator['Phone']}',password='{$existingOperator['Password']}' WHERE CustomerId = " . $CustomerId . ";";
        $result1 = $db->update($query);

        if ($result1) {
            // Retrieve user information associated with the operator
            $query = "SELECT * FROM Customer WHERE CustomerId = " . $CustomerId . ";";
            $result2 = $db->select($query);
            // print_r($result2);
                    }
                    // User and operator information updated successfully
                    $updateMessage = "User information updated successfully.";
                    header("Location: view&update.php");
                } else {
                    echo "Error updating user information.";
                }
            }
        } else {
            echo "Error updating operator information.";
        }
//$db->closeConnection();
?>

